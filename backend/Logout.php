<?php
require_once '../db.php';

if(isset($_GET['user_id'])){
    setcookie("user_id", "",time() -10, "/");
    header("Location: ../admin2/index.php");
}

if(isset($_GET['client'])){
    setcookie("client", "",time() -10, "/");
    header("Location: ../client/index.php");
}