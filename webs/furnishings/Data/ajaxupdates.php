<?php


  require_once('mini.php');
  
 
 $gettype=$_GET['type'];
 $requesttype=$_REQUEST['type'];
 		
		 if($gettype==1){
	  
$thesession=$_GET['sessionid'];
$theprodid=$_GET['prodid'];
$theqty=$_GET['qty'];
 
  mysql_select_db($database_mini, $mini);
  if($theqty==0){
  $insertSQL = "delete from oders where prodid=$theprodid and sessionid='$thesession'"; 
  $themessage="Product Has Been Deleted";
  } else {
  $insertSQL = "update oders set qty=$theqty where prodid=$theprodid and sessionid='$thesession'"; 	  
   $themessage="Product Qty Has Been Updated";
  }
  $Result1 = mysql_query($insertSQL, $mini) or die(mysql_error()); 
  }   
	echo $themessage;
?>

