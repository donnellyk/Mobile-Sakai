<?php
/**
* whitebm4
* This seems like the most elegant way of doing errors without using a database.
**/

$all_errors = array (	
	"1" => "Username/Password combination failed",
	"2" => "You have been logged out.",
	"3" => "Your session has expired."
);

// Gets the actually triggered errors and prints them.
$errors = $_GET["errors"];
if($errors) { 
	$a_errors = explode(",",$errors);
	echo "<div>";
	foreach ($a_errors as &$e) {
	    echo $all_errors[$e];
	}
	echo "</div>"; 
} 
?>