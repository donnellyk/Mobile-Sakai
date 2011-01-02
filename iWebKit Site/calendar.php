<? 
session_start(); 
include 'login_functions.php';
checkLoginStatus();

include 'header.php';
//ini_set('display_errors', 'On');
$site_id = $_GET["siteId"]; 
$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
$session = $_SESSION["soap_session"];
?>

<body>
<div id="topbar" class="black">
	<div id="title">
		CSE 274</div>
	<div id="leftnav">
		<a href="profile.php"><img alt="home" src="images/home.png" /></a><a href="class.php">Class</a></div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a> </div>
</div>
<div id="content">
	<center>
	<div class="pageitem">
	<?
		include 'calendar_functions.php';
		$response = $soap->getAssignmentsForCourse($session, $site_id);
		//$response = "<list><as><title>HW 1</title><due>12/20/2010</due></as><as><title>HW 2</title><due>12/23/2010</due></as></list>";
		$someArray = convertSakaiAssignmentsToCalendarArray($response);
		echo calendar(date("Y"),date("m"),$someArray);
	?>
	</div>
</div>

<? include 'footer.php' ?>
</body>
</html>