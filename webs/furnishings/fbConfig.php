<?php
//session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '253028625122348'; //Facebook App ID
$appSecret = '7e77f6e64b3e51dea46a9ce66b5b0134'; // Facebook App Secret
$redirectURL = 'http://localhost:8888/cf/product-alerts/webs/furnishings/index.php'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>