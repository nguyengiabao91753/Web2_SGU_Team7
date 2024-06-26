<?php
require_once '../backend/Product.php';
require_once '../backend/Category.php';

$sp = getProByID($_GET['id']);

$Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";
$pro = getProBySeries($_GET['id']);
?>

<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi giá trị của input thay đổi
        $('#num').change(function() {
            var quantity = parseInt($(this).val());
            updateButtons(quantity);
            console.log(quantity);
        });
        // Hàm điều chỉnh sự hiển thị của các nút
        function updateButtons(quantity) {
            if (quantity <= 1) {
                $('#decrease').addClass('disabled'); // Thêm lớp disabled
                $('#decrease').prop('disabled', true); // Ngăn chặn sự kiện click  
            } else {
                $('#decrease').removeClass('disabled'); // Xóa lớp disabled
                $('#decrease').prop('disabled', false); // Cho phép sự kiện click
            }

            if (quantity >= <?php echo $sp['Quantity'] ?>) {
                $('#increase').addClass('disabled'); // Thêm lớp disabled
                $('#increase').prop('disabled', true); // Ngăn chặn sự kiện click
            } else {
                $('#increase').removeClass('disabled'); // Xóa lớp disabled
                $('#increase').prop('disabled', false); // Cho phép sự kiện click
            }
        }

        // Xử lý sự kiện khi nút giảm được nhấp
        $('#decrease').click(function() {
            var quantity = parseInt($('#num').val());
            if (quantity > 1) {
                quantity - 1; // Giảm giá trị
                $('#num').val(quantity); // Cập nhật giá trị trong input
                updateButtons(quantity); // Cập nhật sự hiển thị của các nút
            } else {
                $('#num').val(1); // Cập nhật giá trị trong input
                updateButtons(1); // Cập nhật sự hiển thị của các nút
            }
        });

        // Xử lý sự kiện khi nút giảm được nhấp
        $('#increase').click(function() {
            var quantity = parseInt($('#num').val());
            if (quantity <= <?php echo $sp['Quantity'] ?>) {
                quantity + 1; // Giảm giá trị
                $('#num').val(quantity); // Cập nhật giá trị trong input
                updateButtons(quantity); // Cập nhật sự hiển thị của các nút
            }
        });
    });
</script>



<style>
    #bread {
        margin-top: 80px;
    }

    .row {
        margin-bottom: 45px;
    }

    .disabled {
        opacity: 0.5;
        /* Đặt độ mờ */
        pointer-events: none;
        /* Ngăn chặn sự kiện nhấp chuột */
    }
</style>
<script>
    $(document).ready(function() {
        // $('.js-addcart-detail').click(function() {


        // });

        $('.js-addcart-detail').each(function() {
            $(this).on('click', async function() {
                <?php
                if (!isset($_COOKIE['client'])) :
                ?>
                    alert("Hãy đăng nhập trước khi mua hàng");
                    return false;
                <?php endif; ?>
                var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();

                var buttonID = $(this).attr('id');
                var productID = buttonID.split('-')[1];

                var ProductID = parseInt(productID);
                var Quantity = $('.num-product').val();
                var Price = $('.pro-price').text();
                //     alert(Quantity);
                // alert(Price);

                await $.ajax({
                    url: '../backend/Order.php',
                    type: 'post',
                    data: {
                        ProductID: ProductID,
                        Quantity: parseInt(Quantity),
                        Price: parseInt(Price),
                        key: 'add-order'
                    },
                    success: function(response) {
                        // alert(response);
                        if (response) {
                            //alert("true");
                            swal(nameProduct, "is added to cart !", "success")
                            .then(async (value) => {
                                
                                await $.ajax({
                                    url: '../backend/Order.php',
                                    type: 'get',
                                    data:{
                                        key: "update-viewcart"
                                    },
                                    success: function(count) {
                                        $('#cart-icon').attr('data-notify', count);
                                    },
                                    error: function() {
                                        alert("Error fetching cart count.");
                                    }
                                });
                            });

                            // setTimeout(function() {
                            //     window.location.reload(true);
                            // }, 1500); // Thời gian tính bằng mili giây, ở đây là 3 giây
                        } else {
                            //swal(nameProduct, "is added failed !", "error");
                            alert(response);
                        }
                    }

                })


            });
        });
    });
</script>
<!-- breadcrumb -->
<div class="container" id="bread">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="?content=shop" class="stext-109 cl8 hov-cl1 trans-04">
            <?php echo $Name; ?>
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            <?php echo $sp['ProductName']; ?>
        </span>
    </div>
