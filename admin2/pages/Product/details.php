<?php
require_once '../backend/Product.php';
require_once '../backend/Category.php';
require_once '../db.php';

$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

if (isset($_GET['id'])) {
    $detailID = $_GET['id'];
    $kq = getProByID($detailID);
    echo '
    <div class="card">
        <!--Hinh anh cua sp-->
        <div class="row">
            <img class="card-img-top" src="'.$kq['Image'].'" alt="" style="height: 350px; width: auto; border: solid 1px; positon: relative; margin-left: 400px; margin-right: 400px; border-radius: 10px;">
        </div>

        <!--thong tin cua sp-->
        <div class="row">
            <div class="col-md-4 ">
                <label for="">Series: </label>
                <span class="card-text">'.$kq['Series'].'</span>
            </div>

            <div class="col-md-4">
                <label for="">CategoryID: </label>
                <span class="form-control">'.$kq['CategoryID'].'</span>
            </div>

            <div class="col-md-4">
                <label for="">ProductID: </label>
                <span class="form-control">'.$kq['ProductID'].'</span>
            </div>
        </div>

        <div>
            <label for="">Product name: </label>
            <span class="form-control">'.$kq['ProductName'].'</span>
        </div>

        <div class="row">
            <div class ="col-md-3">
                <label for="">Feature: </label>
                <span class="form-control">'.$kq['Feature'].'</span>
            </div>

            <div class ="col-md-3">
                <label for="">Color: </label>
                <span class="form-control">'.$kq['Color'].'</span>
            </div>

            <div class ="col-md-3">
                <label for="">Price: </label>
                <span class="form-control">'.$kq['Price'].'</span>
            </div>

            <div class ="col-md-3">
                <label for="">Size: </label>
                <span class="form-control">'.$kq['Size'].'</span>
            </div>
        </div>

        <div>
            <label for="">Description: </label>
            <span class="form-control">'.$kq['Description'].'</span>
        </div>
    </div>
        ';
                    
}

?>
<script>
   
</script>
<style>
    
</style>

<div>
    
</div>