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

$categories = $kermert->getCategories();
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
<li><div class="green"><strong>Categories</strong></div></li>
<li><a href="./comments.php">Comments</a></li>
<li><a href="./users.php">Administration</a></li>
</ul>
</div>
<!-- ********************** END OF MENU ********************** -->
<div id="rhlp-middle-two">
<div class="rhlp-corner-tr">&nbsp;</div>
<div class="rhlp-corner-tl">&nbsp;</div>

<div id="rhlp-content">
<!-- ************************* Main part *********************** -->


<h1>Categories</h1>
<?php while(!$categories->EOF()) { ?>
<div class="news2">
<h3><?php echo $categories->getTitle();?></h3>
<ul>
     <li><strong>Qualified URI:</strong> <?php echo $categories->getQualifiedUri('small'); ?></li>
     <li><strong>Pictures under this category:</strong><?php echo $categories->getPostCount(); ?></li>
</ul>
</div>
<?php $categories->moveNext(); } ?>
<br /><br />

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