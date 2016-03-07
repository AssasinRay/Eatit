<?php 
session_start();
//$_SESSION['name'] = "";
session_unset();
header('Location: index.php');


?>