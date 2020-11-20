<?php

session_start();

if ( isset($_POST['GET_ALL_USER_MEDIA']) && isset($_SESSION['user_media'])) {
  
  $userMedia = $_SESSION['user_media'];
  echo json_encode($userMedia);
  
}

echo FALSE;

?>