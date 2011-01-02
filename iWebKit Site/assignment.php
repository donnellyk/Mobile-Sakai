<? 
session_start(); 
include 'login_functions.php';
checkLoginStatus();

include 'header.php';
ini_set('display_errors', 'On');
if (isset($_GET["siteId"])) {
	$site_id = $_GET["siteId"];
}
$asgn_id = $_GET['asgnid'];
$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
$session = $_SESSION["soap_session"];
?>
<body>
<div id="topbar" class="black">
	<div id="title">Assignment</div>
	<div id="leftnav">
		<?
			if (isset($_GET["siteId"])) {
				echo "<a href='profile.php'><img alt='home' src='images/home.png' /></a><a href='class.php?siteId=$site_id'>Class</a>\n";
			} else {
				echo "<a href='profile.php'><img alt='home' src='images/home.png' /></a>\n";
			}
		?>
	</div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a>
	</div>
</div>
<?
$response = $soap->getAssignmentsForUser($session);$xml = simplexml_load_string($response);
$items = array();
foreach ($xml->as AS $item) {
	if (strcmp($item->title, $asgn_id) ==0) {
		echo "<h2>$asgn_id</h2>\n";
		echo "<h3>$item->due</h3>\n";
		echo "<h3>$item->instr</h3>\n";
		
	}
}
echo "</ul></div>";	
?>
<? include 'footer.php' ?>
</body>
</html>