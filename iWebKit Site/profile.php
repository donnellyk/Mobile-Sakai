<? 
session_start(); 
include 'login_functions.php';
checkLoginStatus();

include 'header.php';
?>
<body>
<div id="topbar" class="black">
	<div id="title">
		Profile</div>
	<div id="leftbutton"></div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a> </div>
</div>

<div id="content">
	<div class="pageitem">
		<image style="padding-left: 5px; padding-top: 5px;" src="images/logo.jpg" width="50%"/>
		<span style="float:right; padding-right: 20px; padding-top: 40px;" width="50%"><h2>Sakai</h2></span>
	</div>
	<h1>Welcome, <? echo $_SESSION["name"]; ?></h1>
	<? 
		$response = "<list><announcement><title>George Clooney!</title><description>Some guy visited</description><date>11/12/10</date></announcement><announcement><title>Brad Pitt!</title><description>Some other guy visited</description><date>11/14/10</date></announcement></list>";
		$xml = simplexml_load_string($response);
		$items = array();
		echo "<h3>Announcements</h3>";
		echo "<ul class='pageitem'>";
		foreach ($xml->announcement AS $item) {
			echo "<li class='menu'><span class='name'><a href='./announcement.php?id=".$item->title."'>".$item->title ."</a></span><span class='arrow'></span></li>" ;
		}
		echo "</ul>";
		$script_wsdl = "http://localhost:8080/sakai-axis/SakaiMobileScriptC.jws?wsdl";
		$soap = new SoapClient($script_wsdl, array('exceptions' => 0));
		$session = $_SESSION["soap_session"];
		
		$response = $soap->getCoursesUserCanAccess($session);
		//Debug print $response;
		//DEBUG $response = "<list><item><siteId>213</siteId><siteTitle>CSE 217</siteTitle></item></list>";
		$xml = simplexml_load_string($response);
		$items = array();
		echo "<div id='content'><h3>Course List</h3>";
		echo "<ul class='pageitem'>";
		foreach ($xml->item AS $item) {
			echo "<li class='menu'><span class='name'><a href='./class.php?siteId=".$item->siteId."'>".$item->siteTitle ."</a></span><span class='arrow'></span></li>" ;
		}
		echo "</ul>";
	?>
	
	<?
	include 'calendar_functions.php';
	$response = $soap->getAssignmentsForUser($session);
	
	$someArray = convertSakaiAssignmentsToCalendarArray($response);
	echo "<center>".calendar(date("Y"),date("m"),$someArray);
	?>
</div>
<? include 'footer.php' ?>
</body>
</html>