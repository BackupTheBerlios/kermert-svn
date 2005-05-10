<?php

/*

Pixelpost version 1.3
index.php version 1.7

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

error_reporting(0);

// Set cookie for visitor counter, re-count a person after 60 mins
setcookie("lastvisit","expires in 60 minutes",time() +60*60);

// save user info if requested
if($_POST['vcookie'] == "set") {
    $name = clean($_POST['name']);
    $url = clean($_POST['url']);
    setcookie("visitorinfo","$name%$url",time() +60*60*24*30); // save cookie 30 days
    }

require("admin/pixelpost.php");
require("admin/markdown.php");

/* start up mysql */ 
mysql_connect($pixelpost_db_host, $pixelpost_db_user, $pixelpost_db_pass) || die("Error: ". mysql_error());
mysql_select_db($pixelpost_db_pixelpost) || die("Error: ". mysql_error());

// get config
if($cfgquery = mysql_query("select * from ".$pixelpost_db_prefix."config")) {
$cfgrow = mysql_fetch_array($cfgquery);
$upload_dir = $cfgrow['imagepath'];
} else {
    echo "pixelpost does not seem to be installed yet.";
    exit;
    }
// get the language file
require("language/lang-".$cfgrow['langfile'].".php");
    
$pixelpost_site_title = $cfgrow['sitetitle'];
// read the template file

switch ($_GET['x']) {
    case "":
    $tpl = file_get_contents("templates/".$cfgrow['template']."/image_template.html");
    break;
    case "ref":    
    $tpl = file_get_contents("templates/".$cfgrow['template']."/referer_template.html");
    break;
    case "browse":
    $tpl = file_get_contents("templates/".$cfgrow['template']."/browse_template.html");
    break;
    }
if($_GET['popup'] == "comment") {
    $tpl = file_get_contents("templates/".$cfgrow['template']."/comment_template.html");
    }
    
// book a visitor
$datetime = date("Y-m-d H:i:s");
$cdate = $datetime; // for future posting
$host = $_SERVER['HTTP_HOST'];
$referer = $_SERVER['HTTP_REFERER'];

// don't book a referer from self
$refererhost = parse_url($referer);
$refererhost = $refererhost['host'];
if($refererhost == $host) {
    $referer = "";
    }
$ua = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$ruri = $_SERVER['REQUEST_URI'];
// ### if cookie lastvisit not set, count the people!
if(!isset($_COOKIE['lastvisit'])) {
	$query = "insert into ".$pixelpost_db_prefix."visitors(id,datetime,host,referer,ua,ip,ruri)
	VALUES('NULL','$datetime','$host','$referer','$ua','$ip','$ruri')";
    $result = mysql_query($query);
    }
// Get visitor count
$visitors = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."visitors");
$row = mysql_fetch_array($visitors);
$pixelpost_visitors = $row['count'];
// Get number of photos in database
$photonumb = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."pixelpost where datetime<='$datetime'");
$row = mysql_fetch_array($photonumb);
$pixelpost_photonumb = $row['count'];

