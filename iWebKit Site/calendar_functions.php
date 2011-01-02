<?php
/**
Author: whitebm4
Using some basic php calendar from the internet, I forgot to copy the link.. :(

WE GET FROM SAKAI: 
<list>
		 <as>
		 		<title>Homework 3</title>
		 		<due>12/21/2010</due>
		 </as>
</list>
WE WANT: array( array("title"=>"Some Title", "month"=>12, "day"=>20, "year"=>2008), ...);
**/
function convertSakaiAssignmentsToCalendarArray($response){
	$xml = simplexml_load_string($response);
	$items = array();
	foreach ($xml->as AS $item) { 
		$date = split("/",$item->due);
		$items[] = array("title" => $item->title, "month" => $date[0],"day" => $date[1],"year" => $date[2]);
	}
	return $items;
}

function calendar($year, $month, $events, $day_offset = 0){ 
    $days = array("Sun","Mon","Tues","Weds","Thurs","Fri","Sat");
    $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $day_offset = $day_offset % 7;
    $start_day = gmmktime(0,0,0,$month,1,$year); 
    $start_day_number = date("w",$start_day);
    $days_in_month = date("t",$start_day);
    $final_html = "<table>\n<tr><td class='cal_title' colspan = \"7\">".$months[$month-1]." $year</td></tr>\n";
    for($x=0;$x<=6;$x++){
    	$final_html .= "<td class='cal_labels'>".$days[($x+$day_offset)%7]."</td>";
    }
    $final_html .= "</tr>\n";
    $blank_days = $start_day_number - $day_offset;
    if($blank_days<0){$blank_days = 7-abs($blank_days);}
    for($x=0;$x<$blank_days;$x++){
    	$final_html .= "<td class='cal_blank'></td>";
    }
    for($x=1;$x<=$days_in_month;$x++){
    	if(($x+$blank_days-1)%7==0){
    		$final_html .= "</tr>\n<tr>";
    	}
		$eventExists = false;
		foreach ($events as &$event) {
		    if($event["day"] == $x && $event["month"] == $month && $event["year"] == $year){
				$eventExists = true;
			}
		}
		if($eventExists){
			$final_html .= "<td class='cal_assignment'><a href='./assignments.php?day=".$x."&month=".$month."&year=".$year."'>$x</td>";	
		} else {
    		$final_html .= "<td class='cal_day'>$x</td>";
		}
    }
    while((($days_in_month+$blank_days)%7)!=0){
    	$final_html .= "<td class='cal_blank'></td>";
    	$days_in_month++;
    }
    $final_html .= "</tr>\n</table>";
	return($final_html);
}