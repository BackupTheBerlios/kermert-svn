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

class GDWrapper
{

     function genThumb($src)
     {
          $percent = 0.5;
          	debug('image:'.$src);
          if(!GDWrapper::available())
               return(false);
          $thumb = km_thumbsdir."tn_".$src;
          $src = km_appdir.km_imagesdir.$src;

          // Calcul des nouvelles dimensions
          list($width, $height) = getimagesize($src);
          $newwidth = $width * $percent;
          $newheight = $height * $percent;

          // chargement
          $thumb = imagecreatetruecolor($newwidth, $newheight);
          $source = imagecreatefromjpeg($src);

          // Redimensionnement
          imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
          return($thumb);
     }

     function available()
     {
          if(!function_exists('gd_info'))
               return(false);
          return(true);
     }

     function ImageInfos($image)
     {
          if(extension_loaded(exif))
          {
               $exifs_info = '<ul>';
               $exif_raw = exif_read_data($image,0,true);
               $e_model = $exif_raw['IFD0']['Make'].' '.$exif_raw['IFD0']['Model'];
               if($e_model!=' ') $exifs_info.= '<li>Model: '.$e_model.'</li>';
               $e_lens = $exif_raw['EXIF']['LensModel'];
               if($e_lens!='') $exifs_info.= '<li>Lens: '.$e_lens.'</li>';
               $e_focal = $exif_raw['EXIF']['FocalLength'];
               if($e_focal!='') $exifs_info.= '<li>Focal: '.$e_focal.'</li>';
               $e_exposure = $exif_raw['EXIF']['ExposureTime'];
               if($e_exposure!='') $exifs_info.= '<li>Exposure: '.$e_exposure.'</li>';
               $e_fnumber = $exif_raw['EXIF']['FNumber'];
               if($e_fnumber!='') $exifs_info.= '<li>F Number: '.$e_fnumber.'</li>';
               $e_iso = $exif_raw['EXIF']['ISOSpeedRatings'];
               if($e_iso!='') $exifs_info.= '<li>ISO: '.$e_iso.'</li>';
               $exifs_info.= '</ul>';
               if($exifs_info=='<ul></ul>')
               {
               		$exifs_info = '<ul><li>No EXIF info</li></ul>';
               }
               return($exifs_info);
          }
          else
          {
               return(false);
          }

     }
}
?>