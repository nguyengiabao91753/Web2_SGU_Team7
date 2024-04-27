<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

// Định nghĩa các biến phân trang
$limit = 6; // Số bản ghi mỗi trang
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Lấy tham số status từ URL
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Xây dựng câu truy vấn dựa trên trạng thái và phân trang
$sql = "SELECT * FROM orders";
if ($status !== '') {
    $statusArray = explode(',', $status);
    $statusCondition = implode(',', array_map('intval', $statusArray));
    $sql .= " WHERE Status IN ($statusCondition)";
}
$sql .= " LIMIT $limit OFFSET $offset";

// Thực hiện truy vấn dữ liệu từ bảng "orders"
$result = mysqli_query($conn, $sql);

// Đếm số lượng đơn hàng
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));

echo '<div class="card-body">
    <table id="example" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Mã người dùng</th>
                <th>Số lượng</th>
                <th>Tổng giá</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>';

// Kiểm tra nếu có dữ liệu
if (mysqli_num_rows($result) > 0) {
    // Bắt đầu vòng lặp để hiển thị dữ liệu trong tbody
    while ($row = mysqli_fetch_assoc($result)) {
        // Chuyển đổi giá trị status thành các trạng thái tương ứng
        switch ($row["Status"]) {
            case 1:
                $statusText = "Chờ xác nhận";
                break;
            case 2:
                $statusText = "Đang giao";
                break;
            case 3:
                $statusText = "Đã giao";
                break;
            default:
                $statusText = "Không xác định";
                break;
        }

        // Thêm dòng dữ liệu vào tbody
        echo '<tr>';
        echo '<td>' . $row["OrderID"] . '</td>';
        echo '<td>' . $row["UserID"] . '</td>';
        echo '<td>' . $row["Quantity"] . '</td>';
        echo '<td>' . $row["TotalAmount"] . '</td>';
        echo '<td>' . $row["Payment"] . '</td>';
        echo '<td>' . $statusText . '</td>';
        echo '<td>' . $row["CreatedAt"] . '</td>';
        // Thêm nút "Duyệt" với orderID và status được truyền vào hàm JavaScript
        echo '<td><button onclick="approveOrder(' . $row["OrderID"] . ', ' . $row["Status"] . ')">Duyệt</button></td>';
        echo '</tr>';
    }
} else {
    // Nếu không có dữ liệu, hiển thị bảng trống với tất cả các cột
    echo '<tr><td colspan="8">Không có đơn hàng.</td></tr>';
}

echo '</tbody>
    </table>
</div>';

// Phân trang
$total_pages = ceil($total_orders / $limit);
echo '<div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" style="float: left; margin-left: 4%;">Đang hiển thị ' . ($offset + 1) . ' đến ' . min(($offset + $limit), $total_orders) . ' trên tổng số ' . $total_orders . ' đơn hàng</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                <ul class="pagination" style="float: right; margin-right: 4%;">';

// Liên kết Trang trước
$prev = $page - 1;
echo '<li class="paginate_button page-item ' . ($prev <= 0 ? 'disabled' : '') . '"><a href="index.php?page=' . $prev . '&status=' . $status . '" class="page-link">Trước</a></li>';

// Các liên kết trang có số
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="paginate_button page-item ' . ($i == $page ? 'active' : '') . '"><a href="index.php?page=' . $i . '&status=' . $status . '" aria-controls="example1" data-dt-idx="' . $i . '" tabindex="0" class="page-link">' . $i . '</a></li>';
}

// Liên kết Trang sau
$next = $page + 1;
echo '<li class="paginate_button page-item ' . ($next > $total_pages ? 'disabled' : '') . '"><a href="index.php?page=' . $next . '&status=' . $status . '" class="page-link">Tiếp theo</a></li>';

echo '</ul>
            </div>
        </div>
    </div>';

// Đóng kết nối
mysqli_close($conn);
?>

<script>
function approveOrder(orderID, currentStatus) {
    var newStatus;
    if (currentStatus == 1) {
        newStatus = 2;
    } else if (currentStatus == 2) {
        newStatus = 3;
    } else if (currentStatus == 3) {
        alert("Đơn hàng này đã được giao.");
        return;
    }
    
    var confirmation = confirm("Bạn có chắc chắn muốn duyệt đơn hàng này?");
    if (confirmation) {
        // Tạo một đối tượng XMLHttpRequest
        var xhttp = new XMLHttpRequest();
        
        // Thiết lập hàm xử lý phản hồi từ máy chủ
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Hiển thị phản hồi từ máy chủ
                //console.log(this.responseText);
                // Nếu cập nhật thành công, tải lại trang
                // if (this.responseText === "Trạng thái đã được cập nhật thành công!") {
                //     //window.location.href = window.location.href; 
                   
                // } 
                window.location.href = window.location.href; 
            }
        };
        
        // Mở kết nối và gửi yêu cầu Ajax đến máy chủ
        xhttp.open("GET", "index.php?page=pages/order/update&orderID=" + orderID + "&newStatus=" + newStatus, true);
        xhttp.send();
        
    }
}

</script>
