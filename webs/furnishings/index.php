<?php include 'Data/logitin.php'; 
require_once('Data/furniture.php');

//Include FB config file && User class
require_once 'fbConfig.php';
require_once 'User.php';

// For the FB verification we need to do one check before anything else
// FB returns validation to the index.php page. If this is the first time
// the user has logged in we need to add them to our clients table so that
// they will be valid users

if(!$fbUser){
	$fbUser = NULL;
	$loginURL = $facebook->getLoginUrl(array('redirect_uri'=>$redirectURL,'scope'=>$fbPermissions));
	$output = '<a href="'.$loginURL.'"><img src="images/fblogin-btn.png"></a>'; 	
} else {
    //Get user profile data from facebook
    $fbUserProfile = $facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');

    //Initialize User class
    $user = new User();
    
    //Insert or update user data to the database
    $fbUserData = array(
        'oauth_provider'=> 'facebook',
        'oauth_uid'     => $fbUserProfile['id'],
        'first_name'    => $fbUserProfile['first_name'],
        'last_name'     => $fbUserProfile['last_name'],
        'email'         => $fbUserProfile['email'],
        'gender'        => $fbUserProfile['gender'],
        'locale'        => $fbUserProfile['locale'],
        'picture'       => $fbUserProfile['picture']['data']['url'],
        'link'          => $fbUserProfile['link']
    );
    $userData = $user->checkUser($fbUserData);
    
    // print_r($userData);

    //Put user data into session
    $_SESSION['userData'] = $userData;
    
    //Render facebook profile data
    if(!empty($userData)){
        $output =  '<h1>Facebook Profile Details </h1>';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<br/>Facebook ID : ' . $userData['oauth_uid'];
        $output .= '<br/>Name : ' . $userData['Fname'].' '.$userData['Lname'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Facebook';
        $output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="logout.php">Facebook</a>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}

mysqli_select_db($furniture, $database_furniture);

$query_Recordset1 = "SELECT cat_id, cat_name, gethasemailalert(cat_id,'$theuser') as hasemailalert, getuserid('$theuser') as userid from `categories` order by cat_name";

$Recordset1 = mysqli_query($furniture, $query_Recordset1) or die(mysql_error());
$row_Recordset1       = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;

mysqli_select_db($furniture, $database_furniture);

$query_Recordset2 = "SELECT cat_id, cat_name, gethastextalert(cat_id,'$theuser') as hastextalert, getuserid('$theuser') as userid from `categories`  order by cat_name";

$Recordset2 = mysqli_query($furniture, $query_Recordset2) or die(mysql_error());
$row_Recordset2 	  = $Recordset2->fetch_assoc();
$totalRows_Recordset2 = $Recordset2->num_rows;

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
    
<title>My Furniture WishList</title>

<link href="styles/style.css"           rel="stylesheet" type="text/css">
<link href="styles/menus.css"           rel="stylesheet" type="text/css">
<link href="styles/framework.css"       rel="stylesheet" type="text/css">
<link href="styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="styles/animate.css"         rel="stylesheet" type="text/css">
<link href="styles/overrides.css"       rel="stylesheet" type="text/css">
<link href="styles/hamburgers.css"      rel="stylesheet" type="text/css">

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/jqueryui.js"></script>
<script type="text/javascript" src="scripts/framework-plugins.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
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
	 alert('Alert Has Been Added!');
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

$(document).ready(function(){

	$("#email-alerts").click(function(){
	    $(".text-alerts").hide();
	    $(".email-alerts").show();

	    $("#email-alerts").addClass("tab-active" );
	    $("#text-alerts").removeClass("tab-active" );
	});

	$("#text-alerts").click(function(){
	    $(".text-alerts").show();
	    $(".email-alerts").hide();

	   	$("#email-alerts").removeClass( "tab-active" );
	    $("#text-alerts").addClass( "tab-active" );
	});
});
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
    <a class="header-icon-left open-left-sidebar" href="#">
        <button class="hamburger hamburger--arrow" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span> 
          </span>
        </button>
    </a>
    <a class="header-icon-two open-header-menu disabled" href="#"><i class="fa fa-angle-down"></i></a>
    <a class="header-logo" href="#"></a>
    <a class="header-icon-right" href="logout.php">Logout</a>
    
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
            
            <p class="sidebar-footer"></p>
            
        </div>
        
           
        <!--Right Sidebar -->
        
        <div class="snap-drawer snap-drawer-right sidebar-light-clean">
            <div class="sidebar-header">
               
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
                              
                 
            </div>
                        
            <p class="sidebar-divider"></p>
            
            <div class="container no-bottom">
                <div class="sidebar-form contact-form no-bottom"> 
                    <em>
                       
                    </em>
                    <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                        
                    </div>
                         
                </div>
            </div>
            
            <p class="sidebar-divider"></p>
            
            <div class="sidebar-menu">
               
            </div>
            
            <p class="sidebar-footer">Copyright <?php echo $year ?>. All rights reserved</p>
        </div>         
        
        <div id="content" class="snap-content">
            <div class="header-clear-large"></div>
            
            <div class="content">                
                <div class="container heading-style-5">
               	    <div class="boxed-layout">
                        <div style="text-align: center;">
                            <h2>Manage Wishlist</h2>
                        </div>
                     </div>
                    <i class="fa fa-check heading-icon"></i>
                    <div class="line bg-black"></div>
                    <p class="heading-subtitle">
                       Click on the Categories that intrest you to recieve alerts for your wishlist.  Once the item/items are received, you will immediately get a one time notification for each item that you have selected below.
                    </p>
                </div>

                <div class="decoration"></div>

                <div class="text-center">
                	<button id="email-alerts" class="btn-block btn-main btn tab-active">Email</button><button id="text-alerts" class="btn-block btn-main btn ">Text</button>
                </div>

                <div class="container no-bottom">
                    <div class="one-half-responsive email-alerts">
                        <h2>Email Alerts</h2>
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
                         <?php   } while ($row_Recordset1 = $Recordset1->fetch_assoc());
?>
                        <div class="decoration"></div>
                    </div>
                    <div class="one-half-responsive text-alerts" style="display: none;">
                        <h2>Text Alerts</h2>
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
                       <?php   } while ($row_Recordset2 = $Recordset2->fetch_assoc());
