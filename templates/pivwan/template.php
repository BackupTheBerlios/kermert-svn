
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/1">
<title><?php km_config('sitename');?></title>
	<style type="text/css" media="screen">
		@import url( <?php km_config('themeurl');?>/style.css );
	</style>
</head>
<body>

<div id="container">

<div id="contents">

<div id="header">

<div id="navigation">

<a href="<?php km_config('url');?>">INDEX</a> | <a href="<?php km_config('archives');?>">ARCHIVES</a>

</div>

</div>


<div id="img">

<?php
if($mode=='image')
{
     include(km_appdir.km_themesdir.km_theme.'/image.php');
}
elseif($mode=='archives')
{
     include(km_appdir.km_themesdir.km_theme.'/archives.php');
}
?>
</div>


<div id="footer">

<!-- do not remove copyright -->

<p>your footer info . <a href="http://www.cssfill.com">Design by CSSFILL.COM</a></p>

<!-- do not remove copyright -->
</div>


</div>

</div>


</body>
</html>