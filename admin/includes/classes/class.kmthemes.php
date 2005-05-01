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

class kmThemes 
{
	var $_list = array();
	var $_step = 0;
	
	function kmThemes()
	{
		$this->themes_dir = km_appdir.km_themesdir;
		$this->search('theme.txt',$this->themes_dir);
		
	}
	
	function search($target, $directory)
	{
		if(is_dir($directory))
		{
			$direc = opendir($directory);
	       	while(false !== ($file = readdir($direc)))
	       	{
	          	if($file !="." && $file != "..")
	          	{
					if(is_file($directory."/".$file))
					{
	                   		if(preg_match("/$target/i", $file))
	                   		{
	                         	//echo "<a href=\"$directory/$file\">$file</a><br>";
	                         	$this->_list[] = array('directory'=>$directory,'name'=>str_replace($this->themes_dir.'/',"",$directory));
	                         	
	                         }
	               	}
	               	else if(is_dir($directory."/".$file))
	               	{
	                   		$this->search($target,$directory."/".$file);
		               }
		           }
	       	}
	       	closedir($direc);
		}
		return ;
	}
	
	function getThemeslist()
	{
		if($this->_step+1 > count($this->_list))
			return(false);
		$desc = $this->_list[$this->_step]['directory'].'/theme.txt';
		
		$this->_curtheme['meta'] = iniFile::read($desc,true);
		$this->_curtheme['name'] = $this->_list[$this->_step]['name'];
		
		$this->_step++;
		return(true);
	}
	
	function getThemeDir()
	{
		echo $this->_curtheme['name'];
	}
	function getThemeDesc($key)
	{
		echo $this->_curtheme['meta'][$key];
	}
	function getThemePreview()
	{
		echo 'includes/stuff/notfound.png';
	}
}
?>