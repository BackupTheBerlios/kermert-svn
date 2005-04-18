<?php

/**
 * Displays kermert version.
 *
 * @param: none
 * @return: version number extracted from VERSION file located at application's root
 */

function getAppVersion()
{
	$version_file = dirname(__FILE__).'/../../VERSION';
	if(@readfile($version_file)==false)
		echo('Not found!');
}

function subtitle($code)
{
	$codes = array(
				'config.params'=>'Paramètres',
				'config.themes'=>'Thèmes',
				'config.info'=>'Informations',
				'stats.summary'=>'Résumé',
				'stats.detail'=>'Détails des visiteurs',
				'images.image'=>'Nouvelle image',
				'images.list'=>'Gestion des images',
				'images.operations'=>'Opérations sur les images'
				);

	return($codes[$code]);
}

function OuiNon($bool){
  if($bool){
   return "<font color=\"#00ff00\"> Oui</font>";
  }else{
   return "<font color=\"#ff0000\"> Non</font>";
  }
}

function getCategoryList()
{
	global $con;

	$categories = array();

	$rs = $con->select("SELECT * FROM ".km_dbprefix."categories ORDER BY name");
	while(!$rs->EOF())
	{
		$categories[$rs->f('name')] = $rs->f('id');
		$rs->movenext();
	}

	return($categories);
}

function paginate($offset,$step)
{
     global $kermert;
     $pages = (int)($kermert->imageslist->nbRow() / $step)+1;
     $txt = "[ ";
     for($i=0; $i<$pages;$i++)
          $txt.='<a href="./images.php?op=list&offset='.($i*$step).'">'.($i+1)."</a>&nbsp;";
     $txt.= " ]";
     return($txt);
}

function logger($msg,$lvl='ERROR')
{
	error_log('<'.date('Y-m-j H:i:s').'><'.$lvl.'> '.$msg.chr(10),3,dirname(__FILE__).'/../logs.txt');
}

function debug($msg)
{
	logger($msg,'DEBUG');
}
function info($msg)
{
	logger($msg,'INFO');
}
function error($msg)
{
	logger($msg,'ERROR');
}
function warning($msg)
{
	logger($msg,'WARNING');
}
function fatal($msg)
{
	logger($msg,'FATAL');
}
?>