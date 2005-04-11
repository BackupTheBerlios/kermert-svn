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

   if ( $_POST["op"] == "uploadfile" ) {
      saveFile();
      exit();
   }
function saveFile()
{
     if ( is_uploaded_file($_FILES["uploadfile"]['tmp_name']))
     {
          $new_file = dirname(__FILE__).'/../images/'.$_FILES["uploadfile"]['name'];
          if(!move_uploaded_file($_FILES["uploadfile"]['tmp_name'],$new_file))
          {
               $response = 'KO';
          }
          else
          {
               chmod($new_file,0644);
               $response = $_FILES["uploadfile"]['name'];
          }
     }
     else
     {
          $response = "KO";
     }
     ?>
     <html>
     <head>
          <title>Uploading <?= $_POST["uploadfile"] ?></title>
          <script language="javascript">
          <!-- // hide from older browsers
          function respond() {

               if ( window.parent.uploadResponse ) {
               window.parent.uploadResponse("<?= addslashes($response) ?>");
               } else {
               alert('<?= addslashes($response) ?>');
               }
          }
          //-->
          </script>
     </head>
     <body onLoad="respond();">
     </body>
     </html>
     <?
     exit();
}
?>