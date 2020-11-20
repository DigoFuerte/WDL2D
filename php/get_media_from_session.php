<?php

session_start();

// var_dump($_SESSION['user_media']);

// && isset($_SESSION['user_media']) 
// echo "media_id: " . $_POST['media_id'];

if ( isset($_POST['media_id']) && $_POST['media_id']) {
  $p_media_id = $_POST['media_id'];
  $userMedia = $_SESSION['user_media'];

  foreach ($userMedia as $savedMedia) {
    if ($savedMedia['media_id'] == $p_media_id) {
      echo json_encode($savedMedia);
      break;      
    }
  }
}

// echo "media_id in POST: " . $_POST['media_id']; 
// var_dump($_SESSION['user_media']);
// echo json_encode($_SESSION['user_media']);
// echo "YEEEEHA";

echo FALSE;

?>