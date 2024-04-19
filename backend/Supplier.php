<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();


if(isset($_POST['add_supplier'])){
    addSupplier();
}else if(isset($_POST['update_supplier'])){
    updateSupplier();
}else if(isset($_GET['delete_supplier'])){
    deleteSupplier($_GET['delete_supplier']);
}
//Xử lý ajax lấy số trang
if (isset($_GET['rowofPage'])) {
    $rowofPage = $_GET['rowofPage'];
    $total = countSuppliers();
    $page = ((float) ($total / $rowofPage) > (int)($total / $rowofPage)) ? ((int)($total / $rowofPage)) + 1 : (int) ($total / $rowofPage);
    echo $page;
}

//Xử lý ajax lấy supp bởi id
if (isset($_POST['SupplierID'])) {
    $SupplierID = $_POST['SupplierID'];
    $rs = getSupplierByID($SupplierID);
    echo $rs;
}

//Xử lý ajax đây là search nhá
if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    $query = "SELECT * FROM suppliers WHERE Name LIKE '%$searchText%'";
    $result = mysqli_query($conn, $query);
    echo loadSupplierData($result);
}

function getAllSupplier(){
    global $conn;
    $query = "SELECT * FROM suppliers";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $supplier = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $supplier[] = $row;
        }
        return $supplier;
    } else {
        return array();
    }
}

function getSupplierByID($ID)
{
    global $conn;
    $query = "SELECT * FROM suppliers WHERE SuppliId = $ID LIMIT 1";
    $result = mysqli_query($conn, $query);
    $supplier = mysqli_fetch_assoc($result);
    return $supplier;
}

function addSupplier()
{
    global $conn;
    if (isset($_POST['name'], $_POST['address'], $_POST['email'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];

       

        $sql = "INSERT INTO suppliers (Name, Address, Email) VALUES ('$name', '$address', '$email')";
        if ($conn->query($sql) === TRUE) {
            //$_SESSION['success'] = "Supplier added successfully!";
            setcookie("success","Supplier added successfully!",time() + (86400 * 30), "/");
        } else {
            
            setcookie("err","Supplier added failed!",time() + (86400 * 30), "/");
        }
    } else {
        setcookie("err","Supplier added failed!",time() + (86400 * 30), "/");

    }
    header("Location: ../admin2/index.php?page=Supplier/list");
    exit();
}

function countSuppliers()
{
    global $conn;

    $query = "SELECT COUNT(*) FROM Suppliers";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $count = (int)$row[0];
    return $count;
}

function updateSupplier()
{
    global $conn;
    if (isset($_POST['SuppliId'], $_POST['name'], $_POST['address'], $_POST['email'])) {
        $supplierID = $_POST['SuppliId'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];

        // Thêm logic kiểm tra hợp lệ ở đây nếu cần

        $sql = "UPDATE Suppliers SET Name='$name', Address='$address', Email='$email' WHERE SuppliId=$supplierID";
        if ($conn->query($sql) === TRUE) {
            setcookie("success","Supplier updated successfully!",time() + (86400 * 30), "/");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    header("Location: ../admin2/index.php?page=Supplier/list");
    exit();
}

function deleteSupplier($SupplierID)
{
    global $conn;
    if (isset($SupplierID)) {
        $sql = "DELETE FROM Suppliers WHERE SuppliId=$SupplierID";
        if ($conn->query($sql) === TRUE) {
            setcookie("success","Supplier deleted successfully!",time() + (86400 * 30), "/");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    header("Location: ../admin2/index.php?page=Supplier/list");
    exit();
}


function loadSupplierData($result)
{
    $html = '';

    while ($supplier = mysqli_fetch_assoc($result)) {

        $html .= '<tr>';
        $html .= '  <td class="SuppliId">' . $supplier['SuppliId'] . '</td>';
        $html .= '  <td>' . $supplier['Name'] . '</td>';
        $html .= '  <td>' . $supplier['Address'] . '</td>';
        $html .= '  <td>' . $supplier['Email'] . '</td>';
        $html .= '  <td>';
        $html .= '      <button type="button" onclick="update(this)" id="updateSupplier-' . $supplier['SuppliId'] . '" class="updateSupplier btn btn-success">';
        $html .= '        <i class="far fa-edit"></i>';
        $html .= '      </button>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <a onclick="return confirmDelete()" href="../controller/SupplierController.php?delete_supplier=' . $supplier['SuppliId'] . '">';
        $html .= '      <button class="btn btn-danger">';
        $html .= '        <i class="far fa-trash-alt"></i>';
        $html .= '      </button>';
        $html .= '    </a>';
        $html .= '  </td>';
        $html .= '</tr>';
    }

    return $html;
}
