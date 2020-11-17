<?php
include_once "./php/header.php";
include_once "./php/data_model.php";
include_once "./php/profile_process.php";

// user is not signed in ... send user to sign in page
if (!isset($_SESSION['user_details'])) {
    header("Location:sign_in.php");
}  
// user is signed in
else {
    $user_id = $_SESSION['user_details']['user_id'];

    //* get all user details from database
    $user_details = get_user_details($user_id);

    if (isset($user_details)) {
        extract($user_details);
        $_SESSION['user_details'] = $user_details;
    }
}
?>

<div class="container-fluid bg-div">
    <div class="row">
        <div class="col-md-12 offset-md-0 mt-0 main-section text-center">
        
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 profile-header"></div>
            </div>
            <div class="row user-detail">
                <div class="col-lg-12 col-sm-12 col-12" sign-bg-high>
                    <img src="./image/<?=$profile_picture?>" class="rounded-circle img-thumbnail">
                    <p class="mt-1">
                        <a href="#" id="upload-button" class="btn btn-info btn-sm sign-bg-high">Change Image</a>
                    </p>

                    <!-- image upload form -->
                    <div class="col-md-6 offset-md-3 mt-0" id="upload-image">
                        <span class="anchor" id="formContact"></span>
                        <div class="card-header p-0">

                            <div class="bg-info text-white text-center rounded-top py-2 sign-bg-low">
                             <!-- style="background:#04443C!important;"> -->
                             <h5>
                              <!-- <i class="fas fa-upload" style="color:#C5D984"></i>Upload Profile Image -->
                              <i class="fas fa-upload sign-fg-high"></i> Upload Profile Image
                            </h5>
                            </div> 

                            <!-- <div class="card-body rounded-bottom" style="background: #C5D984;"> -->
                            <div class="card-body rounded-bottom sign-bg-high">
                                <form id="upload-form" name="upload-form" 
                                      enctype="multipart/form-data" method="post" action="">
                                    <div class="form-group">
                                        <label for="upload_file" class="mb-0 sign-txt-white"><strong>Select a file</strong></label>
                                        <?php 
                                        if (isset($error_file)) {
                                            echo "<script>document.getElementById('upload-image').style='display:block';"
                                               . "document.getElementById('upload-button').innerHTML = 'Cancel Upload';"
                                               . "</script>";
                                        ?>
                                        <div class="alert alert-danger" id="upload-error-msg" role="alert">
                                            <strong><?=$error_file; ?> </strong>
                                        </div>
                                        <?php } ?>

                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <!-- <i class="fas fa-upload text-info" style="color:#04443C!important;"></i> -->
                                                    <i class="fas fa-upload text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="file" name="upload_file" id="upload_file" class="form-control"
                                                   placeholder="john.doe@gmail.com">
                                        </div>
                                    </div>

                                    <!-- <button type="submit" style="background:#04443C!important;" id="submit" -->
                                            <!-- name="upload" class="btn-hover btn btn-info btn-block rounded-bottom py-2"> -->
                                    <button type="submit" id="submit"
                                            name="upload" class="btn-hover btn btn-info btn-block rounded-bottom py-2 sign-bg-high">
                                        <h5 style="display:inline;">Upload 
                                            <!-- <i class="fas fa-upload" style="color:#C5D984" aria-hidden="true"></i> -->
                                            <i class="fas fa-upload sign-fg-high" aria-hidden="true"></i>
                                        </h5>
                                    </button>

                                </form>
                            </div><!-- card-body rounded-bottom-->
                        </div><!-- card-header p-0 -->
                    </div><!-- col-md-6 offset-md-3 mt-0 -->
                    <!-- end of image upload form -->

                    <hr class="mt-5">
                    <?php 
                    if (!empty($msg) && $msg == "success") {
                        echo "<div class='container alert alert-success text-center font-weight-bold' role='alert'>"
                           . "Record updated successfully !"
                           . "</div>";
                    } 
                    else if(!empty($msg) && $msg == "error_db") {
                        echo "<div class='container alert alert-danger text-center font-weight-bold' role='alert'>"
                           . "There is a problem updating, please try later!"
                           . "</div>";
                    }
				    ?>

                    <h5><?=ucfirst($firstname)." ". ucfirst($lastname) ;?></h5>
                    <p><i class="fas fa-envelope" aria-hidden="true"></i> <?=$email;?></p>

                    <a href="#" id="update-button" class="btn btn-info btn-sm mb-5 sign-bg-high">Update Profile</a>

                    <!-- profile update  -->
                    <div class="col-md-6 offset-md-3 mt-0 " id="update-profile">
                        <span class="anchor" id="formContact"></span>


                        <div class="card-header p-0">
                            <div class="bg-info text-white text-center rounded-top py-2 sign-bg-low">
                                <h5>
                                    <!-- <i class="fas fa-edit" style="color:#C5D984" aria-hidden="true"></i> -->
                                    <i class="fas fa-edit sign-fg-high" aria-hidden="true"></i>Update Profile
                                </h5>
                            </div>
                            <!-- <div class=" card-body rounded-bottom text-left" style="background: #C5D984; "> -->
                            <div class=" card-body rounded-bottom text-left sign-bg-high">
                                <form class="form" action="" method="post" role="form">

                                    <!-- FIRST NAME FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>First Name</strongs></label>
                                        <?php 
                                        if (isset($error_firstname)) {                                
                                            echo "<script>document.getElementById('update-profile').style='display:block';"
                                               . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                               . "</script>";                                
                                        ?>
                                        <div class="alert alert-danger" role="alert" id="error_firstname">
                                            <strong>Oh snap! <?=$error_firstname; ?></strong>
                                        </div>
                                        <?php } ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <!-- <i class="fa fa-user text-info" style="color:#04443C!important;"></i> -->
                                                    <i class="fa fa-user text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="firstname" id="firstname" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   value="<?php if(isset($firstname)) echo $firstname;?>"
                                                   placeholder="John">
                                        </div>
                                    </div>

                                    <!-- LAST NAME FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Last Name</strongs></label>
                                            <?php if(isset($error_lastname)) {
                                                echo "<script>document.getElementById('update-profile').style='display:block';"
                                                   . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                                   . "</script>";
                                            ?>
                                        <div class="alert alert-danger" role="alert" id="error_lastname">
                                            <strong>Oh snap! <?=$error_lastname; ?></strong>
                                        </div>
                                        <?php } ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <!-- <div class="input-group-text"><i class="fa fa-user text-info"
                                                     style="color:#04443C!important;"></i> -->
                                                <div class="input-group-text"><i class="fa fa-user text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="lastname" id="lastname" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   value="<?php if(isset($lastname) )echo $lastname;?>" placeholder="Doe">
                                        </div>
                                    </div>

                                    <!-- EMAIL FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="email" class="mb-0 sign-txt-white"><strong>Email</strong></label>
                                        <?php if (isset($error_email)) {
                                            echo "<script>document.getElementById('update-profile').style='display:block';"
                                               . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                               . "</script>";
                                        ?>
                                        <div class="alert alert-danger" role="alert" id="error_email">
                                            <strong><?=$error_email; ?> </strong>
                                        </div>
                                        <?php } ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <!-- <i class="fa fa-envelope text-info" style="color:#04443C!important;"></i> -->
                                                    <i class="fa fa-envelope text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input readonly type="text" name="email" id="email" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   value="<?php if(isset($email)) echo $email;?>"
                                                   aria-describedby="emailHelp" placeholder="john.doe@gmail.com">
                                            <!-- aria-describedby="emailHelp" ... not fully implemented ... assistive technology -->
                                            <!-- <div id="emailHelp">Deescriptive info about email</div> -->
                                        </div>
                                    </div>

                                    <!-- PASSWORD FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="password" class="mb-0 sign-txt-white"><strong>Password</strong></label>
                                        <?php if(isset($error_password)){
                                            echo "<script>document.getElementById('update-profile').style='display:block';"
                                               . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                               . "</script>";
                                        ?>
                                        <div class="alert alert-danger" role="alert" id="error_password">
                                            <strong><?=$error_password; ?> </strong>
                                        </div>
                                        <?php } ?>

                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <!-- <i class="fa fa-lock" style="color:#04443C!important;"></i> -->
                                                    <i class="fa fa-lock sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="password" name="password" id="password" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   aria-describedby="passwordHelp" placeholder="********">
                                            <!-- aria-describedby="passwordHelp" ... not fully implemented ... assistive technology -->
                                            <!-- <div id="passwordHelp">Deescriptive info about passwrod</div> -->
                                        </div>
                                    </div>


                                    <!-- MEMBER DETAILS SECTION -->
                                    <div class="bg-info text-white text-center rounded-top py-2 sign-bg-high">
                                        <h6>
                                            <i class="far fa-address-card sign-fg-high" aria-hidden="true"></i> Member Details
                                        </h6>
                                    </div>

                                    <!-- STREET NAME FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Street</strongs></label>
                                        <!-- NO ERROR HANDLING CODE ... field is not mandatory -->
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="street" id="street" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Optional information"
                                                   value="<?php if(isset($street)) echo $street;?>"
                                                   placeholder="28b Albion Street">
                                        </div>
                                    </div>

                                    <!-- CITY FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>City</strongs></label>
                                        <!-- ERROR HANDLING NEEDED ... field required for Member permission -->
                                        <?php 
                                        if (isset($error_city)) {                                
                                            echo "<script>document.getElementById('update-profile').style='display:block';"
                                               . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                               . "</script>";                                
                                        ?>
                                        <div class="alert alert-warning" role="alert" id="error_city">
                                            <strong>Warning! <?=$error_city; ?></strong>
                                        </div>
                                        <?php } ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="city" id="city" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   value="<?php if(isset($city)) echo $city;?>"
                                                   placeholder="Brownsville">
                                        </div>
                                    </div>

                                    <!-- COUNTRY FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Country</strongs></label>
                                        <!-- ERROR HANDLING NEEDED ... field required for Member permission -->
                                        <?php 
                                        if (isset($error_country)) {                                
                                            echo "<script>document.getElementById('update-profile').style='display:block';"
                                               . "document.getElementById('update-button').innerHTML = 'Cancel Update';"
                                               . "</script>";                                
                                        ?>
                                        <div class="alert alert-warning" role="alert" id="error_city">
                                            <strong>Warning! <?=$error_country; ?></strong>
                                        </div>
                                        <?php } ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="country" id="country" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Needed for Member access"
                                                   value="<?php if(isset($country)) echo $country;?>"
                                                   placeholder="Drapetomania">
                                        </div>
                                    </div>

                                    <!-- POST CODE FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Post Code</strongs></label>
                                        <!-- NO ERROR HANDLING CODE ... field is not mandatory -->
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-map-marker-alt text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="post_code" id="post_code" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Optional information"
                                                   value="<?php if(isset($post_code)) echo $post_code;?>"
                                                   placeholder="6NE 5J">
                                        </div>
                                    </div>

                                    <!-- PHONE FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Phone</strongs></label>
                                        <!-- NO ERROR HANDLING CODE ... field is not mandatory -->
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                   data-toggle="tooltip" data-placement="bottom" title="Optional information"
                                                   value="<?php if(isset($phone)) echo $phone;?>"
                                                   placeholder="07845 234183">
                                        </div>
                                    </div>

                                    <!-- INTERESTS FORM-GROUP -->
                                    <div class="form-group">
                                        <label for="name" class="mb-0 sign-txt-white"><strong>Interests</strongs></label>
                                        <!-- NO ERROR HANDLING CODE ... field is not mandatory -->
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="far fa-comments text-info sign-fg-low"></i>
                                                </div>
                                            </div>
                                            <!-- 
                                            <input type="text" name="interests" id="interests" class="form-control"
                                                   value="<?php if(isset($interests)) echo $interests;?>"
                                                   placeholder="Topics of interest"> 
                                            -->
                                            <textarea name="interests" id="interests" class="form-control rounded-0" rows="5"
                                                      data-toggle="tooltip" data-placement="bottom" title="Optional information"
                                                      placeholder="Topics of interest"><?php if(isset($interests)) echo $interests;?></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- SUBMIT BUTTON -->
                                    <button type="submit" id="update"
                                            name="update" class="btn-hover btn btn-info btn-block rounded-bottom py-2 sign-bg-high">
                                        <h5 style="display:inline;">Update 
                                            <!-- <i class="fas fa-edit" style="color:#C5D984" aria-hidden="true"></i> -->
                                            <i class="fas fa-edit sign-fg-high" aria-hidden="true"></i>
                                        </h5>
                                    </button>

                                </form>
                            </div>

                        </div>
                    </div> <!-- card-header p-0  -->
                </div> <!-- col-md-6 offset-md-3 mt-0   -->

                <!-- end of profile update  -->
                
            </div><!-- col-lg-12 col-sm-12 col-12-->
        </div><!-- row user-detail-->
    </div><!-- col-md-12-->
</div> <!-- row-->
</div> <!-- container-->

<?php  
include_once "./php/footer.php";
?>