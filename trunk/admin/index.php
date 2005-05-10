<?php
error_reporting(0);
/*

Pixelpost version 1.3
admin/index.php version 1.7a

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

require("pixelpost.php");

$pixelpost_prefix_used = $pixelpost_db_prefix;
/* start up mysql */ 
mysql_connect($pixelpost_db_host, $pixelpost_db_user, $pixelpost_db_pass) || die("Error: ". mysql_error());
mysql_select_db($pixelpost_db_pixelpost) || die("Error: ". mysql_error());

// revised !check
if($cfgquery = mysql_query("select * from ".$pixelpost_db_prefix."config")) {
$cfgrow = mysql_fetch_array($cfgquery);
$upload_dir = $cfgrow['imagepath'];
} else {
    header("Location: install.php");
    }

if($_GET['x'] == "login") {
    $cfgrow_password = base64_decode($cfgrow['password']);
    if(($cfgrow['admin'] == $_POST['user']) AND ($cfgrow_password == $_POST['password'])) {
        // login is valid, set cookie
        $set_admin = base64_encode($_POST['user']);
        setcookie("pixelpost_admin",$set_admin,time() +60*60*60*60);
	    header("Location:index.php");
        unset($login);
        } else { $loginmessage = "Username or Password Incorrect."; }
    } // if (login = yes) end

if($_GET['x'] == "logout") {
    setcookie("pixelpost_admin","nope",time() -60);
    header("Location:index.php");
    }
if(!isset($_COOKIE['pixelpost_admin'])) {
    // cookie is not set, send them to a form
    $login = "true";
    } else {
    // cookie exists, check for validity
    $cookie = base64_decode($_COOKIE['pixelpost_admin']);
    if($cfgrow['admin'] != $cookie) { $login = "true"; }
    }
?>
<!-- pixelpost admin start -->
<html><head><title>PIXELPOST ADMIN</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
<script LANGUAGE="JavaScript">
<!--
// Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete the image?");
if (agree)
        return true ;
else
        return false ;
}
// -->
</script>

<style type='text/css'>
body {	
	background:#fff;
	margin:0px;
	padding:0px;
	text-align:center;
	font-family:Verdana, Helvetica, sans-serif;
	font-size:12px;
	color:#333;
	}
#wrapper {
	margin:0px auto;
	padding-top:0px;
	padding-left:0px;
	padding-right:0px;
	padding-bottom:0px;
	width:600px;
	text-align:left;
	background:#f5f5f5;
	border-top:0px;
	border-left:0px;
	border-right:0px;
	border-bottom:1px solid #333;
	}
#header {
    border-top:0px dotted #444;
    border-bottom:1px solid #444;
    border-right:0px;
    border-left:0px;
    margin:0px 0px;
    padding-top:15px;
    padding-bottom:15px;
    padding-left:10px;
    padding-right:0px;
    background:#444;
    font-family:Helvetica, verdana, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:orange;
    }
#header a {
    color:orange;
    text-decoration:none;
    }
#header a:hover {
    color:#fff;
    text-decoration:none;
    }
#caption {
    border-top:0px dotted #444;
    border-bottom:1px solid #444;
    border-right:0px;
    border-left:0px;
    margin:0px 0px;
    padding-top:5px;
    padding-bottom:5px;
    padding-left:10px;
    padding-right:0px;
    background:orange;
    font-family:Helvetica, verdana, sans-serif;
    font-size:14px;
    font-weight:bold;
    color:#fff;
    }
#jcaption {
    border-top:1px dotted #444;
    border-bottom:1px dotted #444;
    border-right:0px;
    border-left:0px;
    margin:0px 0px;
    padding-top:3px;
    padding-bottom:3px;
    padding-left:10px;
    padding-right:0px;
    font-family:Helvetica, verdana, sans-serif;
    font-size:10px;
    font-weight:bold;
    color:#000;
    background:#999;
    }
#caption a {
    color:#fff;
    text-decoration:none;
    }
#caption a:hover {
    color:#444;
    text-decoration:none;
    }
#navigation {
    margin:0px;
    padding-top:5px;
    padding-bottom:5px;
    padding-left:0px;
    padding-right:0px;
    background:#f5f5f5;
    color:#444;
    font-size:9px;
    font-family:Verdana, Helvetica, sans-serif;
    border-top:0px dotted #444;
    border-bottom:1px solid #444;
    border-right:0px;
    border-left:0px;
    }
#navigation a {
    color:#444;
    text-decoration:none;
    padding:5px;
    }
#navigation a:hover {
    background:orange;
    padding:5px;
    border-top:0px;
    border-bottom:0px;
    border-left:1px solid #444;
    border-right:1px solid #444;
    }
#content {
    border:0px solid #000;
    margin:0px 0px;
    padding-top:10px;
    padding-bottom:0px;
    padding-left:10px;
    padding-right:0px;
    font-size:10px;
    }
