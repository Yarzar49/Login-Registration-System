<?php

//Logout
session_start();       

session_unset();
header('location:login.php');

?>