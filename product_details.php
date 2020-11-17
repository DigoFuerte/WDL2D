<?php

include_once "header.php";
include_once "data_model.php";

if(isset($_GET['pid'])){
  $product_id = $_GET['pid'];
  $product_details = get_product_by_id( $product_id);
}

?>

      
   
<div class="container-fluid bg-div" style="padding-top:100px; padding-bottom:100px;">
        <!-- START THE FEATURETTES -->


        <div class="row mt-5" style="position: relative;color: black;  font-size: 2vw; font-weight:bold;">
		      <div class="col-md-12 text-center">
            <img class="img-fluid mx-auto rounded" style=" border: 20px solid white;box-shadow: 20px 20px 20px black;;" src="images/<?=$product_details['image'];?>" alt="<?=$product_details['image'];?>">
            <p class="font-weight-bold mt-4"><b>Name: <?=$product_details['name'] ;?></b></p>
            <p  class="text-justify"><b>Description: </b><?=$product_details['description'];?></p>
            <p><a class="btn btn-lg btn-primary" style="background:04443C" href="index.php#<?=$product_id?>" role="button">Go Back</a></p>
          </div>
          
        </div>


        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->




<?php

include_once "footer.php";
?>


