<?php

namespace Illuminate\Queue;

use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Queue\Jobs\DatabaseJob;
use Illuminate\Database\Query\Expression;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class DatabaseQueue extends Queue implements QueueContract
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\Connection
     */
    protected $database;

    /**
     * The database table that holds the jobs.
     *
     * @var string
     */
    protected $table;

    /**
     * The name of the default queue.
     *
     * @var string
     */
    protected $default;

    /**
     * The expiration time of a job.
     *
     * @var int|null
     */
    protected $expire = 60;

    /**
     * Create a new database queue instance.
     *
     * @param  \Illuminate\Database\Connection  $database
     * @param  string  $table
     * @param  string  $default
     * @param  int  $expire
     * @return void
     */
    public function __construct(Connection $database, $table, $default = 'default', $expire = 60)
    {
        $this->table = $table;
        $this->expire = $expire;
        $this->default = $default;  //////
        $this->database = $database;
    }

    /**
     * Push a new job onto the queue.
     * 发送消息进队列
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->pushToDatabase(0, $queue, $this->createPayload($job, $data));  //////
    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @param  array   $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        return $this->pushToDatabase(0, $queue, $payload);
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTime|int  $delay
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return void
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->pushToDatabase($delay, $queue, $this->createPayload($job, $data));
    }

    /**
     * Push an array of jobs onto the queue.
     *
     * @param  array   $jobs
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function bulk($jobs, $data = '', $queue = null)
    {
        $queue = $this->getQueue($queue);

        $availableAt = $this->getAvailableAt(0);

        $records = array_map(function ($job) use ($queue, $data, $availableAt) {
            return $this->buildDatabaseRecord(
                $queue, $this->createPayload($job, $data), $availableAt
            );
        }, (array) $jobs);

        return $this->database->table($this->table)->insert($records);
    }

    /**
     * Release a reserved job back onto the queue.
     *
     * @param  string  $queue
     * @param  \StdClass  $job
     * @param  int  $delay
     * @return mixed
     */
    public function release($queue, $job, $delay)
    {
        return $this->pushToDatabase($delay, $queue, $job->payload, $job->attempts);
    }

    /**
     * Push a raw payload to the database with a given delay.
     *
     * @param  \DateTime|int  $delay
     * @param  string|null  $queue
     * @param  string  $payload
     * @param  int  $attempts
     * @return mixed
     */
    protected function pushToDatabase($delay, $queue, $payload, $attempts = 0)
    {
        $attributes = $this->buildDatabaseRecord(
            $this->getQueue($queue), $payload, $this->getAvailableAt($delay), $attempts
        );  //根据给定的消息实例创建一个插入数据库的数组。

        return $this->database->table($this->table)->insertGetId($attributes);  //返回的是插入数据库表中的ID。
    }

    /**
     * Pop the next job off of the queue.
     * 从队列中获取消息
     *
     * @param  string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        if (! is_null($this->expire)) {
            $this->releaseJobsThatHaveBeenReservedTooLong($queue);  //好长的函数名 释放那些保留时间太长的作业(消息)
        }

        if ($job = $this->getNextAvailableJob($queue)) {  //从队列中获取下一个可用的消息
            $this->markJobAsReserved($job->id);  //将给定的消息ID标记为保留，并记录保留的时间   字段设置：'reserved' => 1, 'reserved_at' => $this->getTime()

            $this->database->commit();

            return new DatabaseJob(
                $this->container, $this, $job, $queue
            ); //获取的消息被封装在Illuminate\Queue\Jobs\DatabaseJob类实例中
        }

        $this->database->commit();
    }

    /**
     * Release the jobs that have been reserved for too long.
     *
     * @param  string  $queue
     * @return void
     */
    protected function releaseJobsThatHaveBeenReservedTooLong($queue)
    {
        $expired = Carbon::now()->subSeconds($this->expire)->getTimestamp();

        $this->database->table($this->table)
                    ->where('queue', $this->getQueue($queue))
                    ->where('reserved', 1)
                    ->where('reserved_at', '<=', $expired)
                    ->update([
                        'reserved' => 0,
                        'reserved_at' => null,
                        'attempts' => new Expression('attempts + 1'),
                    ]);
    }

    /**
     * Get the next available job for the queue.
     * 从队列中获取下一个可用的消息
     *
     * @param  string|null  $queue
     * @return \StdClass|null
     */
    protected function getNextAvailableJob($queue)
    {
        $this->database->beginTransaction();

        $job = $this->database->table($this->table)
                    ->lockForUpdate()
                    ->where('queue', $this->getQueue($queue))
                    ->where('reserved', 0)
                    ->where('available_at', '<=', $this->getTime())
                    ->orderBy('id', 'asc')
                    ->first();  //////

        return $job ? (object) $job : null;
    }

    /**
     * Mark the given job ID as reserved.
     * 将给定的消息ID标记为保留，并记录保留的时间
     *
     * @param  string  $id
     * @return void
     */
    protected function markJobAsReserved($id)
    {
        $this->database->table($this->table)->where('id', $id)->update([
            'reserved' => 1, 'reserved_at' => $this->getTime(),
        ]);  // 'reserved' => 1, 'reserved_at' => $this->getTime()
    }

    /**
     * Delete a reserved job from the queue.
     *
     * @param  string  $queue
     * @param  string  $id
     * @return void
     */
    public function deleteReserved($queue, $id)
    {
        $this->database->table($this->table)->where('id', $id)->delete();
    }

    /**
     * Get the "available at" UNIX timestamp.
     *
     * @param  \DateTime|int  $delay
     * @return int
     */
    protected function getAvailableAt($delay)
    {
        $availableAt = $delay instanceof DateTime ? $delay : Carbon::now()->addSeconds($delay);

        return $availableAt->getTimestamp();
    }

    /**
     * Create an array to insert for the given job.
     * 根据给定的消息实例创建一个插入数据库的数组
     *
     * @param  string|null  $queue
     * @param  string  $payload
     * @param  int  $availableAt
     * @param  int  $attempts
     * @return array
     */
    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0)
    {
        //结构与使用php artisan queue:table创建数据库消息队列的数据表迁移文件结构一样。
        return [
            'queue' => $queue,
            'payload' => $payload,
            'attempts' => $attempts,
            'reserved' => 0,
            'reserved_at' => null,
            'available_at' => $availableAt,
            'created_at' => $this->getTime(),
        ];
    }

    /**
     * Get the queue or return the default.
     *
     * @param  string|null  $queue
     * @return string
     */
    protected function getQueue($queue)
    {
        return $queue ?: $this->default;
    }

    /**
     * Get the underlying database instance.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Get the expiration time in seconds.
     *
     * @return int|null
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set the expiration time in seconds.
     *
     * @param  int|null  $seconds
     * @return void
     */
    public function setExpire($seconds)
    {
        $this->expire = $seconds;
    }
}