#logo {
    position:relative;
    float:left;
    border:0px;
    margin:0px 18px;
    padding:0px;
    }
#footer {
    color:#666;
    font-size:10px;
    }
#content ul {
    list-style:none;
    display:block;
    margin:0px;
    padding:0px;
    }
#content ul li {
    padding:5px;
    margin:0px 0px 5px 0px;
    width:570px;
//    height:25px;
    border-top:0px;
    border-bottom:1px solid #444;
    border-left:0px solid #444;
    border-right:1px solid #444;
    background:#ccc;
    }
#content ul li img {
    border:1px solid #000;
    width:24px;
    height:24px;
    float:left;
    margin:0px 10px 0px 0px;
    }
#content ul b {
    color:#000;
    }
#content ul a {
    text-decoration:none;
    color:#444;
    padding:5px;
    }
#content ul a:hover {
    text-decoration:underline;
    color:#000;
    }
</style>
<script language='javascript'>
<!-- BEGIN
function flip(rid)
  {
    current=(document.getElementById(rid).style.display == 'none') ? 'block' : 'none';
    document.getElementById(rid).style.display = current;
  }
// End -->
</script>
</head><body>
<div id="wrapper">

<?php
if($login == "true") {
    ?>
    <div id="caption">
    Welcome to Pixelpost Admin - You need to login.
    </div>
    <div id='jcaption'>
    Login sets a cookie
    </div>
    <div id="content">
    <form method="post" action="<?php echo $PHP_SELF; ?>?x=login">
    Username<br>
    <input type="text" name="user" class="input"><p>
    Password<br>
    <input type="password" name="password" class="input"><p>
    <input type="submit" value="Login">
    <p />
    <?php echo $loginmessage; ?>
    </form>
    </div>
    <?php
    exit();
    }
?>

<div id="header">
<a href="index.php">Administration</a> for <a href="../"><?php echo $cfgrow['sitetitle']; ?></a>
</div>

<div id="navigation">
<a href="<?php echo $PHP_SELF; ?>?">NEW IMAGE</a>
<a href="<?php echo $PHP_SELF; ?>?view=images">IMAGES</a>
<a href="<?php echo $PHP_SELF; ?>?view=categories">CATEGORIES</a>
<a href="<?php echo $PHP_SELF; ?>?view=comments">COMMENTS</a>
<a href="<?php echo $PHP_SELF; ?>?view=options">OPTIONS</a>
<a href="<?php echo $PHP_SELF; ?>?view=info">GENERAL INFO</a>
<a href="<?php echo $PHP_SELF; ?>?view=addons">ADDONS</a>
<a href="<?php echo $PHP_SELF; ?>?x=logout">LOGOUT</a>
</div>
<!-- end navigation -->

