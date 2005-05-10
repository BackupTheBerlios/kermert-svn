<?php
include_once(dirname(__FILE__).'/../includes/classes/class.ini.file.php');
include_once(dirname(__FILE__).'/../includes/classes/class.mysql.php');
include_once(dirname(__FILE__).'/../includes/extend/class.xkermert.php');
include_once(dirname(__FILE__).'/../includes/functions.php');

define('CONFIG_FILE',dirname(__FILE__).'/../config/kermert.ini');

iniFile::read(CONFIG_FILE);

$con = new connection(km_dbuser,km_dbpassword,km_dbhost,km_dbbase);



?>