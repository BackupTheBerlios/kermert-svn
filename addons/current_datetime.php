<?php

/*

Pixelpost version 1.3
Datetime addon version 1.0

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

/*

Provided as a basic example.
It retreives the current datetime as reported by the server.

The new tag to use in templates are
<CURRENT_DATE_TIME>
which will be replaced with the variable $current_date_time.

It's very simplistic.

When creating an addon, please always have the $addon_* variables.
Those are displayed in a users admin panel under general info.

All variables from the main script are available here, be sure not to overwrite!

$tpl holds the current template (image_template.html or comments_template.html etc).

*/

$addon_name = "Pixelpost Current DateTime";
$addon_description = "Displays current date and time as reported by the server.<br />
Format is: date(\"Y-m-d H:i:s\")<br />
 An example of how to create addons.";
$addon_version = "1.0";

$current_date_time = date("Y-m-d H:i:s");
$tpl = ereg_replace("<CURRENT_DATE_TIME>",$current_date_time,$tpl);

?>