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

        // Output as JSON for JavaScript processing
        echo json_encode($response);
    } else {
        // Handle the case where category data is not found
        echo json_encode(array('error' => 'Category not found'));
    }
}
?>