// images/main site
if($_GET['x'] == "") {
// Get Current Image.
if($_GET['showimage'] == "") {
	$query = mysql_query("select * from ".$pixelpost_db_prefix."pixelpost where datetime<='$cdate' order by datetime DESC limit 0,1");
	} else {
	$query = mysql_query("select * from ".$pixelpost_db_prefix."pixelpost where (id='".$_GET['showimage']."')");
	}
$row = mysql_fetch_array($query);
if(!$row['image']) {
    echo "Coming Soon!";
    exit;
    }
$image_name         = $row['image'];
$image_title        = pullout($row['headline']);
$image_id           = $row['id'];
$image_datetime     = $row['datetime'];
$image_datetime_formatted = strtotime($image_datetime);
$image_datetime_formatted = date($cfgrow['dateformat'],$image_datetime_formatted);
$image_category = $row['category'];
$image_date         = substr($row['datetime'],0,10);
$image_time         = substr($row['datetime'],11,5);
$image_date_year_full   = substr($row['datetime'],0,4);
$image_date_year   = substr($row['datetime'],2,2);
$image_date_month = substr($row['datetime'],5,2);
$image_date_day = substr($row['datetime'],8,2);
$image_notes        = markdown(pullout($row['body']));
list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
$image_thumbnail = "<a href='$PHP_SELF?showimage=$image_id'><img src='thumbnails/thumb_$image_name' alt='$image_title' title='$image_title' width='$local_width' height='$local_height' /></a>";
$query = mysql_query("select name from ".$pixelpost_db_prefix."categories where id='$image_category'");
$image_category = mysql_fetch_array($query);
$image_category = pullout($image_category['name']);
    
// get previous image id and name
$previous_query = mysql_query("select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime < '$image_datetime') and (datetime<='$cdate') order by datetime desc limit 0,1");
$previous_row = mysql_fetch_array($previous_query);
$image_previous_name = $previous_row['image'];
$image_previous_id = $previous_row['id'];
$image_previous_title = pullout($previous_row['headline']);
$image_previous_link = "<a href='index.php?showimage=$image_previous_id'>$lang_previous</a>";
list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
$image_previous_thumbnail = "<a href='$PHP_SELF?showimage=$image_previous_id'><img src='thumbnails/thumb_$image_previous_name' width='$local_width' height='$local_height' alt='$image_previous_title' title='$image_previous_title' /></a>";
if($image_previous_id == "") {
    $image_previous_id = $image_id; 
    $image_previous_title = "$lang_no_previous"; 
    $image_previous_link = "";
    $image_previous_thumbnail = "";
    }

// get next image id and name
$next_query = mysql_query("select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime > '$image_datetime') and (datetime<='$cdate') order by datetime asc limit 0,1");
$next_row = mysql_fetch_array($next_query);
$image_next_name = $next_row['image'];
$image_next_id = $next_row['id'];
$image_next_title = pullout($next_row['headline']);
$image_next_link = "<a href='index.php?showimage=$image_next_id'>$lang_next</a>";
list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
$image_next_thumbnail = "<a href='$PHP_SELF?showimage=$image_next_id'><img src='thumbnails/thumb_$image_next_name' alt='$image_next_title' width='$local_width' height='$local_height' title='$image_next_title' /></a>";
if($image_next_id == "") {
    $image_next_id = $image_id; 
    $image_next_title = "$lang_no_next"; 
    $image_next_link = "";
    $image_next_thumbnail = "";
    }

if(function_exists(gd_info)) {
    $gd_info = gd_info();
    if($gd_info != "") { // check that gd is here before this
        // thumbnail row, 5 thumbs
        $aheadnumb = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."pixelpost where (datetime > '$image_datetime') and (datetime<='$cdate')");
        $aheadnumb = mysql_fetch_array($aheadnumb);
        $aheadnumb = $aheadnumb['count'];
        $behindnumb = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."pixelpost where (datetime < '$image_datetime') and (datetime<='$cdate')");
        $behindnumb = mysql_fetch_array($behindnumb);
        $behindnumb = $behindnumb['count'];
        $aheadlimit = round(($cfgrow['thumbnumber']-1)/2);
        $behindlimit = round(($cfgrow['thumbnumber']-1)/2);
        if($aheadnumb <= "1") {
            $behindlimit = ($cfgrow['thumbnumber']-1)-$aheadnumb;
            $aheadlimit = $aheadnumb;
            }
        if($behindnumb <= "1") {
            $aheadlimit = ($cfgrow['thumbnumber']-1)-$behindnumb;
            $behindlimit = $behindnumb;
            }
        $totalthumbcounter = 0; // will count up to four no matter what
        $ahead_thumbs = "";
        $thumbs_ahead = mysql_query("select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime > '$image_datetime') and (datetime<='$cdate') order by datetime asc limit 0,$aheadlimit");
        while(list($id,$headline,$image) = mysql_fetch_row($thumbs_ahead)) {
				list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
            $ahead_thumbs .= "<a href='$PHP_SELF?showimage=$id'><img src='thumbnails/thumb_$image' alt='$headline' title='$headline' class='thumbnails' width='$local_width' height='$local_height' /></a>";
            $totalthumbcounter++;
            }
        $behind_thumbs = "";
        $thumbs_behind = mysql_query("select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime < '$image_datetime') and (datetime<='$cdate') order by datetime desc limit 0,$behindlimit");
        while(list($id,$headline,$image) = mysql_fetch_row($thumbs_behind)) {
				list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
            $behind_thumbs = "<a href='$PHP_SELF?showimage=$id'><img src='thumbnails/thumb_$image' alt='$headline' title='$headline' class='thumbnails' width='$local_width' height='$local_height' /></a>$behind_thumbs";
            }
			list($local_width,$local_height,$type,$attr) = getimagesize("thumbnails/thumb_$image_name");
        $thumbnail_row = "$behind_thumbs<a href='$PHP_SELF?showimage=$image_id'><img src='thumbnails/thumb_$image_name' alt='$image_title' title='$image_title' class='current_thumbnail' width='$local_width' height='$local_height' /></a>$ahead_thumbs";
        $tpl = ereg_replace("<IMAGE_THUMBNAIL_ROW>",$thumbnail_row,$tpl);
        } // gd_info()
    } // func exist

