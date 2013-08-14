<?php
// class ok {
	// protected $_type;
	
	// public function gettype(){
		// return $this->_type;
	// }
	
	// public function settype($type){
		// $this->_type = $type;
	// }
	
// }

// $obj = new ok();
// $obj->settype('Book');
// echo $obj->gettype();

class foo {
	
	private static $instance;
	
	private $_a = 1;
	
	// private function __construct(){
		// echo "This is singleton pattern.";
	// }
	
	public static function singleton(){
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }
	
	public function set($a){
		$this->_a =$a;
	}
	
	public function get(){
		return $this->_a;
	}

}



$obj = foo::singleton();
$obj->set(3);
echo "<p>With Singleton</p>";
echo "<br/>". $obj->get();
$obj1 =  foo::singleton();
echo "<br/>".$obj1->get();




class foo1{
	private $instance;
	
	private $_a = 1;
	
	public function __construct(){
	
	}

	public function set($a){
		$this->_a =$a;
	}
	
	public function get(){
		return $this->_a;
	}

}

$obj3 =  new foo1();
$obj3->set(3);
echo "<p>Without SIngleton</p>";
echo "<br/>". $obj3->get();
$obj4 = new foo1();
echo "<br />".$obj4->get();
?>
