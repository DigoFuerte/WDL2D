<?php

// process profile picture upload
if (isset($_POST['upload'])) {

    $has_error = false;

    $file_name = $_FILES["upload_file"]["name"]; 
    $file_tmp_location = $_FILES["upload_file"]["tmp_name"]; 
    $file_type = $_FILES["upload_file"]["type"]; 
    $file_size = $_FILES["upload_file"]["size"]; 
    $file_error_msg = $_FILES["upload_file"]["error"]; 
    $upload_location  = "images";
    $file_path = $upload_location."/".$file_name;

    // $split = explode(".", $file_name); // Split file name into an array using the dot
    // $file_extension = end($split); 

    //* VALIDATION ON SELECTED FILE

    // file not chosen
    if (!$file_name) { 
        $error_file = "Please browse for a file before clicking the upload button.";
        $has_error = true;        
    } 
    // file size > 5 Megabytes (5242880 Byte)
    else if ($file_size > 5242880) { 
        $error_file = "Your file was larger than 5 Megabytes in size.";
        $has_error = true;
        unlink($file_tmp_location);                     
    } 
    // file not of the correct type
    else if (!preg_match("/.(gif|jpg|png|GIF|JPG|PNG)$/i", $file_name) ) {    
        $error_file = "File must be .gif, .jpg, or .png. format!";
        $has_error = true;
        unlink($file_tmp_location);                             
    } 
    // file upload caused an error
    else if ($file_error_msg == 1) { 
        $error_file = "An error occurred while processing the file. Try again.";
        $has_error = true;
    }
    // file already exists
    else if (file_exists($file_path)) {
        $error_file = "The file $file_name exists!.";
        $has_error = true;
        unlink($file_tmp_location); 
    }
    // no validation errors
    if (!$has_error) {
        $move_file = move_uploaded_file($file_tmp_location, $file_path);

        // file move failed
        if (!$move_file) {
            $error_file = "There was a problem uploading your file.";
            $has_error = true;            
        }
        // file move succeeded 
        else {           
            $user_id = $_SESSION['user_details']['user_id'];
            if (update_profile_picture($file_name, $user_id)) {
                header("Location:profile.php");
            }
        }                 
    }
} // end of POST ... upload

// process profile details update
if (isset($_POST['update'])) {
    $has_error = false;

    if (empty($_POST['firstname'])) {
        $error_firstname = "Please enter first name!";
        $has_error = true;    
    } else {
        $firstname = filterUserInput($_POST['firstname']);
    }
                
    if (empty($_POST['lastname'])) {
        $error_lastname = "Please enter last name";
        $has_error = true;    
    } else  {
        $lastname = filterUserInput($_POST['lastname']);
    }

    if (empty($_POST['email'])) {
        $error_email = "Please enter email";
        $has_error = true;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_email = "Please enter valid email";
        $has_error = true;
    } else {
        $email = filterUserInput($_POST['email']);
    }
        
    if(!empty($_POST['password'])) {
        $password = filterUserInput($_POST['password']);
    } 

    //*  Member details
    if (!empty($_POST['street'])) {
        $street = $_POST['street'];
    }

    // required for Member permission
    if (empty($_POST['city'])) {
        $error_city = "City required for Member permission";
        $has_error = true;    
    } else {
        $city = $_POST['city'];
    }

    // required for Member permission
    if (empty($_POST['country'])) {
        $error_city = "Country required for Member permission";
        $has_error = true;    
    } else {
        $country = $_POST['country'];
    }

    if (!empty($_POST['post_code'])) {
        $post_code = $_POST['post_code'];
    }

    if (!empty($_POST['phone'])) {
        $phone = $_POST['phone'];
    }

    if (!empty($_POST['interests'])) {
        $interests = $_POST['interests'];
    }

    # case when no error was found ... update database
    if (!$has_error) {			
        $user_id = $_SESSION['user_details']['user_id'];
        $user_permission = $_SESSION['user_details']['user_permission'];

        // email on the profile page is now READONLY
        // if ($msg = update_profile ($firstname,$lastname, $email, $password, $user_id,
        //                            $street, $city, $country, $post_code, $phone, $interests)) {
        if ($msg = update_profile ($firstname,$lastname, $password, $user_id,
                                   $street, $city, $country, $post_code, $phone, $interests, $user_permission)) {

            // email on the profile page is now READONLY
            // if ($msg == "error_email") {
            //     $error_email = "This email is already taken!";
            //     $has_error = true;
            // } 
            // elseif ($msg == "error_db") {
            if ($msg == "error_db") {
                $msg = "error_db"; 
            } 
            elseif ($msg == "success") {
                $msg = "success";
            }
        } 
    } // End of has_error

}  // end of POST ... update

?> 


