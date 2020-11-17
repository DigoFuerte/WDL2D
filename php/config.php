<?php

//* database connection setup.
$hostname='localhost';
$user_name='root';
$password='';
$database_name='pex_db';


$conn = mysqli_connect($hostname, $user_name, $password,$database_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//* setup default character set for db connection
mysqli_set_charset($conn, "utf8");


//* setup default timezone setup
date_default_timezone_set('UTC');

//* start server-side session (PHP ... $_SESSION)
session_start();

//* function to sanitise user input
function filterUserInput($data, $type="") {

  // prepare message for storing in db
  if ($type == "message") {
    //* remove whitespace from the start and end of string
    $data = trim($data);
    
    //* strip HTML, XML and PHP tags from string
    $data = strip_tags($data);

    //* prepare a string for storage in a database
    //* add backslashes in front of: single quote ('), double quote ("), backslash (\), NULL
    $data = addslashes($data);

  } 
  // prepare string retrieved from db
  elseif ($type=="") {
    //* strip HTML, XML and PHP tags from string
    $data = strip_tags($data);
    //* remove backslashes from string
    $data = stripslashes($data);
  }

  return $data;

} # End of filter_user_input function

?>
