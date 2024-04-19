<?php
require_once '../db.php';
$db = new DbConnect();
$conn=$db->getConnect();

require_once '../backend/Category.php';
require_once '../backend/Supplier.php';
require_once '../backend/Product.php';


$tableName = $_GET['tableName'];
$pageNumber = isset($_GET['pageNumber']) ? (int)$_GET['pageNumber'] : 1;
$rowofPage = isset($_GET['rowofPage']) ? (int)$_GET['rowofPage'] : 10;
$rowStart = (int)(($pageNumber - 1) * $rowofPage);
$ID = $_GET['ID'];


$query = "SELECT * FROM $tableName
        ORDER BY $ID
        Limit $rowStart, $rowofPage;";
$result = mysqli_query($conn, $query);


if (mysqli_num_rows($result) > 0) {
    if ($tableName == 'categories') {
        $html = '';
        $html = loadCateData($result);
    }else if($tableName == 'suppliers'){
        $html='';
        $html = loadSupplierData($result);
    } else if ($tableName == 'products') {
        $html = '';
        $html =loadProductData();
    } else if($tableName=='goodsreceipt_items'){
        
    }

    echo $html;
} else {
    echo "Failed";
}
