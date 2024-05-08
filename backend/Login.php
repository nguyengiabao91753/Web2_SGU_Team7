<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

if(isset($_POST['signin'])){
   
    login();
}
if(isset($_POST['clientlogin'])){
   
    loginclient();
}


function login(){
    global $conn;
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Truy vấn để lấy thông tin tài khoản dựa trên email
    $query = "SELECT * FROM Accounts WHERE Username = '$email' AND Status = 1 LIMIT 1";
    $rs = mysqli_query($conn, $query);

    if ($rs && mysqli_num_rows($rs) > 0) {
        $account = mysqli_fetch_assoc($rs);
        $hashedPassword = $account['Password'];

        if (password_verify($pass, $hashedPassword)) {

            $userID = $account['AccountID'];
            $query2 = "SELECT * FROM Users WHERE UserID = $userID LIMIT 1";
            $rsuser = mysqli_query($conn, $query2);

            if ($rsuser && mysqli_num_rows($rsuser) > 0) {
                $user = mysqli_fetch_assoc($rsuser);

                $levelId = $user['Level'];
                $query3 = "SELECT * FROM Levels WHERE LevelId = $levelId";
                $rslevel = mysqli_query($conn, $query3);

                if ($rslevel && mysqli_num_rows($rslevel) > 0) {
                    $level = mysqli_fetch_assoc($rslevel);
                    if ($level['Name'] == 'User') {
                        setcookie("err", "There are no permissions to access", time() + (86400 * 30), "/");
                        header("Location: ../admin2/index.php");
                        exit();
                    }
                }

                // Lưu UserID vào cookie và chuyển hướng đến trang người dùng
                setcookie("user_id", $user['UserID'], time() + (86400 * 30), "/");
                header("Location: ../admin2/index.php");
                exit();
            }
        }
    }

    setcookie("errlogin", "Invalid Account Or Locked", time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function loginclient()
{
    global $conn;
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM Accounts WHERE Username = '$email' AND Status = 1 LIMIT 1";
    $rs = mysqli_query($conn, $query);

    if ($rs && mysqli_num_rows($rs) > 0) {
        $account = mysqli_fetch_assoc($rs);
        $hashedPassword = $account['Password'];

        if (password_verify($pass, $hashedPassword)) {

            $userID = $account['AccountID'];
            $query2 = "SELECT * FROM Users WHERE UserID = $userID LIMIT 1";
            $rsuser = mysqli_query($conn, $query2);

            if ($rsuser && mysqli_num_rows($rsuser) > 0) {
                $user = mysqli_fetch_assoc($rsuser);

                // // Kiểm tra quyền của người dùng
                // $levelId = $user['Level'];
                // $query3 = "SELECT * FROM Levels WHERE LevelId = $levelId";
                // $rslevel = mysqli_query($conn, $query3);

                // if ($rslevel && mysqli_num_rows($rslevel) > 0) {
                //     $level = mysqli_fetch_assoc($rslevel);
                //     if ($level['Name'] == 'User') {
                //         // Không có quyền truy cập
                //         setcookie("err", "There are no permissions to access", time() + (86400 * 30), "/");
                //         header("Location: ../admin2/index.php");
                //         exit();
                //     }
                // }

                // Lưu UserID vào cookie và chuyển hướng đến trang người dùng
                setcookie("client", $user['UserID'], time() + (86400 * 30), "/");
                header("Location: ../client/index.php");
                exit();
            }
        }
    }

    setcookie("errlogin", "Invalid Account Or Locked", time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
