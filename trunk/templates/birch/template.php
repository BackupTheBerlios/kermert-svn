<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php km_config('sitename'); ?>  <?php km_imageTitle(":: Photo :: %s"); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="robots" content="index" />


	<link rel="stylesheet" type="text/css" href="<?php km_config('theme'); ?>/style.css" />

</head>
<body>

<div id="content">
<div id="sidebar">

	<h1 id="page-title">
		<?php km_config('sitename'); ?>
	</h1>

	<h2 id="tagline">
		<?php km_config('desc'); ?>
	</h2>


	<div id="nav">
		<a href="<?php km_config('url'); ?>">Home</a>
		<a href="<?php km_config('archives'); ?>">Archives</a>
	</div>

	<div id="badges">
		<a href="http://photoblog.kermert.net" id="powered-by-birch">Powered By Kermert</a>

	</div>

	<div id="copyright">
		&copy; 2005 Your Name Here
	</div>

</div>

<div id="main">
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
</div>

</body>
</html>
