<?php

//  session_start();

require_once '../db.php';
require_once 'User.php';
require_once 'Supplier.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();


if (isset($_POST['key']) && $_POST['key'] == 'countwarehouse') {
    $rowofPage = $_POST['rowofPage'];
    $total = countwarehouse();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}


 if(isset($_POST['checkproduct'])){
    $id = $_POST['ProductID'];
    $query = "SELECT * FROM products WHERE ProductID = $id";
    $re = mysqli_query($conn,$query);
    if(mysqli_num_rows($re) >0){
        echo "exists";
    }else echo "new";

}//ktra tồn tại sp

if (isset($_POST['add_receipt'])) {
   

    // Start transaction
    mysqli_begin_transaction($conn);

    
        add_receipt();

      
        mysqli_commit($conn);
        header("Location: ../admin2/index.php?page=Warehouse_demo/list");
        setcookie("success", "Add successfully!", time() + (86400 * 30), "/");
        exit();

   
    
    //     mysqli_rollback($conn);
    //     header("Location: ../admin2/index.php?page=Warehouse_demo/list");
    //     setcookie("err", "Add Failed!", time() + (86400 * 30), "/");
    //    exit();
    
}

function add_receipt(){
    global $conn;
    $userId = $_COOKIE['user_id'];
        $supplierId = $_POST['SuppliId'];
        $total = 0;
        
       
        $query = "INSERT INTO goodsreceipt (UserID, SuppliId, CreatedAt, Total) VALUES ($userId, $supplierId, NOW(), $total)";
        if (!mysqli_query($conn, $query)) {
            header("Location: ../admin2/index.php?page=Warehouse_demo/list");
            mysqli_rollback($conn);
                setcookie("err", "Add goodsreceipt Failed!", time() + (86400 * 30), "/");
                exit();
        }
        $receiptId = mysqli_insert_id($conn);

        if (!isset($_POST['ProductID'])) {
            mysqli_rollback($conn);
            header("Location: ../admin2/index.php?page=Warehouse_demo/list");
            setcookie("err", "Undefine ProductID", time() + (86400 * 30), "/");
            exit();
        }
    
        foreach (array_keys($_POST['ProductID']) as $index) {
            $price = isset($_POST['new_price'][$index]) ? $_POST['new_price'][$index] : $_POST['ex_price'][$index];
            $quantity = isset($_POST['new_quantity'][$index]) ? $_POST['new_quantity'][$index] : $_POST['ex_quantity'][$index];
            $total += $price * $quantity;

            $productId = $_POST['ProductID'][$index];
            
           

            if (isset($_POST['ex_quantity'][$index])) {
                // Update existing product
                $query = "UPDATE products SET TotalQuantity = TotalQuantity + $quantity, Quantity = Quantity + $quantity WHERE ProductID = $productId";
                if (!mysqli_query($conn, $query)) {
                    mysqli_rollback($conn);
                    header("Location: ../admin2/index.php?page=Warehouse_demo/list");
                    setcookie("err", "Update product Failed!", time() + (86400 * 30), "/");
                    exit();
                }
            } else {
                // Insert new product
                $series = $_POST['series'][$index];
                $categoryId = $_POST['CategoryID'][$index];
                $productName = $_POST['productname'][$index];
                $color = $_POST['color'][$index];
                $size = $_POST['size'][$index];

                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

                // Insert with specific ProductID
                $query = "INSERT INTO products (ProductID, Series, CategoryID, ProductName, Price, Color, Size, TotalQuantity, Quantity,Sale_Quantity, Status) 
                          VALUES ($productId, $series, $categoryId, '$productName', $price, '$color', '$size', $quantity, $quantity, 0, 1)";
                if (!mysqli_query($conn, $query)) {
                    mysqli_rollback($conn);
                    header("Location: ../admin2/index.php?page=Warehouse_demo/list");
                    setcookie("err", "Add product Failed!", time() + (86400 * 30), "/");
                    exit();
                }
            }

            $query = "INSERT INTO goodsreceipt_items (ReceiptId, ProductID, Price, Quantity) VALUES ($receiptId, $productId, $price, $quantity)";
            if (!mysqli_query($conn, $query)) {
                mysqli_rollback($conn);
                header("Location: ../admin2/index.php?page=Warehouse_demo/list");
                setcookie("err", "Add goodsreceipt_items Failed!", time() + (86400 * 30), "/");
                exit();
            }
        }

        // Update the total in goodsreceipt
        $query = "UPDATE goodsreceipt SET Total = $total WHERE ReceiptId = $receiptId";
        if (!mysqli_query($conn, $query)) {
            mysqli_rollback($conn);
            header("Location: ../admin2/index.php?page=Warehouse_demo/list");
            setcookie("err", "Update total goodsreceipt Failed!", time() + (86400 * 30), "/");
            exit();
        }

}


function getWarehouseById($Id){
    global $conn;
    $query = "SELECT * FROM goodsreceipt WHERE ReceiptId = $Id LIMIT 1";
    $result = mysqli_query($conn, $query);

    $orders = mysqli_fetch_assoc($result);
    return $orders;
}

function getIteminWarehouseById($Id){
    global $conn;
    $items = array();

    $query = "SELECT * FROM goodsreceipt_items WHERE ReceiptId = $Id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }

    return $items;
}

function countwarehouse(){
    global $conn;

    $query = "SELECT COUNT(*) FROM goodsreceipt";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}



function loadWarehouse($result){
    $html = '';

    while ($good = mysqli_fetch_assoc($result)) {
        $user = getCusbyId($good['UserID']);
        $supp = getSupplierByID($good['SuppliId']);
        $html .= '<tr>';
        $html .= '  <td class="SuppliId">' . $good['ReceiptId'] . '</td>';
        $html .= '  <td>' . $user['FirstName'] . ' '.$user['LastName'].'</td>';
        $html .= '  <td>' . $supp['Name'] . '</td>';
        $html .= '  <td>' . $good['Total'] . '</td>';
        $html .= '  <td>' . $good['CreatedAt'] . '</td>';
        $html .= '  <td>';
        $html .= '    <a  href="../admin2/index.php?page=Warehouse_demo/detail&Id=' . $good['ReceiptId'] . '">';
        $html .= '      <button class="btn btn-outline-secondary">';
        $html .= '        Detail';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        $html .= '</tr>';
    }

    return $html;
}