<?php

function kmSettings($key='url')
{
	//global km_appurl;
	if($key=='url')
		echo km_appurl;
}

function getImageName()
{
	global $kermert;
	return $kermert->imageslist->f('headline');
}

function getImageThumb()
{
	global $kermert;
	echo km_appurl.km_thumbsdir.'thumb_'.$kermert->imageslist->f('image');
}

function getImageBody()
{
	global $kermert;
	echo $kermert->imageslist->f('body');
}

function getImageId()
{
	global $kermert;
	echo $kermert->imageslist->f('id');
}
?>