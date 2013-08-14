<?php
/*
interface abstract and inharitence examples
*/
interface IflyAble{
	function fly();
}

interface IEatAble{
	function eat();
}

interface IswimAble{
	function swim();
}

abstract class ADuck{
	abstract function create();
	
	function ADuck(){
		
		echo 'This is L function';
	}
}

class Duck extends ADuck
{
	public function __construct(){
		$this->create();
	}
	
	function create(){
	echo 'Duck Created';
	}
	
	
}

class flyableClass extends Duck implements IflyAble {
	function fly(){
	echo  'This Duck can fly';
	}
}


class realDuck  extends flyableClass implements IEatAble {
	function eat(){
	echo  'This Duck can fly and Eat';
	}
}

$realDuck = new realDuck();

?>