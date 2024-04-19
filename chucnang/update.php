<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

require_once '../backend/Category.php';
require_once '../backend/Supplier.php';
require_once '../backend/Product.php';


$Id = $_POST['Id'];

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
}
?>
