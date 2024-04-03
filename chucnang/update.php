<?php
require_once '../db.php';
require_once '../controller/CategoryController.php';

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
}
?>