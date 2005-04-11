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
include_once(dirname(__FILE__).'/includes/classes/class.wiki2xhtml.php');
require_once(dirname(__FILE__).'/includes/Sajax.php');

// Sajax Init

sajax_init();
$sajax_remote_uri = './sajax_operations.php';

sajax_export("ImageInfos","getThumbs");
sajax_handle_client_request();

$list_step = 9;

$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'image';
$id = (!empty($_REQUEST['id'])) ? $_REQUEST['id'] : '';
$posted = (!empty($_REQUEST['posted'])) ? $_REQUEST['posted'] : '';
$offset = (!empty($_REQUEST['offset'])) ? $_REQUEST['offset'] : 0;

$page_strings = array('action_title'=>'Nouvelle image','action_button'=>'Enregistrer','posted'=>'insert');

$action_title = 'Nouvelle image';
if($op=='image')
{
	if($posted=='update')
	{
		$kermert->updateImage($_REQUEST);
	}
	if($id!='')
	{
		$page_strings = array('action_title'=>'Modifier l\'image','action_button'=>'Modifier','posted'=>'update');
		$kermert->loadSingleImage($id);
	}
	else
		$kermert->setSingleImage();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="MSSmartTagsPreventParsing" content="TRUE" />
<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
<script type="text/javascript" src="./includes/tools.js"></script>
<script type="text/javascript" src="./includes/sajax_extra.js"></script>
<script language="javascript" type="text/javascript" src="./includes/sajax_functions.js"></script>
<script language="javascript" type="text/javascript">
<!--
<?
sajax_show_javascript();
?>
-->
</script>
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
<? include_once(dirname(__FILE__).'/includes/menu.inc');?>
</td>

<td class="MainCell">
<div id="main">


<div class="post">
<h2>Images</h2>
<p class="modified"><b>&middot; <?=subtitle('images.'.$op)?></b></p>

<p>
<?php
if($op=='image') {
?>
<form method="POST" action="./file_upload.php" id="form_manage" enctype="multipart/form-data" target="ope_iframe">
<?php echo form::hidden('op','uploadfile');?>
<?php echo form::hidden('image_id',getImageid());?>
	<fieldset>
	     <legend>Image</legend>
	     <div class="imagethumbright"><img id="imgthumb" src="<?php echo getImageThumb();?>"/></div>
	     <p id="uploadbox"></p>
	     <p><label for="image_name">Nom du fichier:</label><br/>
		<?php echo form::field('image_name',50,50,getImageFileName());?>
		<input type="button" value="Modifier" onclick="javascript:updateImageName();"/></p>
    	     <ul>
    	     <?php if($id!=''){ ?>
	          <li>Regénérer la miniature</li>
	          <li><a onclick="javascript:exif_info('<?echo getImageFileName()?>');">Voir les informations EXIF</a></li>
	     <?php }else{ ?>
	     	<li><a href="#" onclick="javascript:openClose('uploadtab',0);">Uploader une image</a></li>
	     	<li><a href="#" onclick="javascript:genThumbs();">Générer la miniature</a></li>
	     <?php } ?>
	     </ul>
	     <div id="uploadtab" style="display:none;">
	     <p>
	     	<label for="uploadfile">Fichier à déposer:</label><br/>
	     	<input type="file" class="button" name="uploadfile" id="uploadfile"/><br/><input type="submit" value="Envoyer"/>

	     </p>
	     </div
	</fieldset>
</form>
<div id="exif_div" style="display:none;">
<form>
     <fieldset>
          <legend>Informations EXIF</legend>
          <p id="exif_paragraph">Récupération des données EXIF en cours...</p>
          <p>[<a onclick="javascript:openClose('exif_div',-1);">Cacher</a>]</p>
     </fieldset>
</form>
</div>
<form method="post" id="form_images">
	<br/>
	<fieldset>
		<legend><?php echo $page_strings['action_title']?></legend>
		<p><label for="image_title">Titre:</label><br/>
		<?php echo form::field('image_title',80,80,getImagename());?></p>
		<table width="80%">
			<tr>
				<td><label for="content_mode">Format:</label></td>
				<td><label for="image_category">Catégorie:</label></td>
			</tr>
			<tr>
				<td><?php echo form::combo('content_mode',array('Wiki'=>'wiki','HTML'=>'redim'),getImageMode())?></td>
				<td><?php echo form::combo('image_category',getCategoryList())?></td>
			</tr>
		</table>
		<p><label for="image_content">Texte:</label><br/>
		<?php echo form::textarea('image_content',100,10,getImageBody());?></p>
	</fieldset>
	<br/>
	<fieldset>
		<legend>Horodatage / Commentaires / Trackbacks</legend>
		<p><label for="image_file">Autoriser les commentaires:</label>
		<?php echo form::combo('img_comments',array('Oui'=>1,'Non'=>0),$kermert->getField('comments'));?></p>
		<p><label for="image_file">Autoriser les trackbacks:</label>
		<?php echo form::combo('img_trackbacks',array('Oui'=>1,'Non'=>0),$kermert->getField('trackbacks'));?></p>
	</fieldset>
	<br/>
	<fieldset class="actions">
		<legend>Actions</legend>
		<? echo form::hidden('op','image');?>
		<? echo form::hidden('id',$id);?>
		<? echo form::hidden('posted',$page_strings['posted']);?>
		<input type="submit" value="Prévisualiser"/>
		&nbsp;
		<input type="submit" value="Enregistrer"/>
		&nbsp;
		<input type="button" value="Supprimer" onclick="javascript:void(0);"/>
		&nbsp;
		<?php if($kermert->isVisible()){ ?>
		<input type="button" value="Mettre hors-ligne" onclick="javascript:void(0);"/>
		<?php }else{ ?>
		<input type="button" value="Mettre en ligne" onclick="javascript:void(0);"/>
		<?php } ?>
	</fieldset>
</form>
<iframe src="blank.html" id="ope_iframe" name="ope_iframe" class="blankiframe"></iframe>
<? }elseif($op=='list'){ ?>
<?php $kermert->loadImagesList('all',$offset);?>

<?php while(!$kermert->EOF() && $kermert->getCurrIdx() <= $offset+$list_step) {?>
<div class="imageitem">
<div class="imagestatus"><?php if($kermert->isVisible()){ ?>(En ligne)<?php }else{ ?>(Hors ligne)<?php } ?></div>
[<a href="#" onclick="javascrip:openClose('preview<?php echo $kermert->getCurrIdx();?>',0)">Preview</a>] <a href="?op=image&id=<?php echo getImageId()?>"><?=getImagename();?></a>
<div id="preview<?php echo $kermert->getCurrIdx();?>" class="imagedetail" style="display:none">
	<div class="imagethumbleft"><img src="<?php echo getImageThumb();?>"/></div>
	<?php echo getImageBody();?>
	<div style="clear:both;"></div>
</div>
</div>
<?php $kermert->moveNext();} ?>
<div id="listtools" class="imagedetail" style="text-align:center;">
<?php echo paginate($offset,$list_step)?>
</div>
<?php }elseif($op=='operations'){ ?>
<ul>
	<li><a href="#" onclick="javascript:operations('regenerate',1);">Regénérer toutes les miniatures</a></li>
	<li><a href="#" onclick="javascript:operations('checkthumb',1);">Vérifier la présence de toutes les miniatures</a></li>
</ul>
<div id="actionframe" style="display:none;">
<iframe id="actioncontent" name="actioniframe" width="98%"></iframe>
<div class="imagethumbright"><a href="javascript:void(0);" onclick="javascript:openClose('actionframe',-1);">Cacher la fenêtre</a></div>
</div>
<?php } ?>
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