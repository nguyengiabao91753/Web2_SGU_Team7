<?php

//  session_start();

require_once '../db.php';
require_once 'User.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();


if(isset($_GET['approve'])){
    $ID = $_GET['approve'];
    approve($ID);
}

if(isset($_GET['reject'])){
    $ID = $_GET['reject'];
    reject($ID);
}


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
    $key = $_POST['key'];
    $query = "SELECT *  
            FROM Orders o 
            INNER JOIN users us ON o.UserID = us.UserID
            WHERE us.FirstName LIKE '%$searchText%' OR us.LastName LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadOrderData($result, $key);
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

function approve($ID){
    global $conn;
    $query = "UPDATE orders SET Status = Status + 1 WHERE OrderID = $ID";
    if($conn->query($query) === TRUE){
        
        header("Location: ../admin2/index.php?page=Order/pending");
        setcookie("success","Approve Order successfully!",time() + (86400 * 30), "/");
        exit();
    }
    echo "Failed";
}
function reject($ID){
    global $conn;
    $query1 = "DELETE FROM orderitems WHERE OrderID = $ID";
    if($conn->query($query1) === TRUE){
        $query = "DELETE FROM orders WHERE OrderID = $ID";
        if($conn->query($query) === TRUE){
            
            header("Location: ../admin2/index.php?page=Order/pending");
            setcookie("success","Approve Order successfully!",time() + (86400 * 30), "/");
            exit();
        }
    }
    echo "Failed";
}

function loadOrderData($rs, $key){
    $html = '';

    while ($order = mysqli_fetch_assoc($rs)) {
        if($order['status'] == $key){

        $cus = getCusbyId($order['UserID']);
        $html .= '<tr>';
        $html .= '  <td class="OrderID">' . $order['OrderID'] . '</td>';
        $html .= '  <td>' . $cus['FirstName'] . ' '.$cus['LastName'].'</td>';
        $html .= '  <td>' . $order['TotalAmount'] . '</td>';
        $html .= '  <td>' . $order['Payment'] . '</td>';
        // $html .= '  <td>';
        // $html .= '      <button type="button" onclick="update(this)" id="approve-' . $order['OrderID'] . '" class=" btn btn-success">';
        // $html .= '        <i class="far fa-edit"></i>';
        // $html .= '      </button>';
        // $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <a  href="../admin2/index.php?page=Order/detail&Id=' . $order['OrderID'] . '">';
        $html .= '      <button class="btn btn-danger">';
        $html .= '        Detail';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        if($key!=3){
            $html .= '  <td>';
            $html .= '    <a  href="../backend/Order.php?approve=' . $order['OrderID'] . '">';
            $html .= '      <button class="btn btn-danger">';
            $html .= '        <i class="far fa-trash-alt"></i>';
            $html .= '      </button>';
            $html .= '    </a>';
            $html .= '  </td>';
        }
        if($key == 1 ){
        $html .= '  <td>';
        $html .= '    <a onclick="return confirmDelete()" href="../backend/Order.php?reject=' . $order['OrderID'] . '">';
        $html .= '      <button class="btn btn-danger">';
        $html .= '        <i class="far fa-trash-alt"></i>';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        }
        $html .= '</tr>';
        }
    }

    return $html;
}