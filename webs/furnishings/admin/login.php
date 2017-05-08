<?php 
require_once('Data/furniture.php');
// *** Validate request to login to this site.
$theemail=$_POST['input-email'];
if($theemail!=''){
mysql_select_db($database_furniture, $furniture);
 $query_customer = sprintf("
SELECT phone , email
  FROM clients where email='$theemail' limit 1
");
$customer = mysql_query($query_customer, $furniture) or die(mysql_error());
$row_customer = mysql_fetch_assoc($customer);
$showpass=$row_customer['phone'];
$showuser=$row_customer['email'];


if($showpass!=''){
$HTMLs         = "Your Username: $showuser & Password: $showpass. Please log into the website using this password";
$to           = "$theemail";
$subject     = "Your Password Request";

//echo $to;

 mail($to,$subject,$HTMLs);
}
}

// see how many times this guy is going to try to login
if (!isset($_SESSION)) {
  session_start();
}



$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = htmlentities($_GET['accesscheck']);
}

if (isset($_POST['username'])) {
  $loginUsername=htmlentities($_POST['username']);
  $password=htmlentities($_POST['password']);
  $getthetries=htmlentities($_POST['tries']);
  
  if($getthetries==""){
 $attempts = "0";
}
if($getthetries=="0"){
 $attempts = "1";
}
if($getthetries=="1"){
 $attempts = "2";
}
if($getthetries=="2"){
 $attempts = "3";
}
if($getthetries=="3"){
  $attempts ="4";
$error="you have exceeded the max number of times to login.  Please click the forgot password link and we will send you the password.";
}

if($attempts!="4"){

  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = $MM_redirectLoginFailed1;
  $MM_redirecttoReferrer = false;
mysql_select_db($database_furniture, $furniture);
  
  $LoginRS__query=sprintf("SELECT username, password FROM `administrators` WHERE username='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $furniture) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  
 }
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link rel="icon" type="../image/png" href="../images/splash/android-chrome-192x192.png" sizes="192x192">
<link rel="apple-touch-icon" sizes="196x196" href="../images/splash/apple-touch-icon-196x196.png">
<link rel="apple-touch-icon" sizes="180x180" href="../images/splash/apple-touch-icon-180x180.png">
<link rel="apple-touch-icon" sizes="152x152" href="../images/splash/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="144x144" href="../images/splash/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="120x120" href="../images/splash/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="114x114" href="../images/splash/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="76x76" href="../images/splash/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="72x72" href="../images/splash/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="60x60" href="../images/splash/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="57x57" href="../images/splash/apple-touch-icon-57x57.png">  
<link rel="icon" type="../image/png" href="../images/splash/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="../image/png" href="../images/splash/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="../image/png" href="../images/splash/favicon-16x16.png" sizes="16x16">
<link rel="shortcut icon" href="../images/splash/favicon.ico" type="image/x-icon" /> 
    
<title>MyFurnitureWishlist | Admin</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

<link href="../styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="../styles/animate.css"         rel="stylesheet" type="text/css">
<link href="../styles/overrides.css"       rel="stylesheet" type="text/css">
<link href="../styles/hamburgers.css"      rel="stylesheet" type="text/css">

<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/jqueryui.js"></script>
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="../scripts/stickyfill.js" type="text/javascript"></script>
<script type="text/javascript" src="../scripts/custom1.js"></script>
</head>

<body> 
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-header text-center">
            <a class="header-logo" href="#"><img src="http://www.myfurniturewishlist.com/images/my_furniture_wishlist_logo.png" class="img-fluid" /></a>
            <h1 style="padding-bottom: 15px;">My Furniture Wishlist</h1>
            <p></p>
        </div>
        <div class="col-sm-12 text-center" style="display: none;">
            <div class="fb-login social-login">
               <a data-analytics_details="facebook" data-analytics_event="Sign Up" data-analytics_location="sign up page" href="<?php echo $loginURL; ?>">
                    <div class="ml-icon ml-facebook-login"></div>
                </a>
            </div>
        </div>
        <div class="col-sm-12">
          <form id="loginform" class="form-vertical no-padding no-margin" action="<?php echo $loginFormAction; ?>" name="loginform" method="post">

                            
                            <div class="form-group">
                                <input class="form-control" id="username" name="username" type="text" placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" id="password" name="password" value="Password" placeholder="Password" />
                            </div>

                        <input name="fname" type="hidden" id="fname">
                        <input name="lname" type="hidden" id="lname">
                        <input name="uid" type="hidden" id="uid">
                        <input name="token" type="hidden" id="token">
                        <input name="tries" type="hidden" id="tries" value="<?php $attempts ?>">
                         <br>
                         <a href="#" onClick="javascript: document.loginform.submit();" class="pageapp-signup-button button button-small button-green button-fullscreen">ADMIN LOG IN</a>

                        <input class="btn-block btn-main btn" type="submit" value=" Admin Log In">

                    </form>
        </div>
    </div>
</div>

</body>
















































