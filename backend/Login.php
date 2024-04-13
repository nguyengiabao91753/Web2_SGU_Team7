<?php
require_once '../db.php';
if(isset($_POST['signin'])){
   
    login();
}


function login(){
    global $conn;
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM users WHERE Email = '$email' AND Password = '$pass' LIMIT 1";
    $rs = mysqli_query($conn,$query);
    if(mysqli_num_rows($rs)>0){
        $user = mysqli_fetch_assoc($rs);
        setcookie("user_id", $user['UserID'],time() + (86400 * 30), "/");
        header("Location: ../admin2/index.php");
        exit();
        //return $user['UserID'];
       
    }
   echo "Không tìm thấy tài khoản!";   
}