<?php
// if no page is specified return a new post / image upload thing
if($_GET['view'] == "") {
    ?>
    <div id='jcaption'>
    Post a New Image</div>
    <div id="content">
    <form method="post" action="<?php echo $PHP_SELF; ?>?x=save" enctype="multipart/form-data">
    Image Title<br />
    <input type="text" name="headline" style="width:95%;" /><p />
    
    File Under Category<br />
    <select name="category">
    <?php
    $query = mysql_query("select * from ".$pixelpost_db_prefix."categories order by name");
    while(list($id,$name) = mysql_fetch_row($query)) {
        $name = pullout($name);
        echo "<option value='$id'>$name</option>\n";
        }
    ?>
    </select><p />
    Image<p />
    <input name="userfile" type="file" /><p />
    </div>
    <div id='jcaption'>
    Image description / text</div>
    <div id='content'>
    Use Markdown or HTML to format the text in this field.<br />
    <a href='http://daringfireball.net/projects/markdown/' title='Markdown homepage'>Markdown homepage</a> 
    &nbsp;&nbsp;&nbsp;
    <a href='http://daringfireball.net/projects/markdown/basics' title='Markdown syntax'>Basics</a> 
    &nbsp;&nbsp;&nbsp;
    <a href='http://daringfireball.net/projects/markdown/syntax' title='Markdown syntax'>Syntax Reference</a> 
    <p />
    <textarea name="body" style="width:95%;height:100px;"></textarea><p />
    </div>
    <div id='jcaption'>
    Date and Time for the entry</div>
    <div id='content'>
    Set a date and time when you want the image to appear on your blog. Leave as is if it should be published immediately.<p />
    Year-month-day&nbsp;&nbsp;&nbsp;&nbsp; hour-minute<br />
    
    <select name='post_year'>
	<option value='<?php echo date("Y"); ?>'><?php echo date("Y"); ?></option>
	<option value='2004'>2004</option>
	<option value='2005'>2005</option>
	<option value='2006'>2006</option>
	<option value='2007'>2007</option>
	<option value='2008'>2008</option>
	</select> -
	<select name='post_month'>
	<option value='<?php echo date("m"); ?>'><?php echo date("m"); ?></option>
	<?php
	$lc = 1;
	while($lc <= 12) {
	    if($lc < 10) { $lc = "0$lc"; }
	    echo "<option value='$lc'>$lc</option>";
	    $lc++;
	    }
	?>
	</select> -
	<select name='post_day'>
	<option value='<?php echo date("d"); ?>'><?php echo date("d"); ?></option>
	<?php
	$lc = 1;
	while($lc <= 31) {
	    if($lc < 10) { $lc = "0$lc"; }
	    echo "<option value='$lc'>$lc</option>";
	    $lc++;
	    }
	?>
	</select>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<select name='post_hour'>
	<option value='<?php echo date("H"); ?>'><?php echo date("H"); ?></option>
	<?php
	$lc = 1;
	while($lc <= 24) {
	    if($lc < 10) { $lc = "0$lc"; }
	    echo "<option value='$lc'>$lc</option>";
	    $lc++;
	    }
	?>
	</select>
	:
	<select name='post_minute'>
	<option value='<?php echo date("i"); ?>'><?php echo date("i"); ?></option>
	<?php
	$lc = 0;
	while($lc <= 59) {
	    if($lc < 10) { $lc = "0$lc"; }
	    
	    echo "<option value='$lc'>$lc</option>";
	    $lc++;
	    }
	?>
	</select>
    
    <p />
    </div>
    <div id='jcaption'>
    Post Entry</div>
    <div id='content'>
    <input type="submit" value="Upload" style='width:100px;font-weight:bold;' />
    </form><p />
    </div>
    
    <?php
    // save new post
    if($_GET['x'] == "save") {
	    $headline = 	clean($_POST['headline']);
	    $body = 		clean($_POST['body']);
	    $datetime = 	
	        $_POST['post_year']."-".
	        $_POST['post_month']."-".
	        $_POST['post_day']." ".
	        $_POST['post_hour'].":".
	        $_POST['post_minute'].":00";
	    
	    if($headline == "") {
	    echo "<div id='jcaption'>Missing data</div><div id='content'>
	    You need at least a title for your image, and an image.</div><p />";
	    exit;
	    }
	    
	    $category = $_POST['category'];
	    // prepare the file
	    if($_FILES['userfile'] != "") {
	    $userfile = strtolower($_FILES['userfile']['name']);
		    $uploadfile = $upload_dir. $userfile;
		        if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		        chmod($uploadfile, 0644);
			    $result = check_upload($_FILES['userfile']['error']);
			    $filnamn = strtolower($_FILES['userfile']['name']);
			    $filtyp = $_FILES['userfile']['type'];
			    $filstorlek = $_FILES['userfile']['size'];
			    $status = "ok";
			    } else {
			    // something went wrong, try to describe what
			    echo "Error";
			    $result = check_upload($_FILES['userfile']['error']);
			    echo "<br>$result<hr>";
			    $status = "no";
			    } // end move
		    } // end prepare of file
	    // insert post in mysql
	    $image = $filnamn;
	    if($status == "ok") {
	    $query = "insert into ".$pixelpost_db_prefix."pixelpost(id,datetime,headline,body,image, category)
	    VALUES('NULL','$datetime','$headline','$body','$image','$category')";
	    $result = mysql_query($query) || die("Error: ".mysql_error());
	    // done
	    echo "
        <div id='caption'>
	    POSTED: ".$_POST['headline']."
	    </div>
	    <div id='content'>
	    ".$_POST['body']."<br>
	    $datetime<p>
	    <img src='../images/$filnamn' />
        </div>
	    ";
	    //create thumbnail
	    if(function_exists('gd_info')) {
	        $gd_info = gd_info();
            if($gd_info != "") {
	            $thumbnail = $filnamn;
	            $thumbnail = createthumbnail($thumbnail);
                } // gd info
            } // function_exists 
            } // end status ok
        } // end save
    } // end view=null

// view = addons
if($_GET['view'] == "addons") {
    echo "<div id='caption'>
    INSTALLED ADDONS
    </div>";
    // addons read in, please get this straighten out
    $dir = "../addons/";
    if($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file != "." && $file != "..") {
                $ftype = strtolower(end(explode('.', $file)));
                if($ftype == "php") {
                    include("../addons/$file");
                    echo "<div id='jcaption'>$addon_name
                    <i>($file - version $addon_version)</i>
                    </div><div id='content'>
                    $addon_description</div><p />";
                    }
                }
            }
        closedir($handle);
        }
    // done
    } // end addons
