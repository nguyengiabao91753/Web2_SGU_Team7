<?php
require_once '../db.php';
require_once '../controller/CategoryController.php';
require_once '../controller/SupplierController.php';


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
}
?>