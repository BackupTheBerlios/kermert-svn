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
include_once(dirname(__FILE__).'/includes/classes/class.kmstats.php');

$offset = (!empty($_REQUEST['offset'])) ? $_REQUEST['offset'] : 0;
$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'summary';

$list_step = 29;

$stats = new kmStats($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="MSSmartTagsPreventParsing" content="TRUE" />
<link rel="stylesheet" type="text/css" href="./style.css" media="screen" />
<title>Administration</title>
<script type="text/javascript" src="./includes/tools.js"></script>
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
<h2>Statistiques</h2>
<p class="modified"><b>&gt; <?=subtitle('stats.'.$op)?></b></p>
<?php if($op=='summary') { ?>
<p>
<ul>
	<li>Visiteurs uniques: <?php echo $stats->getCount('ip');?></li>
</il>
</p>
<?php }elseif($op=='detail'){ ?>
<?php $stats->loadStatList();?>
<p>
<?php while(!$stats->EOF() && $stats->getCurrIdx() <= $offset+$list_step) {?>
<div class="imageitem">
[<a href="#" onclick="javascrip:openClose('preview<?php echo $stats->getCurrIdx();?>',0)">Preview</a>] <?php echo $stats->field('ua')?>
<div id="preview<?php echo $stats->getCurrIdx();?>" class="imagedetail" style="display:none">
	<div class="imagethumbleft"><img src="<?php echo getImageThumb();?>"/></div>
	<?php echo getImageBody();?>
	<div style="clear:both;"></div>
</div>
</div>
<?php $stats->moveNext();} ?>
</p>
<?php }?>
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