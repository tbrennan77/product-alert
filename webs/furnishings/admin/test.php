<?php
$errors         = array();  	// array to hold validation errors
$data 			= array(); 		// array to pass back data
// validate the variables ======================================================
	// if any of these variables don't exist, add an error to our $errors array
	if (empty($_POST['username']))
		$errors['username'] = $_POST['username'];
		if (empty($_POST['password']))
		$errors['password'] = $_POST['password'];
		if (empty($_POST['clientid']))
		$errors['clientid'] = $_POST['clientid'];
	if (empty($_POST['clientid']))
		$errors['clientid'] = $_POST['clientid'];
	if (empty($_POST['firstname']))
		$errors['firstname'] = $_POST['firstname'];
	if (empty($_POST['lastname']))
		$errors['lastname'] = 'lastname is required.';
	if (empty($_POST['phone']))
		$errors['phone'] = 'phone is required.';
	if (empty($_POST['phone_carrier']))
		$errors['phone_carrier'] = 'phone_carrier is required.';
	if (empty($_POST['email']))
		$errors['email'] = 'email is required.';
// return a response ===========================================================
	// if there are any errors in our errors array, return a success boolean of false
	if ( ! empty($errors)) {
		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {
		// if there are no errors process our form, then return a message
		require_once('Data/furniture.php');
                       
					   $pusername=$_POST['username'];
					   $ppassword=$_POST['password'];
                       $pfname=$_POST['firstname'];
					   $plname=$_POST['lastname'];
					   $pemail=$_POST['email'];
					   $phone=$_POST['phone'];
					   $dpate=$_POST['date'];
					   $pphonecarrier=$_POST['phone_carrier'];
					   $pclientid=$_POST['clientid'];
   
	   
		
  $insertSQL = sprintf("update `clients` set username='$pusername', password='$ppassword', fname='$pfname', lname='$plname', email='$pemail', phone='$phone', changedate='$dpate', phone_carrier='$pphonecarrier' where clientid=$pclientid");
 
  mysql_select_db($database_furniture, $furniture);
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error());
	  
		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success!';
	}
	// return all our data to an AJAX call
	echo json_encode($data);
	?>