<?php
include_once "./php/Permissions.php";

function get_all_featured_products () {
	global $conn;
	$featured = 1;

	$sql = "SELECT * FROM products WHERE featured=?";

	if ($stmt_obj = mysqli_prepare($conn,$sql)) {	
		mysqli_stmt_bind_param($stmt_obj, 'i',$featured);
		mysqli_stmt_execute($stmt_obj);
		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if(mysqli_num_rows($result_obj)>0){
			$product_data = mysqli_fetch_all($result_obj, MYSQLI_ASSOC);
			return $product_data;
		} 
		else {
			return FALSE;
		}
	}
} // end of function get_all_featured_products()

function get_all_non_featured_products () {
	global $conn;
	$featured = 0;

	$sql = "SELECT * FROM products WHERE featured=?";

	if ($stmt_obj = mysqli_prepare($conn, $sql)){
	
	mysqli_stmt_bind_param($stmt_obj, 'i',$featured);

	 mysqli_stmt_execute($stmt_obj);
	 $result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj)>0) {
			$product_data = mysqli_fetch_all($result_obj, MYSQLI_ASSOC);
			return $product_data;
		} 
		else {
			return FALSE;
		}
	}
} // end of function get_all_non_featured_products()

function get_all_products () {
	global $conn;
	$sql = "SELECT * FROM products";

	if($stmt_obj = mysqli_prepare($conn,$sql)){

	 mysqli_stmt_execute($stmt_obj);
	 $result_obj = mysqli_stmt_get_result($stmt_obj);

		if(mysqli_num_rows($result_obj)>0){
			$product_data = mysqli_fetch_all($result_obj, MYSQLI_ASSOC);
			return $product_data;
		} 
		else {
			return FALSE;
		}
	}
} // end of function get_all_products()

function check_email_already_exists ($email) {
	global $conn;
	$sql = "SELECT * FROM users WHERE email= ?";
   
	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 's', $email);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj) > 0) {  
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}
} // end of function check_email_already_exists()

function get_product_by_id ($product_id) {
	global $conn;
	$sql = "SELECT * FROM products WHERE id=?";

	if ($stmt_obj = mysqli_prepare($conn,$sql)) {
		mysqli_stmt_bind_param($stmt_obj, 's', $product_id);
		mysqli_stmt_execute($stmt_obj);
		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj)>0) {
			return mysqli_fetch_assoc($result_obj);			
		} 
		else {
			return FALSE;
		}
	}
} // edn of function get_product_by_id()

function register_user ($firstname, $lastname, $email, $password) {
	global $conn;
  //* encrypt the password.
	$password = sha1($password);

	$sql = "INSERT INTO users(firstname, lastname, email, password)
	        VALUES(?, ?, ?, ?)";

	if($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 'ssss',$firstname, $lastname, $email, $password);
		mysqli_stmt_execute($stmt_obj);

		if (mysqli_affected_rows($conn)>0) {
		 return TRUE;
		} else {
		 return FALSE;
		}
	}	             
} // end of function register_user()

//? login page
function login_user ($email, $password) {
	global $conn;
	$user_details =[];
	$password = sha1($password);

	//! change this select staement to match pex table
	// $sql=  "SELECT user_id, firstname, lastname, email, profile_picture 
	$sql=  "SELECT user_id,
                 user_permissions,
                 firstname,
                 lastname,
                 email,
                 password,
                 street,
                 city,
                 profile_done,
                 country,
                 post_code,
                 phone,
                 profile_picture,
                 interests 
	        FROM users WHERE email= ? AND password= ? ";

	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 'ss', $email, $password);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj) > 0) {
			$user_details = mysqli_fetch_assoc($result_obj);
			return $user_details;
		} 
		else {
			return FALSE;
		}
	}
} // end of function login_user()

