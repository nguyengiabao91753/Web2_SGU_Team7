<?php
require_once '../db.php';
$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

require_once '../backend/Category.php';
require_once '../backend/Supplier.php';
require_once '../backend/Product.php';
require_once '../backend/User.php';


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
else if($_POST['tableName'] == 'suppliers'){
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
else if ($_POST['tableName'] == 'products') {
    $prod = getProByID($Id);
    
    if(!empty($prod)){
        $response['data'] = array(
            'Series' => $prod['Series'],
            'ProductID'=>$prod['ProductID'],
            'CategoryID' => $prod['CategoryID'],
            'ProductName' => $prod['ProductName'],
            'Description' => $prod['Description'],
            'Feature' => $prod['Feature'],
            'Price' => $prod['Price'],
            'Color' => $prod['Color'],
            'Size' => $prod['Size'],
            'TotalQuantity'=>$prod['TotalQuantity'],
            'Quantity' => $prod['Quantity'],
            'Sale_Quantity'=> $prod['Sale_Quantity']
        );

        
        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'Product not found'));
    }
}else 
if ($_POST['tableName'] == 'users'){
    $user = getCusbyId($Id);
   
    if(!isAccountIDExists($Id)){
        $acc['Password'] ="";
    }else{
        $acc = getAccountByID($Id);
    }
    if(!empty($user)){
        $response['data'] = array(
            'userID'=> $user['UserID'],
            'firstname'=> $user['FirstName'],
            'lastname'=> $user['LastName'],
            'email'=> $user['Email'],
            'phone'=> $user['Phone'],
            'address'=>$user['Address'],
            'level'=> $user['Level'],
            'password'=>$acc['Password']
        );
        echo json_encode($response);
    }else {
        echo json_encode(array('error' => 'User not found'));
    }
}
?>