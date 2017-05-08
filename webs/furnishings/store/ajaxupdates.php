<?php
require_once('Data/furniture.php');

@ini_set('display_errors', 1);
@ini_set('track_errors', 0);
error_reporting(-1);


$ptype       = (isset($_POST['type']) ? $_POST['type'] : null);
$gettype     = (isset($_GET['type']) ? $_GET['type'] : null);
$requesttype = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

// Request 1 is add a new category
if($requesttype==1) {
  
    try {

      $thesession = (isset($_GET['sessionid']) ? $_GET['sessionid'] : null);
      $theuserid  = $_GET['userid'];
      $thecatid   = $_GET['catid'];
      $thetalert  = $_GET['talert'];

      mysqli_select_db($furniture, $database_furniture);

      $insertSQL = "CALL insertalerts($theuserid,$thecatid,$thetalert)"; 
      $Result1 = mysqli_query($furniture, $insertSQL) or die(mysql_error()); 

    } catch (Exception $e) {
      echo($e->getMessage());
    }

}   

// Request 2 is register a new user
if($requesttype == 2){ 

  // grab our response variables
  $name          =  $_REQUEST['name'];
  $phone         =  $_REQUEST['phone'];
  $phone         =  preg_replace("/[^0-9]/", "", $phone);
  $phone_carrier =  $_REQUEST['phone_carrier'];
  $email         =  $_REQUEST['email'];
  $password      =  $_REQUEST['password'];
  $selections    =  $_REQUEST['selections'];

  try {
    // initialize our database connect
    mysqli_select_db($furniture, $database_furniture);

    // phone number is our unique username so check that it's not already in use
    $query_Recordset1 = "select IFNULL(clientid,0) as clientid from `clients` where username='$phone' ";
    $Recordset1 = mysqli_query($furniture, $query_Recordset1) or die(mysql_error());

    $row_Recordset1       = $Recordset1->fetch_assoc();
    $totalRows_Recordset1 = $Recordset1->num_rows;
        
    //  get the clientid (clientid = username = phone)
    $theclientid=$row_Recordset1['clientid'];
    
    // also make sure that email is unique
    $query_Recordset2 = "select email as clientemail from `clients` where email='$email' ";
    $Recordset2 = mysqli_query($furniture, $query_Recordset2) or die(mysql_error());

    $row_Recordset2       = $Recordset2->fetch_assoc();
    $totalRows_Recordset2 = $Recordset2->num_rows;

    // clientid = username = phone
    $theclientemail=$row_Recordset2['clientemail'];

    if($theclientemail) {
      // response code of bad request (400)
      http_response_code(400);
      echo $theclientemail." is already in use. Please try another email.";
      exit;
    }
  } catch (Exception $e) {
        // response code of bad request (400)
        http_response_code(400);
        echo($e->getMessage());
  }

  // if no record exists, this is a new registration so create and insert the user (client) record
  if($totalRows_Recordset1 <= 0) { 
    try {
      $insertSQL = sprintf("INSERT INTO clients (username, password, fname, lname, email, phone, modified, created, changedate, phone_carrier) VALUES (%s, %s,%s, %s, %s, %s, %s, %s, %s, %s)",
              GetSQLValueString($phone, "text"),
              GetSQLValueString($email , "text"), //$_POST['password']
              GetSQLValueString("", "text"),
              GetSQLValueString("", "text"),
              GetSQLValueString($email , "text"),
              GetSQLValueString($phone, "text"),
              GetSQLValueString(date("Y-m-d H:i:s"), "date"),
              GetSQLValueString(date("Y-m-d H:i:s"), "date"),
              GetSQLValueString(date("Y-m-d H:i:s"), "date"),
              GetSQLValueString($phone_carrier, "text"));

              mysqli_select_db($furniture, $database_furniture);

              $result = mysqli_query($furniture, $insertSQL) or die(mysql_error());

              // phone number is our unique username so check that it's not already in use
              $query_Recordset2 = "select clientid from `clients` where username='$phone' ";
              $Recordset2 = mysqli_query($furniture, $query_Recordset2) or die(mysql_error());

              $row_Recordset2       = $Recordset2->fetch_assoc();
              $totalRows_Recordset21 = $Recordset2->num_rows;
                
              //  get the clientid (clientid = username = phone)
              $theclientid=$row_Recordset2['clientid'];

               // Set a 200 (okay) response code.
              http_response_code(200);
              //echo $phone." has been successfully registered";

              // Initiate their session variables
              $_SESSION['MM_Username']  = $phone;
              $_SESSION['MM_UserGroup'] = ""; 
              $_SESSION['MM_Email']     = $email;
              $_SESSION['MM_UserID']    = $theclientid;

              // If they had any selections lets add them real quick
              if($selections) {
                $selections = ltrim($selections, ",");
                $cats = explode(",", $selections);

                foreach($cats as $cat) {
                    $cat = trim($cat);
                    
                    mysqli_select_db($furniture, $database_furniture);

                    $insertSQL = "CALL insertalerts($theclientid,$cat,2)"; 

                    $Result1 = mysqli_query($furniture, $insertSQL) or die(mysql_error()); 
                }
              }


      } catch (Exception $e) {
        // response code of bad request (400)
        http_response_code(400);
        echo($e->getMessage());
      }
  } else {
      // response code of bad request (400)
      http_response_code(400);
      $errormsg = $phone." is already registered. Please try another phone or login instead.";
      echo $errormsg;
  }


}


// Request 3 is login
if($requesttype == 3){ 

  // grab our response variables
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $selections = $_REQUEST['selections'];

  echo $selections;

  // Check if we have a valid username
  mysqli_select_db($furniture, $database_furniture);

  $query_customer = sprintf("SELECT clientid, password , username, email FROM clients where username = '$username' limit 1");
  $customer       = mysqli_query($furniture, $query_customer) or die(mysql_error());
  $row_customer   = $customer->fetch_assoc();

  // Get Username and password and email
  $showpass     = $row_customer['password'];
  $showuser     = $row_customer['username'];
  $showemail    = $row_customer['email'];
  $showclientid = $row_customer['clientid'];

  // We have a valid username
  if($showuser){

    // Send them an email
    $HTMLs       = "Your Username: $showuser & Password: $showpass. Please log into the website using this password";
    $to          = "$username";
    $subject     = "Your Password Request";

    // mail($to,$subject,$HTMLs);

    // Initiate their session variables
    $_SESSION['MM_Username']  = $showuser;
    $_SESSION['MM_UserGroup'] = ""; 
    $_SESSION['MM_Email']     = $showemail;
    $_SESSION['MM_UserID']    = $showclientid;

    // If they had any selections lets add them real quick
    if($selections) {
      $selections = ltrim($selections, ",");
      $cats = explode(",", $selections);

      foreach($cats as $cat) {
          $cat = trim($cat);
          
          mysqli_select_db($furniture, $database_furniture);

          $insertSQL = "CALL insertalerts($showclientid,$cat,2)"; 

          $Result1 = mysqli_query($furniture, $insertSQL) or die(mysql_error()); 
      }
    }

    // Reply with a 200 (okay) response code.
    http_response_code(200);
    echo $username." has been successfully logged in.";
  } else {
    // response code of bad request (400)
    http_response_code(400);
    $errormsg = $username." was not found. Please try again.";
    echo $errormsg;
  }
}


// EOF>
?>