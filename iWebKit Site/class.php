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
	<div id="title"><? echo $soap->getSiteTitle($session, $site_id); ?></div>
	<div id="leftnav">
		<a href="profile.php"><img alt="home" src="images/home.png" /></a></div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a> </div>
</div>

<div id="content">
	<center>
	<?
	 	$coursename = $soap->getSiteTitle($session, $site_id);
		//$coursename = "Data Structures";
		echo "<h1>".$coursename."</h1>";
	?>
	<?
		$response = $soap->getInstructorForCourse($session, $site_id);
		//$response = "<list><user><name>Gannod</name><email>gannod@muohio.edu</email></user></list>";
		$xml = simplexml_load_string($response);	
		$items = array();
		foreach ($xml->user AS $user) {
			echo "<h2>". $user->name ."</h2>";
			$email = "mailto:".$user->email."?subject=CSE 274";
		}
	?>
	<h3><? echo $soap->getSiteDescription($session, $site_id); ?> </h3>
	<? echo "<a href='assignments.php?siteId=$site_id'><img alt='assignments' src='thumbs/other.png'></a>\n";?>
	<a href=<?php echo $email;?>><img alt="email" src="thumbs/mail.png"></a>
	<? echo "<a href='roster.php?siteId=$site_id'><img alt='roster' src='thumbs/contacts.png'></a>\n"; ?>
	<br/>
	<?
	include 'calendar_functions.php';
	$response = $soap->getAssignmentsForCourse($session, $site_id);
	//$response = "<list><as><title>HW 1</title><due>12/20/2010</due></as><as><title>HW 2</title><due>12/23/2010</due></as></list>";
	$someArray = convertSakaiAssignmentsToCalendarArray($response);
	echo calendar(date("Y"),date("m"),$someArray);
	?>
	
	</center>
</div>

<div id="footer"></div>
</body>
</html>