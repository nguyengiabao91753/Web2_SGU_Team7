<?php
require_once '../db.php';
$db = new DbConnect();
$conn=$db->getConnect();

require_once '../backend/Category.php';
require_once '../backend/Supplier.php';
require_once '../backend/Product.php';
require_once '../backend/Order.php';
require_once '../backend/User.php';
require_once '../backend/Account.php';
require_once '../backend/Warehouse_demo.php';




$tableName = $_GET['tableName'];
$pageNumber = isset($_GET['pageNumber']) ? (int)$_GET['pageNumber'] : 1;
$rowofPage = isset($_GET['rowofPage']) ? (int)$_GET['rowofPage'] : 10;
$rowStart = (int)(($pageNumber - 1) * $rowofPage);
$ID = $_GET['ID'];
if(isset($_GET['key'])){

    $key=$_GET['key'];
}

$query = "SELECT * FROM $tableName
        ORDER BY $ID desc
        Limit $rowStart, $rowofPage;";
$result = mysqli_query($conn, $query);

$html='';

if (mysqli_num_rows($result) > 0) {
    if ($tableName == 'categories') {
        $html = loadCateData($result);
    }else if($tableName == 'suppliers'){
        $html = loadSupplierData($result);
    } else if ($tableName == 'products') {
        $key=$_GET['key'];
        switch ($key) {
            case 'client':
                $html = '';
                $html = LoadProductClient($result);
                break;

            case 'feature':
                $result = getProByFeature();
                $html = '';
                $html = LoadProductClient($result);
                break;
            case 'admin':
                $html = '';
                $html = loadProductData($result);
                break;
        }
    } else if($tableName=='goodsreceipt'){
        $html= loadWarehouse($result);
        
    }else if($tableName == 'orders'){
        if($key == 'pending'){
            $html= loadOrderData($result,1);
        }else if($key == 'delivering'){
            $html= loadOrderData($result,2);
        }else if($key == 'delivered'){
            $html= loadOrderData($result,3);
        }
    }elseif($tableName== "users"){
        if($key == 'cus'){
            $html='';
            $html = loadUserData($result);
        }else{
            $html='';
            $html=loadEmployeeData($result);
        }
    }elseif($tableName== 'Accounts'){
        if($key == 'accemp'){
            $html='';
            $html = loadAccountEmp($result);
        }else{
            $html='';
            $html=loadAccountUser($result);
        }
    }

    echo $html;
} else {
    echo "Failed";
}