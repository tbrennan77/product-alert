<?php 
include 'Data/logitin.php'; 
require_once('Data/furniture.php');

//Include FB config file && User class
require_once '../fbConfig.php';
require_once '../User.php';

// For the FB verification we need to do one check before anything else
// FB returns validation to the index.php page. If this is the first time
// the user has logged in we need to add them to our clients table so that
// they will be valid users

//echo "User: ".$theuser."<br />";
//echo "User: ".$theuserid."<br />";

if(!$fbUser){

  // This creates the Facebook link that we will insert for allowing users to login with Facebook
	$fbUser = NULL;
	$loginURL = $facebook->getLoginUrl(array('redirect_uri'=>$redirectURL,'scope'=>$fbPermissions));
	$output = '<a href="'.$loginURL.'"><img src="images/fblogin-btn.png"></a>'; 	

} else {

    // This user is already validated with Facebook
    // Get user profile data from facebook
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
    
    print_r($userData);

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

// $theuser is a variable set in logitin.php and is the Session email variable
$loggedin = false;

if($theuser) {
  $loggedin = true;
} 

mysqli_select_db($furniture, $database_furniture);

$query_Recordset1 = "SELECT cat_id, cat_name, gethasemailalert(cat_id,'$theuserid') as hasemailalert, getuserid('$theuserid') as userid from `categories` order by cat_name";

// echo "<br />".$query_Recordset1;

$Recordset1 = mysqli_query($furniture, $query_Recordset1) or die(mysql_error());
$row_Recordset1       = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;

mysqli_select_db($furniture, $database_furniture);

$query_Recordset2 = "SELECT cat_id, cat_name, cat_extra, gethastextalert(cat_id,'$theuserid') as hastextalert, getuserid('$theuserid') as userid from `categories`  order by cat_extra DESC, cat_name ASC";

// echo "<br />".$query_Recordset2;

$Recordset2           = mysqli_query($furniture, $query_Recordset2) or die(mysql_error());
$row_Recordset2 	    = $Recordset2->fetch_assoc();
$totalRows_Recordset2 = $Recordset2->num_rows;

?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">


<link rel="icon" type="image/png" href="../images/splash/android-chrome-192x192.png" sizes="192x192">
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
    
<title>My Furniture WishList</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

<link href="../styles/font-awesome.css"    rel="stylesheet" type="text/css">
<link href="../styles/animate.css"         rel="stylesheet" type="text/css">
<link href="../styles/overrides.css"       rel="stylesheet" type="text/css">
<link href="../styles/hamburgers.css"      rel="stylesheet" type="text/css">

<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" src="../scripts/jqueryui.js"></script>
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" src="../scripts/custom.js"></script>
<script type="text/javascript" src="../scripts/stickyfill.js"></script>

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
   }
</script>

<script language="javascript">
function addalerts(cat,user,alerts){
	 
   if(user == 0) {

    $current_list = "";
    cat = "," + cat;
    $current_list = $("#selections").val();     // get the current list value

    // if it's in the list, remove it
    if($current_list.indexOf(cat) > -1) {
        $current_list = $current_list.replace(cat,"");  // append the new category value
    } else {
      // else add it
      $current_list = $current_list + cat;  // append the new category value
    }

    $("#selections").val($current_list);        // update the list

   } else {
     var url = "ajaxupdates.php?talert="+ escape(alerts) +"&catid="+ escape(cat) + "&userid="+ escape(user) +"&type=1";  
     request.open("GET", url , true);
     //alert(url);
     request.onreadystatechange = updatePage();
     request.send(null);
   }
   
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

  // show the login form
  $("#showlogin").click(function(){
      $("#registerform").toggle();
      $("#registerdiv").toggle();
      $("#loginform").toggle();
      $("#logindiv").toggle();
      //$("#formMessages").toggle();
  });

  // show the register form
  $("#showregister").click(function(){
      $("#registerform").toggle();
      $("#registerdiv").toggle();
      $("#loginform").toggle();
      $("#logindiv").toggle();
      //$("#formMessages").toggle();
  });

    var $btns = $('.btn-select').click(function() {
      if (this.id == 'all') {
        $('#parent > div').fadeIn(450);
      } else {
        var $el = $('.' + this.id).fadeIn(450);
        $('#parent > div').not($el).hide();
      }
      $btns.removeClass('active');
      $(this).addClass('active');
    })

    // sticky top navigation
    var stickyNavTop = $('.filter').offset().top;
    var stickyNav = function(){
      var scrollTop = $(window).scrollTop();
            
      if (scrollTop > stickyNavTop) { 
          $('.filter').addClass('sticky');
      } else {
          $('.filter').removeClass('sticky'); 
      }
    };

    // Initialize
    stickyNav();
    
    // assign sticky nav to the browser scroll function
    $(window).scroll(function() {
      stickyNav();
    });


    $('#registerform').submit(function(event){
        // cancels the form submission
        
        event.stopImmediatePropagation();
        event.preventDefault();
        submitRegister();
    });

    $('#loginform').submit(function(event){
        // cancels the form submission
        
        event.stopImmediatePropagation();
        event.preventDefault();
        submitLogin();
    });

  });

  // ToTheTop: when the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          document.getElementById("tothetop").style.display = "block";
      } else {
          document.getElementById("tothetop").style.display = "none";
      }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
      document.body.scrollTop = 0; // For Chrome, Safari and Opera 
      document.documentElement.scrollTop = 0; // For IE and Firefox
  }


