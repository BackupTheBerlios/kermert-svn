<?php

/*

Pixelpost version 1.3
Calendar addon version 1.0.1

Pixelpost www: http://www.pixelpunk.se/software/
Contact: pixelpost@pixelpunk.se
Copyright (c) 2004 shapestyle graphic design + code<http://www.shapestyle.se>
License: http://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

*/

$addon_name = "Pixelpost Calendar";
$addon_description = "A standard calendar. Highlights days on which images are posted.<br />
Will return either a horizontal looking calendar, or a \"normal\" display.
";
$addon_version = "1.0.1";

if($_GET['x'] == "") {
// test calendar
if($cfgrow['calendar'] == "Normal") {
$cal_vz = "";
$curr_month = $_GET['curr_month'];
$curr_year = $_GET['curr_year'];
if(!$curr_year) { $curr_year = date("Y"); }
if(!$curr_month) { $curr_month = date("n"); }
if(!$curr_day) { $curr_day = date("j"); }
$days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$months = array("","January","February","Mars","April","May","June","July","August","September","October","November","December");
$total_days = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
// skottår, english word for this? hmm, february is one day longer anyway
if(date("L", mktime(0,0,0,$curr_month,1,$curr_year))) {
	$total_days[2] = 29;
	}
$prev_month = $curr_month-1;
$prev_year = $curr_year;
if($prev_month < 1) {
	$prev_month=12;
	$prev_year--;
	}
$next_month = $curr_month+1;
$next_year = $curr_year;
if($next_month > 12) {
	$next_month=1;
	$next_year++;
	}
// first day
$first_day_month = date("w", mktime(0,0,0,$curr_month,1,$curr_year));
$cal_vz .= "
	<table class='table_calendar_vz' cellspacing='0'>
	<tr>
	<td class='td_calendar_navi_vz'><a href='$PHP_SELF?curr_month=$prev_month&amp;curr_year=$prev_year'>&laquo;</a></td>
	<td colspan='5' class='td_calendar_navi_vz'>
	$months[$curr_month] $curr_year
	</td>
	<td class='td_calendar_navi_vz'><a href='$PHP_SELF?curr_month=$next_month&amp;curr_year=$next_year'>&raquo;</a></td>
	</tr>
	<tr>";
for ($x=0; $x<7; $x++) {
	$day = substr($days[$x],0,3);
	$cal_vz .= "<td class='td_calendar_days_vz'>$day</td>";
	}
$cal_vz .= "</tr><tr>";
for($x=2; $x<=$first_day_month; $x++) {
	$row_count++;
	$cal_vz .= "<td class='td_calendar_days_vz'>&nbsp;</td>";
	}
$day_count=1;
while($day_count <= $total_days[$curr_month]) {
	if($row_count % 7 == 0) { $cal_vz .= "</tr><tr>"; }
	if($day_count <= 9) { $day_count = "0$day_count"; }
	$thismonth = $curr_month;
	if($curr_month <= 9) { $thismonth = "0$curr_month"; }
	if($day_count <= date("j") && $curr_year == date("Y") && $curr_month == date("n") OR ($curr_month < date("m") AND $curr_year <= date("Y"))) {
		$class = "td_calendar_days_vz";
		} else { 
		$class = "td_calendar_days_vz"; 
		}
	$image_search = "$curr_year-$thismonth-$day_count"; // correct queryformat to check if any image are present the current day
	$link = ""; // forgot, dare not delete yet
	$link2 = ""; // forgot, dare not delete yet
	// search for image for this day
	$dayimage = "false";
	$query = mysql_query("select * from ".$pixelpost_db_prefix."pixelpost where (datetime like '$image_search%') and (datetime<='$cdate')");
	while(list($img_id, $img_datetime, $img_headline, $img_body, $img_image) = mysql_fetch_row($query)) {
		$dayimage = "true";
		$curr_image_id = $img_id;
		}
	if($dayimage == "true") {	
		$class = "td_calendar_days_imagefound"; 
		$link = "<a href='$PHP_SELF?curr_month=$curr_month&amp;curr_year=$curr_year&amp;showimage=$curr_image_id' title='An Image Was Posted This Day'>";
		$link2 = "</a>";
		}
	$cal_vz .= "<td class='$class'>$link$day_count$link2</td>";
	$day_count++;
	$row_count++;
	}
$cal_vz .= "
	</tr>
	</table>
	";
	$tpl = ereg_replace("<SITE_CALENDAR>",$cal_vz,$tpl);


	} // normal cal end
if($cfgrow['calendar'] == "Horizontal") {
// horizontal
$cal_hz = "";
$curr_month = $_GET['curr_month'];
$curr_year = $_GET['curr_year'];
if(!$curr_year) { $curr_year = date("Y"); }
if(!$curr_month) { $curr_month = date("n"); }
if(!$curr_day) { $curr_day = date("j"); }
$days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$months = array("","January","February","Mars","April","May","June","July","August","September","October","November","December"); 
$total_days = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
// skottår
if(date("L", mktime(0,0,0,$curr_month,1,$curr_year))) {
	$total_days[2] = 29;
	}
$prev_month = $curr_month-1;
$prev_year = $curr_year;
if($prev_month < 1) {
	$prev_month=12;
	$prev_year--;
	}
$next_month = $curr_month+1;
$next_year = $curr_year;
if($next_month > 12) {
	$next_month=1;
	$next_year++;
	}
// first day of month
$first_day_month = date("w", mktime(0,0,0,$curr_month,1,$curr_year));
$cal_hz .= "<table class='table_calendar' cellspacing='0'><tr>";
// print the calendar days
$day_count=1;
while($day_count <= $total_days[$curr_month]) {
	if($day_count <= 9) { $day_count = "0$day_count"; }
	$thismonth = $curr_month;
	if($curr_month <= 9) { $thismonth = "0$curr_month"; }
	if($day_count <= date("j") && $curr_year == date("Y") && $curr_month == date("n") OR ($curr_month < date("m") AND $curr_year <= date("Y"))) {
		$class = "td_calendar_days";
		} else { 
		$class = "td_calendar_days"; 
		}
	$image_search = "$curr_year-$thismonth-$day_count"; // correct queryformat to check if any image are present the current day
	$link = ""; // forgot, dare not delete yet
	$link2 = ""; // forgot, dare not delete yet
	// search for image for this day
	$dayimage = "false";
	$query = mysql_query("select * from ".$pixelpost_db_prefix."pixelpost where (datetime like '$image_search%') and (datetime<='$cdate')");
	while(list($img_id, $img_datetime, $img_headline, $img_body, $img_image) = mysql_fetch_row($query)) {
		$dayimage = "true";
		$curr_image_id = $img_id;
		}
	if($dayimage == "true") {	
		$class = "td_calendar_days_imagefound"; 
		$link = "<a href='$PHP_SELF?curr_month=$curr_month&amp;curr_year=$curr_year&amp;showimage=$curr_image_id' title='An Image Was Posted This Day'>";
		$link2 = "</a>";
		}
	$cal_hz .= "<td class='$class'>$link$day_count$link2</td>";
	$day_count++;
	$row_count++;
	}
$showimage = $_GET['showimage'];
$cal_hz .= "
	</tr>
	<tr>
	<td colspan='31' class='td_calendar_navi'>
	<a href='$PHP_SELF?curr_month=$prev_month&amp;curr_year=$prev_year&amp;showimage=$showimage'>&laquo;</a> 
	$months[$curr_month] $curr_year
	<a href='$PHP_SELF?curr_month=$next_month&amp;curr_year=$next_year&amp;showimage=$showimage'>&raquo;</a>
	</td>
	</tr></table>
	";
	$tpl = ereg_replace("<SITE_CALENDAR>",$cal_hz,$tpl);
	}
// end horizontal calendar
    }

?>