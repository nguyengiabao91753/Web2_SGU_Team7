<?php
    array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">');
    array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">');
    array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">');
    array_push($jsStack, '<script src="plugins/datatables/jquery.dataTables.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>');
    array_push($jsStack, '<script src="plugins/jszip/jszip.min.js"></script>');
    array_push($jsStack, '<script src="plugins/pdfmake/pdfmake.min.js"></script>');
    array_push($jsStack, '<script src="plugins/pdfmake/vfs_fonts.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>');
    array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>');


    array_push($jsStack, '
            <script>
                $(function() {
                    $("#example1, #example2").DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo(\'#example1_wrapper .col-md-6:eq(0)\');
                });

                function confirmDelete() {
                    return confirm(\'Are you sure you want to delete this?\');
                }
            </script>
        ');

?>
<script>
        // Nút thêm(addButton)
        $(document).ready(function() {
            var addButton = $("#addbutton");
            var addForm = $("#formadaccount");

            addButton.click(function() {
                addForm.slideDown(); // Sử dụng .show() của jQuery để hiển thị form
            });
        });
        // Nút đóng(removeButton)
        $(document).ready(function() {
            var removeButton = $("#remove");
            var addForm = $("#formadaccount");

            removeButton.click(function() {
                addForm.slideToggle();
            });
        });
        // Nút tạo(createButton)
    </script>
    <style>
        #formadaccount {
            display: none;
        }

        #addbutton{
            width: 89.49px; 
            height: 60px;
            font-size: 20px;
            margin: 5px 0 0 10px;
        }
        
    </style> 

<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

    // Lấy dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT AccountID, Username, Password, Avatar, Created_at, Status FROM accounts";
    $result = mysqli_query($conn, $sql);
    // Kiểm tra xem truy vấn đã thực hiện thành công hay không
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
?>   

<script>
function ReLoadAccount(userid) {
    $("#formadaccount").slideDown();
    // Alert để kiểm tra xem userid đã đúng chưa
    //alert("update " + userid);
    $.ajax({
        url: '../chucnang/update.php',
        type: 'post',
        data: {
            AccountID: parseInt(userid),
            tableName: 'accounts'   
        },
        dataType: 'JSON',
        success: function(response) {
            console.log(response); // Log phản hồi JSON để kiểm tra
            if (response.error) {
                alert('Có lỗi xảy ra');
            } else {
                var addForm = $("#formadaccount");
                addForm.find('input[id="AccountID"]').val(response['data'].AccountID);
                addForm.find('input[id="username"]').val(response['data'].Username); // Load lại giá trị của username
                addForm.find('input[id="password"]').val(response['data'].Password); // Load lại giá trị của password
                addForm.find('input[id="avatar"]').val(response['data'].Avatar); // Thêm dữ liệu Avatar
            }
        },
        error: function(error) {
            var errorMessage = (typeof error === 'object') ? JSON.stringify(error) : error;
            alert("Đã xảy ra lỗi: " + errorMessage);
        }
    });
}

// Hàm gửi yêu cầu cập nhật thông tin người dùng
function updateAccountInfo() {
    var username = $("#username").val();
    var matkhau = $("#password").val();
    var avatar = $("#avatar").val();
    var accountId = $("#AccountID").val(); 

    // Kiểm tra các trường có được nhập đầy đủ không
    if (username.trim() === '' || matkhau.trim() === '') {
        alert('Vui lòng điền đầy đủ thông tin.');
        return;
    }

    // AJAX request để kiểm tra email tồn tại và cập nhật thông tin người dùng
    $.ajax({
        url: '../chucnang/update.php',
        type: 'post',
        data: {
            AccountID: accountId, 
            username: username,
            password: matkhau,
            avatar: avatar,
            tableName: 'updateaccount',
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.success) {
                alert('Cập nhật thành công');
                 window.location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + response.message);
            }
        },
        error: function(xhr, status, error) { // Thêm tham số error
            var errorMessage = (typeof error === 'object') ? JSON.stringify(error) : error;
            alert("Đã xảy ra lỗi: " + errorMessage);
        }
    });
}

