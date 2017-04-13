<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
ob_start();
session_start();
$PHPSESSID=session_id();
$gsession=$PHPSESSID;
$today= date("Y/m/d");
$year=date("Y");
// Lets make sure this is only accessed from the current host
$Host = $_SERVER['HTTP_HOST'] . '/';
//$Host1 = "http://www.hinklemarine.com" . '/';

//$DB_Hostname = "atlanta-web-development.com"; 
//$DB_Hostname1 = "hinklemarine.com"; 

//$IsItGood = explode($DB_Hostname,$Host);
//$IsItGood1 = explode($DB_Hostname1,$Host1);

//if(($IsItGood[1] <> '/'))  { 
//	exit;
//

//-------------------------------------------------------------------------------------------------
// Lets turn on hacker/spam control
// Set words & Error Text
$Words_Vulgar = "dick,pussy,sex,cock,cunt,fuck,suck";
$Words_Spam = "viagria,cialis,prescription,viagra";
$Words_DBHack = "select *,select,delete from,update,drop table,create table,truncate,alter table, http";
$Words_Submitted = strtolower(print_r($_REQUEST,true));

// Lets search for VULGAR words and create errors
$Array_Vulgar = explode(",",$Words_Vulgar);
$Current_Vulgar = 0;
while (count($Array_Vulgar) > $Current_Vulgar) {
	$Check_1 = explode(" " . $Array_Vulgar[$Current_Vulgar],$Words_Submitted);
	$Check_2 = explode($Array_Vulgar[$Current_Vulgar] . " ",$Words_Submitted);
	$Check_3 = explode($Array_Vulgar[$Current_Vulgar] . ".",$Words_Submitted);
	$Check_4 = explode($Array_Vulgar[$Current_Vulgar] . ",",$Words_Submitted);
	$Check_5 = explode($Array_Vulgar[$Current_Vulgar] . ";",$Words_Submitted);
	$Check_6 = explode($Array_Vulgar[$Current_Vulgar] . ":",$Words_Submitted);
	$Check_7 = explode($Array_Vulgar[$Current_Vulgar] . "'",$Words_Submitted);
	$Check_8 = explode($Array_Vulgar[$Current_Vulgar] . '"',$Words_Submitted);
	$Check_Count = count($Check_1) + count($Check_2) + count($Check_3) + count($Check_4) + count($Check_5) +  count($Check_6) + count($Check_7) + count($Check_8);
	
	if($Check_Count > 8) {
		$Vulgar_Found.= $Array_Vulgar[$Current_Vulgar] . ","; }
	$Current_Vulgar += 1; }

// Lets search for SPAM words and create errors
$Array_Spam = explode(",",$Words_Spam);
$Current_Spam= 0;
while (count($Array_Spam) > $Current_Spam) {
	$Check_1 = explode(" " . $Array_Spam[$Current_Spam],$Words_Submitted);
	$Check_2 = explode($Array_Spam[$Current_Spam] . " ",$Words_Submitted);
	$Check_3 = explode($Array_Spam[$Current_Spam] . ".",$Words_Submitted);
	$Check_4 = explode($Array_Spam[$Current_Spam] . ",",$Words_Submitted);
	$Check_5 = explode($Array_Spam[$Current_Spam] . ";",$Words_Submitted);
	$Check_6 = explode($Array_Spam[$Current_Spam] . ":",$Words_Submitted);
	$Check_7 = explode($Array_Spam[$Current_Spam] . "'",$Words_Submitted);
	$Check_8 = explode($Array_Spam[$Current_Spam] . '"',$Words_Submitted);
	$Check_Count = count($Check_1) + count($Check_2) + count($Check_3) + count($Check_4) + count($Check_5) +  count($Check_6) + count($Check_7) + count($Check_8);
	
	if($Check_Count > 8) {
		$Spam_Found.= $Array_Spam[$Current_Spam] . ","; }
	$Current_Spam += 1; }

// Lets search for HACKING  words and create errors
$Array_DBHack = explode(",",$Words_DBHack);
$Current_DBHack = 0;
while (count($Array_DBHack) > $Current_DBHack) {
	$Check_1 = explode(" " . $Array_DBHack[$Current_DBHack],$Words_Submitted);
	$Check_2 = explode($Array_DBHack[$Current_DBHack] . " ",$Words_Submitted);
	$Check_3 = explode($Array_DBHack[$Current_DBHack] . ".",$Words_Submitted);
	$Check_4 = explode($Array_DBHack[$Current_DBHack] . ",",$Words_Submitted);
	$Check_5 = explode($Array_DBHack[$Current_DBHack] . ";",$Words_Submitted);
	$Check_6 = explode($Array_DBHack[$Current_DBHack] . ":",$Words_Submitted);
	$Check_7 = explode($Array_DBHack[$Current_DBHack] . "'",$Words_Submitted);
	$Check_8 = explode($Array_DBHack[$Current_DBHack] . '"',$Words_Submitted);
	$Check_Count = count($Check_1) + count($Check_2) + count($Check_3) + count($Check_4) + count($Check_5) +  count($Check_6) + count($Check_7) + count($Check_8);
	
	if($Check_Count > 8) {
		$DBHack_Found.= $Array_DBHack[$Current_DBHack] . ","; }
	$Current_DBHack+= 1; }

// Lets display errors and stop the page from loading
if($Vulgar_Found <> "") {
	header('Location: index.php?showme=Error&Type=Vulgar&Request=');
	exit();
} elseif($Spam_Found <> "") {
	header('Location: index.php?showme=Error&Type=Spam&Request=');
	exit();
} 
/*
elseif($DBHack_Found <> "") {
	header('Location: index.php?showme=Error&Type=Hack');
	exit(); 
	}
	*/

//-------------------------------------------------------------------------------------------------
// Just a little bragging for ourselves

//-------------------------------------------------------------------------------------------------


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

//echo ("<meta http-equiv=\"Page-Enter\" content=\"blendTrans(Duration=1.0)\">");
//echo ("<meta http-equiv=\"Page-Exit\" content=\"blendTrans(Duration=1.0)\">");
//echo ("<meta http-equiv=\"Site-Enter\" content=\"blendTrans(Duration=1.0)\">");
//echo ("<meta http-equiv=\"Site-Exit\" content=\"blendTrans(Duration=1.0)\">");

?>