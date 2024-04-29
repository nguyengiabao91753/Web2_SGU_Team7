<script>
    // Lấy thẻ button và trường nhập mật khẩu
    var togglePassword = document.getElementById("togglePassword");
    var passwordField = document.getElementById("password");

    // Định nghĩa sự kiện click cho nút "Show"
    togglePassword.addEventListener("click", function() {
        // Nếu trường mật khẩu đang ở kiểu "password", chuyển sang kiểu "text"
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePassword.textContent = "Hide";
        } else { // Nếu trường mật khẩu đang ở kiểu "text", chuyển sang kiểu "password"
            passwordField.type = "password";
            togglePassword.textContent = "Show";
        }
    });
</script>
<?php
require_once '../db.php';
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

function isValidEmail($email) {
    // Biểu thức chính quy để kiểm tra tính hợp lệ của địa chỉ email
    $pattern = '/^[^0-9._][a-zA-Z0-9._-]*@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,}$/';
    // Sử dụng hàm preg_match để kiểm tra địa chỉ email với biểu thức chính quy
    return preg_match($pattern, $email);
}

// Kiểm tra tính hợp lệ của số điện thoại
function isValidPhoneNumber($phone) {
    return preg_match('/^0\d{9}$/', $phone);
}

// Kiểm tra tính hợp lệ của mật khẩu
function isValidPassword($matkhau) {
    return preg_match('/^.{8,}$/', $matkhau);
}
//Kiểm tra email trùng nhau
function isEmailAvailable($email, $conn) {
    $sql = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $matkhau = $_POST['password'];
    $status = 1;
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    if ($firstname == '' || $lastname == '' || $email == '' || $matkhau == '' || $phone == '' || $address == '' || !isValidPhoneNumber($phone) || !isValidEmail($email)) {
        echo "Vui lòng điền đầy đủ thông tin và chắc chắn rằng thông tin nhập vào là hợp lệ";
    } elseif (!isEmailAvailable($email, $conn)) {
        echo "Địa chỉ email đã được sử dụng. Vui lòng chọn địa chỉ email khác.";
    } else if(!isValidPassword($matkhau)) {
        echo "";
    }
    else {
        // // Chèn dữ liệu vào cơ sở dữ liệu
        // $sql = "INSERT INTO users (FirstName, LastName, Email, Phone, Address, Level, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        // $stmt = $conn->prepare($sql);
        // if (!$stmt) {
        //     die("Prepare failed: " . $conn->error);
        // }
        // $stmt->bind_param("sssisii", $firstname, $lastname, $email, $phone, $address, $level, $status);
        // if ($stmt->execute()) {
        //     echo "Thêm khách hàng mới thành công";
            
        // } else {
        //     echo "Lỗi: " . $stmt->error;
        // }
        // $stmt->close();
        // Chèn dữ liệu vào cả hai bảng Accounts và Users
// Chèn dữ liệu vào cả hai bảng Accounts và Users
// Lấy phần username từ địa chỉ email
$username = $email;
// Thiết lập giá trị mặc định cho cột Level là 3 (quyền user)
$defaultLevel = 3;
$sqlUsers = "INSERT INTO Users (FirstName, LastName, Email, Phone, Address, Level) VALUES (?, ?, ?, ?, ?, ?)";
$stmtUsers = $conn->prepare($sqlUsers);
$stmtUsers->bind_param("sssssi", $firstname, $lastname, $email, $phone, $address, $defaultLevel);

$sqlAccounts = "INSERT INTO Accounts (AccountID, Username, Password, Avatar) VALUES (LAST_INSERT_ID(), ?, ?, ?)";
$stmtAccounts = $conn->prepare($sqlAccounts);
$stmtAccounts->bind_param("sss", $username, $matkhau, $avatar);

// Thực hiện truy vấn INSERT cho bảng Users
if ($stmtUsers->execute()) {
    // Lấy ID của bản ghi vừa được thêm vào bảng Users
    $lastInsertedUserId = $stmtUsers->insert_id;

    // Thực hiện truy vấn INSERT cho bảng Accounts
    if ($stmtAccounts->execute()) {
        echo "Thêm khách hàng mới thành công";
    } else {
        echo "Lỗi: " . $stmtAccounts->error;
    }
} else {
    echo "Lỗi: " . $stmtUsers->error;
}

// Đóng kết nối và các câu lệnh prepare
$stmtUsers->close();
$stmtAccounts->close();
$conn->close();


    }
    // $conn->close();
    
}
?>

