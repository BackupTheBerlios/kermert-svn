<?php

/**
 * Element of administration part of application.
 *
 * This page manages authentication to administration.
 * User will be redirected here if no session or cookie is found with user's data.
 * @package Administration
 * @subpackage GUI
 */

$auth_page = 'yes';
include_once(dirname(__FILE__).'/prepend.php');

$posted = (!empty($_REQUEST['posted'])) ? $_REQUEST['posted'] : '';
$username = (!empty($_REQUEST['username'])) ? trim($_REQUEST['username']) : '';
$password = (!empty($_REQUEST['password'])) ? trim($_REQUEST['password']) : '';


if($posted!='')
{
	if(kmUser::authenticate($username,$password))
		header('Location: images.php');
}
	
?>
<!-- pixelpost admin start -->
<html><head><title>Administration kermert</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex" />
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
</head><body>
<div id="wrapper">

    <div id="caption">

    Administration
    </div>
    <div id='jcaption'>
    Login sets a cookie
    </div>
    <div id="content">
    <form method="post">
    Username<br>
    <input type="text" name="username" class="input"><p>

    Password<br>
    <input type="password" name="password" class="input"><p>
    <input type="hidden" name="posted" value="1"/>
    <input type="submit" value="Login">
    <p />
        </form>
    </div>
