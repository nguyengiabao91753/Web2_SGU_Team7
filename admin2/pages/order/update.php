<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy tham số orderID và newStatus từ URL
$orderID = isset($_GET['orderID']) ? $_GET['orderID'] : '';
$newStatus = isset($_GET['newStatus']) ? $_GET['newStatus'] : '';

// Kiểm tra xem orderID và newStatus có tồn tại không
if ($orderID !== '' && $newStatus !== '') {
    // Xây dựng câu truy vấn cập nhật trạng thái của đơn hàng
    $updateSql = "UPDATE orders SET Status = $newStatus WHERE OrderID = $orderID";

    // Thực hiện truy vấn cập nhật
    if (mysqli_query($conn, $updateSql)) {
        echo "Trạng thái đã được cập nhật thành công!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật trạng thái: " . mysqli_error($conn);
    }
} else {
    echo "Thiếu thông tin cần thiết để cập nhật trạng thái!";
}

// Đóng kết nối
mysqli_close($conn);
?>