function submitRegister(){
    // Initiate Variables With Form Content
    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var carrier = $("#phone_carrier>option:selected").text();
    var password = $("#password").val();
    var selections = $("#selections").val();
    var dataString = "name=" + name + "&email=" + email + "&phone=" + phone + "&phone_carrier=" + carrier + "&password=" + password + "&type=2&selections=" + selections;

    //alert(dataString);

    $.ajax({
        type: "POST",
        url: "ajaxupdates.php",
        data: dataString,
          success : function(text){
            formSuccess();
        }
    })
    .done(function(response) {
        // Make sure that the formMessages div has the 'success' class.
        $('#formMessages').removeClass('error');
        $('#formMessages').addClass('success');

        // Set the message text.
        $('#formMessages').text(response);

        // Clear the form.
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');

        location.reload();
    })
    .fail(function(data) {
        // Make sure that the formMessages div has the 'error' class.
        $('#formMessages').removeClass('success');
        $('#formMessages').addClass('error');

        // Set the message text.
        if (data.responseText !== '') {
            $('#formMessages').text(data.responseText);
        } else {
            $('#formMessages').text('Oops! An error occured and your message could not be sent.');
        }
        //alert("fail");
    });
}
function submitLogin(){
    // Initiate Variables With Form Content
    var username = $("#username").val();
    var password = $("#password").val();
    var selections = $("#selections").val();
    var dataString = "username=" + username + "&password=" + password + "&type=3&selections=" + selections;

    //alert(dataString);

    $.ajax({
        type: "POST",
        url: "ajaxupdates.php",
        data: dataString,
          success : function(text){
            formSuccess();
        }
    })
    .done(function(response) {
        // Make sure that the formMessages div has the 'success' class.
        $('#formMessages').removeClass('error');
        $('#formMessages').addClass('success');

        // Set the message text.
        $('#formMessages').text(response).delay(1500);

        // Clear the form.
        //$('#username').val('');
        //$('#password').val('');

         location.reload();
    })
    .fail(function(data) {
        // Make sure that the formMessages div has the 'error' class.
        $('#formMessages').removeClass('success');
        $('#formMessages').addClass('error');

        // Set the message text.
        if (data.responseText !== '') {
            $('#formMessages').text(data.responseText);
        } else {
            $('#formMessages').text('Oops! An error occured and your message could not be sent.');
        }
        //alert("fail");
    });
}
function formSuccess(){
    $( "#msgSubmit" ).removeClass( "hidden" );
}
</script>
<style type="text/css">
  input:required:focus {
    border: 1px solid red !important;
    outline: none !important;
  }
  .success {
    border: 3px solid green;
    color: green;
  }
  .error {
    border: 3px solid red;
    color: red;
  }
  #formMessages {
    margin: 10px 0;
    padding: 10px;
    text-align: center;
    width: 100%;
  }
  #showregister,
  #showlogin {
    color: #e10e5d;
    background-color: transparent;
    border: 2px solid #e10e5d;
    border-radius: 5px;
    padding: 5px 20px;
    font-weight: 700;
  }