// view = options
if($_GET['view'] == "options") {

    switch ($_GET['optaction']) {
    
    case "updateadmin": // admin user+password
        $new_pass = base64_encode($_POST['new_admin_pass']);
        $update = mysql_query("update ".$pixelpost_db_prefix."config set admin='".$_POST['new_admin_user']."', password='$new_pass' where admin='".$cfgrow['admin']."'");
        break;
       
    case "updateimagepath": // imagepath
        $update = mysql_query("update ".$pixelpost_db_prefix."config set imagepath='".$_POST['new_image_path']."' where admin='".$cfgrow['admin']."'");
        break;
        
    case "updateemail":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set email='".$_POST['new_email']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatelang":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set langfile='".$_POST['new_lang']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatecrop":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set crop='".$_POST['new_crop']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatecommentemail":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set commentemail='".$_POST['new_commentemail']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatetemplate":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set template='".$_POST['new_template']."' where admin='".$cfgrow['admin']."'");
        break;

    case "updatetitle":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set sitetitle='".$_POST['new_site_title']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updateurl":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set siteurl='".$_POST['new_site_url']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatecompression":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set compression='".$_POST['new_compression']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatethumbrow":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set thumbnumber='".$_POST['thumbnumber']."' where admin='".$cfgrow['admin']."'");
        break;
    
    case "updatedateformat":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set dateformat='".$_POST['new_dateformat']."'");
        break;

    case "updatecalendar":
        $update = mysql_query("update ".$pixelpost_db_prefix."config set calendar='".$_POST['cal']."'");
        break;
    
    case "updatethumbsize":
        $upquery = mysql_query("update ".$pixelpost_db_prefix."config set thumbwidth='".$_POST['thumbwidth']."', thumbheight='".$_POST['thumbheight']."'");
        break;
    
    case "updatethumbnails":
        if(function_exists('gd_info')) {
            $thumbnail_counter = 0;
            $dir = "../images"; // images folder
            if($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if($file != "." && $file != "..") {
                        $thumbnail = createthumbnail($file);
                        $thumbnail_counter++;
                        } // if
                    } // while
                closedir($handle);
                echo "<div id='jcaption'>Thumbnails updated</div><div id='content'>$thumbnail_counter thumbnails updated.</div><p />";
                } // if handle
            } // if function exists
        break;
    $result = mysql_query($update) or die("Error: ".mysql_error());
    }
    if($_GET['optaction'] != "") {
    echo "<div id='jcaption'>Update Done.</div><div id='content'><a href='$PHP_SELF?view=options'>You need to reload to view the changes made.</a></div><p />";
    }
    $decoded_pass = base64_decode($cfgrow['password']);
    echo "
    <div id='caption'>
    OPTIONS
    </div>
    <div id='jcaption'>
    ADMIN USER &amp; PASSWORD
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updateadmin'>
    User:
    <input type='text' name='new_admin_user' value='".$cfgrow['admin']."' />
    Password: 
    <input type='password' name='new_admin_pass' value='$decoded_pass' />
    <input type='submit' value='Update' />
    </form>
    </div>
    <div id='jcaption'>
    ADMIN EMAIL
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updateemail'>
    <input type='text' name='new_email' value='".$cfgrow['email']."' />
    <input type='submit' value='Update' />
    </form>
    </div>
    <div id='jcaption'>
    SEND EMAIL ON COMMENT
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatecommentemail'>
    <select name='new_commentemail'>
    <option value='".$cfgrow['commentemail']."'>".$cfgrow['commentemail']."</option>
    <option value='yes'>Yes</option>
    <option value='no'>No</option>
    </select>
    <input type='submit' value='Update' />
    </form>
    </div>
    
    <div id='jcaption'>
    SITE TITLE AND URL
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatetitle'>
    <input type='text' name='new_site_title' value='".$cfgrow['sitetitle']."' class='input' style='width:300px;' />
    <input type='submit' value='Update' />
    </form>
    <p />
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updateurl'>
    <input type='text' name='new_site_url' value='".$cfgrow['siteurl']."' class='input' style='width:300px;' />
    <input type='submit' value='Update' />
    </form>
    </div>

    <div id='jcaption'>
    IMAGES PATH
    </div>
    <div id='content'>    
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updateimagepath'>
    <input type='text' name='new_image_path' value='".$cfgrow['imagepath']."' style='width:300px;' />
    <input type='submit' value='Update' />
    </form>
    </div>

    <div id='jcaption'>
    SWITCH TEMPLATE
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatetemplate'>
    <select name='new_template'>
    <option value='".$cfgrow['template']."'>".$cfgrow['template']."</option>
    ";
    // go through template folder
    $dir = "../templates";
    if($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file != "." && $file != "..") {
                echo "<option value='$file'>$file</option>";
                }
            }
        closedir($handle);
        }
    echo "
    </select>
    <input type='submit' value='Update' />
    </form>
    </div>
    
     <div id='jcaption'>
    LANGUAGE FILE
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatelang'>
    <select name='new_lang'>
    <option value='".$cfgrow['langfile']."'>".$cfgrow['langfile']."</option>
    ";
    // go through template folder
    $dir = "../language";
    if($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file != "." && $file != "..") {
                $file = ereg_replace("lang-","",$file);
                $file = ereg_replace(".php","",$file);
                echo "<option value='$file'>$file</option>";
                }
            }
        closedir($handle);
        }
    echo "
    </select>
    <input type='submit' value='Update' />
    </form>
    </div>

    
    
    <div id='jcaption'>
    DATE FORMAT
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatedateformat'>
    The dateformat for images and comments display. 
    This syntax used is identical for the PHP <a href='http://www.php.net/date' target='_blank'>date()</a> function.<p />
    <input type='text' name='new_dateformat' value='".$cfgrow['dateformat']."' style='width:150px;' />
    <input type='submit' value='Update' />
    </form>
    </div>
    
    <div id='jcaption'>
    CALENDAR TYPE
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatecalendar'>
    <select name='cal'>
    ";
    if($cfgrow['calendar'] == "") { $nice_calendar = "No Calendar"; } else { $nice_calendar = $cfgrow['calendar']; }
    echo "
    <option value='".$cfgrow['calendar']."'>$nice_calendar</option>
    <option value'Horizontal'>Horizontal</option>
    <option value='Normal'>Normal</option>
    <option value='No Calendar'>Don't Use a Calendar</option>
    </select>
    <input type='submit' value='Update' />
    </form>
    </div>
    
    <div id='jcaption'>
    THUMBNAILS
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatethumbsize'>
    Set thumbnails size, Width x Height.<br />
    <input type='text' name='thumbwidth' value='".$cfgrow['thumbwidth']."' /> x 
    <input type='text' name='thumbheight' value='".$cfgrow['thumbheight']."' />
    <input type='submit' value='Set New Sizes' />
    </form><p />
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatethumbnails'>
    <input type='submit' value='Re-generate thumbnails' /> This generates new thumbnails from all posted images.
    </form>
    </div>
    
    <div id='jcaption'>
    CROP THUMBNAILS?
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatecrop'>
    If the thumbnails generated should be cropped to exact sizes or maintain the original ratio.<p />
    <select name='new_crop'>
    <option value='".$cfgrow['crop']."'>".$cfgrow['crop']."</option>
    <option value='yes'>Yes</option>
    <option value='no'>No</option>
    </select>
    <input type='submit' value='Update' />
    </form>
    </div>
    
    <div id='jcaption'>
    THUMBNAILROW
    </div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatethumbrow'>
    How many thumbnails to display in the automatically generated row.<br />
    Make this an odd number for best results, ie 7 or 9, not 6 or 8.<p />
    <input type='text' name='thumbnumber' value='".$cfgrow['thumbnumber']."' style='width:50px;' />
    <input type='submit' value='Update' />
    </form>
    </div>
    
    <div id='jcaption'>
    THUMBNAIL COMPRESSION
    </div>
    <div id='content'>   
    How hard do you want the jpg-compression to be? 10 is low quality and 100 is max quality (no loss)<p /> 
    <form method='post' action='$PHP_SELF?view=options&amp;optaction=updatecompression'>
    <input type='text' name='new_compression' value='".$cfgrow['compression']."' style='width:50px;' />
    <input type='submit' value='Update' />
    </form>
    </div>
    <p />
    ";
    }