$tpl = ereg_replace("<IMAGE_DATE_YEAR_FULL>",$image_date_year_full,$tpl);
$tpl = ereg_replace("<IMAGE_DATE_YEAR>",$image_date_year,$tpl);
$tpl = ereg_replace("<IMAGE_DATE_MONTH>",$image_date_month,$tpl);
$tpl = ereg_replace("<IMAGE_DATE_DAY>",$image_date_day,$tpl);
$tpl = ereg_replace("<IMAGE_THUMBNAIL>",$image_thumbnail,$tpl);
$tpl = ereg_replace("<IMAGE_DATE>",$image_date,$tpl);
$tpl = ereg_replace("<IMAGE_TIME>",$image_time,$tpl);
$tpl = ereg_replace("<IMAGE_NAME>",$image_name,$tpl);
$tpl = ereg_replace("<IMAGE_TITLE>",$image_title,$tpl);
$tpl = ereg_replace("<IMAGE_DATETIME>",$image_datetime_formatted,$tpl);
$tpl = ereg_replace("<IMAGE_NOTES>",$image_notes,$tpl);
$tpl = ereg_replace("<IMAGE_ID>",$image_id,$tpl);
$tpl = ereg_replace("<IMAGE_CATEGORY>",$image_category,$tpl);
$tpl = ereg_replace("<IMAGE_PREVIOUS_LINK>",$image_previous_link,$tpl);
$tpl = ereg_replace("<IMAGE_PREVIOUS_THUMBNAIL>",$image_previous_thumbnail,$tpl);
$tpl = ereg_replace("<IMAGE_PREVIOUS_ID>",$image_previous_id,$tpl);
$tpl = ereg_replace("<IMAGE_PREVIOUS_TITLE>",$image_previous_title,$tpl);
$tpl = ereg_replace("<IMAGE_NEXT_ID>",$image_next_id,$tpl);
$tpl = ereg_replace("<IMAGE_NEXT_TITLE>",$image_next_title,$tpl);
$tpl = ereg_replace("<IMAGE_NEXT_THUMBNAIL>",$image_next_thumbnail,$tpl);
$tpl = ereg_replace("<IMAGE_NEXT_LINK>",$image_next_link,$tpl);

// get number of comments
$cnumb = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."comments where parent_id='$image_id'");
$cnumb_row = mysql_fetch_array($cnumb);
$image_comments_number = $cnumb_row['count'];

// get latest comment
$latest_comment = mysql_query("select parent_id from ".$pixelpost_db_prefix."comments order by id desc limit 0,1");
$latest_comment = mysql_fetch_array($latest_comment);
$latest_comment = $latest_comment['parent_id'];
$query = mysql_query("select headline from ".$pixelpost_db_prefix."pixelpost where id='$latest_comment'");
$queryrow = mysql_fetch_array($query);
$latest_comment_name = pullout($queryrow['headline']);

