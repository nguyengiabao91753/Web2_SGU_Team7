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
        //check level người đăng nhập
        $levelId = $user['Level'];
        $valilevel = "SELECT * FROM levels WHERE LevelId = $levelId";
        $rs2 = mysqli_query($conn,$valilevel);
        $level = mysqli_fetch_assoc($rs2);
        if($level['Name'] == 'User'){
            setcookie("err","There are no permissions to access",time() + (86400 * 30), "/");
            header("Location: ../admin2/index.php");
            exit();
        }
        setcookie("user_id", $user['UserID'],time() + (86400 * 30), "/");
        header("Location: ../admin2/index.php");
        exit();
        //return $user['UserID'];
       
    }
    setcookie("err","Invalid Acount",time() + (86400 * 30), "/");
    header("Location: ../admin2/auth/login.php");
    exit();
}

function loginclient(){

}