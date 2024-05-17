<?php

//  session_start();

require_once '../db.php';
require_once 'User.php';

$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();



if (isset($_GET['approve'])) {
    $ID = $_GET['approve'];
    approve($ID);
}
if (isset($_POST['checkout'])) {
    $ID = $_POST['OrderID'];
    checkout($ID);
}
if (isset($_GET['approvecheckout'])) {
    $ID = $_GET['approvecheckout'];
    approvecheckout($ID);
}
if (isset($_GET['cancel'])) {
    $ID = $_GET['cancel'];
    cancel($ID);
}
if (isset($_GET['reject'])) {
    $ID = $_GET['reject'];
    reject($ID);
}


if (isset($_POST['key']) && $_POST['key'] == 'add-order') {
    $client = $_COOKIE['client'];
    $orderID = (int) checkOrders();
    $productID = $_POST['ProductID'];
    $quantity = $_POST['Quantity'];
    $price = $_POST['Price'];
    $subtotal = (int) $quantity * (int) $price;
    if($orderID==0){
        $createorder = "INSERT INTO Orders (UserID, Status, CreatedAt) VALUES ($client, 0, NOW() );";
        $rs = mysqli_query($conn, $createorder);

        $orderID = mysqli_insert_id($conn);
    }
    // Kiểm tra xem sản phẩm đã có trong orderitems của orderID hay chưa
    $checkItemQuery = "SELECT * FROM orderitems WHERE OrderID = $orderID AND ProductID = $productID";
    $checkItemResult = mysqli_query($conn, $checkItemQuery);

    if (mysqli_num_rows($checkItemResult) > 0) {
        // Nếu đã có sản phẩm trong orderitems, cập nhật số lượng và subtotal
        $existingItem = mysqli_fetch_assoc($checkItemResult);
        $newQuantity = (int) $existingItem['Quantity'] + (int) $quantity;
        $newSubtotal = (int) $existingItem['Price'] * $newQuantity;

        $updateItemQuery = "UPDATE orderitems 
                            SET Quantity = $newQuantity, Subtotal = $newSubtotal
                            WHERE OrderID = $orderID AND ProductID = $productID";

        if (mysqli_query($conn, $updateItemQuery)) {
            
           
            
            updateTotal($orderID);

            echo "true";
        } else {
            echo "false";
        }
    } else {
        // Nếu chưa có sản phẩm trong orderitems, thêm mới vào
        $insertItemQuery = "INSERT INTO orderitems (OrderID, ProductID, Price, Quantity, Subtotal) 
                            VALUES ($orderID, $productID, $price, $quantity, $subtotal)";
        if (mysqli_query($conn, $insertItemQuery)) {
            
          
            
            updateTotal($orderID);
            echo "true";
        } else {
            echo "false";
        }
    }
}



function updateProductQuantity($productID, $quantity){
    global $conn;
    $updateProductQuery = "UPDATE products 
    SET Quantity = Quantity - $quantity, Sale_Quantity = Sale_Quantity + $quantity
    WHERE ProductID = $productID";

    mysqli_query($conn, $updateProductQuery);
}



//Xử lý ajax lấy số trang
if (isset($_GET['key']) && $_GET['key'] == 'countorder') {
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

function checkOrders()
{
    global $conn;
    $clientID = $_COOKIE['client'];
    $query = "SELECT OrderID FROM Orders WHERE UserID = $clientID AND Status = 0 LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['OrderID'];
    }
        return 0;
}
function getOrder() {
    global $conn;
    $client = $_COOKIE['client'];
    $query = "SELECT * FROM Orders WHERE Status = 0 AND UserID = $client LIMIT 1";
    $result = mysqli_query($conn, $query);

    $orders = mysqli_fetch_assoc($result);
    return $orders;
}
function getAllOrder() {
    global $conn;
    $client = $_COOKIE['client'];
    $orders = array();
    $query = "SELECT * FROM Orders WHERE UserID = $client
                ORDER BY CreatedAt DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
    };

    return $orders;
}

