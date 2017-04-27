<?php
require_once('Data/furniture.php');
$ptype=$_POST['type'];
 $gettype=$_GET['type'];
 $requesttype=$_REQUEST['type'];
 		
		 if($requesttype==1){
	  
$thesession=$_GET['sessionid'];
$theuserid=$_GET['userid'];
$thecatid=$_GET['catid'];
$thetalert=$_GET['talert'];



  mysql_select_db($database_furniture, $furniture);
  $insertSQL = "CALL insertalerts($theuserid,$thecatid,$thetalert)"; 
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error()); 
  }   
  
  


 if($requesttype==2){
	  
$thecat_id=$_GET['catid'];
$thecat_name=$_GET['name'];
$thecat_extra=$_GET['extra'];
$thetalert=$_GET['talert'];


  if($thetalert==1){
  mysql_select_db($database_furniture, $furniture);
  $insertSQL = "update categories set cat_name='$thecat_name', cat_extra='$thecat_extra' where cat_id=$thecat_id"; 
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error()); 
  } else {
	   mysql_select_db($database_furniture, $furniture);
  $insertSQL = "Delete from categories  where cat_id=$thecat_id limit 1"; 
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error()); 
  }   
 }
  


 
?>
