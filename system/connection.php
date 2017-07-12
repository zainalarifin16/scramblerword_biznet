<?php 

/**
* Class DB;
*/
class Db
{
	private static $instance = NULL;
	
	private static $option_connection = array(
							'db_name'	=> 'scrambler_biznet',
							'username'	=> 'root',
							'password'	=> 'root',
							);

	private function __construct() {}

	private function __clone() {}

	public static function getInstance()
	{
		if(!isset(self::$instance)){
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$instance = new PDO('mysql:host=localhost;dbname='.self::$option_connection['db_name'], self::$option_connection['username'], self::$option_connection['password'], $pdo_options);
		}

		return self::$instance;

	}

}

 ?>