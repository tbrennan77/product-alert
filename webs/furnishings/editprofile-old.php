<? 
require_once('Data/furniture.php');
 include 'Data/logitin.php'; 


mysql_select_db($database_furniture, $furniture);
$query_Recordset1 = "select * from clients where clientid=getuserid('$theuser') ";
$Recordset1 = mysql_query($query_Recordset1, $furniture) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

 
  
/* $pfname=$_POST['firstname'];
					   $plname=$_POST['lastname'];
					   $pemail=$_POST['email'];
					   $phone=$_POST['phone'];
					   $dpate=$_POST['date'];
					   $pphonecarrier=$_POST['phone_carrier'];
					   $submitforms=$_POST['MM_insert'];
if ($submitforms == "form3") {
	   
		
  $insertSQL = sprintf("update `clients` set fname='$pfname', lname='$plname', email='$pemail', phone='$phone', changedate='$dpate', phone_carrier='$pphonecarrier'");
 
  mysql_select_db($database_furniture, $furniture);
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error());
  
   $insertGoTo ="index.php";
 
 
  header(sprintf("Location: %s", $insertGoTo));
  
 
}
  
 */

?><!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<title>Edit Profile</title>
    <script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/plugins.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/skin.css">
<link rel="stylesheet" type="text/css" href="styles/framework.css">
<link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

	<script type="text/javascript">
	// magic.js
$(document).ready(function() {

	// process the form
	$('form').submit(function(event) {

		//$('.form-group').removeClass('has-error'); // remove the error class
		//$('.help-block').remove(); // remove the error text

		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var formData = {
			'clientid' 		    : $('input[clientid=clientid]').val(),
			'firstname' 		: $('input[firstname=firstname]').val(),
			'lastname' 		    : $('input[lastname=lastname]').val(),
			'phone' 		    : $('input[phone=phone]').val(),
			'phone_carrier'     : $('input[phone_carrier=phone_carrier]').val(),
			'email' 			: $('input[email=email]').val(),
			'date' 			    : $('input[date=date]').val()
			
		};

		// process the form
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'test.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
			// using the done promise callback
			.done(function(data) {

				// log data to the console so we can see
				console.log(data); 
alert(data.errors.clientid);
				/* here we will handle errors and validation messages
				if ( ! data.success) {
					alert(data.errors.firstname);
					// handle errors for name ---------------
					if (data.errors.firstname) {
						$('#firstname-group').addClass('has-error'); // add the error class to show red input
						$('#firstname-group').append('<div class="help-block">' + data.errors.firstname + '</div>'); // add the actual error message under our input
					}
					// handle errors for name ---------------
					if (data.errors.lastname) {
						$('#lastname-group').addClass('has-error'); // add the error class to show red input
						$('#lastname-group').append('<div class="help-block">' + data.errors.lastname + '</div>'); // add the actual error message under our input
					}
					// handle errors for name ---------------
					if (data.errors.phone) {
						$('#phone-group').addClass('has-error'); // add the error class to show red input
						$('#phone-group').append('<div class="help-block">' + data.errors.phone + '</div>'); // add the actual error message under our input
					}
// handle errors for name ---------------
					if (data.errors.phone_carrier) {
						$('#phone_carrier-group').addClass('has-error'); // add the error class to show red input
						$('#phone_carrier-group').append('<div class="help-block">' + data.errors.phone_carrier + '</div>'); // add the actual error message under our input
					}
					// handle errors for email ---------------
					if (data.errors.email) {
						$('#email-group').addClass('has-error'); // add the error class to show red input
						$('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the actual error message under our input
					}

					
				} else {
*/
					// ALL GOOD! just show the success message!
					//$('form').append('<div class="alert alert-success">' + data.message + '</div>');

					// usually after form submission, you'll want to redirect
				// window.location = 'index.php'; // redirect a user to another page

				
			})

			// using the fail promise callback
			.fail(function(data) {

				// show any errors
				// best to remove for production
				console.log(data);
			});

		// stop the form from submitting the normal way and refreshing the page
		event.preventDefault();
	});

});
	
	</script>



</head>

<body>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <div class="spinner"></div>
</div>
    
<div class="landing-menu landing-light hidden-menu transparent-backgrounds">
    <div class="landing-menu-scroll">
        <div class="landing-header">
            <h1>Community Furnishings</h1>
            <a href="#" class="landing-remove"><i class="ion-navicon"></i></a>
            <div class="clear"></div>
        </div>
        <div class="menu-items">
            <a data-submenu="sub1" class="menu-item open-submenu" href="index.php">
                <i class="border-green-dark bg-green-dark ion-ios-home-outline"></i>
                <em>Home</em>
            </a>
            <a data-submenu="sub2" class="menu-item open-submenu" href="editprofile.php">
                <i class="border-blue-dark bg-blue-dark ion-ios-gear-outline"></i>
                <em>Edit Profile</em>
            </a>
            <a data-submenu="sub3" class="menu-item open-submenu" href="index.php">
                <i class="border-orange-dark bg-orange-dark ion-ios-list-outline"></i>
                <em>My Alerts</em>
            </a>
            <div class="clear"></div>
           
           

            <a data-submenu="sub4" class="menu-item open-submenu" href="<? echo $logoutAction ?>">
                <i class="border-teal-dark bg-teal-dark ion-ios-analytics-outline"></i>
                <em>LogOut</em>
            </a>
        
            <div class="clear"></div>
            <div class="decoration"></div>
            <div class="landing-socials">
              
            </div>
        </div>
    </div>    
