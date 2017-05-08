<?
//initialize the session ---------------------------------------------------------------------------------------------------
 $today    = date('m-d-Y',mktime(0, 0, 0, date("m"), date("d"),  date("Y")));
 $themonth = date("m");
 $theyear  = date("Y"); 
 $theday   = date("d");
 

// start the session if it's not already
if (!isset($_SESSION)) {
  session_start();
}


// create a logout link for future use
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";


// check the query string and append it to our logoutaction link
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}


// save the current user email address before logging out
$theuser   = $_SESSION['MM_Username'];
$theuserid = $_SESSION['MM_UserID'];


// if this is a user logout then do the following
if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

  // to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['MM_Email']=NULL;

  // Unset the session vars
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_Email']);
	
  // Facebook - Unset user data from session
  unset($_SESSION['userData']);

  // Facebook - Destroy session data
  $facebook->destroySession();

  // Redirecto 
  $logoutGoTo = "login.php?ID=1";

  // redirect to the login page
  if ($logoutGoTo) {
    //header("Location: $logoutGoTo");
    //exit;
  }

} else {


  // login user
  $MM_authorizedUsers  = "";
  $MM_donotCheckaccess = "true";
  $MM_restrictGoTo     = "login.php";

  // If the user has logged in with FB for the first time they will not yet have a username and will 
  // be blocked from access. Check if there is a FB code, and, if so bypass the accesscheck. FB code
  // will only always be returned upon a successful FB login verification per the FB documentation.
  $facebook_code = $_REQUEST["code"];

  // This is a FB request, skip the authorization bc it has already been done through FB
  if(!$facebook_code) {
    if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
      $MM_qsChar = "?";
      $MM_referrer = $_SERVER['PHP_SELF'];
      
      if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
      if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
      $MM_referrer .= "?" . $QUERY_STRING;
      $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
      //header("Location: ". $MM_restrictGoTo); 
      //exit;
    }
  }

}


// Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 

  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 

    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 

    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 

    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
    
  } 
  return $isValid; 
}




?>