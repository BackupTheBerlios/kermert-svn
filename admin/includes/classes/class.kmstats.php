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

class kmStats
{
	var $con;

	function kmStats(&$con)
	{
		$this->con = $con;
	}

	function getCount($key)
	{
		$rs = $this->con->select("SELECT distinct(".$key.") FROM ".km_dbprefix."visitors");
		if(!$rs->isEmpty())
			return($rs->nbRow());
		return(0);
	}

	function loadStatList($mode='all',$offset=0,$order='DESC')
	{
		if($mode=='all')
			$elements = '*';
		else
			$elements = 'id,datetime,ip';
		$this->statslist = $this->con->select('SELECT '.$elements.' FROM '.km_dbprefix.'visitors ORDER BY datetime '.$order);
		$this->statslist->move($offset);
	}

	function movenext()
	{
		return $this->statslist->moveNext();
	}

	function EOF()
	{
		return $this->statslist->EOF();
	}

	function getCurrIdx()
	{
		return($this->imageslist->int_index);
	}

}
?>