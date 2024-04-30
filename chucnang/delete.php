<?php
if(isset($_GET['userid'])){
    $deleteid = $_GET['userid'];
    require_once '../db.php';
    $db = new DbConnect();
    //global $conn;
    $conn=$db->getConnect();
    

    // Cập nhật trạng thái của bản ghi trong bảng users thành 0
    $sqlUsers = "UPDATE users SET Status = 0 WHERE UserID = $deleteid";
    if (mysqli_query($conn, $sqlUsers)) {
        // Cập nhật trạng thái của bản ghi trong bảng accounts thành 0
        $sqlAccounts = "UPDATE accounts SET Status = 0 WHERE AccountID = $deleteid";
        if (mysqli_query($conn, $sqlAccounts)) {
            // Chuyển hướng người dùng sau khi cập nhật thành công
            header("Location: ../admin2/index.php?page=pages/Customer/list");
            exit(); // Dừng kịch bản ngay sau khi chuyển hướng
        } else {
            echo "Lỗi khi cập nhật dữ liệu từ bảng accounts: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi khi cập nhật dữ liệu từ bảng users: " . mysqli_error($conn);
    }
}