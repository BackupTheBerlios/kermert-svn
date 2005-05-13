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
 * Layout functions
 * All these function are used in templates files.
 * @version $Id$
 * @author Pierre-Yves Gillier <pivwan@kermert.net>
 */

/**
 * function km_config
 * echoes current config parameters
 * @param string $key Parameter to retrieve. Default <i>url</i>
 * @return void
 * @author Pierre-Yves Gillier
 */

function km_config($key='url')
{
     switch($key)
     {
          case 'url': echo km_appurl.km_script; break;
          case 'theme': echo km_appurl.km_themesdir.km_theme; break;
          case 'rss': echo km_appurl.'rss.php'; break;
          case 'sitename': echo km_appname; break;
          case 'desc': echo km_desc; break;
          case 'archives': echo km_appurl.km_script.getURISep().'/archives'; break;
          default: break;
     }
     return;
}

function km_displayImage()
{
     global $photoblog;

     echo km_appurl.km_imagesdir.$photoblog->getField('image');
}

function km_previousImage($text="Previous",$id='',$class='')
{
     global $photoblog;
     if($photoblog->_previd!='')
     {
          $link = '<a href="'.km_appurl.km_script.getURISep().'/'.$photoblog->_previd.'"';
          if($id!='') $link.= ' id="'.$id.'"';
          if($class!='') $link.= ' class="'.$class.'"';
          $link.= '>'.$text.'</a>';
          echo $link;
     }
}
function km_nextImage($text="Next",$id='',$class='')
{
     global $photoblog;
     if($photoblog->_nextid!='')
     {
          $link = '<a href="'.km_appurl.km_script.getURISep().'/'.$photoblog->_nextid.'"';
          if($id!='') $link.= ' id="'.$id.'"';
          if($class!='') $link.= ' class="'.$class.'"';
          $link.= '>'.$text.'</a>';
          echo $link;
     }
}

function km_imageTitle($string='%s')
{
     /*
     global $photoblog;
     echo sprintf($string,$photoblog->getField('title'));
     */
     echo sprintf($string,$GLOBALS['imagetitle']);
}

function km_imageBody($string="<p>%s</p>")
{
     global $photoblog;
     echo sprintf($string,$photoblog->formatImageBody());
}

function km_imageDate($format='')
{
     global $photoblog;
 	($format=='')? $date_format = km_dateformat : $date_format = $format;
     echo date($date_format,strtotime($photoblog->getField('datetime')));
}

function km_imageTime($format='')
{
     global $photoblog;
     ($format=='')? $time_format = km_timeformat : $time_format = $format;
     echo date($time_format,strtotime($photoblog->getField('datetime')));
}

function km_Permalink($text="Permalink",$id='',$class='')
{
	global $photoblog;
     if($photoblog->_curid!='')
     {
          $link = '<a href="'.km_appurl.km_script.getURISep().'/'.$photoblog->_curid.'"';
          if($id!='') $link.= ' id="'.$id.'"';
          if($class!='') $link.= ' class="'.$class.'"';
          $link.= '>'.$text.'</a>';
          echo $link;
     }
}

function km_monthList($item='',$around='<li>%s</li>')
{
     global $photoblog;
     $months = $photoblog->getMonthList();
     foreach($months as $month)
     {
          if($item!='')
          {
               for($i=0;$i<$month['count'];$i++)
                    $item_view.= $item;
          }
          else
               $item_view = '('.$month['count'].')';
          echo sprintf($around,'<a href="'.km_appurl.km_script.getURISep().'/'.$month['name'].'">'.$month['name'].'</a> '.$item_view);
     }

}

function km_imageCategories($id='',$class='')
{
     global $photoblog;
     $photoblog->catlist->moveStart();
     while(!$photoblog->catlist->EOF())
     {
          $link = '<a href="'.km_appurl.km_script.getURISep().'/'.$photoblog->catlist->f('qualifieduri').'"';
          if($id!='') $link.= ' id="'.$id.'"';
          if($class!='') $link.= ' class="'.$class.'"';
          $link.= '>'.$photoblog->catlist->f('name').'</a>';
          echo '<li>'.$link.'</li>';

          $photoblog->catlist->moveNext();
     }
}
?>