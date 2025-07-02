<?php
session_start();
session_destroy(); // session ko destroy kar do
header("Location: index.php"); // logout ke baad home page ya login page par redirect karo
exit();
?>
