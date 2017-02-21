<?php
require_once('Data/furniture.php');
// *** Validate request to login to this site.
$theemail=$_POST['input-email'];
if($theemail!=''){
mysql_select_db($database_furniture, $furniture);
 $query_customer = sprintf("
SELECT password , username
  FROM clients where email='$theemail' limit 1
");
$customer = mysql_query($query_customer, $furniture) or die(mysql_error());
$row_customer = mysql_fetch_assoc($customer);
$showpass=$row_customer['password'];
$showuser=$row_customer['username'];


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
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = $MM_redirectLoginFailed1;
  $MM_redirecttoReferrer = false;
mysql_select_db($database_furniture, $furniture);
  
  $LoginRS__query=sprintf("SELECT username, password, email FROM clients WHERE username='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $furniture) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $row_login = mysql_fetch_assoc($LoginRS);

  $theuseremail=$row_login['email'];
  
 }
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare 3 session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_Email'] = $theuseremail;
      

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

<link href="styles/style.css"           rel="stylesheet" type="text/css">
<link href="styles/menus.css"           rel="stylesheet" type="text/css">
<link href="styles/framework.css"       rel="stylesheet" type="text/css">
<link href="styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="styles/animate.css"         rel="stylesheet" type="text/css">

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jqueryui.js"></script>
<script type="text/javascript" src="scripts/framework-plugins.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
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
        <a href="index.html" class="active-header-item"><i class="fa fa-home"></i>Homepage<i class="fa fa-circle"></i></a>
        <a href="features-typography.html"><i class="fa fa-cog"></i>Features<i class="fa fa-circle"></i></a>
        <a href="gallery-square.html"><i class="fa fa-camera"></i>Media<i class="fa fa-circle"></i></a>
        <a href="page-sitemap.html"><i class="fa fa-file-o"></i>SiteMap<i class="fa fa-circle"></i></a>
        <a href="contact.html"><i class="fa fa-envelope-o"></i>Contact<i class="fa fa-circle"></i></a>
        <a href="#" class="close-header-menu"><i class="fa fa-times"></i>Close<i class="fa fa-circle"></i></a>
    </div> 
</div> 
    
        
<div id="footer-fixed" class="footer-menu footer-light disabled">
    <a href="index.html" class="active-footer-item footer-mobile"><i class="fa fa-home"></i>Home</a>
    <a href="features-typography.html" class="footer-mobile"><i class="fa fa-cog"></i>Features</a>
    <a href="gallery-square.html" class="footer-mobile"><i class="fa fa-camera"></i>Media</a>
    <a href="page-sitemap.html" class="footer-mobile"><i class="fa fa-navicon"></i>Sitemap</a>
    <a href="contact.html" class="footer-mobile"><i class="fa fa-envelope-o"></i>Contact</a>
    <a href="#" class="footer-tablet"><i class="fa fa-phone"></i>Call</a>
    <a href="#" class="footer-tablet"><i class="fa fa-comments"></i>Text</a>
    <a href="#" class="footer-tablet"><i class="fa fa-facebook"></i>Like</a>
    <a href="#" class="footer-tablet"><i class="fa fa-twitter"></i>Follow</a>
</div>
    
<div class="gallery-fix"></div> <!-- Important for all pages that have galleries or portfolios -->
            
<div class="all-elements">
    <div class="snap-drawers">
        <div class="snap-drawer snap-drawer-left sidebar-light-clean">        
            <div class="sidebar-header">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-phone"></i></a>
                <a href="#"><i class="fa fa-comment-o"></i></a>
                <a class="close-sidebar" href="#"><i class="fa fa-times"></i></a>
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
                <a class="close-sidebar" href="#"><i class="fa fa-times"></i></a>
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-phone"></i></a>
                <a href="#"><i class="fa fa-comment-o"></i></a>
            </div>   
            
            <div class="sidebar-logo"></div>
                        
            <div class="sidebar-divider no-bottom"></div>
            
            <p class="sidebar-divider"></p>
            
            <div class="sidebar-menu">
                <div class="has-submenu">
                   
                    <div class="submenu change-colors">
                        <div>
                            
                        </div>
                    </div>
                </div>
                <div class="has-submenu">
                    
                    <div class="submenu change-colors">
                        <div>
                          
                        </div>                        
                        <div>
                            
                        </div>
                    </div>
                </div>
            </div>
                        
            <p class="sidebar-divider"></p>
            
            <div class="sidebar-menu">
                <a class="menu-item" href="#">
                    <i class="fa fa-facebook facebook-color"></i>
                    <em>Facebook</em>
                </a>                   
                           
                <a class="menu-item" href="#">
                    <i class="fa fa-google-plus google-color"></i>
                    <em>Google Plus</em>
                </a>                    
                 
            </div>
                        
            <p class="sidebar-divider">Send an email</p>
            
            <div class="container no-bottom">
                <div class="sidebar-form contact-form no-bottom"> 
                    <em>
                        Your message is important to us and we reply to all of them in less than 48 hours.
                    </em>
                    <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                        Awesome! We'll get back to you!
                    </div>
                    <form action="login.php" method="post" class="contactForm" id="contactForm">
                        <fieldset>
                            <div class="formValidationError" id="contactNameFieldError">Name is required!</div>             
                            <div class="formValidationError" id="contactEmailFieldError">Mail address required!</div> 
                            <div class="formValidationError" id="contactEmailFieldError2">Mail address must be valid!</div> 
                            <div class="formValidationError" id="contactMessageTextareaError">Message field is empty!</div>   
                            <div class="formFieldWrap">
                                <input onfocus="if (this.value=='Name') this.value = ''" onblur="if (this.value=='') this.value = 'Name'" type="text" name="contactNameField" value="Name" class="contactField requiredField" id="contactNameField"/>
                            </div>
                            <div class="formFieldWrap">
                                <input onfocus="if (this.value=='Email') this.value = ''" onblur="if (this.value=='') this.value = 'Email'" type="text" name="contactEmailField" value="Email" class="contactField requiredField requiredEmailField" id="contactEmailField"/>
                            </div>
                            <div class="formTextareaWrap">
                                <textarea onfocus="if (this.value=='Message') this.value = ''" onblur="if (this.value=='') this.value = 'Message'" name="contactMessageTextarea" class="contactTextarea requiredField" id="contactMessageTextarea">Message</textarea>
                            </div>
                            <div class="formSubmitButtonErrorsWrap">
                                <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="contactSubmitButton" value="SUBMIT" data-formId="contactForm"/>
                            </div>
                        </fieldset>
                    </form>       
                </div>
            </div>
            
            <p class="sidebar-divider">Contact Us</p>
            
            <div class="sidebar-menu">
                <a class="menu-item" href="tel:+123 456 7890">
                    <i class="fa fa-phone bg-green-dark"></i>
                    <em>Call Us</em>
                </a>                   
                <a class="menu-item" href="sms:+123 456 7890">
                    <i class="fa fa-comment-o bg-blue-dark"></i>
                    <em>Text Us</em>
                </a>                 
                <a class="menu-item" href="mailto:someone@yoursite.com?subject=Message from ThemeForest">
                    <i class="fa fa-envelope-o bg-magenta-dark"></i>
                    <em>Mail Us</em>
                </a>    
                <a class="menu-item close-sidebar" href="#">
                    <i class="fa fa-times bg-red-dark"></i>
                    <em>Close</em>
                    <i class="fa fa-circle"></i>
                </a>
            </div>
            
            <p class="sidebar-footer">Copyright <?php echo $year ?>. All rights reserved</p>
        </div>        
        
        <div id="content" class="snap-content">      
            <div class="header-clear"></div>
            <div class="pageapp-login bg-5 cover-screen">    
                <div class="pageapp-login-content cover-center">
                  <div class="boxed-layout">
                        <a class="pageapp-login-logo" href="#"></a>
                        <form id="loginform" class="form-vertical no-padding no-margin" action="<?PHP echo $loginFormAction; ?>" name="loginform" method="post">
                        <div class="pageapp-login-field">
                            <i class="fa fa-user"></i>
                            <input type="text" value="UserName" id="username" name="username" onfocus="if (this.value=='UserName') this.value = ''" onblur="if (this.value=='') this.value = 'UserName'">
                        </div>
                        <div class="pageapp-login-field">
                            <i class="fa fa-user"></i>
                            <input type="password" id="password" name="password" value="Password" onfocus="if (this.value=='Pasword') this.value = ''" onblur="if (this.value=='') this.value = 'Pasword'">
                        </div>
                          <div class="pageapp-login-links">
                        <a href="#" class="page-login-forgot"><i class="ion-ios-eye"></i>Forgot Credentials</a>
                        <a href="register.php" class="page-login-create">Create Account<i class="ion-android-create"></i></a>
                        <div class="clear"></div>
                    </div>
                        <input name="fname" type="hidden" id="fname">
<input name="lname" type="hidden" id="lname">
<input name="uid" type="hidden" id="uid">
<input name="token" type="hidden" id="token">
<input name="tries" type="hidden" id="tries" value="<?php $attempts ?>">
 <br>
 <a href="#" onClick="javascript: document.loginform.submit();" class="pageapp-signup-button button button-small button-green button-fullscreen">LOG IN</a>
 
                    </form>
                       
                    <div class="decoration"></div>
                     <?php  // put facebook login button here ?>
                                       
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
















































