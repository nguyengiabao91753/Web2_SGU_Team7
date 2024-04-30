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
            var addForm = $("#formadd");

            addButton.click(function() {
                addForm.slideDown(); // Sử dụng .show() của jQuery để hiển thị form
            });
        });
        // Nút đóng(removeButton)
        $(document).ready(function() {
            var removeButton = $("#remove");
            var addForm = $("#formadd");

            removeButton.click(function() {
                addForm.slideToggle();
            });
        });
        // Nút tạo(createButton)
    </script>
    <style>
        #formadd {
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
    // Kiểm tra kết nối
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lấy dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT UserID, FirstName, LastName, Email, Status, Phone, Address, Level FROM users";
    $result = mysqli_query($conn, $sql);
    // Kiểm tra xem truy vấn đã thực hiện thành công hay không
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function ReLoadUser(userid) {
    $("#formadd").slideDown();
    // Alert để kiểm tra xem userid đã đúng chưa
    //alert("update " + userid);
    $.ajax({
        url: '../chucnang/update.php',
        type: 'post',
        data: {
            Id: parseInt(userid),
            tableName: 'users'   
        },
        dataType: 'JSON',
        success: function(response) {
            console.log(response); // Log phản hồi JSON để kiểm tra
            if (response.error) {
                alert('Có lỗi xảy ra');
            } else {
                var addForm = $("#formadd");
                    addForm.find('input[id="inpUserID"]').val(response['data'].UserID);
                    addForm.find('input[id="firstname"]').val(response['data'].FirstName);
                    addForm.find('input[name="lastname"]').val(response['data'].LastName);
                    addForm.find('input[id="email"]').val(response['data'].Email);
                    addForm.find('input[name="phone"]').val(response['data'].Phone);
                    addForm.find('input[name="address"]').val(response['data'].Address);
                    addForm.find('select[name="level"]').val(response['data'].Level);
                    addForm.find('input[value="submit"]').attr('name', 'update_user');
                    //$('#level').val(response['data'].Level);
            }
        },
        error: function(error) {
            var errorMessage = (typeof error === 'object') ? JSON.stringify(error) : error;
            alert("Đã xảy ra lỗi: " + errorMessage);
        }

    });
}

// Hàm gửi yêu cầu cập nhật thông tin người dùng
function updateUserInfo() {
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var userId = $("#inpUserID").val(); 
    var level = $('#level').val();
    // Kiểm tra các trường có được nhập đầy đủ không
    if (firstname.trim() === '' || lastname.trim() === '' || email.trim() === '' || phone.trim() === '' || address.trim() === '') {
        alert('Vui lòng điền đầy đủ thông tin.');
        return;
    }
    // AJAX request để kiểm tra email tồn tại và cập nhật thông tin người dùng
    $.ajax({
        url: '../chucnang/update.php',
        type: 'post',
        data: {
            Id: userId,
            firstname: firstname,
            lastname: lastname,
            email: email,
            phone: phone,
            address: address,
            level: level,
            tableName: 'update',
            checkEmail: true // Thêm cờ này để chỉ định rằng đây là yêu cầu kiểm tra email tồn tại
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.exists) {
                alert('Email đã tồn tại trong cơ sở dữ liệu. Vui lòng chọn email khác.');
            } else {
                if (response.success) {
                    alert('Cập nhật thành công');
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            }
        },
        error: function(error) {
            var errorMessage = (typeof error === 'object') ? JSON.stringify(error) : error;
            alert("Đã xảy ra lỗi: " + errorMessage);
        }
    });
}
$(document).ready(function() {
    $("#submit").click(function() {
        updateUserInfo(); 
        $("#formadd").slideDown(); 
    });
});

</script>


    <style>
        #formadd {
            display: none;
        }

        #addbutton {
            width: 89.49px;
            height: 60px;
            font-size: 20px;
            margin: 5px 0 0 10px;
        }
    </style>
    <div class="card">
        <!--addButton and searchButton-->
        <div class="addform">
            <button id="addbutton" class="btn btn-tool">
                <i class="fa fa-plus-square"></i> <b>Add</b>
            </button>
            <!--addForm-->
            <form method="POST" action="" id="formadd"> 
    <div class="card">
    <a href="index.php?page=pages/Customer/list.php" ><button class="btn btn-primary" style="width: 80px; margin-left: 95%;border-radius: 10px;" id="add">Back</button></a>
        <div class="card-header">
            <h3 class="card-title">Customer update</h3>

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
            <input type="text" value="" id="inpUserID" name="UserID" hidden>
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label>Fist Name</label>
                        <input type="text" id="firstname" class="form-control" placeholder="Enter your last name" name="firstname" value="" require>
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" id="lastname" class="form-control" placeholder="Enter your last name" name="lastname" value="" require>
                        
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" class="form-control <?php echo isset($email) && empty($email) ? 'is-invalid' : ''; ?>" placeholder="Enter email" name="email" value="" require>
                <?php if(isset($email) && empty($email)): ?>
                    <div class="invalid-feedback">Email không được bỏ trống</div>
                <?php elseif(isset($email) && !isValidEmail($email)): ?>
                    <div class="invalid-feedback">Email không hợp lệ</div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" id="phone" class="form-control <?php echo isset($phone) && !isValidPhoneNumber($phone) ? 'is-invalid' : ''; ?>" placeholder="Enter phone number" name="phone" value="" require>
                <?php if(isset($phone) && empty($phone)): ?>
                    <div class="invalid-feedback">Số điện thoại không được bỏ trống</div>
                <?php elseif(isset($phone) && !isValidPhoneNumber($phone)): ?>
                    <div class="invalid-feedback">Số điện thoại không hợp lệ</div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <input type="text" id="address" class="form-control" placeholder="Enter address" name="address" value="" require>
            </div>
        </div>

        <div class="form-group">
            <label for="level">Level</label>
            <select class="form-control" id="level" name="level">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>



        <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="update_user" id="submit" value="submit">
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
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Level</th>
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
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "<td>" . $row['FirstName'] . "</td>";
                    echo "<td>" . $row['LastName'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td>" . $row['Level'] . "</td>";
                    echo '<td>
                            <button class="btn btn-danger btn-sm" >
                            <a onclick="ReLoadUser(' . $row['UserID'] . ')" style="color: white;">Update</a>
                            </button>
                            <input type="text" value="'. $row['UserID'] .'" id="inpUserID" name="UserID" hidden>
                        </td>';

                    echo '<td>
                            <a href="../chucnang/delete.php?userid=' . $row['UserID'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Bạn có muốn xóa tài khoản này không?\')" style="color: white;">Delete</a>
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

    <?php

    // Xử lý khi nhấn nút "Delete"
    if (isset($_POST['delete'])) {
        // Lấy id của bản ghi cần xóa
        $userid = $_POST['userid'];

        // Cập nhật trường "status" thành 0 cho bản ghi có id tương ứng
        $sql = "UPDATE users SET status = 0 WHERE userid = $userid";

        // Thực thi truy vấn
        if (mysqli_query($conn, $sql)) {
            echo "Cập nhật trạng thái thành công";
        } else {
            echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
        }
    }
    else{
        echo"khong được";
    }


    ?>