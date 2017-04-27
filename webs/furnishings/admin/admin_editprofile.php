<?php 
require_once('Data/furniture.php');
 include 'Data/logitin.php'; 
$userid=$_GET['ID'];
$temail=$_GET['uemail'];

mysql_select_db($database_furniture, $furniture);
$query_Recordset11 = "select * from clients where clientid=$userid ";
$Recordset11 = mysql_query($query_Recordset11, $furniture) or die(mysql_error());
$row_Recordset11 = mysql_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysql_num_rows($Recordset11);


mysql_select_db($database_furniture, $furniture);
$query_Recordset1 = "SELECT cat_id, cat_name, gethasemailalert(cat_id,'$temail') as hasemailalert, getuserid('$temail') as userid from `categories` order by cat_name";
$Recordset1 = mysql_query($query_Recordset1, $furniture) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_furniture, $furniture);
$query_Recordset2 = "SELECT cat_id, cat_name, gethastextalert(cat_id,'$temail') as hastextalert, getuserid('$temail') as userid from `categories` order by cat_name ";
$Recordset2 = mysql_query($query_Recordset2, $furniture) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);


?><!DOCTYPE HTML>
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

<script language="javascript">
     var request = false;
   try {
     request = new XMLHttpRequest();
   } catch (trymicrosoft) {
     try {
	
       request = new ActiveXObject("Msxml2.XMLHTTP");
     } catch (othermicrosoft) {
       try {
         request = new ActiveXObject("Microsoft.XMLHTTP");
       } catch (failed) {
         request = false;
       }  
     }
   }</script>

<script language="javascript">
function addalerts(cat,user,alerts){
	
	 var url = "ajaxupdates.php?talert="+ escape(alerts) +"&catid="+ escape(cat) + "&userid="+ escape(user) +"&type=1";  
	
	
     request.open("GET", url , true);
	// alert(url);
	 alert('Alert Has been Added!');
     request.onreadystatechange = updatePage();
     request.send(null);

}

 function updatePage() {
 
  if (request.readyState == 4) {
 var response = request.responseText;
      var updates = new Array();
    if(response.indexOf('|' != -1)) {
    	updates = response.split("|");
		
		if(updates != 0){
			//alert(updates);
	
} }    }
//javascript:window.close();
   }


</script>
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
    <a class="header-logo" href="admin.php"></a>
   
    
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
                    <a class="menu-item show-submenu" href="#">
                        <i class="fa fa-refresh bg-red-dark"></i>
                        <em>Change Colors</em>
                        <strong>8</strong>
                    </a> 
                    <div class="submenu change-colors">
                        <div>
                            <a class="submenu-item submenu-item-active header-light-toggle" href="#">                               <i class="fa fa-angle-right"></i><em>   Header Light    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item header-dark-toggle" href="#">            <i class="fa fa-angle-right"></i><em>   Header Dark     </em><i class="fa fa-circle"></i></a>
                        </div>  
                        <div>
                            <a class="submenu-item submenu-item-active footer-light-toggle" href="#">                               <i class="fa fa-angle-right"></i><em>   Footer Light    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item footer-dark-toggle" href="#">            <i class="fa fa-angle-right"></i><em>   Footer Dark    </em><i class="fa fa-circle"></i></a>
                        </div>
                        <div>
                            <a class="submenu-item sidebars-light-toggle" href="#">                             <i class="fa fa-angle-right"></i><em>   Sidebar Light    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item sidebars-dark-toggle" href="#">                              <i class="fa fa-angle-right"></i><em>   Sidebar Dark    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item-active submenu-item sidebars-light-icon-toggle" href="#">                        <i class="fa fa-angle-right"></i><em>   Sidebar Light Icons    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item sidebars-dark-icon-toggle" href="#">     <i class="fa fa-angle-right"></i><em>   Sidebar Dark Icons    </em><i class="fa fa-circle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="has-submenu">
                    <a class="menu-item show-submenu" href="#">
                        <i class="fa fa-navicon bg-blue-dark"></i>
                        <em>Menu Settings</em>
                        <strong>4</strong>
                    </a> 
                    <div class="submenu change-colors">
                        <div>
                            <a class="submenu-item enable-footer-menu" href="#"><i class="fa fa-angle-right"></i><em>   Enable Footer Menu    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item submenu-item-active disable-footer-menu" href="#"><i class="fa fa-angle-right"></i><em>   Disable Footer Menu    </em><i class="fa fa-circle"></i></a>
                        </div>                        
                        <div>
                            <a class="submenu-item enable-header-menu" href="#"><i class="fa fa-angle-right"></i><em>   Enable Header Menu    </em><i class="fa fa-circle"></i></a>
                            <a class="submenu-item submenu-item-active disable-header-menu" href="#"><i class="fa fa-angle-right"></i><em>   Disable Header Menu    </em><i class="fa fa-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
                        
            <p class="sidebar-divider">Let's get social</p>
            
            <div class="sidebar-menu">
                <a class="menu-item" href="#">
                    <i class="fa fa-facebook facebook-color"></i>
                    <em>Facebook</em>
                </a>                   
                <a class="menu-item" href="#">
                    <i class="fa fa-twitter twitter-color"></i>
                    <em>Twitter</em>
                </a>                 
                <a class="menu-item" href="#">
                    <i class="fa fa-google-plus google-color"></i>
                    <em>Google Plus</em>
                </a>                    
                <a class="menu-item" href="#">
                    <i class="fa fa-youtube-play youtube-color"></i>
                    <em>YouTube</em>
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
                   
                </div>
            </div>
            
            <p class="sidebar-divider">Contact Us</p>
            
          
            
            <p class="sidebar-footer">Copyright 2015. All rights reserved</p>
        </div>        
        
        <div id="content" class="snap-content">
            <div class="header-clear-large"></div>
            
            <div class="content">                
                <div class="container heading-style-5">
                    <h4 class="heading-title">Userlist</h4>
                    <i class="fa fa-user heading-icon"></i>
                    <div class="line bg-black"></div>
                    <p class="user-list-follow">
                    <form method="POST" id="editprofile" class="contactform">
                       Edit User: <div class="formFieldWrap">
                           <div class="pageapp-signup-field">
                             <input type="text" value="<?php echo $row_Recordset11['username']; ?>
