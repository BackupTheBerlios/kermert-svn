<?php

/*

Pixelpost version 1.3
admin/install.php version 1.7

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
/* start up mysql */ 
mysql_connect($pixelpost_db_host, $pixelpost_db_user, $pixelpost_db_pass) || die("Error: ". mysql_error());
mysql_select_db($pixelpost_db_pixelpost) || die("Error: ". mysql_error());
?>
<html>
<head>
<style type="text/css">
body {
    font-family:Verdana, helvetica, sans-serif;
    font-size:12px;
    color:#333;
    }
b {
    color:#008000;
    font-weight:bold;
    }
h1 {
    font-family:Helvetica, verdana, sans-serif;
    letter-spacing:-1px;
    font-size:24px;
    color:#000;
    }
</style>
</head>
<body>
<?php
if($_GET['install'] == "") {
?>
<b>Welcome to Pixelpost!</b>
<h1>STEP 1: Prepare database</h1>
This will install/create the database tables that are needed for pixelpost.<p />
table <b><?php echo $pixelpost_db_prefix; ?>pixelpost</b> will hold imageinformation<br />
table <b><?php echo $pixelpost_db_prefix; ?>categories</b> will hold image categories.<br />
table <b><?php echo $pixelpost_db_prefix; ?>config</b> will hold a few configuration options<br />
table <b><?php echo $pixelpost_db_prefix; ?>comments</b> will hold comments to images<br />
table <b><?php echo $pixelpost_db_prefix; ?>visitors</b> will log visitors and are used to get total visits and refererlog<p />
<form method="post" action="install.php?install=one">
You need to choose a username and password. This will be what you use in order to login and publish images to your photoblog.
Both username and password can be altered later.
<p />

<b>Name</b><br />
<input type="text" name="admin_user" /><p />
<b>Password</b><br />
<input type="password" name="admin_password" /><p />

Table prefix: <?php echo "<b>$pixelpost_db_prefix</b>"; ?><p />

<input type="submit" value="Create Tables">
</form>
<?php
    }
if($_GET['install'] == "two") {
    ?>
    <h1>Step 2: Done.</h1>
    
    I couldn't think of any more to do. It's all set. Upload some images, test it out and make sure it works properly. <b>Take it for a spin.</b><p />
    <b>Be sure to set the correct rights (?) on the "images" folder.</b> If it's not chmod 777 then no images will upload into that folder.<p />
    
    <i>PIXELPOST is basic and intends to continue being so, but more than anything cater to the photobloggers needs. <br />
    I would like to, but am not able to guarantee you eternal happiness because of using this. Instead I tell you that you're on your own, I cannot be held responsible for any damage this software might do to you, your webserver or your dog.</i>    
    <?php
    }
