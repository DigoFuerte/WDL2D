<?php
include_once "./config.php";
include_once "./data_model.php";

// get media details from $_POST
if ( isset($_POST['slide_id']) ) {

  $p_slide_id = $_POST['slide_id'];
  $p_copyright       = $p_slide_id . "_copyright";    
  $p_date            = $p_slide_id . "_date";         
  $p_explanation     = $p_slide_id . "_explanation";  
  $p_hdurl           = $p_slide_id . "_hdurl";        
  $p_media_type      = $p_slide_id . "_media_type";   
  $p_service_version = $p_slide_id . "_service_version";
  $p_title           = $p_slide_id . "_title";        
  $p_url             = $p_slide_id . "_url";          
  // $p_flag            = $p_slide_id . "_flag";         

  if ( isset($_POST[$p_copyright]) )       { $copyright = $_POST[$p_copyright]; }
  if ( isset($_POST[$p_date]) )            { $date = $_POST[$p_date]; }
  if ( isset($_POST[$p_explanation]) )     { $explanation = $_POST[$p_explanation]; }
  if ( isset($_POST[$p_hdurl]) )           { $hdurl = $_POST[$p_hdurl]; }
  if ( isset($_POST[$p_media_type]) )      { $media_type = $_POST[$p_media_type]; }
  if ( isset($_POST[$p_service_version]) ) { $service_version = $_POST[$p_service_version]; }
  if ( isset($_POST[$p_title]) )           { $title = $_POST[$p_title]; }
  if ( isset($_POST[$p_url]) )             { $url = $_POST[$p_url]; }

  // save data to db
  save_user_media ($copyright,
                   $date,
                   $explanation,
                   $hdurl,
                   $media_type,
                   $service_version,
                   $title,
                   $url);
                   
}
else {
  echo FALSE;
}

?>