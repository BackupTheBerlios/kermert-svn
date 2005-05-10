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

include_once(dirname(__FILE__).'/includes/prepend.php');
include_once(dirname(__FILE__).'/includes/layout.php');

$photoblog = new xkermert($con);

if(km_varmode=='path_info')
	$params = $_SERVER['PATH_INFO'];
else
	$params = $_SERVER['QUERY_STRING'];

$params = explode('/',$params);
array_shift($params);
//print_r($params);

$page_mode = getMode($params);
//print_r($page_mode);
$mode = $page_mode['page'];
$comments_allowed = $page_mode['comments'];

$photoblog->init($page_mode);


include_once(km_appdir.km_themesdir.km_theme.'/template.php');

//phpinfo();
?>