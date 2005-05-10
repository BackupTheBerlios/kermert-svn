<?php

/*

Pixelpost version 1.3rc1
Copy Folder Addon version 0.5

Pixelpost www: http://www.pixelpunk.se/software/
Contact: pixelpost@pixelpunk.se
Copyright (c) 2004 shapestyle graphic design + code<http://www.shapestyle.se>
License: http://www.gnu.org/copyleft/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

*/

$copyfolderpath = ereg_replace("/images","",$cfgrow['imagepath']);

$addon_name = "Pixelpost Copy Folder Contents";
$addon_description = "Copy the entire contents of a folder into pixelpost database.<br />
Each entry will have the filename as title.<br />
<i>No thumbnails will be created.</i> You will have to come back to admin and update your thumbnails.
<p />
Enter the absolute path to folder:<p />
<form method='post' action='../index.php?x=copyfolder'>
<input type='text' name='folder_path' value='$copyfolderpath' style='width:400px'><p />
<input type='submit' value='Copy Folder'>
</form>";
$addon_version = "0.5";

if($_GET['x'] == "copyfolder") {
    $filenumber = 0;
    $upload_dir = $cfgrow['imagepath'];
    $folder = $_POST['folder_path'];
    $folder = "$folder/";
    $folder = ereg_replace("//","/",$folder);
    $secondcount = 0;
    
    if($handle = opendir($folder)) { 
        while (false !== ($file = readdir($handle))) { 
            if($file != "." && $file != ".." && $file != ".DS_Store") { 
                if($secondcount < 11) { $secondcount = "0$secondcount"; }
                $datetime = 	date("Y-m-d H:i:$secondcount");
                $secondcount++;
                // prepare the file
                $oldfile = $file;
                $newfile = "$upload_dir$file";
                $file = "$folder$file";
	            if(copy($file,$newfile)) { 
	                $filenumber++;
	                // insert post in mysql
	                $query = "insert into ".$pixelpost_db_prefix."pixelpost(id,datetime,headline,body,image,category)
	                VALUES('NULL','$datetime','$oldfile','$oldfile','$oldfile','')";
	                $result = mysql_query($query) || die("Error: ".mysql_error());
                    } // if copy done
                } // if file done 
            } // while false done 
        closedir($handle);
        } // if handle done
    echo "<hr><b>Copied $filenumber files.</b><br />
    No thumbnails are created while copying files with this addon. Re-generate them from admin options.
    <a href='index.php'>Website</a><br>
        <a href='admin/index.php'>Admin Index</a>
    <hr>";
    } 


?>