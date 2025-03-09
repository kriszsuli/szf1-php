<?php
session_start();
if(isset($_SESSION['username'])){
    header("Location: profile.php");
    exit();
}else{
    header("Location: login.php");
    exit();
}
?>