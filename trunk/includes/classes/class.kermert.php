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
		$this->loadImageCategories($id);
	}

	function loadImages($params,$limit='',$order='DESC')
	{
	     $sql = '';

	     // Max count to retrieve
	     if($limit!='')
	          $limit = ' LIMIT 0,'.$limit;

	     //Columns to retrieve.
	     if((isset($params['columns']) && $params['columns']!=''))
	          $columns = $params['columns'];
	     else
	          $columns = '*';

	     // Search constraints
	     if((isset($params['constraints']) && is_array($params['constraints'])))
	     {
               $constraints = "WHERE ";
               foreach($params['constraints'] as $key=>$value)
                    if($key!='category')
                         $constraints.=$key.'='.$value.' ';

          }
          $sql = "SELECT ".$columns." FROM ".km_dbprefix."images ".$constraints."ORDER BY datetime ".$order.$limit;

          // Do we have a category in constraints?
          // If so, request must be completely modified!
          if((isset($params['constraints']['category']) && $params['constraints']['category']!=''))
          {
               $sql = "SELECT ".$columns." FROM ".km_dbprefix."images ".$constraints."ORDER BY datetime ".$order.$limit;
          }


          echo $sql;
          $this->imageslist = $this->con->select($sql,'kmImage');
          echo $this->con->error();

	}

	function getMonthList()
	{
	     $months = array();
	     $sql = "SELECT DISTINCT DATE_FORMAT(datetime,'%Y/%m') AS month, COUNT(*) AS cpt FROM ".km_dbprefix."images WHERE status='1' GROUP BY month ORDER BY datetime DESC";


	     $rs = $this->con->select($sql);
	     echo $this->con->error();
	     while(!$rs->EOF())
	     {
	          $months[] = array('name'=>$rs->f('month'),'count'=>$rs->f('cpt'));
	          $rs->moveNext();
	     }
          unset($rs);
          return($months);
	}

	function loadImageCategories($id)
	{
          $sql = "SELECT ".km_dbprefix."categories.name, ".km_dbprefix."categories.qualifieduri  FROM ".km_dbprefix."catbypost, ".km_dbprefix."categories WHERE ".km_dbprefix."catbypost.cat_id=".km_dbprefix."categories.id AND ".km_dbprefix."catbypost.image_id=".$id;
          $this->catlist = $this->con->select($sql);
	}

	function getCurrIdx()
	{
		return($this->imageslist->int_index);
	}

	function movenext()
	{
		$this->imageslist->moveNext();
		$this->loadImageCategories($this->imagesliste->f('id'));
		return;
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

	function getField($field)
	{
		if(is_object($this->imageslist))
			return($this->imageslist->field($field));
		return;
	}
}
?>