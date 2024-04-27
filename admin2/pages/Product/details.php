<?php
require_once '../backend/Product.php';
require_once '../backend/Category.php';
require_once '../db.php';

$db = new DbConnect();
//global $conn;
$conn=$db->getConnect();

if (isset($_GET['id'])) {
    $detailID = $_GET['id'];
    getProByID($detailID);
    $kq = getProByID($detailID);
    foreach ($kq as $sp){
        echo '
                
            ';
    }
                    
}

?>
<script>
   
</script>
<style>

</style>

<div>
    <div class="container">
        <!--Hinh anh cua sp-->
        <div class="row">

        </div>

        <!--thong tin cua sp-->
        <div class="row">
            <div class="col-md-4">
                <label for="">Series</label>
                <i></i>
            </div>

            <div class="col-md-4">
                <label for="">CategoryID</label>
                <i></i>
            </div>

            <div class="col-md-4">
                <label for="">ProductID</label>
                <i></i>
            </div>
        </div>

        <div>
            <label for="">Product name</label>
        </div>

        <div class="row">
            <div class ="col-md-3">
                <label for="">Feature</label>
                <i></i>
            </div>

            <div class ="col-md-3">
                <label for="">Color</label>
                <i></i>
            </div>

            <div class ="col-md-3">
                <label for="">Price</label>
                <i></i>
            </div>

            <div class ="col-md-3">
                <label for="">Size</label>
                <i></i>
            </div>
        </div>

        <div>
            <label for="">Description</label>
            <i></i>
        </div>
    </div>
</div>
