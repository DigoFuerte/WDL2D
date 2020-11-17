<?php
include_once "./php/header.php";
include_once "./php/data_model.php";
?>

  <!-- <button type="button" class="btn btn-secondary float-right tooltip-bottom" title="This should be shifted to the left">Shift Left</button> -->
  <!-- <button type="button" class="btn btn-secondary tooltip-bottom" title="This should be shifted to the right">Shift Right</button> -->
  <!-- <button type="button" class="btn btn-secondary tooltip-right" title="This should be shifted down">Shift Down</button> -->
  <!-- <button type="button" class="btn btn-secondary tooltip-right btn-bottom" title="This should be shifted up">Shift Up</button> -->

  <!-- <div class="container-fluid bg-div" style="padding-top:50px; padding-bottom:50px;"> -->
  <div class="container-fluid bg-div">
    <!-- <div class="col-md-8 offset-md-3 mt-0 "> -->
    <div class="col-md-8 mt-0 ">
      <div class="container-viewport">
        <button type="button" class="btn btn-secondary tooltip-viewport-bottom"             title="This should be shifted to the left">
        Shift Left
        <<img src="./image/static/Home_Carousel_Eta_Carinae_RECT.png" 
              class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" 
              alt="">
        </button>
        <button type="button" class="btn btn-secondary tooltip-viewport-right"              title="This should be shifted down">Shift Down</button>
        <button type="button" class="btn btn-secondary tooltip-viewport-bottom float-right" title="This should be shifted to the right">Shift Right</button>
        <button type="button" class="btn btn-secondary tooltip-viewport-right btn-bottom"   title="This should be shifted up">Shift Up</button>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <!-- <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->
  <!-- <script src="../../../../assets/js/vendor/popper.min.js"></script> -->
  <!-- <script src="../../../../dist/js/bootstrap.min.js"></script> -->
  <!-- <script src="tooltip-viewport.js"></script> -->

<?php
include_once "./php/footer.php";
?>