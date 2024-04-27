<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

require_once '../backend/Category.php';
require_once '../backend/Supplier.php';
require_once '../backend/Product.php';
require_once '../controller/UserController.php';


//$Id = $_POST['Id'];
//$AccountID = $_POST['AccountID'];
if($_POST['tableName'] == 'categories'){
    $cate = getCateByID($Id);
    if(!empty($cate)){
        $response['data'] = array(
            'CategoryID' => $cate['CategoryID'],
            'CategoryName' => $cate['CategoryName'],
            'parentID' => $cate['parentID']
        );

        
        echo json_encode($response);
    } else {
       
        echo json_encode(array('error' => 'Category not found'));
    }
}else if($_POST['tableName'] == 'suppliers'){
    $supp = getSupplierByID($Id);
    if(!empty($supp)){
        $response['data'] = array(
            'SuppliId' => $supp['SuppliId'],
            'Name' => $supp['Name'],
            'Address' => $supp['Address'],
            'Email' => $supp['Email']
        );

        
        echo json_encode($response);
    } else {
       
        echo json_encode(array('error' => 'Category not found'));
    }
}else if ($_POST['tableName'] == 'products') {
    $pro = getProByID($Id);
    if(!empty($pro)){
        $response['data'] = array(
            'Series' => $pro['Series'],
            'ProductID'=>$pro['ProductID'],
            'CaterogyID' => $pro['CategoryID'],
            'ProductName' => $pro['ProductName'],
            'Description' => $pro['Description'],
            'Feature' => $pro['Feature'],
            'Price' => $pro['Price'],
            'Color' => $pro['Color'],
            'Size' => $pro['Size'],
            'TotalQuantity'=>$pro['TotalQuantity'],
            'Quantity' => $pro['Quantity'],
            'Sale_Quantity'=> $pro['Sale_Quantity']
        );

        
        echo json_encode($response);
    } else {
       
        echo json_encode(array('error' => 'Category not found'));
    }
} else if($_POST['tableName'] == 'users'){
    $Id = $_POST['Id'];
    $cus = getcusbyID($Id);
    if(!empty($cus)){
        // In ra dữ liệu của biến $cus để debug
        //var_dump($cus); // Hoặc sử dụng print_r($cus);
        $response['data'] = array(
            'UserID' => $cus['UserID'],
            'FirstName' => $cus['FirstName'],
            'LastName' => $cus['LastName'],
            'Email' => $cus['Email'],
            'Phone' => $cus['Phone'],
            'Address' => $cus['Address'],
            'Level' => $cus['Level']
            
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'User not found'));
    }
} else if($_POST['tableName'] == 'accounts'){
    // Đảm bảo $AccountID đã được gán giá trị từ dữ liệu POST trước
    $AccountID = $_POST['AccountID'];
    
    $cus = getcusbyAccountID($AccountID);
    if(!empty($cus)){
        // In ra dữ liệu của biến $cus để debug
        //var_dump($cus); // Hoặc sử dụng print_r($cus);
        $response['data'] = array(
            'AccountID' => $cus['AccountID'],
            'Username' => $cus['Username'],
            'Password' => $cus['Password'],
            'Avatar' => $cus['Avatar'],
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'User not found'));
    }
}
//Update lên database 
if ($_POST['tableName'] == 'update') {
    // Lấy dữ liệu từ biểu mẫu
    $userId = $_POST['Id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $checkmail = $_POST['checkEmail'];
    $level = $_POST['level'];
    if (isset($email) && isset($checkmail)) {
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        $sql = "SELECT Email FROM users WHERE Email = ? AND UserID != ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("si", $email, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode(array("exists" => true));
            exit(); // Dừng xử lý tiếp nếu email tồn tại
        }
        $stmt->close();
    }
    // Tiến hành cập nhật thông tin người dùng
    $sql = "UPDATE users SET FirstName=?, LastName=?, Email=?, Phone=?, Address=?, Level=? WHERE UserID=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssssii", $firstname, $lastname, $email, $phone, $address, $level, $userId);
    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "Lỗi khi cập nhật: " . $stmt->error));
    }
    $stmt->close();
}
//Update Account lên database 
if ($_POST['tableName'] == 'updateaccount') {
    // Lấy dữ liệu từ biểu mẫu
    $accountId = $_POST['AccountID'];
    $username = $_POST['username'];
    $matkhau = $_POST['password'];
    $avatar = $_POST['avatar'];
    // Xử lý tải lên ảnh từ form
    // if (!empty($_FILES['avatar']['name'])) {
    //     $hinhanhpath = basename($_FILES['avatar']['name']);
    //     // Đường dẫn lưu trữ file ảnh
    //     $target_dir = "uploads/";
    //     $target_file = $target_dir . $hinhanhpath;
    //     // Di chuyển file ảnh vào thư mục uploads
    //     if (move_uploaded_file($_FILES["avatar"]["name"], $target_file)) {
    //         echo "Hình đã được upload";
    //     } else {
    //         echo "Lỗi khi tải lên ảnh";
    //         exit; // Dừng việc thực hiện tiếp nếu có lỗi xảy ra
    //     }
    // } else {
    //     // Nếu không có ảnh mới, sử dụng ảnh cũ từ cơ sở dữ liệu
    //     $hinhanhpath = $_POST['avatar'];
    // }
    // Tiến hành cập nhật thông tin người dùng
    $sql = "UPDATE accounts SET Username=?, Password=?, Avatar=? WHERE AccountID=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssi", $username, $matkhau, $avatar, $accountId); 
    if ($stmt->execute()) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "message" => "Lỗi khi cập nhật: " . $stmt->error));
    }
    $stmt->close();
}


?>
