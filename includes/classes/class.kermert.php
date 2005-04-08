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

class kermert
{
	var $con;

	function kermert(&$con)
	{
		$this->con = $con;
	}

	function loadSingleImage($id)
	{
		$sql = 'SELECT * FROM '.km_dbprefix.'images WHERE id='.$id;
		$this->imageslist = $this->con->select($sql,'kmImage');
		$this->imageslist->moveStart();
	}
	function loadImagesList($mode='all',$offset=0,$order='DESC')
	{
		if($mode=='all')
			$elements = '*';
		else
			$elements = 'id,datetime,headline';
		$sql = 'SELECT '.$elements.' FROM '.km_dbprefix.'images ORDER BY datetime '.$order;
		$this->imageslist = $this->con->select($sql,'kmImage');
		$this->imageslist->move($offset);
	}

	function getCurrIdx()
	{
		return($this->imageslist->int_index);
	}

	function movenext()
	{
		return $this->imageslist->moveNext();
	}

	function EOF()
	{
		return $this->imageslist->EOF();
	}

	function isVisible()
	{
	     if($this->imageslist->f('status')=='0')
	          return(false);
          return(true);
	}
	
	function setSingleImage()
	{
		$this->imageslist = new kmImage();
	}
	
	function getCategories()
	{
		$sql = "SELECT * FROM ".km_dbprefix."image2cat WHERE id=".$this->imageslist->field('id');
	}
	
	function getField($field)
	{
		return($this->imageslist->field($field));
	}
}
?>