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

/**
 * Read-only extension.
 *
 * This class provides read-only methods to kermert class.
 * Primary use: Front-End 
 * @package Core
 * @subpackage Extensions
 */

include_once(dirname(__FILE__).'/../classes/class.kermert.php');
include_once(dirname(__FILE__).'/../classes/class.wiki2xhtml.php');

class xkermert extends kermert
{
	
	/**
	 * ID of previous post 
	 * @var string
	 */
     var $_previd;
     
     /**
	 * ID of next post 
	 * @var string
	 */
     var $_nextid;
     
     /**
	 * ID of current post 
	 * @var string
	 */
     var $_curid;
     
     /**
	 * Array of parameters passed to instance.
	 * @var array
	 */
     var $_params;
     
     /**
	 * Current application mode
	 * @var string
	 */
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
               $this->setGlobals(array('imagetitle'=>$this->getField('title')));
               $this->initLinks($rs->f('id'));
               return;
          }
          elseif($params['page']=='archives')
          {
               $this->loadRecentImages($params['category']);
               /*
               if((isset($params['category']) && $params['category']!='' && $params['category']!='archives'))
               {
                    // Category mode.
                    $this->loadImagesbyCat($params['category']);
               }
               elseif((isset($params['category']) && $params['category']!='' && $params['category']=='archives'))
               {
                    //$this->loadImagesList('all','1');
                    $this->loadRecentImages('archives');
               }
               */
          }
     }

     function loadImagesbyCat($category)
     {
          $ids = '';
          $sql = "SELECT DISTINCT image_id FROM ".km_dbprefix."catbypost, ".km_dbprefix."categories WHERE ".km_dbprefix."catbypost.cat_id=".km_dbprefix."categories.id AND ".km_dbprefix."categories.qualifieduri='".$category."'";
          $this->imagesbycat = $this->con->select($sql);
          $this->imagesbycat->moveStart();
     }

     function loadRecentImages($category)
     {

          $criterias = array(
                         "columns"=>"id,image,title",
                         "constraints"=>array("status"=>"'1'",
                                             )
                         );
          if($category!='archives')
               $criterias['constraints']['category']=$category;

          $this->loadImages($criterias,10);
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

     function setGlobals($globals)
     {
          if(is_array($globals))
               foreach($globals as $key=>$value)
                    $GLOBALS[$key]=$value;
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