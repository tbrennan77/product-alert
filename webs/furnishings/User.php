<?php
class User {
	private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "harley77";
    private $dbName     = "hinklema_furniture";
	private $userTbl    = 'clients';
	
	function __construct(){
		if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
	}
	
	function checkUser($userData = array()){
		if(!empty($userData)){
			//Check whether user data already exists in database

			// Check the Users table
			$prevQuery = "SELECT * FROM ".$this->userTbl." 
						  WHERE oauth_provider = '".$userData['oauth_provider']."' 
						  AND oauth_uid = '".$userData['oauth_uid']."'";
			$prevResult = $this->db->query($prevQuery);

			echo $prevResult->num_rows."<br />";

			// Check the Clients table
			//$user_check_query = "SELECT * FROM clients WHERE tokenid = '".$userData['oauth_uid']."' ";
			//$user_check = $this->db->query($user_check_query);

			//echo $user_check->num_rows."<br />";

			// If the user is not in the database then add them to the clients table
			//if($prevResult->num_rows > 0 || $user_check->num_rows == 0) {
			//	$query = "INSERT INTO clients SET 
			//		Fname = '".$userData['first_name']."', 
			//		Lname = '".$userData['last_name']."', 
			//		email = '".$userData['email']."', 
			//		username = '".$userData['email']."', 
			//		facebook = '".$userData['link']."', 
			//		tokenid = '".$userData['oauth_uid']."'";
			//	$insert = $this->db->query($query);

			//	echo $query;
			//}

			if($prevResult->num_rows > 0){
				//Update user data if already exists
				$query = "UPDATE ".$this->userTbl." 
					SET first_name = '".$userData['first_name']."', 
						last_name = '".$userData['last_name']."', 
						email = '".$userData['email']."', g
						ender = '".$userData['gender']."', 
						locale = '".$userData['locale']."', 
						picture = '".$userData['picture']."', 
						link = '".$userData['link']."', 
						oauth_provider = '".$userData['oauth_provider']."', 
						oauth_uid = '".$userData['oauth_uid']."', 
						email = '".$userData['email']."', 
						gender = '".$userData['gender']."', 
						locale = '".$userData['locale']."', 
						picture = '".$userData['picture']."', 
						link = '".$userData['link']."', 
						modified = '".date("Y-m-d H:i:s")."'
					WHERE 
						oauth_provider = '".$userData['oauth_provider']."' 
					AND oauth_uid = '".$userData['oauth_uid']."'";
				$update = $this->db->query($query);
				echo $query;

			} else {

				//Insert user data
				$query = "INSERT INTO ".$this->userTbl." SET 
							oauth_provider = '".$userData['oauth_provider']."', 
							oauth_uid = '".$userData['oauth_uid']."', 
							Fname = '".$userData['first_name']."', 
							Lname = '".$userData['last_name']."', 
							email = '".$userData['email']."', 
							username = '".$userData['email']."', 
							gender = '".$userData['gender']."', 
							locale = '".$userData['locale']."', 
							picture = '".$userData['picture']."',  
							link = '".$userData['link']."', 
							modified = '".date("Y-m-d H:i:s")."',
							created = '".date("Y-m-d H:i:s")."'";
				$insert = $this->db->query($query);

				echo $query;
			}
			
			//Get user data from the database
			$result = $this->db->query($prevQuery);
			$userData = $result->fetch_assoc();

			$_SESSION['MM_Username'] = $userData['username'];
		}
		
		
		//Return user data
		return $userData;
	}
}
?>