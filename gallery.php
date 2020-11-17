<?php
include_once "./php/header.php";
include_once "./php/data_model.php";
$user_media = get_user_media_id();
?>

<div class="container-fluid bg-div" style="padding-top:100px; padding-bottom:100px;">
    <h1 class="text-center mb-5"> Flower Gallery</h1>
    <div class="row">
    <?php foreach($user_media as $user_media_item):?>
        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
            <a href="<?= $user_media_item['hdurl']; ?>" class="fancybox" rel="ligthbox" data-caption="<?= $user_media_item['title']; ?>">
            <img src="<?= $user_media_item['hdurl']; ?>" class="zoom img-fluid " alt="">
            </a>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<?php
include_once "./php/footer.php";
?>