// view=images
if($_GET['view'] == "images") {
    // x=update
    if($_GET['x'] == "update") {
        $headline = clean($_POST['headline']);
        $body = clean($_POST['body']);
        $getid = $_GET['imageid'];
        $newdatetime = $_POST['newdatetime'];
        $category = clean($_POST['category']);
        $query = "update ".$pixelpost_db_prefix."pixelpost set datetime='$newdatetime', headline='$headline', body='$body', category='$category' where id='$getid'";
        $result = mysql_query($query) ||("Error: ".mysql_error());
        echo "<div id='jcaption'>Image update</div>
        <div id='content'>Updated image #$getid.</div><p />";
        }
    // x=delete
    if($_GET['x'] == "delete") {
        $getid = $_GET['imageid'];
        $images = mysql_query("SELECT image FROM ".$pixelpost_db_prefix."pixelpost where id='$getid'");
        $imagerow = mysql_fetch_array($images);
        $image = $imagerow['image'];
        $file_to_del = "$upload_dir".$imagerow['image'];
        
         echo "<div id='jcaption'>Post removal / Image deletion / thumbnail deletion</div>
        <div id='content'>";
        
        $query = "delete from ".$pixelpost_db_prefix."pixelpost where id='$getid'";
        $result = mysql_query($query) ||("Error: ".mysql_error());
        echo "Post deleted.<p />";
        
        if(unlink($file_to_del)) { 
            $image_message = "Image deleted.<p />"; 
            } else { $image_message = "Could not delete imagefile. You have to do that some other way, with your ftp software perhaps.<p />"; }
            
        echo $image_message;
        
        $file_to_del = "../thumbnails/thumb_".$imagerow['image'];
        if(unlink($file_to_del)) { 
            $image_message = "Thumbnail deleted.<p />"; 
            } else { $image_message = "Could not delete thumbnail. You have to do that some other way, with your ftp software perhaps.<p />"; }
            
        echo $image_message."</div>";
        }
    // print out a list over images/posts
    if($_GET['id'] == "") {
        echo "<div id='jcaption'>Images / Posts - Edit or Delete an image</div>
        <div id='content'><ul>";
        if($_GET['page'] == "") { $page = "0"; } else { $page = $_GET['page']; }
        $pagec = 0;
	    $images = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."pixelpost ORDER BY datetime DESC limit $page,10");
	    while(list($id,$datetime,$headline,$body,$image) = mysql_fetch_row($images)) {
	        $headline = pullout($headline);
		    echo "<li>
		    <img src='../thumbnails/thumb_$image' />
		    <strong>$headline</strong><br />
		    <a href=\"$PHP_SELF?view=images&amp;id=$id\">[edit]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    <a onclick=\"return confirmSubmit()\" href=\"$PHP_SELF?view=images&amp;x=delete&amp;imageid=$id\">[delete]</a></li>
		    ";
		    $pagec++;
		    }
	    echo "</ul>
	    ";
	    if($pagec >= "10") {
	        $newpage = $page+10;
	        echo "<a href='index.php?view=images&amp;page=$newpage'>Older Images</a>";
	        }
	    echo "
	    </div><p />";
	    } else {
	    // an id is specified, edit the image, pull it out and put it in a form
	    $getid = $_GET['id'];
	    $images = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."pixelpost where id='$getid'");
	    $imagerow = mysql_fetch_array($images);
	    $headline = pullout($imagerow['headline']);
	    $body = utf8_decode(stripslashes($imagerow['body']));
	    $image = $imagerow['image'];
	    $category = $imagerow['category'];
	    echo "
        <div id='jcaption'>
        Edit Image
        </div>
        <div id='content'>
        <form method='post' action='$PHP_SELF?view=images&amp;x=update&amp;imageid=$getid'>
        Title<br />
        <input type='text' name='headline' value='$headline' style='width:300px;' /><p />
        Text / description<br />
        <textarea name='body' style='width:95%;height:100px;'>$body</textarea><p />
        Category<br />
        <select name='category'>
        ";
        $query = mysql_query("select name from ".$pixelpost_db_prefix."categories where id='$category'");
        $query = mysql_fetch_array($query);
        $nice_category = pullout($query['name']);
        echo "
        <option value='$category'>$nice_category</option>
        <option value=''> - Set New Category - </option>
        ";
        $query = mysql_query("select * from ".$pixelpost_db_prefix."categories order by name");
        while(list($id,$name) = mysql_fetch_row($query)) {
            $name = pullout($name);
            echo "<option value='$id'>$name</option>\n";
            }
        echo "
        </select><p />
        
        Datetime<br />
        <input type='text' name='newdatetime' value='".$imagerow['datetime']."' style='width:300px;' />
        <p />
        Image<br />
        <img src='../thumbnails/thumb_$image' /><br />
        $image (not changeable)<p />
        <input type='submit' value='Update' />
        </form>
        </div><p />
        ";
	    }
    } // end view=images

