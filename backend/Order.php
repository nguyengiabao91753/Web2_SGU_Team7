<?php

//  session_start();

require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

//Xử lý ajax lấy số trang
if (isset($_GET['key']) && $_GET['key'] =='countorder') {
    $rowofPage = $_GET['rowofPage'];
    $total = countOrders();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
    
}


//Xử lý ajax đây là search nhá
if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $query = "SELECT *  
            FROM Orders o 
            INNER JOIN users us ON o.UserID = us.UserID
            WHERE us.FirstName LIKE '%$searchText%' OR us.LastName LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadOrderData($result);
}

function countOrders()
{
    global $conn;

    $query = "SELECT COUNT(*) FROM Orders";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}

function loadOrderData($rs){

}