<?php
ob_start();
session_start();

@ini_set('display_errors', 1);
@ini_set('track_errors', 0);
error_reporting(-1);

$PHPSESSID  = session_id();
$gsession   = $PHPSESSID;
$today		= date("Y/m/d");
$year		= date("Y");

// Development
$hostname_furniture = "localhost";
$database_furniture = "hinklema_furniture";
$username_furniture = "root";
$password_furniture = "harley77";

// Production
//$hostname_furniture = "localhost";
//$database_furniture = "hinklema_furniture";
//$username_furniture = "hinklema_bhinkle";
//$password_furniture = "052597";

$furniture = mysqli_connect($hostname_furniture, $username_furniture, $password_furniture) or trigger_error(mysql_error(),E_USER_ERROR);

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

 
?>