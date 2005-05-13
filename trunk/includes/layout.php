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
 * @see Kermert
 * @package Templating
 * @author Pierre-Yves Gillier <pivwan@kermert.net>
 */

/**
 * Function km_config <br/>
 * echoes current config parameters
 * @param string $key Parameter to retrieve.
 * @return void
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

/**
 * Displays current post's full-size image.
 * @global Kermert
 * @return void
 */
function km_displayImage()
{
     global $photoblog;

     echo km_appurl.km_imagesdir.$photoblog->getField('image');
     return;
}

/**
 * Displays link to previous image.
 * @param string $text Text to be displayed in link.
 * @param string $class CSS class to use.
 * @param string $id Id of link.
 * @return void
 */
function km_previousImage($text="Previous",$class='',$id='')
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
     return;
}

/**
 * Displays link to next image.
 * @param string $text Text to be displayed in link.
 * @param string $class CSS class to use.
 * @param string $id Id of link.
 * @return void
 */
function km_nextImage($text="Next",$class='',$id='')
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

/**
 * Displays current image's title.
 * @param string $string Encapsulation string for title.
 * @return void
 */
function km_imageTitle($string='%s')
{
     /*
     global $photoblog;
     echo sprintf($string,$photoblog->getField('title'));
     */
     echo sprintf($string,$GLOBALS['imagetitle']);
}

/**
 * Displays current image's text body.
 * @param string $string Encapsulation string for body.
 * @return void
 */
function km_imageBody($string="<p>%s</p>")
{
     global $photoblog;
     echo sprintf($string,$photoblog->formatImageBody());
}

/**
 * Displays current image's posting date.
 * Time is formatted following PHP's definitions.
 * @param string $format Date format. If no value is passed, will use configuration's value.
 * @link http://www.php.net/date
 * @return void
 */
function km_imageDate($format='')
{
     global $photoblog;
 	($format=='')? $date_format = km_dateformat : $date_format = $format;
     echo date($date_format,strtotime($photoblog->getField('datetime')));
}

/**
 * Displays current image's posting time.
 * Date is formatted following PHP's definitions.
 * @param string $format Time format. If no value is passed, will use configuration's value.
 * @link http://www.php.net/date
 * @return void
 */
function km_imageTime($format='')
{
     global $photoblog;
     ($format=='')? $time_format = km_timeformat : $time_format = $format;
     echo date($time_format,strtotime($photoblog->getField('datetime')));
}

/**
 * Displays current image's permalink.
 * @param string $text Text to be displayed in link.
 * @param string $class CSS class to use for hyperlink.
 * @param string $id Id of link
 * @return void
 */
function km_Permalink($text="Permalink",$class='',$id='')
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
     return;
}

/**
 * Displays list of months where there are available posts..
 * @param string $around HTML tags to encapsulate each element.
 * @param string $item Code for item's count.
 * @return void
 */
function km_monthList($around='<li>%s</li>',$item='')
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
/**
 * Displays list of categories which current image belongs to.
 * @param string $class CSS class to use for hyperlink.
 * @param string $id Id of link
 * @return void
 */
function km_imageCategories($class='',$id='')
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