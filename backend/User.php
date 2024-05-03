<?php
require_once '../db.php';
require_once 'Userfunction.php';
require_once 'Account.php';

$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();


function getCusbyId($ID)
{
    global $conn;
    $query = "SELECT * FROM Users WHERE UserID = $ID LIMIT 1";
    $rs = mysqli_query($conn, $query);
    $cus = mysqli_fetch_assoc($rs);
    return $cus;
}


if (isset($_POST['add_user'])) {
    addUser();
} else if (isset($_POST['update_user'])) {
    updateUser();
} else if (isset($_GET['delete_user'])) {
    deleteUser($_GET['delete_user']);
}


//Xử lý ajax lấy số trang
if (isset($_POST['key']) && $_POST['key'] == 'countcuspage') {
    $rowofPage = $_POST['rowofPage'];
    $total = countUsers();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

if (isset($_POST['key']) && $_POST['key'] == 'countemppage') {
    $rowofPage = $_POST['rowofPage'];
    $total = countEmps();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

// //Xử lý ajax lấy user bởi id
// if (isset($_POST['UserID'])) {
//     $UserID = $_POST['UserID'];
//     $rs = getUserByID($UserID);
//     echo $rs;
// }

//Xử lý ajax search
if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $query = "SELECT * FROM users WHERE FirstName LIKE '%$searchText%' OR LastName LIKE '%$searchText%' OR Email LIKE '%$searchText%' OR Phone LIKE '%$searchText%' OR Address LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadUserData($result);
}

function getAllUsers()
{
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $users = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return $users;
    } else {
        return array();
    }
}

function getUserByID($ID)
{
    global $conn;
    $query = "SELECT * FROM users WHERE UserID = $ID LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    return $user;
}

