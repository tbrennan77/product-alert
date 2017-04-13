<?php
//session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 

 Test App
 */
$appId = '253028625122348'; //Facebook App ID
$appSecret = '7e77f6e64b3e51dea46a9ce66b5b0134'; // Facebook App Secret
$redirectURL = 'http://localhost:8888/cf/product-alerts/webs/furnishings/index.php'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

// Production
//$appId = '253028058455738'; //Facebook App ID
//$appSecret = 'ba5138604f27dff00258bd5d8e4c39d0'; // Facebook App Secret
//$redirectURL = 'http://www.myfurniturewishlist.com/index.php'; // Callback URL
//$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>