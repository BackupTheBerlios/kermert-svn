<?php

class kmUser
{
	function isAuthenticated()
	{
		global $con;
		$check = $con->select("SELECT uniqid FROM ".km_dbprefix."users WHERE uniqid='".$_SESSION['hashkey']."'");
		if($check->nbRow()==1)
			return(true);
		return(false);
	}
	
	function authenticate($username,$password)
	{
		global $con;
		if($username=='' || $password=='' )
			return(false);
		$user_row = $con->select("SELECT username,password from ".km_dbprefix."users WHERE username='".$username."' AND password='".md5($password)."'");
		if($user_row->nbRow()!=1) //No row found or bug! In all cases, logon denied
			return(false);
		// Everything must be good now.
		// Defining uniqid for cookie.
		$uniqid = md5(uniqid(rand(),true));
		$_SESSION['hashkey'] = $uniqid;
		$con->execute("UPDATE ".km_dbprefix."users SET uniqid='".$uniqid."'");
		return(true);
	}
}
?>