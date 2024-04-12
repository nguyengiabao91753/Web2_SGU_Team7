<?php

if(isset($_POST['signin'])){
    login();
}

function login(){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM users WHERE ";
}