// view=comments
if($_GET['view'] == "comments") {
    // delete a comment
    if($_GET['action'] == "delete") {
	    $delid = $_GET['delid'];
	    $query = "DELETE FROM ".$pixelpost_db_prefix."comments WHERE id='$delid'";
	    $result = mysql_query($query) or die("Error: ".mysql_error());
	    echo "<div id='jcaption'>Deleted a comment.</div>";
	    }
    // list of comments
    if($_GET['id'] == "") {
        echo "<div id='jcaption'>List of Comments - delete at will</div><div id='content'><ul>";
         $pagec = 0;
        if($_GET['page'] == "") { $page = "0"; } else { $page = $_GET['page']; }
	    $images = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."comments ORDER BY id DESC limit $page,10");
	    while(list($id,$parent_id,$datetime,$ip,$message,$name,$url) = mysql_fetch_row($images)) {
	        $message = pullout($message);
	        $name = pullout($name);
	        $url = pullout($url);
	        $imagename = mysql_query("select headline from ".$pixelpost_db_prefix."pixelpost where id='$parent_id'");
	        $imagename = mysql_fetch_array($imagename);
	        $imagename = $imagename['headline'];
	        
		    echo "<li>Name: $name. Comment: <b>$message</b><br />
		    Image \"$imagename\"<br />
		    <i>Comment made: $datetime. From ip: $ip. <a href=\"$PHP_SELF?view=comments&amp;action=delete&amp;delid=$id\">[delete]</a></i></li>
		    ";
		     $pagec++;
		    }
        echo "</ul>
	    ";
	    if($pagec >= "10") {
	        $newpage = $page+10;
	        echo "<a href='index.php?view=comments&amp;page=$newpage'>Older Comments</a>";
	        }
	    echo "
	    </div><p />";
	    } // end list 
    }
