<?php
//Include FB config file
require_once 'fbConfig.php';

//Unset user data from session
unset($_SESSION['userData']);


  // to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['MM_Email']=NULL;

  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_Email']);
	
  // Facebook - Unset user data from session
  unset($_SESSION['userData']);

  // Redirecto 
  $logoutGoTo = "index.php?lo=t";

  //Destroy session data
  $facebook->destroySession();

  // redirect to the login page
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }



//Redirect to homepage
//header("Location:login.php");
?>