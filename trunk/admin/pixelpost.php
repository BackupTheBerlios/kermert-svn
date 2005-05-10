<script language="php">

/*

Pixelpost version 1.3
admin/pixelpost.php version 1.4

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

// database variables - this is info you've received from you hosting service
// those are needed for the script to connect and use MySQL

$pixelpost_db_host      = "localhost"; // database host, often "localhost"
$pixelpost_db_user      = "root"; // database user
$pixelpost_db_pass      = "pivoine"; // database user password
$pixelpost_db_pixelpost = "pixelpost"; // database

$pixelpost_db_prefix = "pixelpost_"; // table prefix, leave as is unless you want to install multiple blogs on the same database

// pixelpost version
$version = "WW91IGFyZSBydW5uaW5nIHZlcnNpb24gPGI+MS4zPC9iPiBvZiBQaXhlbHBvc3QuIFJlbGVhc2VkIDE2IG5vdmVtYmVyIDIwMDQu";

</script>