// view info
if($_GET['view'] == "info") {
    if($_GET['version'] == "check") {
        $pixelpost_latest_version = file_get_contents("http://www.pixelpunk.se/software/service/version.txt");
        } else {
        $pixelpost_latest_version = "<a href='$PHP_SELF?view=info&amp;version=check'>Check</a>";
        }
    $mysql_version = mysql_get_server_info();
        if(function_exists('gd_info')) {
            $gd_info = gd_info();
            $gd_info = $gd_info['GD Version'];
            if($gd_info == "") {
            $gd_info = "Not installed";
            }
        } // func exist
    $version = base64_decode($version);
    $version = stripslashes($version);
    echo "<div id='jcaption'>Pixelpost Version</div>
    <div id='content'>
    $version<br />
    Latest pixelpost version: $pixelpost_latest_version<p />
    Looking for help or want to give feedback, please step into pixelpost forum.<br />
    <a href='http://www.pixelpunk.se/software/forum'>www.pixelpunk.se/software/forum/</a>
    </div>
    <p />
    <div id='jcaption'>Host information</div>
    <div id='content'>
    <b>PHP-version</b> ".phpversion()." <p />
    <b>MySQL version</b> $mysql_version<p />
    <b>GD-lib</b> $gd_info<p />
    <b>Server software</b> ".$_SERVER['SERVER_SOFTWARE']."<p />
    ";
    
    if(extension_loaded(exif)) { 
        echo "<b>EXIF</b> Your php was compiled with exif-enabled. This means you can add additional exif-information to your images such as camera model, aperture, exposure time and more. <br />
        There are certain tags to add to your templates for this. Check pixelpost homepage to learn more.
        ";
        } else {
        echo "<b>EXIF</b> Your php does not seem to be compiled with exif-enabled.";
        }
    
    echo "
    </div>
    <div id='jcaption'>Permissions</div>
    <div id='content'>
    ";
    if(!is_writable("../images/")) {
    $chmod_message = "<b>Images folder not writable!</b><br />You must set correct permissions on this folder or you will not be able to upload any images.<br /> Set the folder to chmod 777 (read, write and execute permissions for owner, group and world).<p />";
    } else {
    $chmod_message = "Images folder is writable, which is a good thing.<p />";
    }

if(!is_writable("../thumbnails/")) {
    $chmod_message2 = "<b>Thumbnails folder is not writable!</b><br />You must set correct permissions on this folder or thumbnails will not work.<br /> Set the folder to chmod 777 (read, write and execute permissions for owner, group and world).<p />";
    } else {
    $chmod_message2 = "Thumbnails folder is writable.<p />";
    }
    echo "
    <b>Images folder</b><br />
    $chmod_message<p />
    
     <b>Thumbnails folder</b><br />
    $chmod_message2<p />
    </div>
    <p />"; 
    }

// categories
if($_GET['view'] == "categories") {
    if($_GET['action'] == "delete") {
        $query = "delete from ".$pixelpost_db_prefix."categories where id='".$_POST['id']."'";
        $result = mysql_query($query) || die("Error: ".mysql_error());
        echo "<div id='jcaption'>Deletion</div><div id='content'>Category deleted.
        You may have to reload to view the changes.</div><p />";
        }
    if($_GET['action'] == "add") {
        $category = clean($_POST['category']);
        $query = "insert into ".$pixelpost_db_prefix."categories(id,name)
	    VALUES('NULL','$category')";
	    $result = mysql_query($query) || die("Error: ".mysql_error());
	    echo "<div id='jcaption'>Add Category</div>
	    <div id='content'>Category <b>\"".$_POST['category']."\"</b> added.</div><p />
	    ";
        }
    if($_GET['action'] == "edit") {
        $query = mysql_query("select * from ".$pixelpost_db_prefix."categories where id='".$_POST['id']."'");
        $query = mysql_fetch_array($query);
        $name = pullout($query['name']);
        echo "<div id='jcaption'>Edit Category</div>
        <div id='content'>Edit the name of the following category.<br />
        All images belonging to the old name will belong to the new name you enter.<p />
        <form method='post' action='$PHP_SELF?view=categories&amp;action=update&amp;id=".$query['id']."'>
        <input type='text' name='category' value='$name' style='width:300px;'/>
        <input type='submit' value='Update Category' />
        </form>
        </div>
        ";
        }
    if($_GET['action'] == "update") {
        $category = clean($_POST['category']);
        $getid = $_GET['id'];
        $upquery = mysql_query("update ".$pixelpost_db_prefix."categories set name='$category' where id='$getid'");
        $result = mysql_query($upquery) ||("Error: ".mysql_error());
        echo "<div id='jcaption'>Update</div><div id='content'>
        Updated category to new name <b>\"$category\".</b></div><p />";
        }
    echo "
    <div id='jcaption'>Add Category</div>
    <div id='content'>Add a category which you can assign to images.<p />
    <form method='post' action='$PHP_SELF?view=categories&amp;action=add'>
    <input type='text' name='category' style='width:300px;' /><p />
    <input type='submit' value='Add Category' />
    </form>
    </div>
    
    
    <div id='jcaption'>Edit Categories</div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=categories&amp;action=edit'>
    <select name='id'>
    <option value=''>Edit a category</option>
    <option value=''>----------</option>
    ";
    $query = mysql_query("select * from ".$pixelpost_db_prefix."categories order by name");
    while(list($id,$name) = mysql_fetch_row($query)) {
        $name = pullout($name);
        echo "<option value='$id'>$name</option>\n";
        }
    echo "
    </select><p />
    <input type='submit' value='Edit Category' />
    </form>
    </div>
    
    <div id='jcaption'>Delete Categories</div>
    <div id='content'>
    <form method='post' action='$PHP_SELF?view=categories&amp;action=delete'>
    <select name='id'>
    <option value=''>Delete a category</option>
    <option value=''>----------</option>
    ";
    $query = mysql_query("select * from ".$pixelpost_db_prefix."categories order by name");
    while(list($id,$name) = mysql_fetch_row($query)) {
        $name = pullout($name);
        echo "<option value='$id'>$name</option>\n";
        }
    echo "
    </select><p />
    <input type='submit' value='Delete Category' />
    </form>
    </div>
    ";
    }

