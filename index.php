<?php 
// index.php

include_once("controller/Controller.php");

$requestUrl = "$_SERVER[REQUEST_URI]";
$userRequest = explode("/", $requestUrl);
$countRequest = count($userRequest);

$default_controller = "Controller";
$error_controller = "Error";

if($requestUrl == "/")
	$controller = new $default_controller;
else{
	if($countRequest == 3 || $countRequest == 4){
		if(file_exists(getcwd()."/controller/".$userRequest[1].".php")){
			$callController = ucwords(strtolower($userRequest[1]));
			include_once("controller/".$callController.".php");
			$controller = new $callController;
		}
	}
}


if(isset($controller))
	if($countRequest == 3)
	{
		unset($_GET["p"]);
		$variable = $_GET;
		$parameter = explode("?", $userRequest[2]);
		/*if (count($parameter)>1)
		{
			$variable  = explode("&", $parameter[1]);
		}*/
		try {
			call_user_func_array( 
							array( $controller, $parameter[0] ),
							$variable
							);
		} catch (Exception $e) {
			echo "<h2>ERROR 404</h2>";
			echo $e->getMessage();
			
		}
	}
	else
		$controller->index();
else
	echo "<h2>ERROR 404</h2>";
?>
