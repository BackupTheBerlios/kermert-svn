<?php

class kermert
{
	var $con;
	
	function kermert(&$con)
	{
		$this->con = $con;
	}
	
	function loadSingleImage($id)
	{
		$this->imageslist = $this->con->select('SELECT * FROM '.km_dbprefix.'images WHERE id='.$id);
		$this->imageslist->moveStart();
	}
	function loadImagesList($mode='all',$offset=0)
	{
		if($mode=='all')
			$elements = '*';
		else
			$elements = 'id,datetime,headline';
		$this->imageslist = $this->con->select('SELECT '.$elements.' FROM '.km_dbprefix.'images');
		$this->imageslist->move($offset);
	}
	
	function getCurrIdx()
	{
		return($this->imageslist->int_index);
	}
	
	function movenext()
	{
		return $this->imageslist->moveNext();
	}
	
	function EOF()
	{
		return $this->imageslist->EOF();
	}
}
?>