function getOrderbyID($ID){
    global $conn;
    $query = "SELECT * FROM Orders WHERE OrderID = $ID LIMIT 1";
    $result = mysqli_query($conn, $query);

    $orders = mysqli_fetch_assoc($result);
    return $orders;
}

function getItemsInOrder() {
    global $conn;
    $client = $_COOKIE['client'];
    $items = array();

    $query = "SELECT * FROM orderitems WHERE OrderID IN (SELECT OrderID FROM Orders WHERE Status = 0 AND UserID = $client) ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }

    return $items;
}

function countItemsInOrder() {
    global $conn;
    $client = $_COOKIE['client'];
    $query = "SELECT SUM(Quantity) AS TotalItems FROM orderitems  WHERE OrderID IN (SELECT OrderID FROM Orders WHERE Status = 0 AND UserID = $client)";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return (int)$row['TotalItems'];
    } else {
        return 0;
    }
}

function getItemsbyOrderID($ID){
    global $conn;
    $items = array();

    $query = "SELECT * FROM orderitems WHERE OrderID = $ID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }

    return $items;
}

function approvecheckout($ID){
    global $conn;


    $query = "UPDATE orders SET Status = Status + 1 WHERE OrderID = $ID";
    if ($conn->query($query) === TRUE) {

       
            $getItemsQuery = "SELECT * FROM orderitems WHERE OrderID = $ID";
            $result = mysqli_query($conn, $getItemsQuery);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $productID = $row['ProductID'];
                    $quantity = $row['Quantity'];

                    $updateProductQuery = "UPDATE products 
                        SET Quantity = Quantity - $quantity, Sale_Quantity = Sale_Quantity + $quantity
                        WHERE ProductID = $productID";

                    mysqli_query($conn, $updateProductQuery);
                }
            }
        

        header("Location:  ../admin2/index.php?page=Order/pending");
        //setcookie("success", "Approve Order successfully!", time() + (86400 * 30), "/");
        exit();
    } else {
        echo "Failed";
    }
}

function approve($ID)
{
    global $conn;


    $query = "UPDATE orders SET Status = Status + 1 WHERE OrderID = $ID";
    if ($conn->query($query) === TRUE) {

        header("Location: ../admin2/index.php?page=Order/delivering");
        setcookie("success", "Approve Order successfully!", time() + (86400 * 30), "/");
        exit();
    } else {
        echo "Failed";
    }
}

function checkout($ID)
{
    global $conn;
    $payement = $_POST['payment'];

    $query = "UPDATE orders SET Status = Status + 1, Payment = '$payement', CreatedAt = NOW() WHERE OrderID = $ID";
    if ($conn->query($query) === TRUE) {

        header("Location: ../client/index.php?content=profile");
        //setcookie("success", "Approve Order successfully!", time() + (86400 * 30), "/");
        exit();
    } else {
        echo "Failed";
    }
}

function cancel($ID){
    global $conn;


    $query = "UPDATE orders SET Status = 4 WHERE OrderID = $ID";
    if ($conn->query($query) === TRUE) {

        header("Location: ../client/index.php?content=profile");
        //setcookie("success", "Approve Order successfully!", time() + (86400 * 30), "/");
        exit();
    } else {
        echo "Failed";
    }
}

function reject($ID)
{
    global $conn;


    $query = "UPDATE orders SET Status = 5 WHERE OrderID = $ID";
    if ($conn->query($query) === TRUE) {

        header("Location: ../admin2/index.php?page=Order/pending");
        setcookie("success", "Reject Order successfully!", time() + (86400 * 30), "/");
        exit();
    } else {
        echo "Failed";
    }
}

