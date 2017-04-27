<?php 
include 'Data/logitin.php'; 
require_once('Data/furniture.php');
	
mysql_select_db($database_furniture, $furniture);
$query_Recordset1 = "SELECT * from `text_emails`  ";
$Recordset1 = mysql_query($query_Recordset1, $furniture) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$gid=$_GET['ID'];
if($gid!=''){
mysql_select_db($database_furniture, $furniture);
$query_Recordset11 = "SELECT * from `text_emails`  where textid=$gid ";
$Recordset11 = mysql_query($query_Recordset11, $furniture) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);	
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
<link rel="icon" type="image/png" href="../images/splash/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="../images/splash/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../images/splash/favicon-16x16.png" sizes="16x16">
<link rel="shortcut icon" href="../images/splash/favicon.ico" type="image/x-icon" /> 
    
<title>CF Administration</title>

<link href="../styles/style.css"           rel="stylesheet" type="text/css">
<link href="../styles/menus.css"           rel="stylesheet" type="text/css">
<link href="../styles/framework.css"       rel="stylesheet" type="text/css">
<link href="../styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="../styles/animate.css"         rel="stylesheet" type="text/css">

<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/jqueryui.js"></script>
<script type="text/javascript" src="../scripts/framework-plugins.js"></script>
<script type="text/javascript" src="../scripts/custom1.js"></script>

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
   
    
    <div class="header-menu-overlay"></div>
  
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
               
                    <a class="menu-item" href="admin.php">
                        <i class="fa fa-home bg-red-dark"></i>
                        <em>Admin Home</em>
                        <strong></strong>
                    </a> 
                   
                             
               
                    <a class="menu-item" href="admin_editpusers.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Edit Customers</em>
                        <strong></strong>
                    </a> 
                     <a class="menu-item" href="admin_editadmin.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Edit Admins</em>
                        <strong></strong>
                    </a> 
                    <a class="menu-item" href="admin_edittexts.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Add Text/Email</em>
                        <strong></strong>
                    </a> 
                   <a class="menu-item" href="admin_editwebsite.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Add Website Data</em>
                        <strong></strong>
                    </a>
                     <a class="menu-item" href="admin_editcats.php">
                        <i class="fa fa-cog bg-orange-dark"></i>
                        <em>Add Categories </em>
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
        
        <div class="snap-drawer snap-drawer-right sidebar-light-clean">
           
            
            <div class="sidebar-logo"></div>
                        
            <div class="sidebar-divider no-bottom"></div>
            
           
            
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
                    </div>
                </div>
            </div>
                        
           
            
           
                        
            <p class="sidebar-divider"></p>
            
            <div class="container no-bottom">
                <div class="sidebar-form contact-form no-bottom"> 
                    <em>
                        
                    </em>
                  
                   
                </div>
            </div>
            
            <p class="sidebar-divider">Contact Us</p>
            
          
            
           
        </div>        
        
        <div id="content" class="snap-content">
            <div class="header-clear-large"></div>
            
            <div class="content">                
                <div class="container heading-style-5">
                    <h4 class="heading-title">Text/Email Verbaige</h4>
                    <i class="fa fa-user heading-icon"></i>
                    <div class="line bg-black"></div>
                    <p class="user-list-follow">
                  <?  if($gid==''){ ?>

                     <form method="POST" id="addtext" class="contactform">
                       Add New Text/Email Verbaige: <div class="formFieldWrap">
                       <div class="pageapp-signup-field">
                            <i class="fa fa-user"></i>  <input type="text"   onfocus="if (this.value=='Verbaige') this.value = ''" onblur="if (this.value=='') this.value = 'Verbaige'" value="Verbaige" name="verbaige" id="verbaige" class="contactField requiredField requiredusernameField" >
 <div class="pageapp-signup-field">
              
               <select name="types" id="types" class="contactField requiredField requiredEmailField" >
            <option value="0" class="select-title">Text Message</option>
               <option value="1">Email</option>
               </select></div>
                            <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="addtext" value="Add Text" data-formId="addtext"/>       
                            </div>
                            </form>
                            <? } else {  ?>
                             <form method="POST" id="edittext" class="contactform">
                       Edit Web Verbaige: <div class="formFieldWrap">
                       <div class="pageapp-signup-field">
                            <i class="fa fa-user"></i>  <input type="text"    value="<?php echo $row_Recordset11['textinfo']; ?>
" name="verbaige" id="verbaige" class="contactField requiredField requiredusernameField" ></div>
 <div class="pageapp-signup-field">
                <input type="hidden"  value="<?php echo $gid ?>
" name="ggid" id="ggid" >
 <select name="type" class="contactField requiredField requiredEmailField" >
            <option value="<?php echo $row_Recordset11['type']; ?>" class="select-title"><? if($row_Recordset11['type']==0){ ?>Text Message <? } else { ?>Email Message<? } ?></option>
            <option value="0" class="select-title">Text Message</option>
               
                <option value="1">Email</option>
                
               </select>
                            <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="edittext" value="Edit Verbaige" data-formId="edittext"/>       
                            </div>
                            </form>
                            <? } ?>
                    </p>
                </div> 
                
                <div class="decoration"></div>
               

 <?php
	
					
   do { 
$thefname=$row_Recordset1['textinfo'];
$thecustid=$row_Recordset1['textid'];

?>               
                <div class="one-third-responsive">
                    <p class="user-list-follow">
                        <img src="../images/pictures/1s.jpg" alt="img">
                        <strong><?php echo $thefname ?> </em></strong>
                        <a href="admin_edittexts.php?ID=<?php echo $thecustid ?>" class="follow">Edit Verbaige</a>
                    </p>
                    <div class="decoration"></div>                
                   
                  
                </div>            
 <?php   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	
?>
               
                
                <div class="decoration"></div>
                
                <div class="container-fullscreen footer footer-light">
                    <a href="#" class="footer-logo"></a>
                    <p class="half-bottom center-text">
                       
                    </p>
                    <div class="decoration"></div>
                    <div class="footer-socials">
                       
                        <div class="clear"></div>
                    </div>
                    <div class="decoration"></div>
                    <p class="small-text no-bottom center-text">Copyright <?php echo $year ?>. All Rights Reserved</p>
                </div>
                <div class="footer-clear disabled"></div>
                
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
