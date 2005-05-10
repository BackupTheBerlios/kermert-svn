<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of DotClear.
# Copyright (c) 2004 Olivier Meunier and contributors. All rights
# reserved.
#
# DotClear is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# DotClear is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with DotClear; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****

# Classe de manipulation de recordSet, composé d'un tableau de la forme

class recordset
{
	var $arry_data;	# tableau contenant les données
	var $int_index;	# index pour parcourir les enregistrements
					# les enregistrements commencent à l'index 0
	
	var $int_row_count;	# nombre d'enregistrements
	var $int_col_count;	# nombre de colonnes
	var $fetch_index;	# utilisé localement
	
	function recordset($data)
	{
		$this->int_index = 0;
		$this->fetch_index = NULL;
		
		if(is_array($data))
		{
			$this->arry_data = $data;
			
			$this->int_row_count = count($this->arry_data);
			
			if ($this->int_row_count == 0)
			{
				$this->int_col_count = 0;
			}
			else
			{
				$this->int_col_count = count($this->arry_data[0]);
			}
		}
	}
	
	function field($c)
	{
		if(!empty($this->arry_data))
		{
			if(is_integer($c))
			{
				$T = array_values($this->arry_data[$this->int_index]);
				return (isset($T[($c)])) ? $T[($c)] : false;
			}
			else
			{
				$c = strtolower($c);
				if(isset($this->arry_data[$this->int_index][$c]))
				{
					if (!is_array($this->arry_data[$this->int_index][$c])) {
						return trim($this->arry_data[$this->int_index][$c]);
					} else {
						return $this->arry_data[$this->int_index][$c];
					}
				}
				else
				{
					return false;
				}
			}
		}
	}
	
	function f($c)
	{
		return $this->field($c);
	}
	
	function setField($c,$v)
	{
		$c = strtolower($c);
		$this->arry_data[$this->int_index][$c] = $v;
	}
	
	function moveStart()
	{
		$this->int_index = 0;
		return true;
	}
	
	function moveEnd()
	{
		$this->int_index = ($this->int_row_count-1);
		return true;
	}
	
	function moveNext()
	{
		if (!empty($this->arry_data) && !$this->EOF()) {
	 		$this->int_index++;
			return true;
		} else {
			return false;
		}
	}
	
	function movePrev()
	{
		if (!empty($this->arry_data) && $this->int_index > 0) {
			$this->int_index--;
			return true;
		} else {
			return false;
		}
	}
	
	function move($index)
	{
		if (!empty($this->arry_data) && $this->int_index >= 0 && $index < $this->int_row_count) {
			$this->int_index = $index;
			return true;
		} else {
			return false;
		}
	}
	
	function fetch()
	{
		if ($this->fetch_index === NULL) {
			$this->fetch_index = 0;
			$this->int_index = -1;
		}
		
		if ($this->fetch_index+1 > $this->int_row_count) {
			$this->fetch_index = NULL;
			$this->int_index = 0;
			return false;
		}
		
		$this->fetch_index++;
		$this->int_index++;
		
		return true;
	}
	
	function BOF()
	{
		return ($this->int_index == -1 || $this->int_row_count == 0);
	}
	
	function EOF()
	{
		return ($this->int_index == $this->int_row_count);
	}
	
	function isEmpty()
	{
		return ($this->int_row_count == 0);
	}
	
	# Donner le tableau de données
	function getData()
	{
		return $this->arry_data;
	}
	
	# Nombre de lignes
	function nbRow()
	{
		return $this->int_row_count;
	}
}
?>