// build a string with all comments
if(($_GET['x'] == "") or ($_GET['popup'] == "comment")) {
    if($_GET['comment'] == "save") {
        $datetime = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        $parent_id = $_POST['parent_id'];
        $message = clean($_POST['message']);
        $name = clean($_POST['name']);
        $url = clean($_POST['url']);
        if($parent_id == "") {
	        $extra_message = "<b>$lang_message_missing_image</b><p />";
	        }
        if($message == "") {
	        $extra_message = "<b>$lang_message_missing_comment</b><p />";
	        }
        if(($parent_id != "") and ($message != "")) {
	        $query = "insert into ".$pixelpost_db_prefix."comments(id,parent_id,datetime,ip,message,name,url)
	        VALUES('NULL','$parent_id','$datetime','$ip','$message','$name','$url')";
	        $result = mysql_query($query);
	        }
        }
// visitor information in comments
$vinfo_name = "";
$vinfo_url = "";
if(isset($_COOKIE['visitorinfo'])) {
    // do stuff
    list($vinfo_name,$vinfo_url) = split("%",$_COOKIE['visitorinfo']);
    }
$tpl = ereg_replace("<VINFO_NAME>",$vinfo_name,$tpl);
$tpl = ereg_replace("<VINFO_URL>",$vinfo_url,$tpl);

    $comment_count = 0;
    $image_comments = "<ul>"; // comments stored in this string
    if($_GET['showimage'] == "") { $imageid = $image_id; } else { $imageid = $_GET['showimage']; }
    $cquery = mysql_query("select datetime, message, name, url from ".$pixelpost_db_prefix."comments where parent_id='".$imageid."' order by id asc");
    while(list($comment_datetime, $comment_message, $comment_name, $comment_url) = mysql_fetch_row($cquery)) {
	    $comment_message = pullout($comment_message);
	    $comment_name = pullout($comment_name);
	    if($comment_url != "") {
	    	$comment_url = "http://$comment_url"; // i'm running for president...
	    	$comment_url = str_replace("http://http://","http://",$comment_url); // you see?
	    	$comment_name = "<a href='$comment_url' title='$lang_visit_homepage'>$comment_name</a>";
	    	}
	    $comment_datetime = strtotime($comment_datetime);
        $comment_datetime = date($cfgrow['dateformat'],$comment_datetime);
	    $image_comments .= "<li>$comment_message<br />$comment_name @ $comment_datetime</li>";
	    $comment_count++;
	    }
    // print out comments or a message saying there ain't no fucking comments
    if($comment_count == 0) { $image_comments .= "<li>$lang_no_comments_yet</li>"; }
    $image_comments .= "</ul>";
    $tpl = ereg_replace("<IMAGE_COMMENTS>",$image_comments,$tpl);
    if(($_GET['popup'] == "comment") AND ($_GET['x'] != "save_comment")) { echo $tpl; exit; }
    } // end if comment
} // end imageprint
// fix a popuplink

// EXIF STUFF
if(extension_loaded(exif)) {
	$curr_image = "images/$image_name";
	$all_exif = exif_read_data($curr_image,0,true);
	$exif = $all_exif['EXIF'];
	$exposure = $exif['ExposureTime'];
	$exifhtml = $all_exif['COMPUTED'];
	$aperture = pullout($exifhtml['ApertureFNumber']);
	$capture_date = $exif['DateTimeOriginal'];
	$flash = $exif['Flash'];
	$lens = pullout($exif['LensModel']);
	$focal = pullout($exif['FocalLength']);
	$ifd = $all_exif['IFD0'];
	$info_camera_manu = $ifd['Make'];
	$info_camera_model = $ifd['Model'];
	if($flash == 0) { 
		$flash = "$lang_flash_not_fired"; 
		} else {
		$flash = "$lang_flash_fired"; 
		}
    if($exposure != "") { $exposure = "$lang_exposure $exposure"; }
    if($aperture != "") { $aperture = "$lang_aperture $aperture"; }
    if($capture_date != "") { $capture_date = "$lang_capture_date $capture_date"; }
    if($focal != "") { $focal = "$lang_focal $focal"; }
    if($info_camera_manu != "") { $info_camera_manu = "$lang_camera_maker $info_camera_manu"; }
    if($info_camera_model != "") { $info_camera_model = "$lang_camera_model $info_camera_model"; }
    $tpl = ereg_replace("<EXIF_EXPOSURE_TIME>",$exposure,$tpl);
    $tpl = ereg_replace("<EXIF_APERTURE>",$aperture,$tpl);
    $tpl = ereg_replace("<EXIF_CAPTURE_DATE>",$capture_date,$tpl);
    $tpl = ereg_replace("<EXIF_FLASH>",$flash,$tpl);
    $tpl = ereg_replace("<EXIF_FOCAL_LENGTH>",$focal,$tpl);
    $tpl = ereg_replace("<EXIF_CAMERA_MAKE>",$info_camera_manu,$tpl);
    $tpl = ereg_replace("<EXIF_CAMERA_MODEL>",$info_camera_model,$tpl);
    $tpl = ereg_replace("<EXIF_LENS>",$lens,$tpl);
    }