function addUser()
{
    global $conn;
    if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['level'])) {
        $FirstName = $_POST['firstname'];
        $LastName = $_POST['lastname'];
        $Email = $_POST['email'];
        $Phone = $_POST['phone'];
        $Address = $_POST['address'];
        $Level = $_POST['level'];

        // Kiểm tra tính hợp lệ của email, số điện thoại và mật khẩu trước khi thêm vào cơ sở dữ liệu
        if (!isValidEmail($Email)) {
            setcookie("err", "Invalid email format!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (!isValidPhoneNumber($Phone)) {
            setcookie("err", "Invalid phone number format!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        if (!isEmailAvailable($Email, $conn,0)) {
            setcookie("err", "Email already exists!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $sql = "INSERT INTO users (FirstName, LastName, Email, Phone, Address, Level) VALUES ('$FirstName', '$LastName', '$Email', '$Phone', '$Address', $Level)";
        if ($conn->query($sql) === TRUE) {
            $userID = $conn->insert_id;
            setcookie("success", "User added successfully!", time() + (86400 * 30), "/");
            if(isset($_POST['password'])){
                $password = $_POST['password'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $avatar = null;
                $status = 1;
                $createdAt = date('Y-m-d H:i:s');
                $accountSql = "INSERT INTO accounts (AccountID, Username, Password, Avatar, Created_at, Status) VALUES ('$userID', '$Email', '$hashedPassword', '$avatar', '$createdAt', $status)";
                if ($conn->query($accountSql) === TRUE){
                }
            }
        } else {
            setcookie("err", "User added failed!", time() + (86400 * 30), "/");
        }
    } else {
        setcookie("err", "User added failed!", time() + (86400 * 30), "/");
    }
    //header("Location: ../admin2/index.php?page=Customer_backup/list");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function countUsers()
{
    global $conn;
    $query = "SELECT COUNT(*) FROM users WHERE Level = 3";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}

function countEmps(){
    global $conn;
    $query = "SELECT COUNT(*) FROM users WHERE Level != 3";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}

function updateUser()
{
    global $conn;
    if (isset($_POST['UserID'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['level'])) {
        $UserID = $_POST['UserID'];
        $FirstName = $_POST['firstname'];
        $LastName = $_POST['lastname'];
        $Email = $_POST['email'];
        $Phone = $_POST['phone'];
        $Address = $_POST['address'];
        $Level = $_POST['level'];

        // Kiểm tra tính hợp lệ của email, số điện thoại và mật khẩu trước khi thêm vào cơ sở dữ liệu
        if (!isValidEmail($Email)) {
            setcookie("err", "Invalid email format!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
        if (!isValidPhoneNumber($Phone)) {
            setcookie("err", "Invalid phone number format!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        if (!isEmailAvailable($Email, $conn, $UserID)) {
            setcookie("err", "Email already exists!", time() + (86400 * 30), "/");
           header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $sql = "UPDATE users SET FirstName='$FirstName', LastName='$LastName', Email='$Email', Phone='$Phone', Address='$Address', Level=$Level WHERE UserID=$UserID";
        if ($conn->query($sql) === TRUE) {
            setcookie("success", "User updated successfully!", time() + (86400 * 30), "/");
            if(isset($_POST['password'])){
                $password = $_POST['password'];
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                if(!isAccountIDExists($UserID)){
                    $avatar = null;
                    $status = 1;
                    $createdAt = date('Y-m-d H:i:s');
                    $accountSql = "INSERT INTO accounts (AccountID, Username, Password, Avatar, Created_at, Status) VALUES ('$UserID', '$Email', '$hashedPassword', '$avatar', '$createdAt', $status)";
                }else{
                    $accountSql = "UPDATE accounts SET Password = '$hashedPassword' WHERE AccountID = $UserID";
                }
               
                if ($conn->query($accountSql) === TRUE){
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    //header("Location: ../admin2/index.php?page=Customer_backup/list");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function deleteUser($UserID)
{
    global $conn;
    if (isset($UserID)) {
        // Set status = 0 instead of deleting
        $sql = "UPDATE users SET Status = 0 WHERE UserID=$UserID";
        if ($conn->query($sql) === TRUE) {
            // Set status = 0 for related accounts
            $sql_accounts = "UPDATE accounts SET Status = 0 WHERE AccountID=$UserID";
            $conn->query($sql_accounts);
            setcookie("success", "User deleted successfully!", time() + (86400 * 30), "/");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
   //header("Location: " . $_SERVER['HTTP_REFERER']);
   header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
function isValidEmail($email)
{
    // Biểu thức chính quy để kiểm tra tính hợp lệ của địa chỉ email
    $pattern = '/^[^0-9._][a-zA-Z0-9._-]*@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,}$/';
    // Sử dụng hàm preg_match để kiểm tra địa chỉ email với biểu thức chính quy
    return preg_match($pattern, $email);
}

// Kiểm tra tính hợp lệ của số điện thoại
function isValidPhoneNumber($phone)
{
    return preg_match('/^0\d{9}$/', $phone);
}

// Kiểm tra tính hợp lệ của mật khẩu
function isValidPassword($matkhau)
{
    return preg_match('/^.{8,}$/', $matkhau);
}
//Kiểm tra email trùng nhau
function isEmailAvailable($email, $conn, $UserID)
{
    $sql = "SELECT * FROM users WHERE Email = ? AND UserID != $UserID";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}
function loadUserData($rs)
{
    $html = '';
    while ($row = mysqli_fetch_assoc($rs)) {
        $level = getLevelbyId($row['Level']);
        // Kiểm tra trạng thái của mỗi hàng
        if ($row['Status'] != 0 && $level['Name'] == 'User') {

            $html .= "<tr>";
            $html .= "<td>" . $row['UserID'] . "</td>";
            $html .= "<td>" . $row['FirstName'] . "</td>";
            $html .= "<td>" . $row['LastName'] . "</td>";
            $html .= "<td>" . $row['Email'] . "</td>";
            //$html .= "<td>" . $row['Status'] . "</td>";
            $html .= "<td>" . $row['Phone'] . "</td>";
            $html .= "<td>" . $row['Address'] . "</td>";
            $html .= "<td>" . $level['Name'] . "</td>";
            $html .= '<td>
            <button class="btn btn-success" >
            <a onclick="update(' . $row['UserID'] . ')""> <i class="far fa-edit"></i></a>
            </button>
           
        </td>';

            $html .= '<td>
            <a href="../backend/Customer.php?delete_user=' . $row['UserID'] . '" class="btn btn-danger" onclick="return confirm(\'Bạn có muốn xóa tài khoản này không?\')""><i class="far fa-trash-alt"></i></a>
        </td>';
            $html .= "</tr>";
        }
    }

    return $html;
}

 function loadEmployeeData($rs)
{
    $html = '';
    while ($row = mysqli_fetch_assoc($rs)) {
        $level = getLevelbyId($row['Level']);
        $emp_login = getCusbyId($_COOKIE['user_id']);
       
        if ($row['Status'] != 0 && $level['Name'] != 'User') {

            $html .= "<tr>";
            $html .= "<td>" . $row['UserID'] . "</td>";
            $html .= "<td>" . $row['FirstName'] . "</td>";
            $html .= "<td>" . $row['LastName'] . "</td>";
            $html .= "<td>" . $row['Email'] . "</td>";
            //$html .= "<td>" . $row['Status'] . "</td>";
            $html .= "<td>" . $row['Phone'] . "</td>";
            $html .= "<td>" . $row['Address'] . "</td>";
            $html .= "<td>" . $level['Name'] . "</td>";
            if($emp_login['Level'] <= $row['Level']){

                $html .= '<td>
                <button class="btn btn-success" >
                <a onclick="update(' . $row['UserID'] . ')""> <i class="far fa-edit"></i></a>
                </button>
                
                </td>';
            }
            
            $html .= "<td>";
            if ($_COOKIE['user_id'] != $row['UserID'] && $emp_login['Level'] < $row['Level']) {


                $html .= "<a href='../backend/Customer.php?delete_user=" . $row['UserID'] . "' class='btn btn-danger' onclick=\"return confirm('Bạn có muốn xóa tài khoản này không?')\"><i class='far fa-trash-alt'></i></a>";
            }
            $html .="</td>";
            $html .= "</tr>";
        }
    }

    return $html;
}
