<?php
session_start();
$_SESSION['USERNAME'] = $_POST['username'];
$_SESSION['PASSWORD'] = $_POST['password'];

print json_encode(array('username' => $_SESSION['USERNAME'],'password' => $_SESSION['PASSWORD']));
/*console.log(json_encode(array('password' => $_SESSION['PASSWORD'])));*/
die();


?>