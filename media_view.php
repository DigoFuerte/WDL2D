<?php
include_once "php/header.php";
include_once "php/Permissions.php";

// user is not signed in ... send user to sign in page
if (! isset($_SESSION['user_details'])) {
    header("Location:sign_in.php");
}  
else if (! HasMemberAccess($_SESSION['user_details']['user_permissions']) ) {
    header("Location:profile.php");
}

//! TEST
// var_dump($_SESSION['user_media']);

?>
<script src="js/album.js"></script>

<main role="main">
    <div class="container" onload="getSlideId();">
        <div class="row">
            <div class="col-sm-6">
                <div id="media_div"></div>
                    <div>
                        <br>
                        <!-- <form id="save_media" name="save_media" method="POST" action=""> -->
                            <button type="submit" id="save_media_btn" name="save_media_btn"
                                    class="btn-hover btn btn-info btn-block rounded-bottom py-2 sign-bg-high">
                        <h5 style="display:inline;">Save
                            <!-- <i class="fas fa-upload" style="color:#C5D984" aria-hidden="true"></i> -->
                            <i class="fas fa-upload sign-fg-high" aria-hidden="true"></i>
                        </h5>
                        </button>
                        <!-- </form> -->
                    </div>
                </div>
                <div class="col-sm-6 sign-txt-white">
                    <h3 id='title_para'></h3>
                    <div id="copyright_div"></div>
                    <div id="date_div"></div>
                    <div id="explanation_div"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once "php/footer.php";
?>
<script src="js/ajax_db.js"></script>
