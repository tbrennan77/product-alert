<?php
require_once('Data/furniture.php');

@ini_set('display_errors', 1);
@ini_set('track_errors', 0);
error_reporting(-1);

$ptype       = (isset($_POST['type']) ? $_POST['type'] : null);
$gettype     = (isset($_GET['type']) ? $_GET['type'] : null);
$requesttype = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

echo("Request type:".$requesttype);

  if($requesttype==1) {
	
    try {

      $thesession = (isset($_GET['sessionid']) ? $_GET['sessionid'] : null);
      $theuserid  = $_GET['userid'];
      $thecatid   = $_GET['catid'];
      $thetalert  = $_GET['talert'];

      echo($theuserid);

      mysqli_select_db($furniture, $database_furniture);

      $insertSQL = "CALL insertalerts($theuserid,$thecatid,$thetalert)"; 
      $Result1 = mysqli_query($furniture, $insertSQL) or die(mysql_error()); 

    } catch (Exception $e) {
      echo($e->getMessage());
    }

  }   
  
   if($gettype==2){
      $theoderid =  $_GET['orderid'];
      $theqty =  $_GET['qty'];
      $theoldprice =  $_GET['price'];
      $theship1=$_GET['ship'];
      $thecomments=htmlspecialchars($_GET['comments']);
      $tcardslit=$_GET['cardslit'];
      $tminilock=$_GET['minilock'];
      $tmakelock=$_GET['makelock'];

      mysql_select_db($database_mini, $mini);

      if($theqty == 0){
        $insertSQL = "delete from oders  where oderid = $theoderid";
      } else {

      // see if the invoice_id from shipping_invoice is not null, then update the record
      $insertSQL = "update oders set qty='$theqty', price='$theoldprice',  shipping='$theship1', comments='$thecomments', cardslit='$tcardslit', minilock='$tminilock', makelock='$tmakelock' where oderid = $theoderid";
      }

      $Result1 = mysql_query($insertSQL, $mini) or die(mysql_error());   
    }


 if($requesttype==3){
	 	 
 $thefname =  $_REQUEST['fname'];
 $thelname =  $_REQUEST['lname'];
 $theemail =  $_REQUEST['email'];
 $thephone=$_REQUEST['phone'];
 $theaddress=$_REQUEST['address'];
 $thecity=$_REQUEST['city'];
 $thestate=$_REQUEST['state'];
 $thezip=$_REQUEST['zip'];
 $thecomments=htmlspecialchars($_REQUEST['comments']);
 $thesession=$_REQUEST['sessionid'];

// insert customer information
 mysql_select_db($database_mini, $mini);
$insertSQL = "insert into customers (fname, lname, email, bill_address, bill_city, bill_state, phone,ship_address, ship_city, ship_state,ship_zip, bill_zip, sessionid ) values ('$thefname', '$thelname','$theemail','$theaddress','$thecity','$thestate','$thephone','$theaddress','$thestate','$thecity','$thezip','$thezip', '$thesession')";
$Result1 = mysql_query($insertSQL, $mini) or die(mysql_error());  

// get the customerid
 mysql_select_db($database_mini, $mini);
/*$customerid = "Call updatecustomer ('$thesession')";
$query_customerid = "select customerid from customers where sessionid='$thesession'";
$customerid = mysql_query($query_customerid, $mini) or die(mysql_error());  
$row_customerid = mysql_fetch_assoc($customerid);
$thecustid=$rows_customerid['customerid']; 

mysql_select_db($database_mini, $mini);
$query_customerid1 = "update oders set cust_id=$thecustid where sessionid='$thesession'";
$Result2 = mysql_query($query_customerid1, $mini) or die(mysql_error());  */

mysql_select_db($database_mini, $mini);
$query_showtotal = sprintf("select customerid from customers where sessionid='$thesession'");
$showtotal = mysql_query($query_showtotal, $mini) or die(mysql_error());
$row_showtotal= mysql_fetch_assoc($showtotal);
$custeromid=$row_showtotal['customerid'];

mysql_select_db($database_mini, $mini);
$query_showtotal1 = sprintf("update oders set cust_id=$custeromid where sessionid='$thesession'");
$showtotal1 = mysql_query($query_showtotal1, $mini) or die(mysql_error());
$row_showtotal1= mysql_fetch_assoc($showtotal1);


// email the invoice
mysql_select_db($database_mini, $mini);
$query_showrows2 = "SELECT oders.prodid, oders.oderid, oders.cardslit, oders.minilock, oders.makelock, products.prod_shipping, oders.qty, oders.price, products.prod_name, products.prod_desc, oders.order_date, oders.shipping, oders.cust_id, customers.fname, customers.lname, customers.bill_address, customers.bill_state, customers.bill_zip, customers.bill_city, customers.phone, customers.email FROM oders inner join products on oders.prodid=products.productid inner join customers on customers.customerid=oders.cust_id where oders.sessionid='$thesession'";
$showrows2 = mysql_query($query_showrows2, $mini) or die(mysql_error());
$row_showrows2 = mysql_fetch_assoc($showrows2);



         $tprice= $row_showrows2['price'];
		 $tqty= $row_showrows2['qty'];
		 $tcardslip=$row_showrows2['cardslit'];
		 $tminilock=$row_showrows2['minilock'];
		 $tmakelock=$row_showrows2['makelock'];
		 $tshipping=$row_showrows2['prod_shipping'];
		 $tprice1=$tprice*$tqty;
		 $tprice2=$tcardslip+$tmakelock+$tminilock;
		 $tprice4=$tqty*$tprice2;
		 $tprice3=$tshipping*$tqty;
		 $finalprice=$tprice1+$tprice4+$tprice3;
		 
		 $fname=$row_showrows2['fname'];
$lname=$row_showrows2['lname'];
$address=$row_showrows2['bill_address'];
$city=$row_showrows2['bill_city'];
$state=$row_showrows2['bill_state'];
$zip=$row_showrows2['bill_zip'];
$emails=$row_showrows2['email'];       
$userphone=$row_showrows2['phone'];
$orderid = $row_showrows2['oderid'];

   // send the email       
  $HTML         = "<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>Country Barn Babe</title>
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
<table width=\"579\" height=\"394\" border=\"0\" align=\"center\">
  <tr>
    <td><div align=\"center\">Thank you for your order! Please allow 3 weeks for your order to ship. As soon as your order is shipped, we will email you tracking info! Feel free to email us at info@countrybarnbabe.com if you have any questions or if you need an order sooner. </div></td>
  </tr>
  <tr>
    <td height=\"49\"><div align=\"center\" class=\"style1\">Country Barn Babe Invoice #".$orderid."</div></td>
  </tr>
  <tr>
    <td bgcolor=\"#000000\"><span class=\"style7\">Billing Info</span> </td>
  </tr>
  <tr>
    <td height=\"100\" valign=\"top\"><table width=\"572\" border=\"0\">

      <tr>
        <td width=\"114\">Name:</td>
        <td width=\"448\">".$fname." ".$lname."</td>
      </tr>
      <tr>
        <td>Address:</td>
        <td>".$address."</td>
      </tr>
      <tr>
        <td>City, State Zip:</td>
        <td>".$city.", ".$state." ".$zip."</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>".$emails."</td>
      </tr>
	   <tr>
        <td>Phone:</td>
        <td>".$userphone."</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor=\"#000000\"><span class=\"style7\">Shipping Info</span></td>
  </tr>
  <tr>
    <td><table width=\"572\" border=\"0\">
      <tr>
        <td width=\"114\">Ship to Name:</td>
        <td width=\"448\">".$fname."</td>
      </tr>
      <tr>
        <td>Address:</td>
        <td>".$address."</td>
      </tr>
      <tr>
        <td>City,State Zip:</td>
        <td>".$city.", ".$state." ".$zip."</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td bgcolor=\"#000000\"><span class=\"style7\">Order Info</span></td>
  </tr>
  <tr>
    <td><table width=\"570\" border=\"0\">
      <tr>
        <td width=\"118\" bgcolor=\"#EBEBEB\"><div align=\"center\"><strong> </strong></div></td>
        <td width=\"277\" bgcolor=\"#EBEBEB\"><div align=\"center\"><strong>Item Description </strong></div></td>
        <td width=\"75\" bgcolor=\"#EBEBEB\"><div align=\"center\"><strong>$ Qty </strong></div></td>
        <td width=\"82\" bgcolor=\"#EBEBEB\"><div align=\"center\"><strong>$ Price</strong></div></td>
      </tr>
	   
     
	  ";
	  $z=0;
	   do { 
	   $z++; 
	   $HTML .="
      <tr>
        <td><div align=\"center\">".$z."</div></td>
        <td><div align=\"center\">".$row_showrows2['prod_name']."</div></td>
         <td><div align=\"center\">".$row_showrows2['qty']."</div></td>
       <td><div align=\"center\">".$row_showrows2['price']."</div></td>
        </div></td>
		 ";
		
		 } while ($row_showrows2 = mysql_fetch_assoc($showrows2));
		 
		  
		 $HTLM .="
		
        <td><div align=\"center\">
          <div align=\"center\"></div>
        </div></td>
		
      </tr>
	  <tr>
	 <td><div align=\"center\">Total Price: </div></td>
        <td><div align=\"center\">".$tprice ."</div></td>
         <td><div align=\"center\"></div></td>
       <td><div align=\"center\"></div></td>
        </div></td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align=\"center\">
      <p><strong>Thank you For your Business! </strong></p>
      
      </div></td>
  </tr>
</table>
</body>
</html>
"; 
$from         = "orders@countrybarnbabe.com";
$to           = "nmiller2288@yahoo.com, bryan@hinklemarine.com";
$subject     = "Your Order from Country Barn Babe";

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
sendHTMLemail($HTML,$from,$to,$subject);

// end send email		  



  }
?>
