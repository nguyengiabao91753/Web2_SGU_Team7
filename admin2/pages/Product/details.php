<?php
require_once '../backend/Product.php';
require_once '../backend/Category.php';
require_once '../db.php';

$db = new DbConnect();
//global $conn;
$conn = $db->getConnect();

if (isset($_GET['id'])) {
    $detailID = $_GET['id'];
    $kq = getProByID($detailID);
    echo '
    
    <div class="container">
        <a class="btn btn-outline-info" href="../admin2/index.php?page=Product/list">Back</a>
        <h3>Product Information</h3>
        <div class="imgs">
            <!--Hinh anh cua sp-->
            <div class="row">
                <img class="card-img-top" src="' . $kq['Image'] . '" alt="" style="height: 350px; width: auto; border: solid 1px; positon: relative; margin-left: 400px; margin-right: 400px; border-radius: 10px;">
            </div>
        </div>

        <div class="block">
            <!--thong tin cua sp-->
            <div class="row">
                <div class="col-md-4 ">
                    <label for="">Series: </label>
                    <span class="form-control">' . $kq['Series'] . '</span>
                </div>

                <div class="col-md-4">
                    <label for="">CategoryID: </label>
                    <span class="form-control">' . $kq['CategoryID'] . '</span>
                </div>

                <div class="col-md-4">
                    <label for="">ProductID: </label>
                    <span class="form-control">' . $kq['ProductID'] . '</span>
                </div>
            </div>

            <div class="form-group">
                <label for="">Product name: </label>
                <span class="form-control">' . $kq['ProductName'] . '</span>
            </div>

            <div class="row">
                <div class ="col-md-3">
                    <label for="">Feature: </label>
                    <span class="form-control">' . $kq['Feature'] . '</span>
                </div>

                <div class ="col-md-3">
                    <label for="">Color: </label>
                    <span class="form-control">' . $kq['Color'] . '</span>
                </div>

                <div class ="col-md-3">
                    <label for="">Price: </label>
                    <span class="form-control">' . $kq['Price'] . '</span>
                </div>

                <div class ="col-md-3">
                    <label for="">Size: </label>
                    <span class="form-control">' . $kq['Size'] . '</span>
                </div>
            </div>

            <div class="form-group">
                <label for="">Description: </label>
                <span class="form-control" id="des">' . $kq['Description'] . '</span>
            </div>
        </div>
    </div>
        ';
}

?>
<script>

</script>
<style>
    label {
        padding: 15px 0 5px 0;
    }

    .container {
        border: 1px solid whitesmoke;
        background-color: white;
    }

    .block {
        padding-top: 40px;
    }

    #des {
        min-height: 150px;
    }

    .imgs {
        padding: 20px 0 10px 0;
    }

    h3 {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 36px;
        padding: 20px 0 0 380px;
        color: #8B0000;
    }
</style>

<div>

</div>
