<?php
include_once "./php/header.php";
include_once "./php/data_model.php";

// user is logged in... go to the profile page
if (isset($_SESSION['user_details'])) {
    header("Location:profile.php");
}

$has_error = false;

//* registration details are being posted back to the form
if (isset($_POST['signup'])) {

    // validate user first name
    if (empty($_POST['firstname']))  {
        $error_firstname = "Please enter first name!";
        $has_error = true;
    } 
    else {
        $firstname = filterUserInput($_POST['firstname']);
    }

    // validate user last name
    if (empty($_POST['lastname'])) {
        $error_lastname = "Please enter last name";
        $has_error = true;    
    } 
    else  {
        $lastname = filterUserInput($_POST['lastname']);
    }

    // validate user email
    if (empty($_POST['email'])) {
        $error_email = "Please enter email";
        $has_error = true;
    }        
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_email = "Please enter valid email";
        $has_error = true;    
    } 
    else if (check_email_already_exists($_POST['email'])) {
        $error_email ="Sorry This email already exists!";
        $has_error = true;
    }         
    else {
        $email = filterUserInput($_POST['email']);
    }

    // validate user password        
    if (empty($_POST['password'])) {
        $error_password= "Please enter password";
        $has_error = true;    
    } 
    else  {
        $password = filterUserInput($_POST['password']);
    }
    
    // validation successfully completed 
	if (!$has_error) {       
        if (register_user($firstname, $lastname, $email, $password)) {            
            $msg = "success";   
        } 
        else {
            $msg = "error_db";
        } 
        
        // whether or not registration was successful,
        // return user to the sign in page
        header("Location:sign_in.php?action=$msg");							
	}
}
?>

<div class="container-fluid bg-div" style="padding-top:100px; padding-bottom:100px;">
    <div class="col-md-6 offset-md-3 mt-0 ">
        <span class="anchor" id="formContact"></span>

        <div class="card-header p-0">
            <div class="bg-info text-white text-center rounded-top py-2 sign-bg-high">
                <h3><i class="fa fa-user sign-fg-med" aria-hidden="true"></i>Sign Up</h3>
            </div>
            <div class=" card-body rounded-bottom sign-bg-low">

                <form class="form" action="" method="post" role="form">

                    <!-- form-group for FIRST NAME -->
                    <div class="form-group">
                        <label for="name" class="mb-0 "><strong>First Name</strongs></label>
                        <?php if (isset($error_firstname)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap! <?=$error_firstname; ?></strong>
                        </div>
                        <?php } ?>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-user text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <input type="text" name="firstname" id="firstname" class="form-control"
                                value="<?php if(isset($firstname))echo $firstname;?>" placeholder="John">
                        </div>
                    </div>

                    <!-- form-group for LAST NAME -->
                    <div class="form-group">
                        <label for="name" class="mb-0 "><strong>Last Name</strongs></label>
                        <?php if (isset($error_lastname)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap! <?=$error_lastname; ?></strong>
                        </div>
                        <?php } ?>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-user text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <input type="text" name="lastname" id="lastname" class="form-control"
                                value="<?php if (isset($lastname) )echo $lastname; ?>" placeholder="Doe">
                        </div>
                    </div>

                    <!-- form-group for EMAIL -->
                    <div class="form-group">
                        <label for="email" class="mb-0"><strong>Email</strong></label>
                        <?php if(isset($error_email)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?=$error_email; ?> </strong>
                        </div>
                        <?php } ?>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-envelope text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <input type="text" name="email" id="email" class="form-control"
                                value="<?php if (isset($email)) echo $email; ?>" aria-describedby="emailHelp"
                                placeholder="john.doe@gmail.com">
                        </div>
                    </div>

                    <!-- form-group for PASSWORD -->
                    <div class="form-group">
                        <label for="password" class="mb-0"><strong>Password</strong></label>
                        <?php if (isset($error_password)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?=$error_password; ?> </strong>
                        </div>
                        <?php } ?>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-lock sign-fg-low"></i>
                                </div>
                            </div>
                            <input type="password" name="password" id="password" class="form-control"
                                value="<?php if (isset($password))echo $password; ?>" aria-describedby="emailHelp"
                                placeholder="********">
                        </div>
                    </div>

                    <!-- form-group for FORM BUTTON ... name passed to $_POST -->
                    <button type="submit" id="signup" name="signup"
                        class="btn-hover btn btn-info btn-block rounded-bottom py-2 sign-bg-high">
                        <h3 style="display:inline;">Sign up <i class="fas fa-sign-in-alt sign-fg-high" aria-hidden="true"></i>
                        </h3>
                    </button>
                    
                    <!-- case when user has already registered with the website -->
                    <p class="text-center mt-2 mb-0"><strong>Already signed up?</strong>
                        <a href="sign_in.php"><strong>Sign in</strong></a>
                    </p>

                </form>
            </div>
        </div>
    </div>

</div>

<?php
include_once "./php/footer.php";
?>