<?php

class kmInfo
{
	function env_info()
	{
		$env_info = '<ul>';
		$env_info.= '<li>Serveur Web: '.php_uname().'</li>';
		$env_info.= '<li>Version de PHP: '.phpversion().'</li>';
		$env_info.= '<li>Date serveur: '.date('d/m/Y H:i:s').'</li>';
		$env_info.= '</ul>';
		echo $env_info;
	}
	function graphic_info()
	{
		$gd_info.= "<h4>Support de GD: </h4>";
		$gd_info.= '<ul>';
		if(function_exists("gd_info"))
		{
			$info = gd_info();
			$keys  = array_keys($info);
			for($i=1;$i<count($keys);$i++)
			{
				$gd_info.= "<li>".$keys[$i] .": ".OuiNon($info[$keys[$i]]).'</li>';
			}
		}
		else
		{
			$gd_info.= "<li>Non supporté</li>";
		}
		$gd_info.= '</ul>';

		$gd_info.= "<h4>Support de Imagemagick: </h4>";
		echo($gd_info.$im_info);
	}
}

function OuiNon($bool)
{
  if($bool){
   return "<font color=\"#00ff00\"> Oui</font>";
  }else{
   return "<font color=\"#ff0000\"> Non</font>";
  }
}
?>