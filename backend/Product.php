<?php
//Code lấy dữ liệu từ db
//  session_start();

require_once '../db.php';
require_once 'Category.php';
$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();

if (isset($_POST['add_product'])) {
    addProduct();
} else if (isset($_GET['delete_product'])) {
    deleteProduct($_GET['delete_product']);
} else if (isset($_POST['update_product'])) {
    updateProduct();
} else if (isset($_GET['cate'])) {
    $kq = getProByCate($_GET['cate']);
    LoadProductClient($kq);
}
//Lấy tất cả sản phẩm
function getAll_Product()
{
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
//Lấy theo ID
function getProByID($ID)
{
    global $conn;
    $query = "SELECT * FROM products WHERE ProductID = $ID Limit 1";
    $r = mysqli_query($conn, $query);
    $Pro = mysqli_fetch_assoc($r);
    return $Pro;
}
//Thêm sản phẩm
function addProduct()
{
    global $conn;
    $series = $_POST['series'];
    $CategoryID = $_POST['CategoryID'];
    $productName = $_POST['productname'];
    $uploadIMG = UploadIMG();
    $description = $_POST['description'];
    $feature = $_POST['feature'];
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
        header("Location: ../admin2/index.php?page=Product/list");
        setcookie("success", "Product added successfully!", time() + (86400 * 30), "/");
        exit();
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
    if (isset($_POST['ProductID'])) {
        $series = $_POST['series'];
        $ProductID = $_POST['ProductID'];
        $CategoryID = $_POST['CategoryID'];
        $productName = $_POST['productname'];
        $newIMG = updateProductImage($ProductID);
        $description = $_POST['description'];
        $feature = $_POST['feature'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $size = $_POST['size'];
        $totalQuan = $_POST['totalquan'];
        $Quantity = $_POST['quantity'];
        $saleQuan = $_POST['salequan'];

        $sql = "UPDATE products SET Series='$series', ProductName='$productName', Image='$newIMG', Description = '$description', Feature='$feature', Price = '$price', Color='$color', Size ='$size',  CategoryID= $CategoryID, TotalQuantity='$totalQuan', Quantity='$Quantity', Sale_Quantity = '$saleQuan', Status = 1
            WHERE ProductID = $ProductID            ";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Product updated successfully!";
            header("Location: ../admin2/index.php?page=Product/list");
            setcookie("success", "Product updated successfully!", time() + (86400 * 30), "/");
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
            header("Location: ../admin2/index.php?page=Product/list");
            setcookie("success", "Product deleted successfully!", time() + (86400 * 30), "/");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
//Đếm số lượng sản phẩm
function countProduct()
{
    global $conn;
    $query = "SELECT COUNT(*) FROM products WHERE Status = 1";
    $Count = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($Count);
    $Count = (int)$row[0];
    return $Count;
}
//Tải hình ảnh lên db
function UploadIMG()
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
    if ($uploadIMG != "jpg" && $uploadIMG != "png" && $uploadIMG != "jpeg" && $uploadIMG != "gif") {
        echo '<script>alert("The File is not an Image")</script>';
        $flag = 0;
    }
    if ($flag == 0) {
        echo '<script>alert("Sorry, your file was not uploaded.Please try again")</script>';
    } else if (move_uploaded_file($_FILES["uploadimg"]["tmp_name"], $target_file)) {
        return $target_file;
    }
}

//đổi hình ảnh
function updateProductImage($productId)
{
    global $conn;

    $newImageName = UploadIMG();
    // Lấy đường dẫn hoặc tên tệp hình ảnh hiện tại của sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT Image FROM products WHERE ProductID = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentImageName = $row["Image"];

        // Xóa hình ảnh hiện tại từ thư mục lưu trữ
        $imagePath = "../img/" . $currentImageName;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Xóa tệp hình ảnh
        }

        // Cập nhật thông tin hình ảnh mới của sản phẩm trong cơ sở dữ liệu
        $sql = "UPDATE products SET Image = '$newImageName' WHERE ProductID = $productId";
        if ($conn->query($sql) === TRUE) {
            // Cập nhật thành công
            return $newImageName;
        } else {
            // Xảy ra lỗi khi cập nhật cơ sở dữ liệu
            return false;
        }
    } else {
        // Không tìm thấy sản phẩm trong cơ sở dữ liệu
        return false;
    }
}

//Xử lý ajax lấy cate bởi id
if (isset($_POST['ProductID'])) {
    $productId = $_POST['ProductID'];
    $rs = getProByID($productId);
    echo $rs;
}

//Xử lý ajax lấy số trang
if (isset($_POST['key']) && $_POST['key'] == "countproducts") {
    $rowofPage = $_POST['rowofPage'];
    $total = countProduct();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

//Xử lý ajax đây là search nhá
if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $query = "SELECT * FROM products WHERE ProductName LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadProductData($result);
}

// Xử lý ajax show sp khi click cate
if (isset($_POST['key']) && $_POST['key'] == 'cate-click') {
    $CategoryID = $_POST['CategoryID'];
    $query = "SELECT * FROM products WHERE CategoryID = $CategoryID";
    $rs = mysqli_query($conn, $query);
    $html = LoadProductClient($rs);
    if (mysqli_num_rows($rs) > 0) {

        echo $html;
    } else
        echo "failed";
}

//Hiển thị sản phẩm
function loadProductData($kq)
{
    $html = '';
    //$kq = getAll_Product();

    foreach ($kq as $sp) {
        $Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";

        $html .= '<tr>';
        $html .= '<td>' . $sp['ProductID'] . '</td>';
        $html .= '<td>' . $Name . '</td>';
        $html .= ' <td>' . $sp['Series'] . '</td>';
        $html .= '<td>' . $sp['ProductName'] . '</td>';
        $html .= '<td><img src="' . $sp['Image'] . '" width="100px" height="50px"></td>';
        $html .= '<td>' . $sp['Feature'] . '</td>';
        $html .= '<td>' . $sp['Color'] . '</td> ';
        $html .= '<td>' . $sp['Price'] . ' $</td>';
        $html .= '<td>' . $sp['TotalQuantity'] . '</td>';
        $html .= '<td>
                                        <div class="proddetails">
                                            <a href="../admin2/index.php?page=Product/details&id=' . $sp['ProductID'] . '">Details</a>
                                        </div>
                                    </td>';
        $html .= '<td>
                                        <button type="button" onclick="update(this)" id="updateProduct-' . $sp['ProductID'] . '" class="updateProduct btn btn-success">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>';
        $html .= '<td>
                                        <a onclick="return confirmDelete()" href="../backend/Product.php?delete_product=' . $sp['ProductID'] . '">';
        $html .= '      <button class="btn btn-danger">';
        $html .= '        <i class="far fa-trash-alt"></i>';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        $html .= '</tr>';
    }
    return $html;
}

function LoadProductClient($kq)
{
    $cc = '';

    foreach ($kq as $sp) {
        $Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";

        $cc .= '<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item" id="' . $Name . '">';
        $cc .= '<a href="index.php?content=product-detail&id=' . $sp['ProductID'] . '">';
        $cc .= '<div class="block2">';
        $cc .= '<div class="block2-pic hov-img0">';
        $cc .= '<img src="' . $sp['Image'] . '" alt="IMG-PRODUCT" style="width: 270px; height: 330px;">';
        $cc .= '</div>';
        $cc .= '<div class="block2-txt flex-w flex-t p-t-14">';
        $cc .= '<div class="block2-txt-child1 flex-col-l ">';
        $cc .= '<a href="index.php?content=product-detail&id='.$sp['ProductID'].'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">';
        $cc .= $sp['ProductName'];
        $cc .= '</a>';
        $cc .= '<span class="stext-105 cl3">';
        $cc .= $sp['Price'];
        $cc .= '</span>';
        $cc .= '</div>';
        $cc .= '</div>';
        $cc .= '</div>';
        $cc .= '</a>';
        $cc .= '</div>';
    }
    //$cc = '';
    return $cc;
}

function getProByCate($cate)
{
    if (isset($_POST['cate'])) {
        global $conn;
        $sql = "SELECT * FROM products WHERE Status = 1 AND CategoryID = $cate";
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
}

function getProByFeature()
{
    global $conn;
    $sql = "SELECT * FROM products WHERE Status = 1 AND Feature = 'Feature'";
    $result = $conn->query($sql);

    //test func
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

function getProBySeries($ID){
    global $conn;
    $sql = "SELECT * FROM products WHERE Series IN (
                                                        SELECT Series
                                                        FROM products
                                                        GROUP BY Series
                                                        HAVING COUNT(*) > 1
                                                    );
    ";
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

    //Xóa dòng dữ liệu có ID = ID sản phẩm
    foreach ($kq as $key=> $sp){
        if($sp['ProductID'] == $ID){
            unset($kq[$key]);
        }
    }

    return $kq;
}