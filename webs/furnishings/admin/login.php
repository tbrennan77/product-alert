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
    
<title>CF ADMINISTRATION</title>

<link href="../styles/style.css"           rel="stylesheet" type="text/css">
<link href="../styles/menus.css"           rel="stylesheet" type="text/css">
<link href="../styles/framework.css"       rel="stylesheet" type="text/css">
<link href="../styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="../styles/animate.css"         rel="stylesheet" type="text/css">

<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/jqueryui.js"></script>
<script type="text/javascript" src="../scripts/framework-plugins.js"></script>
<script type="text/javascript" src="../scripts/custom.js"></script>
</head>

<body class="dual-sidebar"> 
    
<div id="preloader">
	<div id="status">
        <div class="preloader-logo"></div>
        <h3 class="center-text">Welcome</h3>
        <p class="center-text smaller-text">
            We're loading the content, give us a second. This won't take long!
        </p>
    </div>
</div>
    
<div id="header-fixed" class="header-light">
    <a class="header-icon-left open-left-sidebar" href="#"><i class="fa fa-navicon"></i></a>
    <a class="header-icon-two open-header-menu disabled" href="#"><i class="fa fa-angle-down"></i></a>
    <a class="header-logo" href="#"></a>
    <a class="header-icon-right open-right-sidebar" href="#"><i class="fa fa-envelope-o"></i></a>
    
    <div class="header-menu-overlay"></div>
    <div class="header-menu header-menu-light">
     
    </div> 
</div> 
    
        
<div id="footer-fixed" class="footer-menu footer-light disabled">
  
</div>
    
<div class="gallery-fix"></div> <!-- Important for all pages that have galleries or portfolios -->
            
<div class="all-elements">
    <div class="snap-drawers">
        <div class="snap-drawer snap-drawer-left sidebar-light-clean">        
            <div class="sidebar-header">
               
            </div>   
            
            <div class="sidebar-logo"></div>
            
            <div class="sidebar-divider no-bottom"></div>

            <p class="sidebar-divider">Navigation</p>
            <div class="sidebar-menu">
               
                    <a class="menu-item" href="index.php">
                        <i class="fa fa-home bg-red-dark"></i>
                        <em>Home</em>
                        <strong></strong>
                    </a> 
                   
                             
               
                    <a class="menu-item" href="editprofile.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Profile</em>
                        <strong></strong>
                    </a> 
                   
                   
               
                    <a class="menu-item" href="<?php echo $logoutAction ?>">
                        <i class="fa fa-navicon bg-green-dark"></i>
                        <em>Log Out</em>
                        <strong></strong>
                    </a> 
                                
              
                   
               
               
            </div>
                                  
           
                <a class="menu-item close-sidebar" href="#">
                    <i class="fa fa-times bg-red-dark"></i>
                    <em>Close</em>
                </a>
            </div>
            
            <p class="sidebar-footer">Copyright 2017. All rights reserved</p>
            
        </div>
        
        <!--Right Sidebar -->
        
        <!--Right Sidebar -->
        
        <div class="snap-drawer snap-drawer-right sidebar-light-clean">
            <div class="sidebar-header">
             
            </div>   
            
            <div class="sidebar-logo"></div>
                        
            <div class="sidebar-divider no-bottom"></div>
            
          
            
            <div class="sidebar-menu">
                <div class="has-submenu">
                
                    <div class="submenu change-colors">
                        <div>
                          
                        </div>  
                        <div>
                            
                        </div>
                        <div>
                          
                        </div>
                    </div>
                </div>
                <div class="has-submenu">
                   
                       
                    <div class="submenu change-colors">
                        <div>
                         
                        </div>
                    </div>
                </div>
            </div>
                        
            <p class="sidebar-divider"></p>
            
            <div class="sidebar-menu">
              
            </div>
                        
            <p class="sidebar-divider"></p>
            
            <div class="container no-bottom">
                <div class="sidebar-form contact-form no-bottom"> 
                  
                    <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                      
                    </div>
                  
                </div>
            </div>
            
            <p class="sidebar-divider">Contact Us</p>
            
            <div class="sidebar-menu">
              
            </div>
            
            <p class="sidebar-footer">Copyright <?php echo $year ?>. All rights reserved</p>
        </div>        
        
        <div id="content" class="snap-content">      
            <div class="header-clear"></div>
            <div class="pageapp-login bg-5 cover-screen">    
                <div class="pageapp-login-content cover-center">
                  <div class="boxed-layout">
                        <a class="pageapp-login-logo" href="#"></a>
                        <form id="loginform" class="form-vertical no-padding no-margin" action="<?php echo $loginFormAction; ?>" name="loginform" method="post">
                        <div class="pageapp-login-field">
                            <i class="fa fa-user"></i>
                            <input type="text" value="UserName" id="username" name="username" onfocus="if (this.value=='UserName') this.value = ''" onblur="if (this.value=='') this.value = 'UserName'">
                        </div>
                        <div class="pageapp-login-field">
                            <i class="fa fa-mobile"></i>
                            <input type="password" id="password" name="password" value="Password" onfocus="if (this.value=='Password') this.value = ''" onblur="if (this.value=='') this.value = 'Password'">
                        </div>
                          <div class="pageapp-login-links">
                       
                        <div class="clear"></div>
                    </div>
                        <input name="fname" type="hidden" id="fname">
