<?php

//? After this number of seconds, stored data will be seen as 'garbage' and
//? cleaned up by the garbage collection process.
//? ttp://php.net/session.gc-maxlifetime
//? ession.gc_maxlifetime=1440
//? set for 8 hours
//? session.gc_maxlifetime=28800

session_start();

const SESSION_KEY_TEST = 'jq_php_test';

//? WRITE data to SESSION super-global
if ( isset($_POST['SESSION_VARIABLE_KEY']) && isset($_POST['SESSION_VARIABLE_VALUE']) ) {
  $post_key = $_POST['SESSION_VARIABLE_KEY'];
  $post_value = $_POST['SESSION_VARIABLE_VALUE'];
  $_SESSION[$post_key] = $post_value;
  unset($_POST['SESSION_VARIABLE_KEY']);
  unset($_POST['SESSION_VARIABLE_VALUE']);
  echo isset($_SESSION[$post_key]);
  // echo "session variable set: OK";
}
//? READ data to SESSION super-global
else if ( isset($_GET['SESSION_VARIABLE_KEY']) ) {
  $get_key = $_GET['SESSION_VARIABLE_KEY'];
  unset($_GET['SESSION_VARIABLE_KEY']);
  if (isset($_SESSION[$get_key]) ) {
    echo $_SESSION[$get_key];
  }
  else {
    echo "Session variable: $get_key not found";
  }
}
else {
  echo FALSE;
}

?>