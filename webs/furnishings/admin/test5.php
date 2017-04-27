<?php
$errors         = array();  	// array to hold validation errors
$data 			= array(); 		// array to pass back data
// validate the variables ======================================================
	// if any of these variables don't exist, add an error to our $errors array

// return a response ===========================================================
	// if there are any errors in our errors array, return a success boolean of false
	if ( ! empty($errors)) {
		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {
		// if there are no errors process our form, then return a message
		require_once('Data/furniture.php');
                       $pverbaige=$_POST['verbaige'];
					   $ptype=$_POST['type'];
                       
					  
  $insertSQL = sprintf("INSERT INTO `hinklema_furniture`.`text_emails` (`textinfo`, `type`) VALUES ('$pverbaige', $ptype); ");
 
  mysql_select_db($database_furniture, $furniture);
  $Result1 = mysql_query($insertSQL, $furniture) or die(mysql_error());
	  
		// show a message of success and provide a true success variable
		$data['success'] = true;
		$data['message'] = 'Success!';
	}
	// return all our data to an AJAX call
	echo json_encode($data);
	?>