<input name="lname" type="hidden" id="lname">
<input name="uid" type="hidden" id="uid">
<input name="token" type="hidden" id="token">
<input name="tries" type="hidden" id="tries" value="<?php $attempts ?>">
 <br>
 <a href="#" onClick="javascript: document.loginform.submit();" class="pageapp-signup-button button button-small button-green button-fullscreen">ADMIN LOG IN</a>
 
                    </form>
                       
                    <div class="decoration"></div>
                   
                                       
                    </div>
                </div>
                <div class="overlay bg-black"></div>
               
            </div>   
            
        </div>
    </div>  
    <a href="#" class="back-to-top-badge"><i class="fa fa-caret-up"></i>Back to top</a>
</div>
    
    
<!--Fly up share box and notifications go here -->
<!--These are the only features that should be placed outside the all-elements class-->
    
<div class="share-bottom">
    <h3>Share Page</h3>
    <div class="share-socials-bottom">
        <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.themeforest.net/">
            <i class="fa fa-facebook facebook-color"></i>
            Facebook
        </a>
        <a href="https://twitter.com/home?status=Check%20out%20ThemeForest%20http://www.themeforest.net">
            <i class="fa fa-twitter twitter-color"></i>
            Twitter
        </a>
        <a href="https://plus.google.com/share?url=http://www.themeforest.net">
            <i class="fa fa-google-plus google-color"></i>
            Google
        </a>

        <a href="https://pinterest.com/pin/create/button/?url=http://www.themeforest.net/&media=https://0.s3.envato.com/files/63790821/profile-image.jpg&description=Themes%20and%20Templates">
            <i class="fa fa-pinterest-p pinterest-color"></i>
            Pinterest
        </a>
        <a href="sms:">
            <i class="fa fa-comment-o sms-color"></i>
            Text
        </a>
        <a href="mailto:?&subject=Check this page out!&body=http://www.themeforest.net">
            <i class="fa fa-envelope-o mail-color"></i>
            Email
        </a>
        <div class="clear"></div>
    </div>
    <a href="#" class="close-share-bottom">Close</a>
</div>
    
<div class="top-notification-1 top-notification bg-blue-dark">
    <h4>Did you know?</h4>
    <p>
        Easy way to make sure your messages get read!
    </p>
    <a href="#" class="close-top-notification"><i class="fa fa-times"></i></a>
</div>
<div class="bottom-notification-1 bottom-notification bg-green-dark">
    <h4>Did you know?</h4>
    <p>
        Easy way to make sure your messages get read!
    </p>
    <a href="#" class="close-bottom-notification"><i class="fa fa-times"></i></a>
</div> 
<div class="bottom-notification-2 bottom-notification bg-orange-dark timeout-notification">
    <h4>Timeout: 5 Seconds</h4>
    <p>
        I'll go away on my own after a few seconds!
    </p>
</div>
<div class="top-notification-2 top-notification bg-red-dark timeout-notification">
    <h4>Timeout: 5 Seconds</h4>
    <p>
        I'll go away on my own after a few seconds!
    </p>
</div>
    
</body>















































