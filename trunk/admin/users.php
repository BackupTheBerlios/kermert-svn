<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of Kermert.
# Copyright (c) 2005 Pierre-Yves Gillier and contributors. All rights
# reserved.
#
# Kermert is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# Kermert is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Kermert; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****

/**
 * Element of administration part of application.
 *
 * This page manages users of the application.
 * @package Administration
 * @subpackage GUI
 */

include_once(dirname(__FILE__).'/prepend.php');
include_once(dirname(__FILE__).'/includes/classes/class.kmuser.php');
//include_once(dirname(__FILE__).'/includes/wrappers/wrapper.kmuser.php');
require_once(dirname(__FILE__).'/includes/Sajax.php');

$sajax_remote_uri = './includes/wrappers/wrapper.kmuser.php';
sajax_init();
sajax_export("userList");
sajax_handle_client_request();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="MSSmartTagsPreventParsing" content="TRUE" />
<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
<title>Administration</title>
<script type="text/javascript" src="./includes/tools.js"></script>
<script type="text/javascript" src="./includes/sajax_extra.js"></script>
<script language="javascript" type="text/javascript" src="./includes/sajax_functions.js"></script>
<script language="javascript" type="text/javascript" src="./includes/wrappers/wrapper.kmuser.js"></script>
<script language="javascript" type="text/javascript">
<!--
<?
sajax_show_javascript();
?>
-->
</script>
</head>
<body onload="javascript:initPage();">
<table width="100%" class="Framework" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2">

<div id="top">
<table width="100%" cellpadding="8" cellspacing="0">
<tr>
<td>
<h1>Administration</h1>

</td>
</tr>
</table>
</div>
<div id="sub">
<div class="BlogStats">Version: <?php getAppVersion() ?></div></div>


</td>
</tr>
<tr>

<td rowspan="2" class="LeftCell">
<? include_once(dirname(__FILE__).'/includes/menu.inc');?>
</td>

<td class="MainCell">
<div id="main">


<div class="post">
<h2>Utilisateurs</h2>
<p class="modified"><b>&middot; Gestion</b></p>
<p id="listusers">
</p>
<p>
	<form method="POST">
		<fieldset>
			<legend><span id="legend_txt"></span></legend>
			<p><label for="nickname">Pseudo:</label><br/>
			<input type="text" id="nickname" name="nickname"/></p>
			<p><label for="login">Login:</label><br/>
			<input type="text" id="login" name="login"/></p>
			<p><label for="password">Mot de passe:</label><br/>
			<input type="password" id="password" name="password"/></p>
			<p><label for="email">E-mail:</label><br/>
			<input type="text" id="email" name="email"/></p>
			<p><input type="button" name="bsubmit" id="bsubmit" onclick="javascript:validateForm();"/></p>
		</fieldset>
	</form>
</p>
<div id="placeholder" style="display: none;">
	<div class="imageitem">
		<span id="name"></span>
	</div>
</div>
</td>
</tr>
<tr>
<td class="FooterCell">
<p id="footer">
Kermert
</p>

</td>
</tr>
</table>
</form>
</body>
</html>