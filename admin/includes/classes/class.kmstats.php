<?php

class kmStats
{
	var $con;
	
	function kmStats(&$con)
	{
		$this->con = $con;
	}
	
	function getCount($key)
	{
		$rs = $this->con->select("SELECT distinct(".$key.") FROM ".km_dbprefix."visitors");
		if(!$rs->isEmpty())
			return($rs->nbRow());
		return(0);
	}
}
?>