?>
                        <div class="decoration"></div>
                    </div>
                </div>
                <div class="decoration"></div>   
                

            </div>
        </div>
    </div>  

                <div id="footer">
                <div class="text-center">
                    <div class="share-icons">
                        <h2>FOLLOW US ON SOCIAL</h2>
                        <p>
                            <span>
                                <a class="pinterest" href="http://www.pinterest.com/" target="_blank">
                                    <img alt="Pinterest" src="images/pinterest-c14212a7e4eb48bb464beb5d8546cc12.png">
                                </a>
                                <a class="facebook" href="http://facebook.com/" target="_blank">
                                    <img alt="Facebook" src="images/facebook-7857dd5132dad951307a35b746307f7c.png">
                                </a>
                                <a class="twitter" href="https://twitter.com" target="_blank">
                                    <img alt="Twitter" src="images/twitter-d4a0376da5a90719d29a98a0ab83ad03.png">
                                </a>
                                <a class="instagram" href="http://instagram.com" target="_blank">
                                    <img alt="Instagram" src="images/instagram-a4a3e5e92d2b999c24051428cf69d2c4.png">
                                </a>
                            </span>
                        </p>
                    </div>
                    <div class="copyright-notice">
                        Copyright © 2017 MyFurnitureWishlist.com All Rights Reserved.
                    </div>
            </div>


    <a href="#" class="back-to-top-badge"><i class="fa fa-caret-up"></i>Back to top</a>
</div>
    
    
<!--Fly up share box and notifications go here -->
<!--These are the only features that should be placed outside the all-elements class-->
    
<div class="share-bottom">
    <h3>Share Page</h3>
    <div class="share-socials-bottom">
     
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