// ##########################################################################################//
// FUNCTIONS
// ##########################################################################################//
// translate file upload errors to something human understandable
function check_upload($string) {
	$error_explained = array(
		"0" => "Upload went without error.", 
		"1" => "Exceeded maximum filesize for webserver to handle.", 
		"2" => "Exceeded maximum filesize.",
		"3" => "File was not fully uploaded.",
		"4" => "No file was uploaded."
		); 
	$result = $error_explained[$string];
	return($result);
	}
function clean($string) {
    $string = utf8_encode($string);
	$string = addslashes($string);
    return $string;
	}
function pullout($string) {
	$string = stripslashes($string);
	$string = utf8_decode($string);
	$string = htmlentities($string);
	//$string = nl2br($string);
	return $string;
	}

function createthumbnail($file) {
    global $pixelpost_db_prefix;
    $cfgquery = mysql_query("select * from ".$pixelpost_db_prefix."config");
    $cfgrow = mysql_fetch_array($cfgquery);
    // credit to codewalkers.com - this is 90% a tutorial there
    $max_width = $cfgrow['thumbwidth'];
    $max_height = $cfgrow['thumbheight'];
    define(IMAGE_BASE, "../images");
    $image_path = IMAGE_BASE . "/$file";
    $img = null;
    $ext = strtolower(end(explode('.', $image_path)));
    if ($ext == 'jpg' || $ext == 'jpeg') {
      $img = @imagecreatefromjpeg($image_path);
        } else if ($ext == 'png') {
        $img = @imagecreatefrompng($image_path);
        } else if ($ext == 'gif') {
        $img = @imagecreatefromgif($image_path);
        }
    if($img) {
        $width = imagesx($img);
        $height = imagesy($img);
        $scale = max($max_width/$width, $max_height/$height);
        if($scale < 1) {
            $new_width = floor($scale*$width);
            $new_height = floor($scale*$height);
            $tmp_img = imagecreatetruecolor($new_width,$new_height);
            // gd 2.0.1 or later: imagecopyresampled
            // gd less than 2.0: imagecopyresized
            if(function_exists(imagecopyresampled)) {
                imagecopyresampled($tmp_img, $img, 0,0,0,0,$new_width,$new_height,$width,$height);
                } else {
                imagecopyresized($tmp_img, $img, 0,0,0,0,$new_width,$new_height,$width,$height);
                }
            imagedestroy($img);
            $img = $tmp_img;
            }
        if($cfgrow['crop'] == "yes") {
            // crop
            $tmp_img = imagecreatetruecolor($max_width,$max_height);
            if(function_exists(imagecopyresampled)) {
                imagecopyresampled($tmp_img, $img, 0,0,0,0,$max_width,$max_height,$max_width,$max_height);
                } else {
                imagecopyresized($tmp_img, $img, 0,0,0,0,$max_width,$max_height,$max_width,$max_height);
                }
            imagedestroy($img);
            $img = $tmp_img;
            } // end crop yes
        }
    imagejpeg($img, "../thumbnails/thumb_$file",$cfgrow['compression']);
    $thumbimage = "../thumbnails/thumb_$file";
    chmod($thumbimage,0644);
    }

?>
</div> 
<br /><br /><br /><br />
</body></html>