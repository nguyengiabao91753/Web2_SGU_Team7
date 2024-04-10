<?php
//Code lấy dữ liệu từ db
require_once("../db.php");
if (isset($_POST['createButton'])&&$_POST['createButton']){
    addProduct();
}
function getAll_Product(){
    global $conn;
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    // Kiểm tra truy vấn
    if (!$result) {
        die("Truy vấn không thành công: " . $conn->error);
    }
    $kq = [];

    // Lấy từng dòng một từ kết quả
    while ($row = $result->fetch_assoc()) {
        $kq[] = $row;
    }

    return $kq;
}

    function addProduct(){
        global $conn;
        $series =$_POST['series'] ;
        $CategoryID = $_POST['CategoryID'];
        $productName = $_POST['productname'];
        $uploadIMG = UploadIMG();
        $description = $_POST['description'];
        $feature= $_POST['feature'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $totalQuan = $_POST['totalquan'];
        $Quantity = $_POST['quantity'];
        $saleQuan = $_POST['salequan'];
    
    
    
        // Chuẩn bị câu truy vấn
        $sql = "INSERT INTO products (CategoryID, Series, ProductName, Image, Description, Feature, Price, Color, Size, TotalQuantity, Quantity, Sale_Quantity, Status) VALUES ('$CategoryID', '$series', '$productName', '$uploadIMG', '$description', '$feature', '$price', '$color', '$size', '$totalQuan', '$Quantity', '$saleQuan', 1)";
    
        // Thực hiện truy vấn
        if (mysqli_query($conn, $sql)) {
        //echo "Dữ liệu đã được thêm vào cơ sở dữ liệu thành công!";
        header("Location: ../admin2/index.php?page=pages/Product/list");
        } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
    
        // Đóng kết nối
        mysqli_close($conn);
    }

    function UploadIMG ()
    {
        $target_dir = "../admin2/img/";
        $target_file = $target_dir . basename($_FILES["uploadimg"]["name"]);
        $uploadIMG = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $flag = 1;
        //kiểm tra file có tồn tại chưa
        if (file_exists($target_file)) {
            $flag = 0;
        }
        //kiểm tra file đúng định dạng ảnh không
        if ($uploadIMG != "jpg" && $uploadIMG != "png" && $uploadIMG != "jpeg" && $uploadIMG != "gif" ) {
            echo '<script>alert("The File is not an Image")</script>';
            $flag = 0;
        }
        if ($flag == 0) {
            echo '<script>alert("Sorry, your file was not uploaded.Please try again")</script>';
        } else if (move_uploaded_file($_FILES["uploadimg"]["tmp_name"], $target_file)){
            return $target_file;
        }
    }

?>