if($_GET['install'] == "one") {
$prefix = $pixelpost_db_prefix;
$query = mysql_query("
CREATE TABLE ".$prefix."config (
  admin varchar(20) NOT NULL default '',
  password varchar(90) NOT NULL default '',
  email varchar(90) NOT NULL default '',
  commentemail varchar(3) NOT NULL default '',
  template varchar(150) NOT NULL default '',
  imagepath varchar(150) NOT NULL default '',
  siteurl varchar(100) NOT NULL default '',
  sitetitle varchar(100) NOT NULL default '',
  langfile varchar(100) NOT NULL default '',
  calendar varchar(30) NOT NULL default '',
  crop varchar(3) NOT NULL default '',
  thumbwidth int(11) NOT NULL,
  thumbheight int(11) NOT NULL,
  thumbnumber int(11) NOT NULL,
  compression int(11) NOT NULL,
  dateformat varchar(30) NOT NULL default ''
)
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."config created...<p />";

// guess environment
$images_path = $_SERVER['DOCUMENT_ROOT']; 
$images_path .= $_SERVER['SCRIPT_NAME'];
$images_path = pathinfo($images_path);
$images_path = $images_path['dirname'];
$site_url = $_SERVER['HTTP_HOST'];
$site_url .= $_SERVER['SCRIPT_NAME'];
$site_url = pathinfo($site_url);
$site_url = $site_url['dirname'];
$site_url = eregi_replace("admin","",$site_url);
$site_url = "http://$site_url";
$images_path = eregi_replace("admin","images/",$images_path);

// get post data
$admin_user = addslashes($_POST['admin_user']);
$admin_password = $_POST['admin_password'];
$adm_pass = base64_encode($admin_password);
$query = mysql_query("
INSERT INTO ".$prefix."config VALUES (
'$admin_user', '$adm_pass','','no', 'pixelpost-light', '$images_path', '$site_url', 'pixelpost','english','No Calendar','yes','100','75','5','75','Y-m-d H:i:s')
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."config populated...<p />
<b>Remember your data:</b><p />
<u>User: $admin_user<br />
Pass: $admin_password
</u><p />";

$query = mysql_query("
CREATE TABLE ".$prefix."categories (
  id int(11) NOT NULL auto_increment,
  name varchar(100) NOT NULL default '',
  KEY id (id)
)
");
if(!$query) { die("Error: ". mysql_error()); }
$query = mysql_query("
INSERT INTO ".$prefix."categories VALUES ('NULL', 'default')
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."categories created...<p />";

$query = mysql_query("
CREATE TABLE ".$prefix."pixelpost (
  id int(11) NOT NULL auto_increment,
  datetime datetime NOT NULL default '0000-00-00 00:00:00',
  headline varchar(150) NOT NULL default '',
  body text NOT NULL,
  image text NOT NULL,
  category varchar(150) NOT NULL default '',
  KEY id (id)
)
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."pixelpost created...<p />";
$query = mysql_query("
CREATE TABLE ".$prefix."comments (
  id int(11) NOT NULL auto_increment,
  parent_id int(11) NOT NULL default '0',
  datetime datetime NOT NULL default '0000-00-00 00:00:00',
  ip varchar(20) NOT NULL default '',
  message text NOT NULL,
  name varchar(20) NOT NULL default '',
  url varchar(40) NOT NULL default '',
  KEY id (id)
)
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."comments created...<p />";
$query = mysql_query("
CREATE TABLE ".$prefix."visitors (
  id int(11) NOT NULL auto_increment,
  datetime datetime NOT NULL default '0000-00-00 00:00:00',
  host varchar(100) NOT NULL default '',
  referer varchar(255) NOT NULL default '',
  ua varchar(255) NOT NULL default '',
  ip varchar(255) NOT NULL default '',
  ruri varchar(150) NOT NULL default '',
  PRIMARY KEY  (id)
)
");
if(!$query) { die("Error: ". mysql_error()); }
echo "table ".$prefix."visitors created...<p />
<b>The tables are all set.</b><p />

";
if(!is_writable("../images/")) {
    $chmod_message = "<b>Images folder not writable!</b><br />You must set correct permissions on this folder or you will not be able to upload any images.<br /> Set the folder to chmod 777.<p />";
    } else {
    $chmod_message = "Images folder is writable, which is a good thing.<p />";
    }

if(!is_writable("../thumbnails/")) {
    $chmod_message2 = "<b>Thumbnails folder is not writable!</b><br />You must set correct permissions on this folder or thumbnails will not work.<br /> Set the folder to chmod 777.<p />";
    } else {
    $chmod_message2 = "Thumbnails folder is writable.<p />";
    }

?>
<h1>Done.</h1>
<b>Let's see if we can save images in the folder images:</b><p />
&raquo; <?php echo $chmod_message; ?><p />

<b>Let's see if we can save thumbnails in the folder thumbnails:</b><p />
&raquo; <?php echo $chmod_message2; ?><p />
    
Next thing you want to do is <a href="index.php"> login to the admin interface</a> and get started posting.<p />
    
    <i>PIXELPOST does not come with any warranties. I sure hope it'll work great for you and give you a worryfree great photoblog.</i> 
    
<?php
} // if x=create_tables done
?>
</body></html>