<?php
session_start();
include_once(dirname(__FILE__).'/../includes/classes/class.ini.file.php');
include_once(dirname(__FILE__).'/../includes/classes/class.mysql.php');
include_once(dirname(__FILE__).'/../includes/classes/class.kermert.php');
include_once(dirname(__FILE__).'/../includes/classes/class.kmImage.php');
include_once(dirname(__FILE__).'/../includes/lib.form.php');
include_once(dirname(__FILE__).'/../includes/functions.php');
include_once(dirname(__FILE__).'/includes/classes/class.kminfo.php');
include_once(dirname(__FILE__).'/includes/classes/class.kmuser.php');
include_once(dirname(__FILE__).'/includes/functions.php');

define('CONFIG_FILE',dirname(__FILE__).'/../config/kermert.ini');

iniFile::read(CONFIG_FILE);

$con = new connection(km_dbuser,km_dbpassword,km_dbhost,km_dbbase);

$_SESSION['hashkey'] = (!empty($_REQUEST['logout'])) ? $_SESSION['hashkey']=NULL : $_SESSION['hashkey'] ;

if(!kmUser::isAuthenticated()&& empty($auth_page))
{
	header('Location: auth.php');
}

$kermert = new Kermert($con);

?>