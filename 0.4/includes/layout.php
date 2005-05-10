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

// Display functions for templates.

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
     global $photoblog;
     echo sprintf($string,$photoblog->getField('title'));
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
?>