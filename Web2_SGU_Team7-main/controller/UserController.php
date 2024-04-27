
<?php
//Không chạy được nên không dùng file usercontroller.php này
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();
// if(isset($_POST['update_user'])){
//     //header("Location: ../../index.php?page=pages/Customer/create");
//     //UpdateUser();
// }
function getcusbyID($ID)
{
    global $conn;

    $query = "SELECT * FROM users WHERE UserID = $ID Limit 1";
    $r = mysqli_query($conn, $query);
    $Cus = mysqli_fetch_assoc($r);
    return $Cus;
}

function getcusbyAccountID($ID)
{
    global $conn;

    $query = "SELECT * FROM accounts WHERE AccountID = $ID Limit 1";
    $r = mysqli_query($conn, $query);
    $Cus = mysqli_fetch_assoc($r);
    return $Cus;
}
//Lỗi nên không dùng ở đây nữa
// function UpdateUser(){
//     global $conn;    
//     // Kiểm tra nếu biểu mẫu đã được gửi đi
//     if (isset($_POST['firstname'])) { 
//         // Lấy dữ liệu từ biểu mẫu
//         $userId = $_POST['Id'];
//         $firstName = $_POST['firstname'];
//         $lastName = $_POST['lastname'];
//         $email = $_POST['email'];
//         $phone = $_POST['phone'];
//         $address = $_POST['address'];

//         // Cập nhật dữ liệu vào cơ sở dữ liệu
//         $sql = "UPDATE users SET FirstName='$firstName', LastName='$lastName', Email='$email', Phone='$phone', Address='$address' WHERE UserID=$userId";

//         if ($conn->query($sql) === TRUE) {
//             $response = array("success" => true, "message" => "Cập nhật thành công");
//             echo json_encode($response);
//         } else {
//             $response = array("error" => true, "message" => "Lỗi khi cập nhật: " . $conn->error);
//             echo json_encode($response);
//         }

//     }
//     $conn->close();
// }
