<?php
session_start();
if ($_SESSION['auth'] != 'ok'){
    header('location:webapp/views/login.php');
    exit();
}
else{
    header('location:webapp/views/');
}