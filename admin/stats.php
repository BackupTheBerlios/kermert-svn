<?php

include_once(dirname(__FILE__).'/prepend.php');
include_once(dirname(__FILE__).'/includes/classes/class.wiki2xhtml.php');

$list_step = 9;

$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'image';
$id = (!empty($_REQUEST['id'])) ? $_REQUEST['id'] : '';
$offset = (!empty($_REQUEST['offset'])) ? $_REQUEST['offset'] : 0;

$page_strings = array('action_title'=>'Nouvelle image','action_button'=>'Enregistrer');

$action_title = 'Nouvelle image';
if($op=='image')
{
	if($id!='')
	{
		$page_strings = array('action_title'=>'Modifier l\'image','action_button'=>'Modifier');
		$kermert->loadSingleImage($id);
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
<script language="javascript" type="text/javascript">
<!--
function openClose(id,mode)
{
	if(document.getElementById) {
		element = document.getElementById(id);
		img = document.getElementById('img_' + id);
	} else if(document.all) {
		element = document.all[id];
		img = document.all['img_' + id];
	} else return;

	if(element.style) {
		if(mode == 0) {
			if(element.style.display == 'block' ) {
				element.style.display = 'none';
				img.src = 'images/plus.png';
			} else {
				element.style.display = 'block';
				img.src = 'images/moins.png';
			}
		} else if(mode == 1) {
			element.style.display = 'block';
			img.src = 'images/moins.png';
		} else if(mode == -1) {
			element.style.display = 'none';
			img.src = 'images/plus.png';
		}
	}
}
-->
</script>
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
<p class="modified"><b>&gt; <?=subtitle('images.'.$op)?></b></p>
<p>
<?php
if($op=='image') {
?>
<form method="POST">
	<fieldset>
		<legend><?php echo $page_strings['action_title']?></legend>
		<p><label for="image_title">Titre:</label><br/>
		<?php echo form::field('image_title',50,50,getImagename());?></p>
		<p><label for="image_content">Texte:</label><br/>
		<?php echo form::textarea('image_content',100,10,getImageBody());?></p>
	</fieldset>
	<br/>
	<fieldset>
	     <legend>Image</legend>
	     <div class="imagethumbright"><img src="<?php echo getImageThumb();?>"/></div>
	     <p><label for="image_file">Nom du fichier:</label><br/>
		<?php echo form::field('image_file',50,50,getImageFileName());?>
		<input type="button" value="Modifier"/></p>
    	     <ul>
	          <li>Regénérer la miniature</li>
	     </ul>

	</fieldset>
	<br/>
	<fieldset class="actions">
		<legend>Actions</legend>
		<? echo form::hidden('op','image');?>
		<? echo form::hidden('id',$id);?>
		<? echo form::hidden('posted',1);?>
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
<? }else{ ?>
<?php $kermert->loadImagesList('all',$offset);?>

<?php while(!$kermert->EOF() && $kermert->getCurrIdx() <= $offset+$list_step) {?>
<div class="imageitem">
<div class="imagestatus"><?php if($kermert->isVisible()){ ?>(En ligne)<?php }else{ ?>(Hors ligne)<?php } ?></div>
[<a href="#" onclick="javascrip:openClose('preview<?php echo $kermert->getCurrIdx();?>',0)">Preview</a>] <a href="?op=image&id=<?php getImageId()?>"><?=getImagename();?></a>
<div id="preview<?php echo $kermert->getCurrIdx();?>" class="imagedetail" style="display:none">
	<div class="imagethumbleft"><img src="<?php echo getImageThumb();?>"/></div>
	<?php echo getImageBody();?>
	<div style="clear:both;"></div>
</div>
</div>
<?php $kermert->moveNext();} ?>

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