function loadOrderData($rs, $key)
{
    $html = '';

    while ($order = mysqli_fetch_assoc($rs)) {
        if ($order['Status'] == $key) {

            $cus = getCusbyId($order['UserID']);
            $html .= '<tr>';
            $html .= '  <td class="OrderID">' . $order['OrderID'] . '</td>';
            $html .= '  <td>' . $cus['FirstName'] . ' ' . $cus['LastName'] . '</td>';
            $html .= '  <td>' . $order['TotalAmount'] . '</td>';
            $html .= '  <td>' . $order['Payment'] . '</td>';
            // $html .= '  <td>';
            // $html .= '      <button type="button" onclick="update(this)" id="approve-' . $order['OrderID'] . '" class=" btn btn-success">';
            // $html .= '        <i class="far fa-edit"></i>';
            // $html .= '      </button>';
            // $html .= '  </td>';
            $html .= '  <td>';
            $html .= '    <a  href="../admin2/index.php?page=Order/detail&Id=' . $order['OrderID'] . '">';
            $html .= '      <button class="btn btn-outline-secondary">';
            $html .= '        Detail';
            $html .= '      </button>';
            $html .= '    </a>';
            $html .= '  </td>';
            if ($key ==2) {
                $html .= '  <td>';
                $html .= '    <a onclick="return confirmApprove()" href="../backend/Order.php?approve=' . $order['OrderID'] . '">';
                $html .= '      <button class="btn btn-success">';
                $html .= '        <i class="far fa-check-circle"></i>';
                $html .= '      </button>';
                $html .= '    </a>';
                $html .= '  </td>';
            }
            if ($key == 1) {
                $html .= '  <td>';
                $html .= '    <a onclick="return confirmApprove()" href="../backend/Order.php?approvecheckout=' . $order['OrderID'] . '">';
                $html .= '      <button class="btn btn-success">';
                $html .= '        <i class="far fa-check-circle"></i>';
                $html .= '      </button>';
                $html .= '    </a>';
                $html .= '  </td>';

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


function getItembyId($orderItemID){
    global $conn;
    $query = "SELECT * FROM orderitems WHERE orderItemID = $orderItemID LIMIT 1";
    $result = mysqli_query($conn, $query);

    $item = mysqli_fetch_assoc($result);
    return $item;
}

if (isset($_POST['key'])) {
    if ($_POST['key'] == 'update-quantity') {
    
        $orderItemID = $_POST['orderItemID'];
        $quantity = $_POST['quantity'];

        
        updateItemQuantity($orderItemID, $quantity);

        $neworder = getOrder();
        $newitem = getItembyId($orderItemID);
        $response['data'] = array(
            'total'=> $neworder['TotalAmount'],
            'subtotal'=> $newitem['Subtotal']
        );
        echo  json_encode($response) ; 
    }

    elseif($_POST['key'] == 'remove-item'){
        $orderItemID = $_POST['orderItemID'];

        removeItem($orderItemID);

        $neworder = getOrder();
        $response['data'] = array(
            'total'=> $neworder['TotalAmount']
        );
        echo  json_encode($response) ; 
    }
}



// Hàm cập nhật số lượng sản phẩm
function updateItemQuantity($orderItemID, $quantity) {
    global $conn;

    $query = "UPDATE orderitems SET Quantity = $quantity, Subtotal = $quantity * Price WHERE OrderItemID = $orderItemID";

    if (mysqli_query($conn, $query)) {
        
        $orderID = getOrderIDFromOrderItemID($orderItemID);
        updateTotal($orderID);
    }
}

//Hàm xóa sản phẩm khỏi giỏ hàng
function removeItem($OrderItemID){
    global $conn;
    $orderID = getOrderIDFromOrderItemID($OrderItemID);
    $query = "DELETE FROM orderitems WHERE OrderItemID = $OrderItemID";
    if (mysqli_query($conn, $query)) { 
        updateTotal($orderID);
    }
}

// Hàm lấy OrderID từ OrderItemID
function getOrderIDFromOrderItemID($orderItemID) {
    global $conn;

    $query = "SELECT OrderID FROM orderitems WHERE OrderItemID = $orderItemID LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['OrderID'];
    }

    return null;
}


function updateTotal($orderID){
    global $conn;
    $updateTotalAmountQuery = "UPDATE Orders 
    SET TotalAmount = (SELECT SUM(Subtotal) FROM orderitems WHERE OrderID = $orderID)
    WHERE OrderID = $orderID";

    mysqli_query($conn, $updateTotalAmountQuery);

}


if(isset($_GET['key']) && $_GET['key'] == 'update-viewcart'){
    $count = countItemsInOrder();
    echo $count;
}