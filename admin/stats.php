<?php

include_once(dirname(__FILE__).'/prepend.php');
include_once(dirname(__FILE__).'/includes/classes/class.kmstats.php');

$op = (!empty($_REQUEST['op'])) ? $_REQUEST['op'] : 'summary';

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
<p>
<ul>
	<li>Visiteurs uniques: <?php echo $stats->getCount('ip');?></li>
</il>
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