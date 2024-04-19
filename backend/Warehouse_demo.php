<?php

//  session_start();

require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();


 //Xử lý Ajax kt sp
 if(isset($_POST['checkproduct'])){
    $id = $_POST['ProductID'];
    $query = "SELECT * FROM products WHERE ProductID = $id";
    $re = mysqli_query($conn,$query);
    if(mysqli_num_rows($re) >0){
        echo "exists";
    }
    echo 'new';

}
