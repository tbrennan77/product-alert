<?php
define('SHOPIFY_APP_SECRET', 'c914ffbefc6b075619969316c9243cf1');
function verify_webhook($data, $hmac_header)
{
	$calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
	return ($hmac_header == $calculated_hmac);
}
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$jsonData  = file_get_contents('php://input');
$verified = verify_webhook($jsonData , $hmac_header);
error_log('Webhook verified: '.var_export($verified, true));

//error_log('Webhook data: '.$data);
 //check error.log to see the result
 if($verified==true){
    $host = "localhost";
    $username = "hinklema_bhinkle";
    $password = "052597";
    $dbname = "hinklema_furniture";
    $conn = mysqli_connect($host, $username, $password, $dbname) or die('Error in Connecting: ' . mysqli_error($con));

    

    // read json file
   // $filename = 'empdata.json';
  //  $json = file_get_contents($filename);   

    //convert json object to php associative array
    $data    = json_decode($jsonData);

    // loop through the array
  // $arrSQL     = array();
   $tblName    = "ShopifyProducts";
		$id = $data->id;
		$title=$data->title;
		$bodyhtml=$data->body_html;
		$vendor=$data->vendor;
		$prodtype=$data->product_type;
		$created=$data->created_at;
		$updated=$data->updated_at;
		
		
			foreach ($data->variants as $val) {
				$prices = $val->price;
				$cprices = $val->compare_at_price;
				$qty=$val->inventory_quantity;
				foreach ($data->options as $news){
				$tsrcs=$news->name;
				}
				foreach ($data->images as $newss){
				$tsrc=$newss->src;
				}
				      
				$tmpSQL    = "INSERT INTO " . $tblName . "(id, title, body_html, vendor, product_type, created_at, updated_at, price, compare_at_price, inventory_quantity,src)";
				$tmpSQL   .= " VALUES('$id', '$title', '$bodyhtml', '$vendor','$prodtype','$created','$updated',";
				$tmpSQL   .= "'$prices', '$cprices', '$qty', '$tsrc')";
			
				$arrSQL[]  = $tmpSQL;
			if (mysqli_query($conn, $tmpSQL)) {
     //error_log('New record created successfully');
} else {
    error_log('Error entering shopifyproducts : '. mysqli_error($conn));
}

			}
			
		

mysqli_close($conn);
			// NOW YOU CAN JUST USE IMPLODE TO CREATE THE STRING EQUIVALENT OF THE SQL QUERY:
		//	$strSQL = implode(";\n\n", $arrSQL);
        
        // execute insert query
       
   error_log('Webhook data: '.$tmpSQL);
    
    //close connection
   // mysqli_close($con);
 }
 
?>