<?php require_once('Data/furniture.php');
/*SELECT a . * , b . * 
FROM  `oders` a
INNER JOIN  `products` b ON a.prodid = b.productid WHERE a.sessionid='$getsession'
*/
mysql_select_db($database_furniture, $furniture);
$query_showberrys = "SELECT prod.*,cat.*,alert.*,cust.* FROM
 `new_products` prod 
 inner join `categories` cat on prod.cat_id=cat.cat_id inner join `alerts` alert on alert.cat_id=cat.cat_id inner join 
 `clients` cust on cust.clientid=alert.cust_id 
 WHERE prod.isactive=1";
$showberrys = mysql_query($query_showberrys, $furniture) or die(mysql_error());
$row_showberrys = mysql_fetch_assoc($showberrys);
$totalRows_showberrys = mysql_num_rows($showberrys);


function sendHTMLemail($HTML,$from,$to,$subject)
{
// First we have to build our email headers
// Set out "from" address

    $headers = "From: $from\r\n"; 

// Now we specify our MIME version

    $headers .= "MIME-Version: 1.0\r\n"; 

// Create a boundary so we know where to look for
// the start of the data

    $boundary = uniqid("HTMLEMAIL"); 
    
// First we be nice and send a non-html version of our email
    
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 

    $headers .= "This is a MIME encoded message.\r\n\r\n"; 

    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
                
    $headers .= chunk_split(base64_encode(strip_tags($HTML))); 

// Now we attach the HTML version

    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=ISO-8859-1\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n"; 
                
    $headers .= chunk_split(base64_encode($HTML)); 

// And then send the email ....

    mail($to,$subject,"",$headers);
    
}
?>

  <? do{
		 $cat=$row_showberrys['product_id'];
			 if($cat!=''){
																
                        
$themail= $row_showberrys['email'];
$thelink= $row_showberrys['prod_link'];
$theimage= $row_showberrys['prod_image'];
$theprice= $row_showberrys['price'];
$thephone= $row_showberrys['phone'];
$thecat_name= $row_showberrys['cat_name'];
$thephonecar= $row_showberrys['phone_carrier'];
$thephonestring=$thephone.$thephonecar;

$from         = "alerts@hinklemarine.com";
$to           = $themail.','.$thephonestring;
$subject     = "Your Order $thecat_name Has Arrived";

/*
mail("{$themail}", "New {$thecat_name} just arrived", "Click here : {$thelink} \n  ", "from: info@hinklemarine.com"); 
echo $themail;          
   */
   $HTML         = "<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>Untitled Document</title>
<style type=\"text/css\">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style6 {font-family: \"Times New Roman\", Times, serif}
.style7 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
   <table width=\"327\" border=\"0\" bgcolor=\"#CCCCCC\">
  <tr>
    <td colspan=\"3\"><div align=\"center\"><strong>Your New $thecat_name Has Arrived!</strong></div></td>
  </tr>
  <tr>
    <td width=\"81\">&nbsp;</td>
    <td width=\"125\">&nbsp;</td>
    <td width=\"107\">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img name=\"product\" src=\"$theimage\" width=\"79\" height=\"81\" alt=\"\"></td>
    <td><a href=\"$thelink\">Click Here</a></td>
    <td>$ $theprice</td>
  </tr>
</table>                             
      </body>
</html>
";

sendHTMLemail($HTML,$from,$to,$subject);
                          
     } }  while ($row_showberrys = mysql_fetch_assoc($showberrys));
								?>

 
