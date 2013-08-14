<?php
// $filename = 'file.txt';
// $file = file_get_contents($filename);
// $file .= 'this file is created by rajesh yogi';
// file_put_contents($filename,$file);

// class trick
// {
      // function doit()
      // {
                // echo __FUNCTION__;
      // }
      // function doitagain()
      // {
                // echo __METHOD__;
      // }
// }
// $obj=new trick();
//$obj->doit();

// $obj->doitagain();



// $foo = 'Bob';              // Assign the value 'Bob' to $foo
// $bar = &$foo;              // Reference $foo via $bar.
// $bar = "My name is $bar";  // Alter $bar...
// echo $bar;
// echo $foo;                 // $foo is altered too.

// $a = 'Hello';
// $$a = 'world';
// echo "$a ${$a}";


// $arr = array('one', 'two', 'three', 'four', 'stop', 'five');
// while (list(, $val) = each($arr)) 
// {

    // if ($val == 'stop') {
        // break;    /* You could also write 'break 1;' here. */
    // }
    // echo "$val<br />\n";
// }

// $arr = array('one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'stop' => '0', 'five' => '5');
//echo '<pre>';
//var_dump($arr);
// while(list($key,$val) = each($arr)){
	// echo $key."=>".$val;
// }


// function recursion($a)
// {
    // if ($a < 20) {
        // echo "$a\n";
        // recursion($a+1);
    // }
// }
// recursion();


// class BaseClass {
   // function __construct() {
       // print "In BaseClass constructor\n";
   // }
// }

// class SubClass extends BaseClass {
   // function __construct() {
       // parent::__construct();
       // print "In SubClass constructor\n";
   // }
// }

// class OtherSubClass extends BaseClass {
    //inherits BaseClass's constructor
// }

//In BaseClass constructor
// $obj = new BaseClass();
// $obj = new SubClass();
// $obj = new OtherSubClass();


// class MyClass
// {
    // public $public = 'Public';
    // protected $protected = 'Protected';
    // private $private = 'Private';

    // function printHello()
    // {
        // echo $this->public;
        // echo $this->protected;
        // echo $this->private;
    // }
// }

// $obj = new MyClass();
//echo $obj->public; // Works
//echo $obj->protected; // Fatal Error
//echo $obj->private; // Fatal Error
//$obj->printHello(); // Shows Public, Protected and Private
// $_get //
// $_post //
// $_request

// class myclass{
	// protected function hello()
	// {
		// echo 'this is protected hello()';
	// }
// }

// class myclass2 extends myclass{
	// public function hi(){
		// parent::hello();
		// echo 'this is public hi()';
	// }
// }

// $obj = new myclass2;
// $obj->hi();



// abstract class AbstractClass
// {
    //Force Extending class to define this method
    // abstract protected function getValue();
    // abstract protected function prefixValue($prefix);

    //Common method
    // public function printOut() {
        // print $this->getValue() . "\n";
    // }
// }

// class ConcreteClass1 extends AbstractClass
// {
    // protected function getValue() {
        // return "ConcreteClass1";
    // }

    // public function prefixValue($prefix) {
        // return "{$prefix}ConcreteClass1";
    // }
// }

// class ConcreteClass2 extends AbstractClass
// {
    // public function getValue() {
        // return "ConcreteClass2";
    // }

    // public function prefixValue($prefix) {
        // return "{$prefix}ConcreteClass2";
    // }
// }

// $class1 = new ConcreteClass1;
// $class1->printOut();

// echo $class1->prefixValue('FOO_') ."\n";



// abstract class AbstractClass
// {
    //Our abstract method only needs to define the required arguments
    // abstract protected function prefixName($name);

// }

// class ConcreteClass extends AbstractClass
// {

    //Our child class may define optional arguments not in the parent's signature
    // public function prefixName($name, $separator = ".") {
        // if ($name == "Pacman") {
            // $prefix = "Mr";
        // } elseif ($name == "Pacwoman") {
            // $prefix = "Mrs";
        // } else {
            // $prefix = "";
        // }
        // return "{$prefix}{$separator} {$name}";
    // }
// }

// $class = new ConcreteClass;
// echo $class->prefixName("Pacman"), "\n";
// echo $class->prefixName("Pacwoman"), "\n";


// interface a
// {
    // const b = 'Interface constant';
// }

// Prints: Interface constant
// echo a::b;


// This will however not work because it's not allowed to 
// override constants.
// class b implements a
// {
    // const b = 'Class constant';
// }

// class TestClass
// {
    // public $foo;

    // public function __construct($foo)
    // {
        // $this->foo = $foo;
    // }

    // public function __toString()
    // {
        // return $this->foo;
    // }
// }

// $class = new TestClass('Hello');
// echo $class;

// class A
// {
	// public function a(){
		// echo 'this is function a';
	// }
// }

// class B extends A{
	// public function a(){
		// echo 'overrite a() of Class A <br/>';
	// }
	
	
	// public function b(){
		//b ka a 
		//echo 'this is function b<br/>';
		
		// self::a();
	// }
// }

// class C extends B{
	// public function a(){
		// echo 'overrite aaa2212aaaa() of Class A <br/>';
	// }
	
	// public function c()
	// {
		//echo 'this is function c<br>';
		// $this->b();
	// }
// }
// $obj = new C();


// class CallableClass
// {
    // public function __invoke($x)
    // {
        // var_dump($x);
    // }
// }
// $obj = new CallableClass;
// $obj(5);
// var_dump(is_callable($obj));


// class a 
// {
    // public function a1 ()
    // {
        // $this->b1();    
    // }

    // protected function b1()
    // {
        // echo 'This is in the a class<br />';
    // }
// }

// class b extends a 
// {
    // protected function b1()
    // {
        // echo 'This is in the b class<br />';
    // }
// }

// class c extends a
// {
    // protected function b1()
    // {
        // echo 'This is in the c class<br />';
    // }
// }

// $a = new a();
// $a->a1();

// $b = new b();
// $b->a1();

// $c = new c();
// $c->a1(); 


 // class BaseClass {
   // public function test() {
       // echo "BaseClass::test() called\n";
   // }
   
   // final public function moreTesting() {
       // echo "BaseClass::moreTesting() called\n";
   // }
// }

// class ChildClass extends BaseClass {
   // public function moreTesting() {
       // echo "ChildClass::moreTesting() called\n";
   // }
// }


// class A {
    // public static function who() {
        // echo __CLASS__;
    // }
    // public static function test() {
        // self::who();
    // }
// }

// class B extends A {
    // public static function who() {
        // echo __CLASS__;
    // }
// }

// B::test();

?>
