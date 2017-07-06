<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 执行迁移
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            /*
             * 字段类型：increments()  integer() float() double()  string():相当于varchar类型  text():相当于text类型
             * 修饰：first() nullable() default($value) unsigned()
             * 索引：primary()主键  unique()唯一索引 index()加入基本索引
             * */
            $table->increments('id');  //相当于Incrementing类型（数据表主键）
            $table->string('name');  //相当于varchar类型
            $table->string('email')->unique();  //加入唯一索引
            $table->string('password');
            $table->rememberToken();  //记录令牌，相当于100位长度varchar，varchar(100)。
            $table->timestamps();  //加入created_at和updated_at字段。
        });
    }

    /**
     * Reverse the migrations.
     * 回滚迁移
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
