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

include_once(dirname(__FILE__).'/../classes/class.kermert.php');
include_once(dirname(__FILE__).'/../classes/class.wiki2xhtml.php');

class xkermert extends kermert
{
     var $_previd;
     var $_nextid;
     var $_curid;
     var $_params;
     var $mode;

     function xkermert($con)
     {
          $this->kermert($con);
     }

     function init($params)
     {
     	$this->_params = $params;
     	$this->mode = $params['page'];
          if($params['page']=='image')
          {
          	echo "image";
               // Home Page?
               if((isset($params['index'])&& $params['index']==true))
               {
                    $sql = "SELECT DATE_FORMAT(datetime,'%Y/%m/%d') AS image_date, qualifieduri, id FROM ".km_dbprefix."images WHERE status='1' ORDER BY datetime DESC LIMIT 0,1";
               }
               else
               {
                    // One image.
                    $image = explode('-',$params['map'][3]);
                    $sql = "SELECT DATE_FORMAT(datetime,'%Y/%m/%d') AS image_date, qualifieduri, id FROM ".km_dbprefix."images WHERE id=".$image[0];
               }
               
               $rs = $this->con->select($sql);
               $this->_curid = $rs->f('image_date').'/'.$rs->f('id').'-'.$rs->f('qualifieduri');
               $this->loadSingleImage($rs->f('id'));
               $this->initLinks($rs->f('id'));
               return;
          }
          elseif($params['page']=='archives')
          {
          	$this->loadImagesList('all','1');
          }
     }

     function initLinks($id)
     {
          // Previous Link
          $sql = "SELECT DATE_FORMAT(datetime,'%Y/%m/%d') AS image_date, qualifieduri, MAX(id) AS prev_id FROM  ".km_dbprefix."images WHERE status='1' GROUP BY datetime HAVING prev_id<".$id." ORDER BY datetime DESC LIMIT 0,1";
          $rs = $this->con->select($sql);
          if($rs->f('prev_id')!='')
               $this->_previd = $rs->f('image_date').'/'.$rs->f('prev_id').'-'.$rs->f('qualifieduri');

          // Next Link
          $sql = "SELECT DATE_FORMAT(datetime,'%Y/%m/%d') AS image_date, qualifieduri, MIN(id) AS next_id FROM  ".km_dbprefix."images WHERE status='1' GROUP BY datetime HAVING next_id>".$id." ORDER BY datetime ASC LIMIT 0,1";
          $rs = $this->con->select($sql);
          if($rs->f('next_id')!='')
               $this->_nextid = $rs->f('image_date').'/'.$rs->f('next_id').'-'.$rs->f('qualifieduri');
     }

     function formatImageBody()
     {
          if($this->getField('body_format')=='html')
          {
               return($this->getField('body'));
          }
          elseif($this->getField('body_format')=='wiki')
          {
               $wiki_parser = new Wiki2xhtml();
               return($wiki_parser->transform($this->getField('body')));
          }
     }
     
     function xgetField($field)
     {
     	if($this->params['page']=='image')
     		return($this->getField($field));
     	
     }
}
?>