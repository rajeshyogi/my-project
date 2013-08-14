<?php
	interface Ispeak{
		function speak();
	}
	
	interface Iwalk{
		function walk();
	}
	
	interface Ilisten{
		function listen();
	}
	
	interface Ieat{
		function eat();
	}
	
	class human{

		// public function __construct(){
			// echo 'they can speak';
		// }
		// public function speak(){
			// echo 'they can speak..';
		// }
		
	}
		
		class blindhuman extends human implements Ispeak {

			public function speak(){
				echo 'they can speak';
			}
			public function blind(){
				echo 'they cant see.';
			}
		}
		
	
	
	$objOfClass = new blindhuman();
	$objOfClass->speak();
	
?>