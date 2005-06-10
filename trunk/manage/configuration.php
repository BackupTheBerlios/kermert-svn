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

include_once(dirname(__FILE__).'/prepend.php');

$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'params';

if($op=='params')
{
	$posted = (!empty($_REQUEST['posted'])) ? $_REQUEST['posted'] : false;
	if($posted)
	{
		$ini = new iniFile(CONFIG_FILE);
		$ini->editVar('km_appname',trim($_REQUEST['app_name']));
		$ini->editVar('km_appurl',trim($_REQUEST['app_url']));
		$ini->editVar('km_appdir',trim($_REQUEST['app_dir']));
		$ini->editVar('km_imagesdir',trim($_REQUEST['images_dir']));
		$ini->editVar('km_dateformat',trim($_REQUEST['date_format']));
		$ini->editVar('km_timeformat',trim($_REQUEST['time_format']));
		$ini->editVar('km_dbhost',trim($_REQUEST['db_host']));
		$ini->editVar('km_dbuser',trim($_REQUEST['db_user']));
		$ini->editVar('km_dbpassword',trim($_REQUEST['db_password']));
		$ini->editVar('km_dbbase',trim($_REQUEST['db_base']));
		$ini->editVar('km_dbprefix',trim($_REQUEST['db_prefix']));
		$ini->editVar('km_graphiclib',trim($_REQUEST['graphic_lib']));
		$ini->editVar('km_thumbwidth',trim($_REQUEST['thumb_width']));
		$ini->editVar('km_thumbheight',trim($_REQUEST['thumb_height']));
		$ini->editVar('km_graphicthumbtype',trim($_REQUEST['graphic_thumbtype']));
		$ini->saveFile();
	}

	$params = inifile::read(CONFIG_FILE,true);

	if($params['km_graphiclib']=='gd')
	{
		$use_gd = 1; $use_im = -1;
	}
	else
	{
		$use_gd = -1; $use_im = 1;
	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Kermert: Administration</title>
	<link rel="stylesheet" type="text/css" media="screen" href="./style.css" />
</head>
<body>

<?php include_once(dirname(__FILE__).'/inc/main_header.php'); ?>
<div id="rhlp-nav"></div>
<!-- ********************** START OF MENU ********************** -->
<div id="rhlp-side-left">

<div id="rhlp-side-nav-label">Site Navigation:</div>	<ul id="rhlp-side-nav">
<li><a href="./index.php">Dashboard</a></li>
<li><a href="./pictures.php">Pictures</a></li>
<li><a href="./categories.php">Categories</a></li>
<li><a href="./comments.php">Comments</a></li>
<li><div class="green">Administration</div><ul>
<li><a href="./users.php">Users</a></li>
<li><strong>Configuration</strong></li>
<li><a href="./sysinfo.php">Sys Info</a></li>
</ul></li>

</ul>
</div>
<!-- ********************** END OF MENU ********************** -->
<div id="rhlp-middle-two">
<div class="rhlp-corner-tr">&nbsp;</div>
<div class="rhlp-corner-tl">&nbsp;</div>

<div id="rhlp-content">
<!-- ************************* Main part *********************** -->


<h1>Configuration</h1>
[<a href="#general">General configuration</a> | <a href="#database">Database configuration</a> ]
<form>
<div class="news2" id="general">
<h3>General configuration</h3><br/>
<p><label for="app_name">Nom de l'application:</label><br/>
		<?php echo form::field('app_name',50,50,$params['km_appname'])?></p>
		<p><label for="app_url">URL de l'application:</label><br/>
		<?php echo form::field('app_url',40,40,$params['km_appurl'])?></p>
		<p><label for="app_dir">Chemin complet de l'application:</label><br/>
		<?php echo form::field('app_dir',40,255,$params['km_appdir'])?></p>
		<p><label for="images_dir">Répertoire des images:</label><br/>
		<?php echo form::field('images_dir',40,40,$params['km_imagesdir'])?></p>
		<p><label for="thumb_dir">Répertoire des miniatures:</label><br/>
		<?php echo form::field('thumb_dir',40,40,$params['km_thumbsdir'])?></p>
		<p><label for="date_format">Format de la date:</label><br/>
		<?php echo form::field('date_format',40,40,$params['km_dateformat'])?>&nbsp;(selon la fonction <a href="http://php.net/date">date</a> de PHP)</p>
		<p><label for="time_format">Format de l'heure:</label><br/>
		<?php echo form::field('time_format',40,40,$params['km_timeformat'])?>&nbsp;(selon la fonction <a href="http://php.net/date">date</a> de PHP)</p>
</div><br />
<div class="news2" id="database">
<h3>Database configuration</h3><br/>
<p>Les informations de connexion à la base de données.</p>
		<p><label for="db_host">Serveur:</label><br/>
		<?php echo form::field('db_host',20,20,$params['km_dbhost'])?></p>
		<p><label for="db_base">Base de données:</label><br/>
		<?php echo form::field('db_base',20,20,$params['km_dbbase'])?></p>
		<p><label for="db_user">Nom d'utilisateur:</label><br/>
		<?php echo form::field('db_user',20,20,$params['km_dbuser'])?></p>
		<p><label for="db_password">Mot de passe:</label><br/>
		<?php echo form::field('db_password',20,20,$params['km_dbpassword'])?></p>
		<p><label for="db_prefix">Préfixe des tables:</label><br/>
		<?php echo form::field('db_prefix',20,20,$params['km_dbprefix'])?></p>
</div><br />
</form>
<!-- ************************* Footer starts *********************** -->
</div>
<div class="rhlp-corner-br">&nbsp;</div>

<div class="rhlp-corner-bl">&nbsp;</div>
</div>
<!-- content END -->
<div id="rhlp-footer">
<br />
	Published with <a href="http://www.kermert.net">Kermert: photoblog</a>
<br />

</div></body>
</html>