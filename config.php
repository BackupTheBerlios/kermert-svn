<?php

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
		$ini->editVar('km_imagesdir',trim($_REQUEST['images_dir']));
		$ini->editVar('km_dbhost',trim($_REQUEST['db_host']));
		$ini->editVar('km_dbuser',trim($_REQUEST['db_user']));
		$ini->editVar('km_dbpassword',trim($_REQUEST['db_password']));
		$ini->editVar('km_dbbase',trim($_REQUEST['db_base']));
		$ini->editVar('km_dbprefix',trim($_REQUEST['db_prefix']));
		$ini->editVar('km_graphiclib',trim($_REQUEST['graphic_lib']));
		$ini->editVar('km_thumbwidth',trim($_REQUEST['thumb_width']));
		$ini->editVar('km_thumbheight',trim($_REQUEST['thumb_height']));
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="MSSmartTagsPreventParsing" content="TRUE" />
<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
<title>Administration</title>
</head>
<body>
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
<div id="leftmenu">


<h3>Navigation</h3>
<ul>
	<li><a href="/">Accueil</a></li>
	<li><a href="<?php kmSettings('url')?>">Site public</a>
</ul>

<h3>Images</h3>
<ul>
	<li><a href="./images.php">Nouvelle image</a></li>
	<li><a href="./images.php?op=list">Gestion des images</a></li>
	<li><a href="./images.php?op=operations">Op�rations</a></li>
</ul>
<h3>Configuration</h3>
<ul>
	<li><a href="./config.php">Param�tres</a></li>
	<li><a href="./config.php?op=themes">Th�mes</a></li>
	<li><a href="./config.php?op=info">Informations</a></li>
</ul>


<h3>&nbsp;</h3>
<ul>
	<li><a href="logout.php">D�connexion</a></li>
</ul>
</td>

<td class="MainCell">
<div id="main">


<div class="post">
<h2>Configuration</h2>
<p class="modified"><b>&gt; <?=subtitle('config.'.$op)?></b></p>
<?php //$errors->display(); ?>
<p>
<?php
// Informations
if($op=='info') {
?>
<h4>Environnement:</h4>
<?php kmInfo::env_info();?>
<h4>Graphique:</h4>
<?php kmInfo::graphic_info();?>
<?php
}elseif($op=='params'){
?>
<form>
	<fieldset>
		<legend>G�n�ral</legend>
		<p>Les informations publiques de votre photoblog.</p>
		<p><label for="app_name">Nom de l'application:</label><br/>
		<?php echo form::field('app_name',50,50,$params['km_appname'])?></p>
		<p><label for="app_url">URL de l'application:</label><br/>
		<?php echo form::field('app_url',40,40,$params['km_appurl'])?></p>
		<p><label for="images_dir">R�pertoire des images:</label><br/>
		<?php echo form::field('images_dir',40,40,$params['km_imagesdir'])?></p>
	</fieldset><br/>
	<fieldset>
		<legend>Base de donn�es</legend>
		<p>Les informations de connexion � la base de donn�es.</p>
		<p><label for="db_host">Serveur:</label><br/>
		<?php echo form::field('db_host',20,20,$params['km_dbhost'])?></p>
		<p><label for="db_base">Base de donn�es:</label><br/>
		<?php echo form::field('db_base',20,20,$params['km_dbbase'])?></p>
		<p><label for="db_user">Nom d'utilisateur:</label><br/>
		<?php echo form::field('db_user',20,20,$params['km_dbuser'])?></p>
		<p><label for="db_password">Mot de passe:</label><br/>
		<?php echo form::field('db_password',20,20,$params['km_dbpassword'])?></p>
		<p><label for="db_prefix">Pr�fixe des tables:</label><br/>
		<?php echo form::field('db_prefix',20,20,$params['km_dbprefix'])?></p>
	</fieldset><br/>
	<fieldset>
		<legend>Graphiques</legend>
		<p>Les librairies graphiques � utiliser et leurs options.</p>
		<p><label for="graphic_lib">Librairie graphique:</label><br/>
		<?php echo form::radio('graphic_lib','gd',$use_gd)?>GD
		<?php echo form::radio('graphic_lib','im',$use_im)?>Imagemagick
		</p>
		<p><label for="graphic_lib">Taille des miniatures:</label><br/>
		<?php echo form::field('thumb_width',3,3,$params['km_thumbwidth'])?> *
		<?php echo form::field('thumb_height',3,3,$params['km_thumbheight'])?> pixels
		</p>
	</fieldset><br/>
	<fieldset>
		<legend>Actions</legend>
		<? echo form::hidden('op','params');?>
		<? echo form::hidden('posted',1);?>
		<input type="submit" value="Enregistrer"/>&nbsp;<input type="reset" value="Annuler"/>
	</fieldset>
</form>
<?php
}elseif($op=='themes'){
?>
<?php }?>
</p>
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