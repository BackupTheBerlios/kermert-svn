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

# Classe de connexion MySQL

require_once dirname(__FILE__).'/class.recordset.php';

class connection
{
	var $con_id;
	var $error;
	var $errno;
	var $cache_dir;
	var $cache_uptime;
	
	function connection($user, $pwd , $alias='', $dbname)
	{
		$this->error = '';
		$this->cache_dir = false;
		
		$this->con_id = @mysql_connect($alias, $user, $pwd);
		
		if (!$this->con_id) {
			$this->setError();
		} else {
			$this->database($dbname);
		}
	}
	
	function database($dbname)
	{
		$db = @mysql_select_db($dbname);
		if(!$db) {
			$this->setError();
		return false;
		} else {
			return true;
		}
	}
	
	function close()
	{
		if ($this->con_id) {
			mysql_close($this->con_id);
			return true;
		} else {
			return false;
		}
	}
	
	function select($query,$class='recordset',$cache=true)
	{
		if (!$this->con_id) {
			return false;
		}
		
		if ($class == '' || !class_exists($class)) {
			$class = 'recordset';
		}
		
		if ($cache && ($rs = $this->_getFromCache($query)) !== false)
		{
			return new $class($rs);
		}
		else
		{
			
			$cur = mysql_unbuffered_query($query, $this->con_id);
			
			if ($cur)
			{
				# Insertion dans le reccordset
				$i = 0;
				$arryRes = array();
				while($res = mysql_fetch_row($cur))
				{
					for($j=0; $j<count($res); $j++)
					{
						$arryRes[$i][strtolower(mysql_field_name($cur, $j))] = $res[$j];		
					}
					$i++;
				}
				
				$this->_putInCache($query,$arryRes);			
				return new $class($arryRes);
			}
			else
			{
				$this->setError();
				return false;
			}
		}
	}
	
	function execute($query)
	{
		if (!$this->con_id) {
			return false;
		}
		
		$cur = mysql_query($query, $this->con_id);
		
		if (!$cur) {
			$this->setError();
			return false;
		} else {
			return true;
		}
		
	}
	
	function getLastID()
	{
		if ($this->con_id) {
			return mysql_insert_id($this->con_id);
		} else {
			return false;
		}
	}
	
	function setError()
	{
		if ($this->con_id) {
			$this->error = mysql_error($this->con_id);
			$this->errno = mysql_errno($this->con_id);
		} else {
			$this->error = (mysql_error() !== false) ? mysql_error() : 'Unknown error';
			$this->errno = (mysql_errno() !== false) ? mysql_errno() : 0;
		}
	}
	
	function error()
	{
		if ($this->error != '') {
			return $this->errno.' - '.$this->error;
		} else {
			return false;
		}
	}
	
	function escapeStr($str)
	{
		return mysql_escape_string($str);
	}
	
	
	# Cache de requêtes SQL
	function setCache($dir,$uptime,$ttl='-24 hours')
	{
		if (is_dir($dir) && is_writable($dir)) {
			$this->cache_dir = $dir;
			$this->cache_uptime = $uptime;
			
			# Purge automatique du cache
			$files = array();
			if (($dh = @opendir($dir)) !== false)
			{
				while (($file = readdir($dh)) !== false)
				{
					if (is_file($dir.'/'.$file))
					{
						$stat = stat($dir.'/'.$file);
						$files[$dir.'/'.$file] = $stat[9];
					}
				}
				closedir($dh);
				
				asort($files);
				
				# Suppression des fichiers de plus de 24h
				$ttl = strtotime($ttl);
				foreach ($files as $k => $v)
				{
					if ($v < $ttl) {
						@unlink($k);
					}
				}
			}
		}
	}
	
	function _getFromCache($query)
	{
		if ($this->cache_dir != '')
		{
			$f = $this->cache_dir.'/'.md5($query);
			
			$ftest = file_exists($f) && (filemtime($f) > $this->cache_uptime);
			
			if ($ftest && ($fc = implode('',file($f))) !== false) {
				if (( $rs = @unserialize($fc)) !== false && is_array($rs)) {
					return $rs;
				}
			}
		}
		
		return false;
	}
	
	function _putInCache($query,$rs)
	{
		if ($this->cache_dir != '')
		{
			$f = $this->cache_dir.'/'.md5($query);
			
			if (($fp = @fopen($f,'w')) !== false) {
				$fc = serialize($rs);
				fwrite($fp,$fc,strlen($fc));
				fclose($fp);
			}
		}
	}
}

?>
