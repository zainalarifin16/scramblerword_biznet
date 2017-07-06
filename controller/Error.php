<?php

/**
* Error Controller
*/
class Error
{
	
	function __construct()
	{
		
	}

	public function display_error()
	{
		include_once("view/error_404.php");
	}
}

?>