<?php

# session start
session_start();
unset($_SESSION['username']); //delete the username key
//sesion_destroy; // this would delete all the session keys

header('Location: login.php');

?>