// refererlog
if($_GET['x'] == "ref") {
    $referer_print = "<ul>";
    // only count referers from the last seven days
    $from_date = mktime(0,0,0,date("m"),date("d")-7,date("Y"));
    $from_date = strftime("%Y-%m-%d", $from_date);
    $from_date = "$from_date 00:00:00";
    // get referers no
    $referer = "";
    $query = mysql_query("select distinct referer from ".$pixelpost_db_prefix."visitors where (referer!='') AND (datetime>'$from_date')");
    while(list($nreferer) = mysql_fetch_row($query)) {
        $nreferer = htmlentities($nreferer);
	    $referer .= "!".$nreferer;
    	}
    $referer = split("!",$referer);
    $ref_biglist = "";
    foreach($referer as $value) {
	    // $value holds the referer
	    if($value != "") {
	    	$query = mysql_query("select count(*) as count from ".$pixelpost_db_prefix."visitors where (referer='$value') AND (datetime>'$from_date')");
	    	$row = mysql_fetch_array($query);
            $refnumb = $row['count'];
	    	$ref_biglist .= "$refnumb@$value!";
            }
	    }
    $ref_biglist = split("!",$ref_biglist);
    rsort($ref_biglist,SORT_NUMERIC);
    foreach($ref_biglist as $value) {
	    list($numb,$referer) = explode("@",$value);
	    if($numb > "0") {
	    	if($numb < "10") { $numb = "0$numb"; }
	    // take down the length as urls can be quite long
		$referername = $referer;

		$length = strlen($referername);
		if($length > 50) { $referername = substr($referername,0,50); $referername = "$referername..."; }
		$referer_print .= "<li><a href='$referer'>$numb &nbsp;&nbsp;&nbsp; $referername</a></li>";
		}
	}
	$referer_print .= "</ul>";
    $tpl = ereg_replace("<REFERERS>",$referer_print,$tpl);
    } // end refererlog
    
if($_GET['x'] == "browse") {
    $thumb_output = "";
    $where = "";
    if($_GET['category'] != "") { $where = "and (category='".$_GET['category']."')"; }
    $query = mysql_query("select id,headline,image from ".$pixelpost_db_prefix."pixelpost where (datetime<='$cdate') $where order by datetime desc");
    while(list($id,$title,$name) = mysql_fetch_row($query)) {
        $title = pullout($title);
        $thumbnail = "thumbnails/thumb_$name";
        $thumb_output .= "<a href='$PHP_SELF?showimage=$id'><img src='$thumbnail' alt='$title' title='$title' class='thumbnails' /></a>";
        }
    $tpl = ereg_replace("<THUMBNAILS>",$thumb_output,$tpl);
    }
    
// build browse menu
$browse_select = "<select name='browse' 
onChange='self.location.href=this.options[this.selectedIndex].value;'><option value=''>$lang_browse_select_category</option><option value='?x=browse&amp;category='>$lang_browse_all</option>";
$query = mysql_query("select * from ".$pixelpost_db_prefix."categories order by name");
while(list($id,$name) = mysql_fetch_row($query)) {
    $name = pullout($name);
    $browse_select .= "<option value='?x=browse&amp;category=$id'>$name</option>";
    }
$browse_select .= "</select>";

