<?php
/*!
 * @FileName: index.php
 * @Description: [Description]
 * @Author: User
 * @Date: 2016-10-20 15:33:08
 * @Email: gray_guest@126.com
 * @Last Modified by: User
 * @Last Modified time: 2017-07-04 11:25:18
 */
 	header("Content-Type: text/html;charset=gb2312");
	date_default_timezone_set('PRC');//设置时区 中华人民共和国
 	echo time()."<br/>";
 	echo date("Y-m-d G-i-s")."<br/>";
 	echo "2016/11/4 21:09 在宿舍台式机修改此文件!".'<br/>';

//反射例子
	class ReflectorTestCase {
	    public function __construct($i, $j) {
	        echo "A construct";
	    }
	}

	$concrete = new ReflectorTestCase;

	$reflector = new ReflectionClass($concrete);

	$constructor = $reflector->getConstructor();

	$dependencies = $constructor->getParameters();

	var_dump($dependencies);

	foreach ($dependencies as $key => $value)
	    echo $key.'=>'.$value->name."<br/>";


//后期静态绑定(Late Static Bindings)例子
    // A hard problem：
    class A {
        public static function foo() {
            static::who(); //
        }

        public static function who() {
            echo __CLASS__."\n";
        }

    }

    class B extends A {
        public static function test() {
            A::foo();
            parent::foo();
            self::foo();
        }

        public static function who() {
            echo __CLASS__."\n";
        }

    }
    class C extends B {
        public static function who() {
            echo __CLASS__."\n";
        }

    }

    C::test();

    /*  总结
      预编译 ->         编译     -> 运行
      static   -> 继承父函数 -> static::who()
    */

//htmlentities vs. htmlspecialchar             编码/解码相关
    $str = '<a href="demo.php?m=index&a=index&name=中文">测试页面</a>';

    echo 'htmlentities指定GB2312编码：'.htmlentities($str, ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, "GB2312")."\n";  //解码   json_encode()编码


    echo 'htmlentities未指定编码：    '.htmlentities($str)."\n";

    $str = '<a href="demo.php?m=index&a=index&name=中文">测试页面</a>';

    echo 'htmlspecialchars未指定编码：'.htmlspecialchars($str)."\n";