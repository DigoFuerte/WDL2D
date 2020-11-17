<?php
include_once "header.php";
include_once "contact_process.php";
?>

<hr class="my-5">

<?php 

?>

<main role="??? web page content ???">

    <div class="col-md-6 offset-md-3">

        <span class="anchor" id="formContact"></span>

        <div class="card-header p-0">

            <div class="bg-info text-white text-center py-2">
                <h3><i class="fa fa-envelope"></i> Contact Us</h3>
                <p class="m-0">Form to DB & Email</p>
            </div>
            
            <div class="card-body">
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
                                <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                            </div>
                            <input type="text" name="name" id="name" class="form-control"
                                value="<?php if(isset($name))echo $name;?>" placeholder="John Doe">
                        </div>
                    </div>

                    <label for="email" class="mb-0">Email</label>
                    <?php if(isset($error_email)){?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?=$error_email; ?> </strong>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                            </div>
                            <input type="text" name="email" id="email" class="form-control"
                                value="<?php if(isset($email))echo $email;?>" aria-describedby="emailHelp"
                                placeholder="john.doe@gmail.com">
                        </div>
                    </div>

                    <label for="reason" class="mb-0">Reason</label>
                    <?php if(isset($error_reason)){?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?=$error_reason; ?> </strong>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-tag prefix text-info"></i></div>
                            </div>
                            <select class="form-control" id="reason" name="reason">
                                <option value="" disabled selected> Select</option>
                                <option value="About Site"> About Site </option>
                                <option value="About Tutorial"> About Tutorial</option>
                                <option value="Other"> Other </option>
                            </select>
                        </div>
                    </div>

                    <label for="message" class="mb-0">Message</label>
                    <?php if(isset($error_message) && !empty($error_message)){?>
                    <div class="alert alert-danger" role="alert">
                        <strong> <?=$error_message; ?></strong>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-comment text-info"></i></div>
                            </div>
                            <textarea rows="6" name="message" id="message" class="form-control"
                                placeholder="Write your message here.."><?php if(isset($message))echo "$message"?></textarea>
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
                            class="btn btn-info btn-block rounded-0 py-2">
                            Send Message 
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- /form user info -->

    </div>

    <hr class="featurette-divider">

</main>

<?php
include_once "footer.php";
?>