<?php
//? stop browser from caching
//*              ...... date in the past ....
// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// header("Cache-Control: no-cache");
// header("Pragma: no-cache");
//*
include_once "./php/header.php";
?>

<main role="main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
      <li data-target="#myCarousel" data-slide-to="5"></li>
      <li data-target="#myCarousel" data-slide-to="6"></li>
    </ol>

    <div class="carousel-inner">
  
      <!-- CAROUSEL ITEM 01 -->
      <div class="carousel-item active">
        <div class="div-slide-01 text-center"></div>
        <div class="container">
          <!-- <div class="carousel-caption text-left"> -->
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-01 title">{title placeholder}.</h1> -->
            <!-- <p class="slide-01 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-01 image-dated"></p>
            <p class="slide-01 copyright">Cras ac faucibus orci, sed fringilla magna. Sed vitae bibendum massa, sit amet luctus mi. Ut nec nulla dui.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary btn-earn-more" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->

            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-01">
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-01" role="button">Learn more</a></p>
            </form>

          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 02 -->
      <div class="carousel-item">
        <div class="div-slide-02 text-center"></div>
        <div class="container">
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-02 title">{title placeholder}</h1> -->
            <!-- <p class="slide-02 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-02 image-dated"></p>
            <p class="slide-02 copyright">Proin malesuada tellus eu ex facilisis, a feugiat augue mollis. Nam at magna nec nisl malesuada sagittis ut vel massa.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-02">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-02" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 03 -->
      <div class="carousel-item">
        <div class="div-slide-03 text-center"></div>
        <div class="container">
          <!-- <div class="carousel-caption text-right"> -->
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-03 title">{title placeholder}</h1> -->
            <!-- <p class="slide-03 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-03 image-dated"></p>
            <p class="slide-03 copyright">Aenean efficitur elit eu metus fringilla scelerisque. Integer consequat urna id diam interdum convallis. Maecenas bibendum faucibus urna non congue.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-03">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-03" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 04 -->
      <div class="carousel-item">        
        <div class="div-slide-04 text-center"></div>
        <div class="container">
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-04 title">{title placeholder}</h1> -->
            <!-- <p class="slide-04 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-04 image-dated"></p>
            <p class="slide-04 copyright">Quisque sit amet purus velit. Pellentesque ac lorem dui. Donec in pulvinar odio. Ut commodo euismod ipsum, quis pharetra est tincidunt in.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-04">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-04" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 05 -->
      <div class="carousel-item">
        <div class="div-slide-05 text-center"></div>
        <div class="container">
          <!-- <div class="carousel-caption text-left"> -->
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-05 title">{title placeholder}</h1> -->
            <!-- <p class="slide-05 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-05 image-dated"></p>
            <p class="slide-05 copyright">Praesent et finibus justo. Duis ac vulputate leo, in cursus eros. Integer in turpis ac ligula sagittis condimentum vitae non diam.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-05">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-05" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 06 -->
      <div class="carousel-item">
        <div class="div-slide-06 text-center"></div>
        <div class="container">
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-06 title">{title placeholder}</h1> -->
            <!-- <p class="slide-06 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-06 image-dated"></p>
            <p class="slide-06 copyright">Aliquam consequat lacus non dolor posuere dapibus. Ut mollis aliquet risus, eget dictum urna mollis vel. Proin ornare consequat turpis eu mollis.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-06">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-06" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>

      <!-- CAROUSEL ITEM 07 -->
      <div class="carousel-item">
        <div class="div-slide-07 text-center"></div>
        <div class="container">
          <!-- <div class="carousel-caption text-right"> -->
          <div class="carousel-caption carousel-caption-div">
            <!-- <h1 class="slide-07 title">{title placeholder}</h1> -->
            <!-- <p class="slide-07 explanation">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget
              metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p class="slide-07 image-dated"></p>
            <p class="slide-07 copyright">Mauris a massa sit amet nunc condimentum maximus. Integer at velit euismod, venenatis libero nec, porta velit. Praesent pharetra nec nulla eget rutrum.</p> -->
            <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
            <!-- post to image details webpage -->
            <form action="media_view.php" method="POST" role="form">
              <input type="hidden" class="form-control" name="slide_selected" value="slide-07">
              <!-- <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p> -->
              <p><a class="btn btn-lg btn-primary" href="media_view.php?selected_slide=slide-07" role="button">Learn more</a></p>
            </form>
          </div>
        </div>
      </div>
    
    </div> <!-- class="carousel-inner" -->

    <a class="carousel-control-prev carousel-next-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    
    <a class="carousel-control-next carousel-next-prev" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>

  </div> <!-- id="myCarousel" -->
  
</main>
<?php
include_once "./php/footer.php";
?>
