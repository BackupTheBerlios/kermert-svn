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
require_once(dirname(__FILE__).'/includes/sajax/images.php');

// Sajax Init

sajax_init();
//$sajax_remote_uri = './sajax_operations.php';

sajax_export("updateImageStatus");
sajax_handle_client_request();

$list_step = 9;

$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'list';
$offset = (!empty($_REQUEST['offset'])) ? $_REQUEST['offset'] : 0;
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
<script language="javascript" type="text/javascript" src="./includes/wrappers/wrapper.images.js"></script>
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
<p class="modified"><b>&middot; <?php echo subtitle('images.'.$op);?></b></p>

<p>
<?php
if($op=='list'){ ?>
<?php $kermert->loadImagesList('all',$offset);?>

<?php while(!$kermert->EOF() && $kermert->getCurrIdx() <= $offset+$list_step) {?>
<div class="imageitem">
<div class="imagestatus" id="imgstatus<?php echo getImageId()?>"><?php if($kermert->isVisible()){ ?>(En ligne)<?php }else{ ?>(Hors ligne)<?php } ?></div>
[<a href="#" onclick="javascrip:openClose('preview<?php echo $kermert->getCurrIdx();?>',0)">Preview</a>] 
<a href="./image.php?op=image&id=<?php echo getImageId()?>"><?=getImagename();?></a>
<div id="preview<?php echo $kermert->getCurrIdx();?>" class="imagedetail" style="display:none">
	<div class="imagethumbleft"><img src="<?php echo getImageThumb();?>"/></div>
	<?php echo getImageBody();?>
	<div style="clear:both; text-align:right;"><input type="button" id="b<?php echo getImageId()?>" value="mettre en ligne" onclick="javascript:updateStatus(<?php echo getImageId()?>);"/></div>
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