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
function getImageFileName()
{
	global $kermert;
	return $kermert->imageslist->f('image');
}

function getImageThumb()
{
	global $kermert;
	if($kermert->imageslist->f('image')!='')
		echo km_appurl.km_thumbsdir.'thumb_'.$kermert->imageslist->f('image');
	else
		echo km_appurl.'includes/stuff/notfound.png';
}

function getImageBody()
{
	global $kermert;
	return $kermert->imageslist->f('body');
}

function getImageId()
{
	global $kermert;
	return $kermert->imageslist->f('id');
}

function getImageMode()
{
     global $kermert;
	return $kermert->imageslist->f('mode');
}

function formatDate($date)
{
	//return(
}

function getMode($params)
{
	// No params: index page
	if(count($params)==0)
		return(array('page'=>'image','index'=>true,'comments'=>km_indexcomments));
	// One non-numerci param: Archives or category page.
	if(count($params)==1 && !is_numeric($params[0]))
		return(array('page'=>'archives','category'=>$params[0]));
     // Fully qualified URI: One particular image
	if(count($params)==4)
	     return(array('page'=>'image','map'=>$params,'comments'=>1));
	// Too much parameters! redirecting to homepage
	if(count($params)>4)
	     return(array('page'=>'image','index'=>true,'comments'=>km_indexcomments));
	// Everything else: year/month view
     return(array('page'=>'archives','map'=>$params));
}

function getURISep()
{
     if(km_varmode=='get')
          return('?');
     return;
}

?>