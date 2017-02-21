<?php
    $host = "localhost";
    $username = "hinklema_bhinkle";
    $password = "052597";
    $dbname = "hinklema_furniture";
	$conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8");
   // $conn = mysqli_connect($host, $username, $password, $dbname) or die('Error in Connecting: ' . mysqli_error($conn));
	$myvariable=1;
	   // send mail code  
$stmt = $conn->prepare('select p.prod_link, p.prod_image, p.price, p.title, a.email_alert, a.text_alert, c.email, c.phone, c.phone_carrier from 
`new_products` p  left join 
`alerts` a on a.cat_id=p.cat_id  join `clients` c on c.clientid=a.cust_id where p.isactive = ?');
$stmt->bind_param('s', $myvariable);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
//$mysqli->close();

//$productinsert="select p.prod_link, p.prod_image, p.price, p.title, a.email_alert, a.text_alert, c.email, c.phone, c.phone_carrier from 
//`new_products` p  left join 
//`alerts` a on a.cat_id=p.cat_id  join `clients` c on c.clientid=a.cust_id where p.isactive=1;";
//$result = mysqli_query($conn,$productinsert);

 while($row = mysqli_fetch_array($result))
      {
		  $temailalert=$row['email_alert'];
		  $ttextalert=$row['text_alert'];
		  $temail=$row['email'];
		  $tphone=$row['phone'];
		  $tphonecarrier=$row['phone_carrier'];
		  $ttitle=$row['title'];
		  //$tlink3=preg_replace("/[^a-zA-Z]/", " ", $ttitle);
		  $tlink=$row['prod_link'];
		  $tprice=$row['price'];
		  $timage=$row['prod_image'];
		  $tlink1=str_replace(" ", "-", $ttitle);
		   $tlink4=str_replace(".", "", $tlink1);
		    $tlink4=str_replace("/", "-", $tlink1);
		  
		  $tlink2=$tlink.''.$tlink4;
		  
             // send the email       
  $HTML = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<title>Community Furnishings</title>
</head>

<body>
<table width=\"501\" border=\"0\" align=\"center\">
  <tr>
    <td colspan=\"4\" align=\"center\" bgcolor=\"#CCCCCC\"><strong>Community Furnishings</strong></td>
  </tr>
  <tr>
    <td colspan=\"4\">Your Alert for ".$ttitle." has been triggered. Use the link to view your ".$ttitle.".</td>
  </tr> 
   <tr>
    <td width=\"98\"><img name=\"\" src=\"".$timage."\" width=\"153\" height=\"104\" alt=\"\" /></td>
    <td width=\"125\">".$ttitle."</td>
    <td width=\"125\">Price: $".$tprice."</td>
    <td width=\"135\"><a href=\"".$tlink2."\">Click Here</a></td>
  </tr>  
</table>
<h1>&nbsp;</h1>
</body>
</html> ";

$textmessage ="Click on the link to view the image.\n";
$textmessage .="".$timage."\n";
$textmessage .="Click on the link to view the product.\n";
$textmessage .="".$tlink2."\n";
	  
$from   = "alerts@atlanta-web-development.com";
$subject     = "Your ".$ttitle."Alert From Community Furnishings";


// First we have to build our email headers
// Set out "from" address

   $random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n
//$headers  = 'MIME-Version: 1.0' . "\r\n";
//$headers .= "From: alerts@hinklemarine.com";
//add boundary string and mime type specification
//$headers .= "\r\nContent-Type: text/html; boundary=\"PHP-alt-".$random_hash."\""; 

// And then send the email ....
echo $HTML."\n";
//echo $textmessage;

     if($temailalert==1){
	$to           = "".$temail."";

	
	$headers = "From: alerts@atlanta-web-development.com";
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: text/html; boundary=\"PHP-alt-".$random_hash."\""; 

   mail($to,$subject,$HTML,$headers);
     }
    if($ttextalert==1){
	$to = "".$tphone."".$tphonecarrier."";
	echo $to;

	$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= "From: alerts@atlanta-web-development.com";
	
   mail($to,$subject,$textmessage,$headers);
          }
	 
	  }
	  
	  	$newproductupdate="update `new_products` set isactive=0 where isactive=1; ";
	if (mysqli_query($conn, $newproductupdate)) {
     //error_log('New record created successfully');
} else {
    error_log('Error updating products inactive into table : '. mysqli_error($conn));
}

 mysqli_close($conn);
?>