<?php 
require_once('Data/furniture.php');
$errormsg = "";
  
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



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // start the insert 
    if ($_POST["MM_insert"] == "form2") {	
    	$theemail=$_POST['email'];
    	$thephone=$_POST['phone'];
    	$pphone=preg_replace("/[^0-9]/", "", $thephone);
    	
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
}
?><!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link rel="icon" type="image/png" href="images/splash/android-chrome-192x192.png" sizes="192x192">
<link rel="apple-touch-icon" sizes="196x196" href="images/splash/apple-touch-icon-196x196.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/splash/apple-touch-icon-180x180.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/splash/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="144x144" href="images/splash/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/splash/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/splash/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/splash/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/splash/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="60x60" href="images/splash/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="57x57" href="images/splash/apple-touch-icon-57x57.png">  
<link rel="icon" type="image/png" href="images/splash/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="images/splash/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="images/splash/favicon-16x16.png" sizes="16x16">
<link rel="shortcut icon" href="images/splash/favicon.ico" type="image/x-icon" /> 
    
<title>Community Furnishings Alerts</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

<link href="styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="styles/animate.css"         rel="stylesheet" type="text/css">
<link href="styles/overrides.css"       rel="stylesheet" type="text/css">
<link href="styles/hamburgers.css"      rel="stylesheet" type="text/css">

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jqueryui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</head>

<body> 
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-header text-center">
            <a class="header-logo" href="#"><img src="http://www.myfurniturewishlist.com/images/my_furniture_wishlist_logo.png" class="img-fluid" /></a>
            <h1 style="padding-bottom: 15px;">My Furniture Wishlist</h1>
            <p>Create a Profile</p>
            <?php if($errormsg) {
                echo "<p class='errormsg'>".$errormsg."</p>";
            }
            ?>
        </div>
    </div>
    <form action="register.php" method="post" id="registerform" name="form2">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control requiredField requiredEmailField" placeholder="Your Name Please">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <input type="text" name="phone" id="phone" class="form-control requiredField requiredEmailField" placeholder="Enter Your Cell Number as (555) 333-7890" />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group" style="margin-bottom: 0px;">
                <select name="phone_carrier" class="form-control requiredField requiredEmailField">
                    <option value="0">Select Carrier</option>
                    <option value="@mms.att.net" class="select-title">ATT</option>
                    <option value="@vtext.com">Verizon</option>
                    <option value="@pm.sprint.com">Sprint</option>
                    <option value="@myboostmobile.com">Boost</option>
                    <option value="@sms.mycricket.com">Cricket</option>
                    <option value="@vmobl.com">Virgin Mobile</option>
                    <option value="@txt.att.net">ATT</option>
                    <option value="@tmomail.net">T Mobile</option>
                    <option value="@message.alltel.com">AllTel</option>
                </select>
            </div>
            <div class="text-center">
                    <span class="small">(may not work with all phone carriers)</span>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group" style="margin-bottom: 0px;">
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email Address (optional)">
            </div>  
            <div class="text-center">
                    <span class="small">We do not share, post or sell your information <img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/2.2.1/svg/1f642.svg"></span>
            </div>
        </div>
        <div class="col-sm-12 hidden-xs-up">
            <div class="form-group">
                <input type="password" value="Password" name="password" id="password" class="form-control">
            </div>
        </div>
        <div class="col-sm-12">
        <p></p>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <input class="btn-block btn-main btn" type="submit" value="Register">
            </div>
             Or, <a href="login.php">back to login</a>.

            <input type="hidden" value="<?php echo $today ?>" name="date" id="date" >
            <input type="hidden" name="MM_insert" value="form2" id="MM_insert">
        </div>
    </div>
    </form>
</div>


    
</body>






























