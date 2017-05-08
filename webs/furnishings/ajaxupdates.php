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

 $theaddress=$_REQUEST['address'];
 $thecity=$_REQUEST['city'];
 $thestate=$_REQUEST['state'];
 $thezip=$_REQUEST['zip'];
 $thecomments=htmlspecialchars($_REQUEST['comments']);
 $thesession=$_REQUEST['sessionid'];

 // start the insert 
 $theemail=$_REQUEST['email'];
 $thephone=$_REQUEST['phone'];
 $pphone=preg_replace("/[^0-9]/", "", $_REQUEST['phone']);
      
 mysqli_select_db($furniture, $database_furniture);

 $query_Recordset1 = "select IFNULL(clientid,0) as clientid from `clients` where username='$theemail' ";

 $Recordset1 = mysqli_query($furniture, $query_Recordset1) or die(mysql_error());

 $row_Recordset1       = $Recordset1->fetch_assoc();
 $totalRows_Recordset1 = $Recordset1->num_rows;
        
 $theclientid=$row_Recordset1['clientid'];

if($totalRows_Recordset1<=0) { 
  $insertSQL = sprintf("INSERT INTO clients (username,password,fname, lname, email, phone, modified, created, phone_carrier) VALUES (%s, %s,%s, %s, %s, %s, %s, %s, %s)",
      GetSQLValueString($_POST['email'], "text"),
      GetSQLValueString($pphone, "text"), //$_POST['password']
      GetSQLValueString("", "text"),
      GetSQLValueString("", "text"),
                         GetSQLValueString($_POST['email'], "text"),
                         GetSQLValueString($pphone, "text"),
                                   GetSQLValueString(date("Y-m-d H:i:s"), "date"),
                         GetSQLValueString(date("Y-m-d H:i:s"), "date"),
                         GetSQLValueString($_POST['phone_carrier'], "text"));
              mysqli_select_db($furniture, $database_furniture);

              $Result1 = mysqli_query($furniture, $insertSQL) or die(mysql_error());
              
              $insertGoTo ="login.php";

              header(sprintf("Location: %s", $insertGoTo));
         } else {
           $errormsg="That email address is already in use. Please try again or <a href='/login.php'>click here to login</a>.";
         }
    }

sendHTMLemail($HTML,$from,$to,$subject);

// end send email		  
}


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
