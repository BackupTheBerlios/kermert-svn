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

require_once(dirname(__FILE__)."/includes/Sajax.php");
require_once(dirname(__FILE__)."/prepend.php");

/**
 * Fonction de r�cup�ration des informations EXIF d'une image pass�e en param�tre.
 *
 * @param: le chemin qualifi� vers l'image sur le FS
 * @return: une s�rialisation SAJAX des donn�es
 */
function ImageInfos($image)
{
     $res = GDWrapper::ImageInfos(km_appdir.km_imagesdir.$image);
     if(!$res)
          return(sajax_serialize("status","KO","libelle","Impossible d'extraire les donn�es EXIF"));
     else
          return(sajax_serialize("status","OK","libelle",$res));
}

/**
 * Fonction de g�n�ration d'une miniature
 *
 * @param: le chemin qualifi� vers l'image originale
 * @return: true/false
 */

function genThumb($image)
{
     $res = GDWrapper::genThumb($image);
     if(!$res)
          return(sajax_serialize("status","KO","libelle","La miniature n'a pu �tre g�n�r�e"));
     else
          return(sajax_serialize("status","OK","thumb",$res));
}


sajax_init();
sajax_export("ImageInfos","getThumbs");
sajax_handle_client_request();

?>