//? profile page
function get_user_details ($user_id) {
	global $conn;  
	// $sql = "SELECT * FROM users WHERE user_id=? ";
	$sql=  "SELECT user_id,
                 user_permissions,
                 firstname,
                 lastname,
                 email,
                 password,
                 street,
                 city,
                 profile_done,
                 country,
                 post_code,
                 phone,
                 profile_picture,
                 interests 
	        FROM users WHERE user_id= ?";

	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 's', $user_id);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);
				
		if (mysqli_num_rows($result_obj)>0) {
			$user_details = mysqli_fetch_assoc($result_obj);
		}
		else{
			echo "No user found";
		}								
		return $user_details;
   }
} // end of function get_user_details()


//* profile image update
function update_profile_picture ($file_name, $user_id) {
	global $conn;
	$sql = "UPDATE users SET profile_picture = ? WHERE user_id = ?";

	if($stmt_obj = mysqli_prepare($conn, $sql)){
		mysqli_stmt_bind_param($stmt_obj, 'ss',$file_name, $user_id);
		mysqli_stmt_execute($stmt_obj);

		if (mysqli_affected_rows($conn)>0) { 
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}
} // end of function update_profile_picture ()

//* update user profile 
// if ($msg = update_profile ($firstname,$lastname, $password, $user_id,
//                            $street, $city, $country, $post_code, $phone, $interests)) {
// function update_profile ($firstname, $lastname, $email, $password, $user_id) {
function update_profile ($firstname,$lastname, $password, $user_id,
                         $street, $city, $country, $post_code, $phone, $interests, $user_permissions) {
	global $conn;  
	$counter = 0;

  	// update password 
  	if (isset($password) && !empty($password)) {

			//* encrypt the password entered 
			$password = sha1($password);
			
			$sql = "UPDATE users
							SET  password = ?
							WHERE user_id = ?";
							
			if ($stmt_obj = mysqli_prepare($conn, $sql)) {
					mysqli_stmt_bind_param($stmt_obj, 'ss', $password, $user_id);
					mysqli_stmt_execute($stmt_obj);
					$counter++;          
			}                

    }
		
		// email is now READONLY on the profile page
    // if (check_same_email_exists_for_other_user($email, $user_id)) {
	  //  		return "error_email";
		// } 
		// else {
		// 		$email = $email;
		// }

		$memberDetailsUpdateError = "";

    //* update all other fields  
    if (isset($firstname) && !empty($firstname) && 
        isset($lastname) && !empty($lastname) && 
				// isset($email) && !empty($email) &&
				isset($city) && !empty($city) &&
				isset($country) && !empty($country) ) { 
        
        $sql = "UPDATE users 
								SET firstname=?, lastname=?, street=?, city=?, country=?, post_code=?, phone=?, interests=?, profile_done=?								
                WHERE user_id=?";
                
				if ($stmt_obj = mysqli_prepare($conn, $sql)) {
					$profile_done = TRUE;
					mysqli_stmt_bind_param($stmt_obj, 'ssssssssss', $firstname, $lastname, $street, $city, $country, $post_code, $phone, $interests, $profile_done, $user_id);
					mysqli_stmt_execute($stmt_obj);					
					$counter++;

					//* profile update completed with no error
					if ( (mysqli_stmt_errno($stmt_obj) == 0) ) {
						// update user permission with the Member Permission

						$user_permissions_obj = new Permissions($user_permissions);
						
						if (! $user_permissions_obj->IsGuest() ) {
							$user_permissions = $user_permissions_obj->addPermission(Permissions::Guest);
						}

						if (! $user_permissions_obj->IsMember() ) {
							$user_permissions = $user_permissions_obj->addPermission(Permissions::Member);
						}

						$sql = "UPDATE users SET user_permission=? WHERE user_id=?";
						if ($stmt_obj = mysqli_prepare($conn, $sql)) {
							mysqli_stmt_bind_param($stmt_obj, 'ss', $user_permissions, $user_id);
							mysqli_stmt_execute($stmt_obj);					
						}
					}
					else {
						$memberDetailsUpdateError = mysqli_stmt_esqlstate($stmt_obj);
					}
        }      
		}
    
		if ($counter > 0) {
			return "success";
		} 
		else {
			return "error_db";
		}

} //end of function update_profile()

function check_same_email_exists_for_other_user($email, $user_id){
	global $conn;
	$sql = "SELECT * FROM users WHERE email= ? AND user_id !=?";
	
	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 'ss',$email, $user_id);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj) > 0) {  
			return TRUE;
		} 
		else {
			return FALSE;
		}	
  } 
}