// ##########################################################################################//
// RSS 2.0 FEED
// ##########################################################################################//
if($_GET['x'] == "rss") {
	pullout($cfgrow['sitetitle']);
	
    $output = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
    <rss version=\"2.0\">
    <channel>
    <title>".$cfgrow['sitetitle']."</title>
    <link>".$cfgrow['siteurl']."</link>
    <description>".$cfgrow['sitetitle']." photoblog</description>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>pixelpost</generator>
    ";
    $query = mysql_query("select id,datetime,headline,body,image from ".$pixelpost_db_prefix."pixelpost where (datetime<='$cdate') order by datetime desc");
    while(list($id,$datetime,$headline,$body,$image) = mysql_fetch_row($query)) {
        $headline = pullout($headline);
        $body = pullout($body);
        $image = $cfgrow['siteurl']."thumbnails/thumb_$image";
        
        $datetime = strtotime($datetime);
        $datetime = date("r",$datetime);
        $body = stripslashes($body);
        $body = htmlentities($body);
        $body = ereg_replace("\n","&lt;br /&gt;",$body);
        $output .= "
        <item>
        <title>$headline</title>
        <link>".$cfgrow['siteurl']."?showimage=$id</link>
        <description>&lt;img src=&quot;$image&quot; align=&quot;right&quot;&gt; $body</description>
        <pubDate>$datetime</pubDate>
        </item>
        ";
        }
    $output .= "
        </channel>
        </rss>";
    header("Content-type:application/rss+xml");
    echo $output;
    exit;
    }
// ##########################################################################################//
// ATOM FEED - re and triple check the encoding please please please
// ##########################################################################################//
if($_GET['x'] == "atom") {
    header("content-type: application/atom+xml");
    $tzone = substr(date("O"),0,3);
    $tzone = "$tzone:00";
	pullout($cfgrow['sitetitle']);
    $atom = "<?xml version='1.0' encoding='utf8'?>
    <feed
    version='0.3'
    xml:lang='en-US'
    xmlns='http://purl.org/atom/ns#'>
    <title>".$cfgrow['sitetitle']."</title>
    <link rel='alternate' type='text/html' href='".$cfgrow['siteurl']."' title='".$cfgrow['sitetitle']."' />
    <author>
    <name>".$cfgrow['sitetitle']."</name>
    <url>".$cfgrow['siteurl']."</url>
    </author>
    <generator
    url='http://www.pixelpunk.se/software/'
    version='1.3'>Pixelpost</generator>
    <modified>".date("Y-m-d\TH:i:s$tzone")."</modified>
    ";
    $query = mysql_query("select id,datetime,headline,body,image from ".$pixelpost_db_prefix."pixelpost where (datetime<='$cdate') order by datetime desc");
    while(list($id,$datetime,$headline,$body,$image) = mysql_fetch_row($query)) {
        $headline = pullout($headline);
        $body = pullout($body);
        $image = $cfgrow['siteurl']."thumbnails/thumb_$image";
        $datetime = strtotime($datetime);
        $issued = $datetime;
        $tzone = substr(date("O"),0,3);
        $tzone = "$tzone:00";
        $datetime = date("Y-m-d\TH:i:s$tzone",$datetime);
        $issued = date("Y-m-d\TH:i:s$tzone",$issued);
        $atom .= "
        <entry>
        <title
            type='text/html'
            mode='escaped'>
            $headline</title>
        <link rel='alternate' 
            type='text/html' 
            href='".$cfgrow['siteurl']."?showimage=$id' 
            title='$headline' />
        <id>".$cfgrow['siteurl']."?showimage=$id</id>
        <content type='text/xhtml'>
        <img src='$image' /><br />
        $body
        </content>
        <issued>$issued</issued>
        <modified>$datetime</modified>
        </entry>
        ";
        }
    $atom .= "</feed>";
    echo $atom;
    exit;
    }
$tpl = ereg_replace("<SITE_RSS_LINK>","<a href='index.php?x=rss'>RSS 2.0</a>",$tpl);
$tpl = ereg_replace("<SITE_TITLE>",$pixelpost_site_title,$tpl);
$tpl = ereg_replace("<SITE_REFLINK>","index.php?x=ref",$tpl);
$tpl = ereg_replace("<SITE_BROWSELINK>","index.php?x=browse",$tpl);
$tpl = ereg_replace("<SITE_PHOTONUMBER>",$pixelpost_photonumb,$tpl);
$tpl = ereg_replace("<SITE_VISITORNUMBER>",$pixelpost_visitors,$tpl);
$tpl = ereg_replace("<IMAGE_COMMENTS_NUMBER>",$image_comments_number,$tpl);
$tpl = ereg_replace("<LATEST_COMMENT_ID>",$latest_comment,$tpl);
$tpl = ereg_replace("<LATEST_COMMENT_NAME>",$latest_comment_name,$tpl);
$tpl = ereg_replace("<COMMENT_POPUP>","<a href='#' onclick=\"window.open('index.php?popup=comment&amp;showimage=$image_id','Comments','width=480,height=540');\">$lang_comment_popup</a>",$tpl);
$tpl = ereg_replace("<BROWSE_CATEGORIES>",$browse_select,$tpl);

