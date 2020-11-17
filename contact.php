<?php
include_once "./php/header.php";
include_once "./php/contact_process.php";

// user is not signed in ... send user to sign in page
if (! isset($_SESSION['user_details'])) {
    header("Location:sign_in.php");
}  
else if (! HasMemberAccess($_SESSION['user_details']['user_permissions']) ) {
    header("Location:profile.php");
}
?>

<div class="container-fluid bg-div" style="padding-top:100px; padding-bottom:100px;">

    <?php 
    if (isset($confirm_msg)) {
       echo $confirm_msg;
        unset($name);
        unset($email);
        unset($message);
       }
    ?>
    <div class="col-md-6 offset-md-3">
        <span class="anchor" id="formContact"></span>

        <div class="card-header p-0">
            <div class="bg-info text-white text-center rounded-top py-4 sign-bg-high">
                <h3><i class="fa fa-envelope sign-fg-high"></i> Contact Us</h3>
            </div>
            <div class="card-body rounded-bottom sign-bg-low">
                <form class="form" action="" method="post" role="form" autocomplete="off">

                    <div class="form-group">
                        <label for="name" class="mb-0 ">Name</label>
                        <?php if(isset($error_name)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap! <?=$error_name; ?></strong>
                        </div>
                        <?php } ?>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-user text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="<?php if(isset($name))echo $name;?>" placeholder="John Doe">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="mb-0">Email</label>
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
                                   value="<?php if(isset($email))echo $email;?>" aria-describedby="emailHelp"
                                   placeholder="john.doe@gmail.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason" class="mb-0">Reason</label>

                        <?php if(isset($error_reason)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?=$error_reason; ?> </strong>
                        </div>
                        <?php } ?>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-tag prefix text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <select class="form-control" id="reason" name="reason">
                                <option value="" disabled selected> Select</option>
                                <option value="About Site"> About Site </option>
                                <option value="About Tutorial"> About Tutorial</option>
                                <option value="Other"> Other </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="mb-0">Message</label>
                        <?php if(isset($error_message) && !empty($error_message)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong> <?=$error_message; ?></strong>
                        </div>
                        <?php } ?>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-comment text-info sign-fg-low"></i>
                                </div>
                            </div>
                            <textarea rows="6" name="message" id="message" class="form-control"
                                      placeholder="Write your message here.."><?php if(isset($message))echo "$message"?>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-check small">
                        <label for="send_copy" class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="Yes" id="send_copy" name="send_copy">
                            <span> <b>Send me a copy</b> </span>
                        </label>
                    </div>
                    <br>
                    <button type="submit" id="submit" name="submit"
                            class="btn btn-info btn-block rounded py-3 sign-bg-high">Send Message <i class="fa fa-paper-plane"
                            aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <!-- /form user info -->
    </div>
</div>
<?php
include_once "./php/footer.php";	
?>