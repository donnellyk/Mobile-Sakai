<?
// This was the example provided to us.
function sakai_soap_connect($host=null, $user=null, $pass=null) {
	if ($host == null) { 
		$host = 'localhost';   
	}
	if ($user == null) {
		$user = 'admin';   
	}
	if ($pass == null) {
		$pass = 'admin';   
	}
	
	$login_wsdl = $host .'/sakai-axis/SakaiLogin.jws?wsdl';
	$script_wsdl = $host .'/sakai-axis/SakaiMobileScriptC.jws?wsdl';

	$login = new SoapClient($login_wsdl, array('exceptions' => 0));
	$session = $login->login($user, $pass);
	$active = new SoapClient($script_wsdl, array('exceptions' => 0));
	return array($active, $session);
}

// I want to use this one for users from our app actually checking to see if they can login.
function sakai_login_valid($user, $pass) {
	//$host = 'localhost'; 
	$login_wsdl = "http://localhost:8080/sakai-axis/SakaiLogin.jws?wsdl";
	$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
	
	$login = new SoapClient($login_wsdl, array('exceptions' => 0));
	$session = $login->login($user, $pass);
	
	$active = new SoapClient($script_wsdl, array('exceptions' => 0));
	return array($active, $session);
}
