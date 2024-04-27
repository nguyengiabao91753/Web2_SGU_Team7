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


// Xử lý khi người dùng nhấn nút "Submit" để tạo phiếu nhập
if (isset($_POST['add_receipt'])) {
    // Thu thập thông tin từ form
    $userID = $_SESSION['userID']; // Giả sử thông tin về người dùng đã được lưu trong session
    $supplierID = $_POST['SupplierId'];
    $createdAt = date('Y-m-d H:i:s'); // Thời gian tạo phiếu nhập
    $total = $_POST['total']; // Tổng số tiền

    // Thực hiện truy vấn để tạo phiếu nhập mới trong bảng "GoodReceipt"
    $insertReceiptSql = "INSERT INTO GoodReceipt (UserID, SupplierID, CreatedAt, Total) VALUES ($userID, $supplierID, '$createdAt', $total)";
    if (mysqli_query($conn, $insertReceiptSql)) {
        // Lấy ID của phiếu nhập mới tạo
        $receiptID = mysqli_insert_id($conn);

        // Thu thập thông tin về các sản phẩm từ form
        $productIDs = $_POST['ProductID'];
        $quantities = $_POST['quantity'];
        $prices = $_POST['price'];

        // Liên kết các sản phẩm với phiếu nhập
        for ($i = 0; $i < count($productIDs); $i++) {
            $productID = $productIDs[$i];
            $quantity = $quantities[$i];
            $price = $prices[$i];

            // Kiểm tra xem sản phẩm đã tồn tại trong bảng "Products" hay chưa
            $checkProductSql = "SELECT * FROM Products WHERE ProductID = $productID";
            $checkProductResult = mysqli_query($conn, $checkProductSql);
            if (mysqli_num_rows($checkProductResult) > 0) {
                // Sản phẩm đã tồn tại, cập nhật số lượng và giá tiền
                $updateProductSql = "UPDATE Products SET Quantity = Quantity + $quantity, Price = $price WHERE ProductID = $productID";
                mysqli_query($conn, $updateProductSql);
            } else {
                // Sản phẩm chưa tồn tại, thêm mới vào bảng "Products"
                $insertProductSql = "INSERT INTO Products (ProductID, Quantity, Price) VALUES ($productID, $quantity, $price)";
                mysqli_query($conn, $insertProductSql);
            }

            // Liên kết sản phẩm với phiếu nhập trong bảng trung gian "Receipt_Product"
            $linkProductSql = "INSERT INTO Receipt_Product (ReceiptID, ProductID, Quantity, Price) VALUES ($receiptID, $productID, $quantity, $price)";
            mysqli_query($conn, $linkProductSql);
        }

        // Thực hiện xong, có thể thông báo thành công cho người dùng
        echo "Receipt created successfully.";
    } else {
        // Đã xảy ra lỗi khi tạo phiếu nhập
        echo "Error creating receipt: " . mysqli_error($conn);
    }
}

// Kiểm tra xem phiếu nhập đã được tạo thành công hay không
if (isset($_POST['add_receipt'])) {
    // Thực hiện truy vấn để tạo phiếu nhập mới trong bảng "GoodReceipt"
    $insertReceiptSql = "INSERT INTO GoodReceipt (UserID, SupplierID, CreatedAt, Total) VALUES ($userID, $supplierID, '$createdAt', $total)";
    if (mysqli_query($conn, $insertReceiptSql)) {
        // Lấy ID của phiếu nhập mới tạo
        $receiptID = mysqli_insert_id($conn);

        // Lấy danh sách sản phẩm từ bảng goodreceipt_item dựa trên receiptID
        $query = "SELECT * FROM goodreceipt_item WHERE ReceiptID = $receiptID";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $productID = $row['ProductID'];
                $quantity = $row['Quantity'];

                // Kiểm tra sản phẩm có trong bảng product hay không
                $checkProductQuery = "SELECT * FROM product WHERE ProductID = $productID";
                $productResult = mysqli_query($conn, $checkProductQuery);

                if (mysqli_num_rows($productResult) > 0) {
                    // Sản phẩm đã tồn tại, thực hiện cập nhật số lượng
                    $updateQuery = "UPDATE product SET Quantity = Quantity + $quantity WHERE ProductID = $productID";
                    mysqli_query($conn, $updateQuery);
                } else {
                    // Sản phẩm chưa tồn tại, thực hiện thêm mới
                    $insertQuery = "INSERT INTO product (ProductID, Quantity) VALUES ($productID, $quantity)";
                    mysqli_query($conn, $insertQuery);
                }
            }
        }

        // Thực hiện xong, có thể thông báo thành công cho người dùng
        echo "Receipt created successfully.";
    } else {
        // Đã xảy ra lỗi khi tạo phiếu nhập
        echo "Error creating receipt: " . mysqli_error($conn);
    }
}




