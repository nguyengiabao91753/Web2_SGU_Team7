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

}//ktra tồn tại sp
$sql = "SELECT * FROM products WHERE ProductID = $productID";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Nếu sản phẩm đã tồn tại, thực hiện cập nhật số lượng
        $row = mysqli_fetch_assoc($result);
        $currentQuantity = $row['Quantity'];
        $newQuantity = $currentQuantity + $quantity;
        
        // Cập nhật số lượng sản phẩm
        $updateSql = "UPDATE products SET Quantity = $newQuantity WHERE ProductID = $productID";
        if (mysqli_query($conn, $updateSql)) {
            echo "Product quantity updated successfully.";
        } else {
            echo "Error updating product quantity: " . mysqli_error($conn);
        }
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới vào cơ sở dữ liệu
        $insertSql = "INSERT INTO products (ProductID, Quantity) VALUES ($productID, $quantity)";
        if (mysqli_query($conn, $insertSql)) {
            echo "New product inserted successfully.";
        } else {
            echo "Error inserting new product: " . mysqli_error($conn);
        }
    }
    
    // Liên kết sản phẩm với phiếu nhập
    $linkSql = "INSERT INTO receipt_product (ReceiptID, ProductID, Quantity) VALUES ($receiptID, $productID, $quantity)";
    if (mysqli_query($conn, $linkSql)) {
        echo "Product linked to receipt successfully.";
    } else {
        echo "Error linking product to receipt: " . mysqli_error($conn);
    }
    
    // Đóng kết nối
    mysqli_close($conn);

// Sử dụng hàm để liên kết sản phẩm với phiếu nhập
$productID = $_POST['ProductID']; // Giả sử bạn nhận được ID sản phẩm từ form
$quantity = $_POST['quantity']; // Giả sử bạn nhận được số lượng từ form
$receiptID = $_POST['ReceiptId']; // Giả sử bạn nhận được ID phiếu nhập từ form