</div>
    
<div class="header header-light">
    <h1>Community</h1>
    <a href="#" class="landing-deploy"><i class="ion-navicon"></i></a>
    <div class="clear"></div>
</div> 
            
<div id="page-content" class="header-clear">
    <div id="page-content-scroll"><!--Enables this element to be scrolled --> 
                
        <div class="page-login content">
            <a href="#" class="page-login-logo"><img class="preload-image" data-original="images/preload-logo.png" alt="img" src="images/empty.png"></a>
            <div class="page-login-input">
           <form action="test.php" method="POST">
           
                <i class="login-icon ion-person"></i>
                <input type="text" value="<? echo $row_Recordset1['Fname']; ?>
" name="firstname" id="firstname" >
            </div>   
            <div class="page-login-input">
                <i class="login-icon ion-person"></i>
                <input type="text" value="<? echo $row_Recordset1['Lname']; ?>" name="lastname" id="lastname" >
            </div>  
             <div class="page-login-input">
                <i class="login-icon ion-person"></i>
                <input type="text" value="<? echo $row_Recordset1['phone']; ?>" name="phone" id="phone" >
            </div>                     
 <div class="page-login-input">
  <div class="select-box">
               
               <select name="phone_carrier" >
            <option value="<? echo $row_Recordset1['phone_carrier']; ?>" class="select-title"><? echo $row_Recordset1['phone_carrier']; ?></option>
               
                <option value="@txt.att.net">ATT</option>
                 <option value="@txt.att.net">ATT</option>
                  <option value="@txt.att.net">ATT</option>
                   <option value="@txt.att.net">ATT</option>
                    <option value="@txt.att.net">ATT</option>
                     <option value="@txt.att.net">ATT</option>
               
               </select>
               </div>
            </div>    
            <div class="page-login-input">
                <i class="login-icon ion-at"></i>
                <input type="text" value="<? echo $row_Recordset1['email']; ?>" name="email" id="email" >
            </div>                     
            <input type="hidden" value="<? echo $today ?>" name="date" id="date" >
            <input type="hidden" name="MM_insert" value="form3" id="MM_insert">
             <input type="hidden" name="clientid" value="form3" id="clientid" value="<? echo $row_Recordset1['clientid']; ?>">

           
           <button type="submit" class="button button-green button-icon button-full half-top full-bottom">Update Profile </button>
           
           
            
          
</form> 
        
            <div class="decoration full-top"></div>

            <a href="index.php" class="button button-blue button-icon button-full half-top full-bottom"><i class="ion-person"></i>Back To Alert</a>           
        </div>
                   
        <div class="decoration decoration-margins"></div>
        
        <div class="footer footer-light">
            <a href="index.html" class="footer-logo scale-hover"></a>
            <p>
                Simplicity and complexity packed into a beautiful, 
                feature filled, powerful, gorgeous mobile template.
            </p>
            <div class="footer-socials">
                <a href="#" class="icon icon-round icon-ghost icon-xs facebook-bg"><i class="ion-social-facebook"></i></a>
                <a href="#" class="icon icon-round icon-ghost icon-xs twitter-bg"><i class="ion-social-twitter"></i></a>
                <a href="#" class="icon icon-round icon-ghost icon-xs google-bg"><i class="ion-social-googleplus"></i></a>
                <a href="#" class="icon icon-round icon-ghost icon-xs phone-bg"><i class="ion-ios-telephone"></i></a>
                <a href="#" class="icon icon-round icon-ghost icon-xs show-share-bottom border-magenta-dark"><i class="ion-android-share"></i></a>
                <a href="#" class="icon icon-round icon-ghost icon-xs back-to-top border-blue-light"><i class="ion-arrow-up-b"></i></a>
            </div>
            <div class="decoration"></div>
            <p class="copyright-text">Copyright <span id="copyright-year"></span>. All Rights Reserved.</p>
        </div>
    </div>  
</div>
    
<div class="share-bottom share-light">
    <h3>Share Page</h3>
    <div class="share-socials-bottom">
        <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.themeforest.net/">
            <i class="ion-social-facebook-outline icon-ghost facebook-bg"></i>
            Facebook
        </a>
        <a href="https://twitter.com/home?status=Check%20out%20ThemeForest%20http://www.themeforest.net">
            <i class="ion-social-twitter-outline twitter-bg"></i>
            Twitter
        </a>
        <a href="https://plus.google.com/share?url=http://www.themeforest.net">
            <i class="ion-social-googleplus-outline icon-ghost google-bg"></i>
            Google
        </a>
        <a href="https://pinterest.com/pin/create/button/?url=http://www.themeforest.net/&media=https://0.s3.envato.com/files/63790821/profile-image.jpg&description=Themes%20and%20Templates">
            <i class="ion-social-pinterest-outline icon-ghost pinterest-bg"></i>
            Pinterest
        </a>
        <a href="sms:">
            <i class="ion-ios-chatboxes-outline icon-ghost sms-bg"></i>
            Text
        </a>
        <a href="mailto:?&subject=Check this page out!&body=http://www.themeforest.net">
            <i class="ion-ios-email-outline icon-ghost mail-bg"></i>
            Email
        </a>
        <div class="clear"></div>
    </div>
</div>
 
    
</div>
</body>