//? DATA INTERACTIONS FOR pex.user_media TABLE
// copyright       VARCHAR(50)  NULL,
// apod_date       VARCHAR(20)  NULL,
// explanation     VARCHAR(512) NULL,
// hdurl           VARCAHR(128) NULL,
// media_type      VARCHAR(10)  NULL,
// service_version VARCAHR(10)  NULL,
// title           VARCAHR(50)  NULL,
// url             VARCAHR(128) NULL,

//! DEFUNCT
//* function to check url NOT in db
function media_exists ($hdurl) {
	global $conn;
	$sql = "SELECT * FROM user_media WHERE hdurl= ?";
	
	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, 's', $hdurl);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj) > 0) {  
			return TRUE;
		} 
		else {
			return FALSE;
		}	
  } 
}

//! DEFUNCT
//* function to save media data in db ... user id (member perm) required
function save_user_media ($copyright,
                          $apod_date,
                          $explanation,
                          $hdurl,
                          $media_type,
                          $service_version,
                          $title,
													$url) {
													// ,$flag) {
	if ( !isset($_SESSION['user_details']['user_id']) ) {
		echo "User not logged in";
	}
	else {
		$user_id = $_SESSION['user_details']['user_id'];
	}

	global $conn;
	// $sql = "CALL sp_save_user_media (user_id,copyright,apod_date,explanation,hdurl,media_type,service_version,title,url,flag,@returnStatus)";
	// $sql = "CALL sp_save_user_media (user_id,copyright,apod_date,explanation,hdurl,media_type,service_version,title,url,flag)";
	$sql = "CALL sp_save_user_media (?,?,?,?,?,?,?,?,?)";

	if ( $stmt_obj = mysqli_prepare($conn, $sql) ) {

		// mysqli_stmt_bind_param($stmt_obj,'sssssssss',$user_id,$copyright,$apod_date,$explanation,$hdurl,$media_type,$service_version,$title,$url,$flag);
		mysqli_stmt_bind_param($stmt_obj,'issssssss',$user_id,$copyright,$apod_date,$explanation,$hdurl,$media_type,$service_version,$title,$url);
													 
		mysqli_stmt_execute($stmt_obj);

		// get return status from procedure session variable
		//* currently, @returnStatus not being used
		//$sql = "SELECT @returnStatus";
		//$result = mysqli_query($con, $sql);
		//$row = mysqli_fetch_row($result);
		// echo $row[0]; // should contain the user_media_link_id INT(10)

		if (mysqli_affected_rows($conn)>0) {
		 return TRUE;
		} 
		else {
		 return FALSE;
		}
	}	             
} // end of function save_user_media()

//* function to get media data BY user_id
function get_user_media_id () {
	if ( !isset($_SESSION['user_details']['user_id']) ) {
		echo "User not logged in";
	}
	else {
		$user_id = $_SESSION['user_details']['user_id'];
	}

	global $conn;
	// $sql = "SELECT * FROM user_media WHERE user_id= ?";
	$sql = "CALL sp_get_user_media(?)";

	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		// mysqli_stmt_bind_param($stmt_obj, 'i', $user_id);
		mysqli_stmt_bind_param($stmt_obj, 's', $user_id);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj)>0) {
			// return mysqli_fetch_assoc($result_obj);
			return mysqli_fetch_all($result_obj, MYSQLI_ASSOC);
		}
		else {
			echo "No user media found";
		}										
  } 
}

//* function to get all media data
function get_user_media_all () {
	global $conn;
	$sql = "SELECT * FROM user_media";
	
	if ($stmt_obj = mysqli_prepare($conn, $sql)) {
		mysqli_stmt_bind_param($stmt_obj, '', $user_id);
		mysqli_stmt_execute($stmt_obj);

		$result_obj = mysqli_stmt_get_result($stmt_obj);

		if (mysqli_num_rows($result_obj)>0) {
			return mysqli_fetch_assoc($result_obj);
		}
		else{
			echo "No user media found";
		}								
  } 
}

?>