$(document).ready(function() {
    $("#submit").click(function() {
        updateAccountInfo(); 
        $("#formadaccount").slideDown(); 
    });
});

</script>


<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if(isset($_POST['update_user'])) {
//         $target_dir = "uploads/";
//         $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
//         $uploadOk = 1;
//         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//         // Kiểm tra xem tệp tin đã tồn tại chưa
//         if (file_exists($target_file)) {
//             echo "Tệp tin đã tồn tại.";
//             $uploadOk = 0;
//         }

//         // // Kiểm tra kích thước tệp tin
//         // if ($_FILES["avatar"]["size"] > 500000) {
//         //     echo "Tệp tin quá lớn.";
//         //     $uploadOk = 0;
//         // }

//         // // Cho phép chỉ tải lên các loại tệp tin hình ảnh
//         // if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//         //     && $imageFileType != "gif") {
//         //     echo "Chỉ cho phép tải lên các tệp tin hình ảnh JPG, JPEG, PNG, GIF.";
//         //     $uploadOk = 0;
//         // }

//         // Kiểm tra biến $uploadOk
//         if ($uploadOk == 0) {
//             echo "<p class='text-danger'>Tải lên tệp tin không thành công.</p>";
//         } else {
//             if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
//                 $avatarFileName = basename($_FILES["avatar"]["name"]);
//                 echo "<p class='text-success'>Tệp tin " . htmlspecialchars($avatarFileName) . " đã được tải lên thành công.</p>";
//                 echo "<img src='uploads/" . htmlspecialchars($avatarFileName) . "' alt='Uploaded Avatar' style='max-width: 200px;'>";
//             // Tiến hành cập nhật thông tin người dùng trong cơ sở dữ liệu
//             $accountId = $_POST['AccountID'];
//             $sql = "UPDATE accounts SET Avatar=? WHERE AccountID=?";
//             $stmt = $conn->prepare($sql);
//             if (!$stmt) {
//                 die("Prepare failed: " . $conn->error);
//             }
//             $stmt->bind_param("si", $avatarFileName, $accountId);
//             if ($stmt->execute()) {
//                 echo "<p class='text-success'>Đã cập nhật ảnh vào cơ sở dữ liệu.</p>";
//             } else {
//                 echo "<p class='text-danger'>Có lỗi xảy ra khi cập nhật ảnh vào cơ sở dữ liệu: " . $stmt->error . "</p>";
//             }
//             $stmt->close();
//         } else {
//             echo "<p class='text-danger'>Có lỗi xảy ra khi tải lên tệp tin.</p>";
//         }
//         }
//     }
// }
?>
<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if(isset($_POST['update_user'])) {
//         $target_dir = "uploads/";
//         $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
//         $uploadOk = 1;
//         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//         // Kiểm tra xem tệp tin đã tồn tại chưa
//         if (file_exists($target_file)) {
//             $message = "Tệp tin đã tồn tại.";
//             $uploadOk = 0;
//         }

//         // Kiểm tra biến $uploadOk
//         if ($uploadOk == 0) {
//             $message = "Tải lên tệp tin không thành công.";
//         } else {
//             if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
//                 $avatarFileName = basename($_FILES["avatar"]["name"]);
//                 $message = "Tệp tin " . htmlspecialchars($avatarFileName) . " đã được tải lên thành công.";
//                 $message .= "<br><img src='uploads/" . htmlspecialchars($avatarFileName) . "' alt='Uploaded Avatar' style='max-width: 200px;'>";
//                 // Tiến hành cập nhật thông tin người dùng trong cơ sở dữ liệu
//                 $accountId = $_POST['AccountID'];
//                 $sql = "UPDATE accounts SET Avatar=? WHERE AccountID=?";
//                 $stmt = $conn->prepare($sql);
//                 if (!$stmt) {
//                     die("Prepare failed: " . $conn->error);
//                 }
//                 $stmt->bind_param("si", $avatarFileName, $accountId);
//                 if ($stmt->execute()) {
//                     $message .= "<br>Đã cập nhật ảnh vào cơ sở dữ liệu.";
//                 } else {
//                     $message .= "<br>Có lỗi xảy ra khi cập nhật ảnh vào cơ sở dữ liệu: " . $stmt->error;
//                 }
//                 $stmt->close();
//             } else {
//                 $message = "Có lỗi xảy ra khi tải lên tệp tin.";
//             }
//         }
//     }
// }
?>
<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if(isset($_FILES['avatar'])) {
//         // Đường dẫn tạm thời của tệp tải lên
//         $imageTmpPath = $_FILES["avatar"]["tmp_name"];

//         // Đọc dữ liệu nhị phân của ảnh
//         $imageData = file_get_contents($imageTmpPath);

//         // Tiến hành cập nhật thông tin người dùng trong cơ sở dữ liệu
//         $accountId = $_POST['AccountID'];
//         $sql = "UPDATE accounts SET Avatar=? WHERE AccountID=?";
//         $stmt = $conn->prepare($sql);
//         if (!$stmt) {
//             die("Prepare failed: " . $conn->error);
//         }
//         $stmt->bind_param("si", $imageData, $accountId);
//         if ($stmt->execute()) {
//             $message = "Đã cập nhật ảnh vào cơ sở dữ liệu.";
//         } else {
//             $message = "Có lỗi xảy ra khi cập nhật ảnh vào cơ sở dữ liệu: " . $stmt->error;
//         }
//         $stmt->close();
//     }
// }

?>


<div class="card">
    <!-- addButton and searchButton -->
    <div class="addform">
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <!-- addForm -->
        <form method="POST" action="" id="formadaccount" enctype="multipart/form-data">
            <div class="card">
                <a href="index.php?page=pages/Customer/list.php"><button class="btn btn-primary" style="width: 80px; margin-left: 95%;border-radius: 10px;" id="add">Back</button></a>
                <div class="card-header">
                    <h3 class="card-title">Customer create</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="text" value="" id="AccountID" name="AccountID" hidden>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" id="username" class="form-control" placeholder="Enter your username" name="username" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" id="avatar" class="form-control" name="avatar">
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" name="update_user" id="submit" value="Submit">
                </div>
            </div>
            <!-- /.card -->
        </form>
    </div>
        <div class="card-header">
            <!-- <h3 class="card-title">Customer list</h3> -->
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
            
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="example1_filter" class="dataTables_filter" style="float: right; margin-right: 4%;">
                    Search:<input type="search" class="form-control form-control-sm" placeholder="">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Account</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Avatar</th>
                        <th>Create At</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    if (isset($result) && $result !== null) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               
                // Kiểm tra trạng thái của mỗi hàng
                if ($row['Status'] != 0) {
                    echo "<tr>";
                    echo "<td>" . $row['AccountID'] . "</td>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>" . $row['Password'] . "</td>";
                    // Lấy dữ liệu ảnh từ cơ sở dữ liệu và hiển thị nó
                    echo "<td><img src='uploads/" . $row['Avatar'] . "' alt='Avatar' width='80' height='50'></td>";
                    echo "<td>" . $row['Created_at'] . "</td>";
                    echo '<td>
                            <button class="btn btn-danger btn-sm" >
                            <a onclick="ReLoadAccount(' . $row['AccountID'] . ')" style="color: white;">Update</a>
                            </button>
                            <input type="text" value="'. $row['AccountID'] .'" id="AccountID" name="AccountID" hidden>
                        </td>';

                    echo '<td>
                            <a href="./pages/Customer/delete.php?userid=' . $row['AccountID'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Bạn có muốn xóa tài khoản này không?\')" style="color: white;">Delete</a>
                        </td>';
                    echo "</tr>";
                    
                }
            }
        } else {
            echo "0 results";
        }
    } else {
        echo "Query failed or no result returned.";
    }
    // Đóng kết nối
    mysqli_close($conn);
    ?>   
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" style="float: left; margin-left: 4%;">Showing 1 to 6 of 6 entries</div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                    <ul class="pagination" style="float: right; margin-right: 4%;">
                        <li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" class="page-link">Previous</a></li>
                        <li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                        <li class="paginate_button page-item next disabled" id="example1_next"><a href="#" class="page-link">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>