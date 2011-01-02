<? 
session_start(); 
include 'login_functions.php';
checkLoginStatus();

include 'header.php';

ini_set('display_errors', 'On');
$site_id = $_GET["siteId"]; 
$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
$session = $_SESSION["soap_session"];
?>

<body>
<div id="topbar" class="black">
	<div id="title">
		Roster</div>
	<div id="leftnav">
		<? echo "<a href='profile.php'><img alt='home' src='images/home.png' /></a><a href='class.php?siteId=$site_id'>Class</a>\n"?>
	</div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a> </div>
</div>

<?
	$response = $soap->getUsersInSite($session, $site_id);
	//$response = "<list><user><name>John Doe</name><email>JD@muohio.edu</email></user></list>";
	$xml = simplexml_load_string($response);
	$items = array();
	echo "<div id='content'><h3>Roster</h3>";
	echo "<ul class='pageitem'>";
	foreach ($xml->user AS $item) {
		echo "<li class='menu'><span class='name'><a href='mailto:".$item->email."'>".$item->name.", ".$item->type."</a></span></li>" ;
	}
	echo "</ul>";
?>
<? include 'footer.php' ?> 
</body>
</html>