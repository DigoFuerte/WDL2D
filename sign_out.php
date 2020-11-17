<?php
if (isset($_GET['log']) && ($_GET['log']=='out')) {
  session_destroy();
  header('location:index.php');
}
echo "<a class='dropdown-item' href='?log=out'><i class='fas fa-sign-out-alt'></i> Sign out</a>";
?>