" name="username" id="username" class="contactField requiredField requiredEmailField" ></div>
 <div class="pageapp-signup-field">
                             <input type="password" value="<?php echo $row_Recordset11['password']; ?>
" name="password" id="password" class="contactField requiredField requiredEmailField" ></div>
                              <div class="pageapp-signup-field">
                             <input type="text" value="<?php echo $row_Recordset11['Fname']; ?>
" name="firstname" id="firstname" class="contactField requiredField requiredEmailField" ></div>
                                  <input type="text" value="<?php echo $row_Recordset11['Lname']; ?>" name="lastname" id="lastname" class="contactField requiredField requiredEmailField">
                                    <div class="pageapp-signup-field">
                            
                                    <input type="text" value="<?php echo $row_Recordset11['phone']; ?>" name="phone" id="phone" class="contactField requiredField requiredEmailField"></div>
                                    <input type="text" value="<?php echo $row_Recordset11['email']; ?>" name="email" id="email" class="contactField requiredField requiredEmailField" >
                                     <select name="phone_carrier" class="contactField requiredField requiredEmailField" >
            <option value="<?php echo $row_Recordset11['phone_carrier']; ?>" class="select-title"><?php echo $row_Recordset11['phone_carrier']; ?></option>
               
                <option value="@txt.att.net">ATT</option>
                 <option value="@txt.att.net">ATT</option>
                  <option value="@txt.att.net">ATT</option>
                   <option value="@txt.att.net">ATT</option>
                    <option value="@txt.att.net">ATT</option>
                     <option value="@txt.att.net">ATT</option>
               
               </select>
                  <input type="hidden" value="<?php echo $today ?>" name="date" id="date" >
          
             <input type="hidden" name="clientid" id="clientid" value="<?php echo $row_Recordset11['clientid']; ?>">
                                <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="editprofile" value="Edit Profile" data-formId="editprofile"/>     
                                   
                            </div>
                            </form>
                            
                    </p>
                     <div class="decoration"></div>
                      <a href="admin.php" class="facebook-login facebook-color"><i class="fa fa-backward"></i>Back Home</a>
                </div> 
                
                <div class="decoration"></div>

               
               <div class="container no-bottom">
                    <div class="one-half-responsive">
                        <h4>Email Alerts</h4>
                        <p>
                            Click the check green to receive email alerts!
                        </p>
                         <?php
						
   do { 
$thecatid=$row_Recordset1['cat_id'];
$thecatname=$row_Recordset1['cat_name'];
$thehasemailalert=$row_Recordset1['hasemailalert'];
$thecustid=$row_Recordset1['userid'];
//$theemailalert=$row_Recordset1['email_alert'];
//$thetextalert=$row_Recordset1['text_alert'];
if($thehasemailalert==0){
	$showalert="";
} else {
	
	$showalert="tasklist-completed";
}
?>               
                        <a href="#" onClick="addalerts(<?php echo $thecatid ?>,<?php echo $thecustid ?>,1)" class="tasklist-item <?php echo $showalert ?>">
                            <i class="fa fa-check"></i>
                            <h5><?php echo $thecatname ?></h5>
                        </a>                    
                         <?php   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
?>
                        <div class="decoration"></div>
                    </div>
                    <div class="one-half-responsive last-column">
                        <h4>Text Alerts</h4>
                        <p>
                            Click the check green to receive text alerts!
                        </p>
                         <?php
						
   do { 
$thecatids=$row_Recordset2['cat_id'];
$thecatnames=$row_Recordset2['cat_name'];
$thehastextalert=$row_Recordset2['hastextalert'];
$thecustids=$row_Recordset2['userid'];

if($thehastextalert==0){
	$showalerts="";
} else {
	
	$showalerts="tasklist-completed";
}
?>            
                        <a href="#" onClick="addalerts(<?php echo $thecatids ?>,<?php echo $thecustids ?>,2)" class="tasklist-item <?php echo $showalerts ?>">
                            <i class="fa fa-check"></i>
                            <h5><?php echo $thecatnames ?></h5>
                        </a>                    
                       <?php   } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
?>
                        <div class="decoration"></div>
                    </div>
                </div>
                <div class="decoration"></div> 
 
               
                
                <div class="decoration"></div>
                
                <div class="container-fullscreen footer footer-light">
                    <a href="#" class="footer-logo"></a>
                    <p class="half-bottom center-text">
                        We aim to simplify your life by creating a 
                        beautiful and simple product that's feature rich and easy to use!
                    </p>
                    <div class="decoration"></div>
                    <div class="footer-socials">
                        <a href="#" class="scale-hover facebook-color"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="scale-hover google-color"><i class="fa fa-google-plus"></i></a>
                        <a href="#" class="scale-hover twitter-color"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="scale-hover phone-color"><i class="fa fa-phone"></i></a>
                        <a href="#" class="scale-hover mail-color"><i class="fa fa-envelope-o"></i></a>
                        <a href="#" class="scale-hover bg-magenta-dark back-to-top"><i class="fa fa-angle-up"></i></a>
                        <div class="clear"></div>
                    </div>
                    <div class="decoration"></div>
                    <p class="small-text no-bottom center-text">Copyright 2016. All Rights Reserved</p>
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
