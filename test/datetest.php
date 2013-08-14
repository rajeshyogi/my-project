<?php
	class newdate extends datetime
	{
		public function currentdate()
		{
			$date = date('d/m/Y');
		}
	}
	 $obj = new newdate();
	 $obj->currentdate();
?>