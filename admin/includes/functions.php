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
				'config.params'=>'Param�tres',
				'config.themes'=>'Th�mes',
				'config.info'=>'Informations',
				'stats.summary'=>'R�sum�',
				'images.image'=>'Nouvelle image',
				'images.list'=>'Gestion des images',
				'images.operations'=>'Op�rations sur les images'
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
?>