</style>
</head>
<body> 
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-header text-center">
            <img src="../images/myfurniturewishlist_star.png" class="img-fluid" />
            <h1 style="padding-bottom: 15px;">My Furniture Wishlist</h1>
            <p>Manage Wishlist</p>
        </div>
        <div class="col-sm-12 text-center">
            <p>
            Click on the product categories below that interest you to receive alerts for your wishlist. As items are received, you will immediately get a one time notification for each item category that you have selected below. You'll be the first to know! If you want to stop alerts simply come back here and unselect the categories you are done with.
            </p>
            <?php if($loggedin) { ?>
            <p style="color: #000;">You are logged in as <?php echo $theuser; ?>. <a class="" href="logout.php?doLogout=true" style="color: #e10e5d;">Logout</a>.</p>
            <?php } else { ?>
            <p style="color: #000;">Once you are done selecting, scroll down to <a class="" href="#profile" style="color: #e10e5d;">create a profile</a>.</p>
            <?php } ?>
        </div>
        <div class="col-sm-12 text-center filter" id="filter">
            <input type="hidden" name="selections" id="selections" /><br />
            <button class="active btn-select" id="all">Show All</button>
            <button class="btn-select" id="popular">Popular</button>
            <button class="btn-select" id="styles">Styles</button>
            <button class="btn-select" id="more">More</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="parent">
                    <?php
                        $count = 0;
                        do { 
                            // Grab the row data
                            $thecatids=$row_Recordset2['cat_id'];
                            $thecatnames=$row_Recordset2['cat_name'];
                            $thecatstyle=$row_Recordset2['cat_extra'];
                            $thehastextalert=$row_Recordset2['hastextalert'];
                            $thecustids=$row_Recordset2['userid'];

                            if($thehastextalert==0){
                                $showalerts="";
                            } else {
                                $showalerts="tasklist-completed";
                            }

                            // quick check for blanks names (they are supposed to keep track of these but some will slip through no doubt)
                            if($thecatnames!="") {
                              if($theuserid == "") {
                                $theuserid = 0;
                              }
                            ?>
                            <div class="checkbox-list <?php echo $thecatstyle; ?>">
                                <input id="toggle<?php echo $count; ?>" type="checkbox" onClick="addalerts(<?php echo $thecatids ?>,<?php echo $theuserid ?>,2)" <?php if($showalerts) echo "checked"; ?>>
                                <label for="toggle<?php echo $count; ?>"><?php echo $thecatnames ?></label>
                            </div>
                            <a href="#" onClick="addalerts(<?php echo $thecatids ?>,<?php echo $theuserid ?>,2)" class="tasklist-item  <?php echo $showalerts ?>" style="display: none;">
                                <i class="fa fa-check"></i>
                                <h5></h5>
                             </a>                    
                       <?php  }
                       $count++;

                       } while ($row_Recordset2 = $Recordset2->fetch_assoc()); 
                    ?>
        </div>
    </div>
    <div class="row">
        <?php if($loggedin) { ?>
        <div class="col-sm-12 text-center" style="margin: 50px 0;">
            <p><a class="btn-block btn-main btn" href="logout.php?doLogout=true">Logout</a></p>
        </div>
        <?php } else { ?>
        <a name="profile"></a>
        <div class="row pt-4 mt-4">
            <div class="col-sm-12 pt-4 mt-4 text-header text-center">
                <h1 style="padding-bottom: 15px;">Get notified when what you want arrives!</h1>
                <p>Create a Profile or Login</p>
            </div>
            <div class="col-sm-12 text-center" id="registerdiv">
                <p>
                  Enter your name, cell number and select your carrier (email is optional). We'll notify you right away when items in your collections come in. 
                </p>
                <p style="color: #000;">Already registered? <button id="showlogin">Login instead</button></p>
            </div>
            <div class="col-sm-12 text-center" id="logindiv" style="display: none;">
                <p>
                  Enter your cell number and email to login.
                </p>
                <p style="color: #000;">Need to register instead? <button id="showregister">Click here</button></p>
            </div>
        </div>
        <div id="formMessages"></div>
        <form id="registerform" role="form">
          <div class="row">
              <div class="col-sm-12">
                  <div class="form-group">
                      <input type="text" name="name" id="name" class="form-control requiredField requiredEmailField" placeholder="Your Name Please" required />
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <input type="text" name="phone" id="phone" class="form-control requiredField requiredEmailField" placeholder="Enter Your Cell Number as (555) 333-7890" required />
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group" style="margin-bottom: 0px;">
                      <select name="phone_carrier" class="form-control requiredField requiredEmailField" id="phone_carrier">
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
                          <input type="text" name="email" id="email" class="form-control" placeholder="Email Address (optional)" />
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
                      <button class="btn-block btn-main btn" type="submit" id="form-submit">Register</button>
                  </div>
                  <input type="hidden" value="<?php echo $today ?>" name="date" id="date" >
                  <input type="hidden" name="MM_insert" value="form2" id="MM_insert">
              </div>
          </div>
        </form>
        <form id="loginform" role="form" style="display: none; margin-top: 0px;" class="container">
          <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <input class="form-control" id="username" name="username" type="text" placeholder="Phone Number" required />
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <input class="form-control" type="password" id="password" name="password" placeholder="Password is Email" required />
                </div>
              </div>
              <div class="col-sm-12">
                <input class="btn-block btn-main btn" type="submit" value="Log In">
              </div>
              <input name="fname" type="hidden" id="fname">
              <input name="lname" type="hidden" id="lname">
              <input name="uid" type="hidden" id="uid">
              <input name="token" type="hidden" id="token">
              <input name="tries" type="hidden" id="tries" value="<?php $attempts ?>">
          </div>
        </form>
        <?php } ?>
        <div class="col-sm-12">
          <button onclick="topFunction()" id="tothetop" title="Go to top">Top</button>
        </div>
    </div>
</div>

<div class="container">

</div>


</body>