<?php
session_start();
session_destroy();
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['verify']);
header("location: login.php");

?>