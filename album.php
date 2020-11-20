<?php
include_once "./php/header.php";
include_once "./php/data_model.php";
$user_media = get_user_media_id();
// put user media details to $_SESSION
// session_start();
$_SESSION['user_media'] = $user_media;
//! FUNCTION TO COPY $_SESSION['user_media'] TO sessionStorage
//jq_save_user_media_local();
?>
<script src="js/album.js"></script>

<main role="main">
  <section class="jumbotron text-center">
    <img id="dummy_img"
         src="image/telescope-home-page-icon.png" alt="" style="display: none;"
         onload="jq_save_user_media_local()" >
    <div class="container">
      <h2 class="jumbotron-heading">Album</h2>
      <!-- <p class="lead text-muted">Something short and leading about the collection.</p> -->
    </div>
  </section>

  <div class="album py-5 album-bg-black">
    <div class="container">
      <div class="row">
        <?php foreach($user_media as $user_media_item):?>
          <!-- <div class="col-md-4 album-bg-black"> -->
          <div class="col-md-4">
            <div class="card mb-4 album-bg-black">
              <img class="card-img-top" src="<?= $user_media_item['url']; ?>" alt="Card image cap">
              <div class="card-body">
                <p class="card-text album-text-white"><small class="text-muted"><?= $user_media_item['title']; ?></small></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Media Id: {<?= $user_media_item['media_id']; ?>}</button> -->
                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> -->                    
                    <form action="media_view.php" method="POST" role="form">
                      <input type="hidden" class="form-control">
                      <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_media=<?= $user_media_item['media_id']; ?>" role="button">Learn more</a></p>
                    </form>

                  </div>                  
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>

<?php
include_once "./php/footer.php";
?>
<!-- <script src="js/ajax_db.js"></script> -->
