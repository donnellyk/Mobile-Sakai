<? 
session_start(); 
include 'login_functions.php';
checkLoginStatus();

include 'header.php';
ini_set('display_errors', 'On');
if (isset($_GET["siteId"])) {
	$site_id = $_GET["siteId"];
}
$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
$session = $_SESSION["soap_session"];
?>


<body>
<?
/** ASSIGNMENTS
*<list>
 *	<as>
 *		<title>Homework 3</title>
 *		<due>12/21/2010</due>
 *	</as>
 *	<as>
 *		...
 *	</as>
 *	...
 *</list>
 */
if(isset($_GET["day"])){ // We have a day to focus on. No class focused.
	$response = $soap->getAssignmentsForUser($session);
	echo '<div id="topbar" class="black">
		<div id="title">
			Assignments</div>
		<div id="leftnav">
			<a href="profile.php"><img alt="home" src="images/home.png" /></a></div>
		<div id="rightbutton">
			<a href="./logout.php" class="noeffect">Logout</a> </div>
	</div>';	//$response = "<list><as><title>HW1</title><due>12/20/10</due></as><as><title>HW2</title><due>12/23/10</due></as></list>";
	$xml = simplexml_load_string($response);
	$items = array();
	echo "<div id='content'><h3>Assignments</h3>";
	echo "<ul class='pageitem'>";
	foreach ($xml->as AS $item) {
		$date = split("/",$item->due);
		if(strcmp($_GET["month"], $date[0])==0 && strcmp($_GET["day"], $date[1]) == 0 && strcmp($_GET["year"], $date[2]) == 0){
			if (isset($site_id)) {
				$link = "'./assignment.php?siteId=$site_id&asgnid=$item->title'";
			 } else {
			 	$link = "'./assignment.php?asgnid=$item->title'";
			 }
			 $type = "$item->title - $item->due";
			 echo "<li class='menu'><span class='name'><a href=".$link.">".$type."</a></span></li>";
			 
		}
	}
	echo "</ul></div>";
	
} else { // we want all the assignments for this class
	$response = $soap->getAssignmentsForCourse($session, $site_id);
	
	echo '<div id="topbar" class="black">
		<div id="title">
			Assignments</div>
		<div id="leftnav">
				<a href="profile.php"><img alt="home" src="images/home.png" /></a><a href="class.php?siteId='.$site_id.'">Class</a></div>
		<div id="rightbutton">
			<a href="./logout.php" class="noeffect">Logout</a> </div>
	</div>';
	//$response = "<list><as><title>HW1</title><due>12/20/10</due></as><as><title>HW2</title><due>12/23/10</due></as></list>";
	$xml = simplexml_load_string($response);
	$items = array();
	echo "<div id='content'><h3>Assignments</h3>";
	echo "<ul class='pageitem'>";
	foreach ($xml->as AS $item) {
		$link = "'./assignment.php?siteId=$site_id&asgnid=$item->title'";
		$type = "$item->title - $item->due";
		echo "<li class='menu'><span class='name'><a href=".$link.">".$type."</a></span></li>";
		
		//./assignment.php?siteId=".$site_id."&asgnid=".$item->title."'>".$item->title." - ".$item->due."</span></li>" ;
	}
	echo "</ul></div>";	
}
?>
<? include 'footer.php' ?>
</body>
</html>