// ##########################################################################################//
// EMAIL NOTE ON COMMENTS
// ##########################################################################################//
if($cfgrow['commentemail'] == "yes") {
if($_GET['x'] == "save_comment") {
    $admin_email = $cfgrow['email'];
    $comment_name = clean($_POST['name']);
    $comment_image_id = $_POST['parent_id'];
    $comment_message = clean($_POST['message']);
    
    $link_to_comment = $cfgrow['siteurl']."?showimage=$comment_image_id";
    
    $subject = "Pixelpost - New Comment Made";
    $sent_date = date("Y-m-d");
    $sent_time = date("H:i");
$body = "Hello,\r\n
A new comment has been made at your photoblog.
$link_to_comment

The Comment is 
----------------------------------------------------------------------
$comment_message
by $comment_name
----------------------------------------------------------------------    
Email Sent by pixelpost
";

    $headers = "To: admin <$admin_email>\r\n";
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= "From: PIXELPOST <$admin_email>\r\n";
    mail($recipient_email,$subject,$body,$headers);
    }
} // commentemail yes
// ##########################################################################################//
// SAVE COMMENT
// ##########################################################################################//
if($_GET['x'] == "save_comment") {
$datetime = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$parent_id = $_POST['parent_id'];
$message = clean($_POST['message']);
$name = clean($_POST['name']);
$url = clean($_POST['url']);
if($parent_id == "") {
	$extra_message = "<b>$lang_message_missing_image</b><p />";
	}
if($message == "") {
	$extra_message = "<b>$lang_message_missing_comment</b><p />";
	}
if(($parent_id != "") and ($message != "")) {
	$query = "insert into ".$pixelpost_db_prefix."comments(id,parent_id,datetime,ip,message,name,url)
	VALUES('NULL','$parent_id','$datetime','$ip','$message','$name','$url')";
	$result = mysql_query($query);
	}
?>
<!-- pixelpost saving comment -->
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><title><?php echo $lang_comment_page_title; ?></title>
<!-- meta -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- no meta -->
<style type="text/css">
body {
    font-family:Helvetica, Verdana, sans-serif;
    text-align:center;
    margin:40px 0px;
    font-size:12px;
    }
a {
    text-decoration:none;
    color:#444;
    }
a:hover {
    background:#f5f5f5;
    }
</style>
</head>
<body>

<?php
echo "$lang_comment_thank_you<p />$extra_message";
if(!$_GET['popup']) {
    echo "<a href='index.php?showimage=$parent_id'>$lang_comment_redirect</a>";
        } else {
        echo "<a href='index.php?popup=comment&amp;showimage=$parent_id'>$lang_comment_redirect</a>";
        }
    echo "</body></html>";
    }

// ##########################################################################################//
// SUCK IN ADDONS
// ##########################################################################################//
// addons read in, please get this straighten out
$dir = "addons/";
if($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if($file != "." && $file != "..") {
            $ftype = strtolower(end(explode('.', $file)));
            if($ftype == "php") {
                include($dir.$file);
                }
            }
        }
    closedir($handle);
    }
// done

// ##########################################################################################//
// END - ECHO TEMPLATE
// ##########################################################################################//
// spit it out unless its a special case like comment included here
// script is getting ugly, i dont like those hacks
if($_GET['x'] != "save_comment") {
    echo $tpl;
    }
    
// ##########################################################################################//
// functions
// ##########################################################################################//
function clean($string) {
    $string = utf8_encode($string);
	$string = addslashes($string);
    return $string;
	}
function pullout($string) {
	$string = stripslashes($string);
	$string = utf8_decode($string);
	//$string = nl2br($string);
	return $string;
	}
?>