</div>


<?php
echo '
               
                <!-- Product Detail -->
                <section class="sec-product-detail bg0 p-t-65 p-b-60">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-lg-7 p-b-30">
                                <div class="p-l-25 p-r-30 p-lr-0-lg">
                                    <div class="wrap-slick3 flex-sb flex-w">
                                        <div class="slick3 gallery-lb">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="' . $sp['Image'] . '" alt="IMG-PRODUCT">
        
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="' . $sp['Image'] . '">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-md-6 col-lg-5 p-b-30">
                                <div class="p-r-50 p-t-5 p-lr-0-lg">
                                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                        ' . $sp['ProductName'] . '
                                    </h4>
            
                                    $<span class="mtext-106 cl2 pro-price">
                                         ' . $sp['Price'] . '
                                    </span>
            
                                    <p class="stext-102 cl3 p-t-23">
                                        Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.
                                    </p>
                                    
                                    <!--  -->
                                    <div class="p-t-33">
                                        <div class="flex-w flex-r-m p-b-10">
                                            <div class="size-203 flex-c-m respon6">
                                                Size
                                            </div>
                                            <div class="size-204 respon6-next">
                                                ' . $sp['Size'] . '
                                            </div>
                                            
                                        </div>
            
                                        <div class="flex-w flex-r-m p-b-10">
                                            <div class="size-203 flex-c-m respon6">
                                                Color
                                            </div>
                                            <div class="size-204 respon6-next">
                                                <span>' . $sp['Color'] . '</span>
                                                <span class="col-1" style="border: 1px solid gray; background-color: ' . $sp['Color'] . '; height: 38px; width: 38px; margin: 0 20px 0 20px; padding: 5px 20px 5px 10px;"> </span>
                                            </div>
                                        </div>
            
                                        <div class="flex-w flex-r-m p-b-10">
                                            <div class="size-204 flex-w flex-m respon6-next">
                                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m disabled" id="decrease">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>
            
                                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1" id="num" disabled>
            
                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" id="increase">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
            
                                                <button id="pro-' . $sp['ProductID'] . '" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail ">

                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>	
                                    </div>
            
                                    <!--  -->
                                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                        <div class="flex-m bor9 p-r-10 m-r-11">
                                            <a href="" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                                <i class="zmdi zmdi-favorite"></i>
                                            </a>
                                        </div>
            
                                        <a href="" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
            
                                        <a href="" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
            
                                        <a href="" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="bor10 m-t-50 p-t-43 p-b-40">
                            <!-- Tab01 -->
                            <div class="tab01">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item p-b-10">
                                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                                    </li>
            
                                    <li class="nav-item p-b-10">
                                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
                                    </li>
            
                                    <li class="nav-item p-b-10">
                                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
                                    </li>
                                </ul>
            
                                <!-- Tab panes -->
                                <div class="tab-content p-t-43">
                                    <!-- - -->
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        <div class="how-pos2 p-lr-15-md">
                                            <p class="stext-102 cl6">
                                                Aenean sit amet gravida nisi. Nam fermentum est felis, quis feugiat nunc fringilla sit amet. Ut in blandit ipsum. Quisque luctus dui at ante aliquet, in hendrerit lectus interdum. Morbi elementum sapien rhoncus pretium maximus. Nulla lectus enim, cursus et elementum sed, sodales vitae eros. Ut ex quam, porta consequat interdum in, faucibus eu velit. Quisque rhoncus ex ac libero varius molestie. Aenean tempor sit amet orci nec iaculis. Cras sit amet nulla libero. Curabitur dignissim, nunc nec laoreet consequat, purus nunc porta lacus, vel efficitur tellus augue in ipsum. Cras in arcu sed metus rutrum iaculis. Nulla non tempor erat. Duis in egestas nunc.
                                            </p>
                                        </div>
                                    </div>
            
                                    <!-- - -->
                                    <div class="tab-pane fade" id="information" role="tabpanel">
                                        <div class="row">
                                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                                <ul class="p-lr-28 p-lr-15-sm">
                                                    <li class="flex-w flex-t p-b-7">
                                                        <span class="stext-102 cl3 size-205">
                                                            Weight
                                                        </span>
            
                                                        <span class="stext-102 cl6 size-206">
                                                            0.79 kg
                                                        </span>
                                                    </li>
            
                                                    <li class="flex-w flex-t p-b-7">
                                                        <span class="stext-102 cl3 size-205">
                                                            Dimensions
                                                        </span>
            
                                                        <span class="stext-102 cl6 size-206">
                                                            110 x 33 x 100 cm
                                                        </span>
                                                    </li>
            
                                                    <li class="flex-w flex-t p-b-7">
                                                        <span class="stext-102 cl3 size-205">
                                                            Materials
                                                        </span>
            
                                                        <span class="stext-102 cl6 size-206">
                                                            60% cotton
                                                        </span>
                                                    </li>
            
                                                    <li class="flex-w flex-t p-b-7">
                                                        <span class="stext-102 cl3 size-205">
                                                            Color
                                                        </span>
            
                                                        <span class="stext-102 cl6 size-206">
                                                            Black, Blue, Grey, Green, Red, White
                                                        </span>
                                                    </li>
            
                                                    <li class="flex-w flex-t p-b-7">
                                                        <span class="stext-102 cl3 size-205">
                                                            Size
                                                        </span>
            
                                                        <span class="stext-102 cl6 size-206">
                                                            XL, L, M, S
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
            
                                    <!-- - -->
                                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                                        <div class="row">
                                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                                <div class="p-b-30 m-lr-15-sm">
                                                    <!-- Review -->
                                                    <div class="flex-w flex-t p-b-68">
                                                        <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                            <img src="images/avatar-01.jpg" alt="AVATAR">
                                                        </div>
            
                                                        <div class="size-207">
                                                            <div class="flex-w flex-sb-m p-b-17">
                                                                <span class="mtext-107 cl2 p-r-20">
                                                                    Ariana Grande
                                                                </span>
            
                                                                <span class="fs-18 cl11">
                                                                    <i class="zmdi zmdi-star"></i>
                                                                    <i class="zmdi zmdi-star"></i>
                                                                    <i class="zmdi zmdi-star"></i>
                                                                    <i class="zmdi zmdi-star"></i>
                                                                    <i class="zmdi zmdi-star-half"></i>
                                                                </span>
                                                            </div>
            
                                                            <p class="stext-102 cl6">
                                                                Quod autem in homine praestantissimum atque optimum est, id deseruit. Apud ceteros autem philosophos
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Add review -->
                                                    <form class="w-full">
                                                        <h5 class="mtext-108 cl2 p-b-7">
                                                            Add a review
                                                        </h5>
            
                                                        <p class="stext-102 cl6">
                                                            Your email address will not be published. Required fields are marked *
                                                        </p>
            
                                                        <div class="flex-w flex-m p-t-50 p-b-23">
                                                            <span class="stext-102 cl3 m-r-16">
                                                                Your Rating
                                                            </span>
            
                                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                                <input class="dis-none" type="number" name="rating">
                                                            </span>
                                                        </div>
            
                                                        <div class="row p-b-25">
                                                            <div class="col-12 p-b-5">
                                                                <label class="stext-102 cl3" for="review">Your review</label>
                                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                            </div>
            
                                                            <div class="col-sm-6 p-b-5">
                                                                <label class="stext-102 cl3" for="name">Name</label>
                                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
                                                            </div>
            
                                                            <div class="col-sm-6 p-b-5">
                                                                <label class="stext-102 cl3" for="email">Email</label>
                                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
                                                            </div>
                                                        </div>
            
                                                        <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
                        <span class="stext-107 cl6 p-lr-25">
                            SKU: JAK-01
                        </span>
            
                        <span class="stext-107 cl6 p-lr-25">
                            Categories: Jacket, Men
                        </span>
                    </div>
                </section>
				';
?>

<div class="container">
    <div class="p-b-45">
        <h3 class="ltext-106 cl5 txt-center">
            Related Products
        </h3>
    </div>
    <div class="row">
        <?php
        foreach ($pro as $key => $val) {
            if ($val['Series'] == $sp['Series']) {
                $Name = ($sp['CategoryID'] != 0) ? getCateByID($sp['CategoryID'])['CategoryName'] : "";
                echo '
                            <!-- Related Products -->
                            <div class="col-sm-6 col-md-4 col-lg-3 isotope-item" id="' . $Name . '">
                                <a href="index.php?content=product-detail&id=' . $val['ProductID'] . '">
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="' . $val['Image'] . '" alt="IMG-PRODUCT" style="width: 270px; height: 330px;">
                                        </div>
                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="index.php?content=product-detail&id=' . $val['ProductID'] . '" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"> ' . $val['ProductName'] . ' </a>    
                                                <span class="stext-105 cl3"> ' . $sp['Price'] . ' </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ';
            }
        }
        ?>
    </div>
</div>