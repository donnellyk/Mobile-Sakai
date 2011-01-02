<?php

include 'sakai_functions.php';
//ini_set('display_errors', 'On');
function doLogin($username, $password){	
	// FILLER TO BYPASS SAKAI
	$result = sakai_login_valid($username, $password);
	if(is_array($result)){
		// I'm not sure if I NEED this but I want to make sure it doesnt get carried away with sessions.
		//session_destroy(); 
		session_start(); // load new session
		list($soap, $session) = $result;
		if(strlen($session) == 36) {
			//Valid login
			$_SESSION["name"] = $username;
			$_SESSION["soap"] = $soap;
			$_SESSION["soap_session"] = $session;
			header('Location: ./profile.php');
 		} else {
 			//Invalid Login
 			session_destroy(); 
			header('Location: ./index.php?errors=1');
		}
	} else {
		header('Location: ./index.php?errors=1');
	}
}
function absolute_url($page = 'index.php'){
	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
   $url = rtrim($url, '/\\');
   $url = $url.'/'.$page;
   return $url;
}

function checkLoginStatus(){
	//Check if session is set...
	if(!isset($_SESSION["soap_session"])) {
		$url = absolute_url('index.php');
		header("Location: $url");
	}
	//Check if session is valid
	/*
	$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
	$active = new SoapClient($script_wsdl, array('exceptions' => 0));
	$response = $active->validSession($_SESSION["soap_session"]);
	*/
	$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
	$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
	$session = $_SESSION["soap_session"];
	
	//Just need to test if session is open...
	$response = $soap->getUserEmail($session);
	if ($response == "false") {
		$url = absolute_url('index.php?errors=3');
		header("Location: $url");
	}
}

function logout(){
	if(isset($_SESSION["soap_session"])) {
		//print "Unsetting";
		unset($_SESSION["soap_session"]);
	}
	$url = absolute_url('index.php?errors=2');
	header("Location: $url");
}