<form method="POST" action="">
    <!-- Default box -->
    <div class="card">
    <a href="index.php?page=pages/Customer/list.php" ><button class="btn btn-primary" style="width: 80px; margin-left: 95%;border-radius: 10px;" id="add">Back</button></a>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="firstname" class="form-control <?php echo isset($firstname) && empty($firstname) ? 'is-invalid' : ''; ?>" placeholder="Enter your first name" name="firstname" value="<?php echo isset($firstname) ? $firstname : ''; ?>">
                        <?php if(isset($firstname) && empty($firstname)): ?>
                            <div class="invalid-feedback">First name không được bỏ trống</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control <?php echo isset($lastname) && empty($lastname) ? 'is-invalid' : ''; ?>" placeholder="Enter your last name" name="lastname" value="<?php echo isset($lastname) ? $lastname : ''; ?>">
                        <?php if(isset($lastname) && empty($lastname)): ?>
                            <div class="invalid-feedback">Last name không được bỏ trống</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control <?php echo isset($email) && empty($email) ? 'is-invalid' : ''; ?>" placeholder="Enter email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                <?php if(isset($email) && empty($email)): ?>
                    <div class="invalid-feedback">Email không được bỏ trống</div>
                <?php elseif(isset($email) && !isValidEmail($email)): ?>
                    <div class="invalid-feedback">Email không hợp lệ</div>
                <?php endif; ?>
            </div>
                <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" id="password" class="form-control <?php echo isset($matkhau) && empty($matkhau) ? 'is-invalid' : ''; ?>" placeholder="Enter password" name="password" value="<?php echo isset($matkhau) ? $matkhau : ''; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">Show</button>
                    </div>
                    <?php if(isset($matkhau) && empty($matkhau)): ?>
                    <div class="invalid-feedback">Password không được bỏ trống</div>
                    <?php elseif(isset($matkhau) && !isValidPassword($matkhau)): ?>
                    <div class="invalid-feedback">Password không hợp lệ</div>
                <?php endif; ?>
                </div>   
            </div>

            <!-- <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control <?php echo isset($confirm_password) && empty($confirm_password) ? 'is-invalid' : ''; ?>" placeholder="Confirm password" name="confirm_password" value="<?php echo isset($confirm_password) ? $confirm_password : ''; ?>">
                <?php if(isset($confirm_password) && empty($confirm_password)): ?>
                    <div class="invalid-feedback">Password confirmation không được bỏ trống</div>
                <?php elseif(isset($matkhau) && isset($confirm_password) && $matkhau !== $confirm_password): ?>
                    <div class="invalid-feedback">Password confirmation không trùng khớp</div>
                <?php endif; ?>
            </div> -->

            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control <?php echo isset($phone) && !isValidPhoneNumber($phone) ? 'is-invalid' : ''; ?>" placeholder="Enter phone number" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                <?php if(isset($phone) && empty($phone)): ?>
                    <div class="invalid-feedback">Số điện thoại không được bỏ trống</div>
                <?php elseif(isset($phone) && !isValidPhoneNumber($phone)): ?>
                    <div class="invalid-feedback">Số điện thoại không hợp lệ</div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Enter address" name="address" value="<?php echo isset($address) ? $address : ''; ?>">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" name="create">Create</button>
        </div>
    </div>
    <!-- /.card -->
</form>