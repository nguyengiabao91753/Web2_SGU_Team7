<?php
require_once '../backend/Order.php';
require_once '../backend/Product.php';
$items = getItemsInOrder();
$order = getOrder();
?>
<script>
    $(document).ready(function() {
        $('.btn-num-product-down').click(function() {
            var inputQuantity = $(this).siblings('.num-product');
            var currentVal = parseInt(inputQuantity.val());
            var orderItemID = inputQuantity.attr('name').replace('num-product', '');
            
            if (currentVal === 0) {
                if(confirm('You will remove this product form your cart')){
                   removeitem(orderItemID);
                }
            }
            $('button[name="up-' + orderItemID + '"]').removeAttr('disabled');



            if (!isNaN(currentVal)) {
                updateQuantity(orderItemID, currentVal);
                // Thực hiện cập nhật số lượng sản phẩm và subtotal tại đây
            }
        });

        $('.btn-num-product-up').click(function() {
            var inputQuantity = $(this).siblings('.num-product');
            var max = inputQuantity.attr('max');
            var currentVal = parseInt(inputQuantity.val());
            var orderItemID = inputQuantity.attr('name').replace('num-product', '');
            if (currentVal == max) {
                $(this).attr('disabled', true);

            }
            $('button[name="down-' + orderItemID + '"]').removeAttr('disabled');

            if (!isNaN(currentVal)) {
                updateQuantity(orderItemID, currentVal);
                // Thực hiện cập nhật số lượng sản phẩm và subtotal tại đây
            }
        });


    });

    function removeitem(orderItemID){
        $('#total').empty();
        $.ajax({
            type: 'post',
            url: '../backend/Order.php',
            data: {
                key: 'remove-item',
                orderItemID: orderItemID
            },
            dataType: 'json',
            success:function(response){
                $('#item-'+orderItemID).hide();
                $('#total').append(response['data'].total);
                
            }
        });
    }

    function updateQuantity(orderItemID, quantity) {
        $('#subtotal-' + orderItemID + '').empty();
        $('#total').empty();
        $.ajax({
            type: 'POST',
            url: '../backend/Order.php',
            data: {
                key: 'update-quantity',
                orderItemID: orderItemID,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                $('#subtotal-' + orderItemID + '').append(response['data'].subtotal);
                $('#total').append(response['data'].total);

            },
            error: function(error) {
                // Xử lý lỗi nếu có
                alert("error");
            }
        });
    }
</script>
<br>
<br>
<br>
<br>
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            Shoping Cart
        </span>
    </div>
</div>


<!-- Shoping Cart -->

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <div class="m-l-25 m-r--38 m-lr-0-xl">
                <div class="wrap-table-shopping-cart">
                    <table class="table-shopping-cart">
                        <tr class="table_head">
                            <th class="column-1">Product</th>
                            <th class="column-2"></th>
                            <th class="column-3">Price</th>
                            <th class="column-4">Quantity</th>
                            <th class="column-5">Total</th>
<<<<<<< HEAD
=======
                           
>>>>>>> f55ed077d85af65cf137b481726e0f4f067cac55
                        </tr>
                        <?php foreach ($items as $item) : ?>
                            <?php


                            $sp = getProByID($item['ProductID']);
                            ?>
<<<<<<< HEAD
                            <tr class="table_row">
=======
                            <tr class="table_row" id="item-<?php echo $item['OrderItemID'] ?>">                              
>>>>>>> f55ed077d85af65cf137b481726e0f4f067cac55
                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="<?php echo $sp['Image'] ?>" alt="IMG">
                                    </div>
                                </td>
                                <td class="column-2"><?php echo $sp['ProductName'] ?></td>
                                <td class="column-3">$ <?php echo $item['Price'] ?></td>
                                <td class="column-4">
                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
<<<<<<< HEAD
                                        <button class="btn btn-sm btn-outline-secondary btn-num-product-down" type="button">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </button>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product<?php echo $item['OrderItemID'] ?>" value="<?php echo $item['Quantity'] ?>">

                                        <button class="btn btn-sm btn-outline-secondary btn-num-product-up" type="button">
=======
                                        <button class="btn btn-sm btn-outline-secondary btn-num-product-down" name="down-<?php echo $item['OrderItemID'] ?>" type="button">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </button>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product<?php echo $item['OrderItemID'] ?>" value="<?php echo $item['Quantity'] ?>" max="<?php echo $sp['Quantity'] ?>">

                                        <button class="btn btn-sm btn-outline-secondary btn-num-product-up" name="up-<?php echo $item['OrderItemID'] ?>" type="button">
>>>>>>> f55ed077d85af65cf137b481726e0f4f067cac55
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td id="subtotal-<?php echo $item['OrderItemID'] ?>" class="column-5">$ <?php echo $item['Subtotal'] ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">
                    Cart Totals
                </h4>


                <form action="../backend/Order.php" method="post">
                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Payment
                            </span>
                        </div>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm" style="width: 100%;">


                            <div class="p-t-15">


                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <select class="js-select2" name="payment">
                                        <option value="Payment on delivery">Payment on delivery</option>
                                        <option value="Banking">Banking</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span id="total" class="mtext-110 cl2">
                                <?php if (isset($order['TotalAmount'])) echo "$" . $order['TotalAmount']; ?>
                            </span>
                        </div>
                    </div>
                    <input type="number" name="OrderID" value="<?php echo $order['OrderID'] ?>" hidden>
                    <!-- <a type="su" class="btn btn-outline-secondary btn-lg">                  
                        Proceed to Checkout
                        </a> -->
<<<<<<< HEAD
                    <button type="submit" name="checkout" class="btn btn-outline-secondary btn-lg">Proceed to Checkout</button>
=======
                    <button type="submit" name="approve" class="btn btn-outline-secondary btn-lg">Proceed to Checkout</button>
>>>>>>> f55ed077d85af65cf137b481726e0f4f067cac55
                </form>
            </div>
        </div>
    </div>
</div>