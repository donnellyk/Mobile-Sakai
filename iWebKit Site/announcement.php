<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<? include 'header.php' ?>
<body>
<div id="topbar" class="black">
	<div id="title">
		CSE 274</div>
		<div id="leftnav">
			<a href="profile.php"><img alt="home" src="images/home.png" /></a></div>
	<div id="rightbutton">
		<a href="./logout.php" class="noeffect">Logout</a> </div>
</div>
<div id="content">
	<center>
	<h1>Announcement</h1>
	<?
	$response = "<list><announcement><title>George Clooney!</title><description>Some guy visited</description><date>11/12/10</date></announcement><announcement><title>Brad Pitt!</title><description>Some other guy visited</description><date>11/14/10</date></announcement></list>";
	$xml = simplexml_load_string($response);
	$items = array();
	echo "<div class='pageitem'>";
	foreach ($xml->announcement AS $item) {
		if(strcmp($item->title, $_GET["id"]) == 0 ){
			echo "<p><h3>". $item->title . "</h3></p>";
			echo "<p>". $item->date . "</p>";
			echo "<p>". $item->description . "</p>";
		}
	}
	echo "</div>";
	?>
</div>

<? include 'footer.php' ?>
</body>
</html>