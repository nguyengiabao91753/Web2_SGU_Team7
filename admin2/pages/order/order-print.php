<?php
// require_once '../../../backend/Order.php';
// require_once '../backend/Product.php';
// require_once '../backend/User.php';


$orderID = $_GET['Id'];
$order = getOrderbyID($orderID);
$items = getItemsbyOrderID($orderID);
$cus = getCusbyId($order['UserID']);
?>

<script>
    
        //$('.callout.callout-info').hide();
        window.addEventListener("load", window.print());
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order-detail</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                </div>


                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> COZA STORE, Inc.
                                <small class="float-right">Date: <?php echo $order['CreatedAt'] ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Admin, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (804) 123-5432<br>
                                Email: info@almasaeedstudio.com
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong><?php echo $cus['FirstName'] . " " . $cus['LastName'] ?></strong><br>
                                <?php echo $cus['Address'] ?><br>
                                Phone: <?php echo $cus['Phone'] ?><br>
                                Email: <?php echo $cus['Email'] ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <!-- <b>Invoice #007612</b><br> -->
                            <br>
                            <b>Order ID:</b> <?php echo $order['OrderID'] ?><br>
                            <b>Payment Due:</b> <?php echo $order['CreatedAt'] ?><br>
                            <b>Account:</b> <?php echo $cus['Level'] ?>-<?php echo $cus['UserID'] ?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item) : ?>
                                        <?php $sp = getProByID($item['ProductID']) ?>
                                        <tr>
                                            <td><?php echo $sp['ProductID'] ?></td>
                                            <td><?php echo $sp['ProductName'] ?></td>
                                            <td><?php echo $item['Quantity'] ?></td>
                                            <td><?php echo $item['Price'] ?></td>
                                            <td><?php echo $item['Subtotal'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-6">
                            <p class="lead">Payment Methods: <b><?php echo $order['Payment'] ?></b></p>
                            <!-- <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> -->


                        </div>
                        <!-- /.col -->
                        <div class="col-6">

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Total:</th>
                                        <td>$<?php echo $order['TotalAmount'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->