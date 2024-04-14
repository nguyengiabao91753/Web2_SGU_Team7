<?php
//Code lấy dữ liệu từ db
require_once("../db.php");
if (isset($_POST['createButton'])&&$_POST['createButton']){
    addProduct();
} else if (isset($_GET['delete_product'])) {
    deleteProduct($_GET['delete_product']);
}
//Lấy tất cả sản phẩm
    function getAll_Product(){
        global $conn;
        $sql = "SELECT * FROM products WHERE Status = 1";
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
//Thêm sản phẩm
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
        header("Location: ../admin2/index.php?page=Product/list");
        } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
    
        // Đóng kết nối
        mysqli_close($conn);
    }
//Cập nhật sản phẩm 
    function updateProduct()
    {
        global $conn;
        if (isset($_POST['ProductID']) && isset($_POST['ProductID'])) {
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
    
            
                $sql = "UPDATE products SET ProductName='$productName', Series = '$series' ProductName='$productName',ProductName='$productName',ProductName='$productName',ProductName='$productName',ProductName='$productName',ProductName='$productName',ProductName='$productName'WHERE CategoryID=$CategoryID";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success'] = "Category updated successfully!";
                    header("Location: ../admin2/index.php?page=Category/list");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }
    }

//Xóa sản phẩm
    function deleteProduct($ProductID)
{
    global $conn;
    if (isset($ProductID)) {
        
        $sql = "UPDATE products SET Status = 0 WHERE ProductID=$ProductID";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['flash_message'] = "Product deleted successfully!";
            header("Location: ../admin2/index.php?page=Product/list");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
//Đếm số lượng sản phẩm
    function countProduct(){
        global $conn;
        $query = "SELECT COUNT(*) FROM products";
        $Count = mysqli_query($conn, $query);
        $row = mysqli_fetch_row($Count);
        $Count = (int)$row[0];
        return $Count;
    }
//Tải hình ảnh lên db
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

//Xử lý ajax lấy số trang
    if (isset($_GET['rowofPage'])) {
        $rowofPage = $_GET['rowofPage'];
        $total = countProduct();
        $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
        echo $page;
    }

//Xử lý ajax đây là search nhá
    if (isset($_POST['searchText'])) {
        $searchText = $_POST['searchText'];
        $query = "SELECT * FROM products WHERE ProductName LIKE '%$searchText%'";
        $result = mysqli_query($conn, $query);
        echo loadProductData();
    }
//Hiển thị sản phẩm
    function loadProductData() {
        $html = '';
                    $kq = getAll_Product();
                    
                        foreach ($kq as $sp) {
                            $Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";
                            
                            $html .='<tr>';
                            $html .= '<td>'.$sp['ProductID'].'</td>';
                            $html .= '<td>'.$Name.'</td>';
                            $html .= ' <td>'.$sp['Series'].'</td>';
                            $html .= '<td>'.$sp['ProductName'].'</td>';
                            $html .= '<td><img src="'.$sp['Image'].'" width="100px" height="50px"></td>';
                            $html .= '<td>'.$sp['Feature'].'</td>';
                            $html .= '<td>'.$sp['Color'].'</td> ';
                            $html .= '<td>'.$sp['Price'].' $</td>';
                            $html .= '<td>'.$sp['TotalQuantity'].'</td>';
                            $html .= '<td>
                                        <button type="button" onclick="update(this)" id="updateCate-' . $sp['ProductID'] . '" class="updateCategory btn btn-success">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>';
                            $html .= '<td>
                                        <button type="button" onclick="update(this)" id="updateProduct-' . $sp['ProductID'] . '" class="updateProduct btn btn-success">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>';
                            $html .= '<td>
                                        <a onclick="return confirmDelete()" href="../backend/Product.php?delete_product='.$sp['ProductID'].'">';
                                        $html .= '      <button class="btn btn-danger">';
                                        $html .= '        <i class="far fa-trash-alt"></i>';
                                        $html .= '      </button>';
                                        $html .= '    </a>';
                                        $html .= '  </td>';
                            $html .= '</tr>';
                        }
                        return $html;
    }
?>
