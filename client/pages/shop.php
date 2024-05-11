<?php
require_once '../backend/Product.php';
require_once '../backend/Category.php';
//require_once '../chucnang/phantrang.php';

$cates = getAllCategory();
?>
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<script>
    //phân trang đê


    //load dữ liệu
    function loadData(pageNumber) {
        var rowofPage = 8;
        $(".row.showsp").empty();
        $.ajax({
            url: '../chucnang/phantrang.php',
            type: 'get',
            data: {
                tableName: "products",
                rowofPage: rowofPage,
                pageNumber: pageNumber,
                ID: "ProductID",
                key: "client"
            },
            // dataType: 'json',
            success: function(response) {
                $(".row.showsp").append('<p>hello</p>');
                $(".row.showsp").html(response);

                $(".pagination .page-item").removeClass("active");

                $(".pagination .page-item:contains(" + pageNumber + ")").addClass("active");
            }

        });
    }



    //xử lý khi nhấn nút trang
    function clickload(element) {
        //alert("vô");
        var pageNumber = element;
        //alert(pageNumber);
        if (pageNumber == 111) {
            var currentPage = $(".page-item.active").text();

            if (currentPage > 1) {
                loadData(currentPage - 1);
            } else {
                alert("This is first page");
            }
        } else if (pageNumber == 222) {
            var currentPage = parseInt($(".page-item.active").text());
            var lastPage = parseInt($(".pagination .page-item").last().prev().text());
            if (currentPage < lastPage) {
                loadData(currentPage + 1);
            } else {
                alert("This is last page");
            }
        } else {
            loadData(pageNumber);
        }
    }

    //tính số trang
    function countPage() {
        var rowofPage = 8;
        $.ajax({
            url: '../backend/Product.php',
            type: 'post',

            data: {
                rowofPage: rowofPage,
                key: 'countproducts',
            },
            success: function(response) {
                //alert(response);
                $(".pagination").empty();
                var previous = 111;
                var next = 222;
                $(".pagination").append('<li class="paginate_button page-item" id="example1"><a href="#" class="page-link" onclick="clickload(' + previous + ')">Previous</a></li>');
                for (var i = 1; i <= response; i++) {
                    $(".pagination").append('<li class="paginate_button page-item"><a href="#" aria-controls="example1" data-dt-idx="' + i + '" tabindex="0" class="page-link" onclick="clickload(' + i + ')">' + i + '</a></li>');
                }
                $(".pagination").append('<li class="paginate_button page-item" id="example1"><button type="button" class="page-link" onclick="clickload(' + next + ')" >Next</button></li>');
            }
        });
    }

    $(document).ready(function() {

        countPage();
        loadData(1);

    });
    //nut show all
    $(document).ready(function() {

        $('#allpro').click(function() {

            $('.dataTables_paginate.paging_simple_numbers').show();
            countPage();
            loadData(1);
        })
    });
    //show sp theo cate khi click
    $(document).ready(function() {
        $('.cate-click').click(function() {
            var cateValue = $(this).attr('name');
            $.ajax({
                url: '../backend/Product.php',
                type: 'post',
                data: {
                    CategoryID: cateValue,
                    key: 'cate-click'
                },
                success: function(response) {
                    $(".row.showsp").empty();
                    $(".row.showsp").html(response);
                    $('.dataTables_paginate.paging_simple_numbers').hide();
                }
            });
        });

    });

    //filter
    $(document).ready(function() {
        // Bắt sự kiện click trên nút Filter
        $(".btn-outline-success").click(function() {
            // Lấy dữ liệu từ các input radio đã được chọn   
            var category = $("input[name='cate']:checked").val();
            if (category == "" && category == undefined) {
                var category = undefined;
            }
            var color = $("input[name='color']:checked").val();
            if (color == "" && color == undefined) {
                var color = undefined;
            }

            var feature = $("input[name='feat']:checked").val();
            if (feature == "" && feature == undefined) {
                var feature = undefined;
            }

            var price = $("input[name='price']:checked").val();
            if (price !== undefined && price !== "All") {
                var priceArray = price.split("-");
                var price1 = priceArray[0].replace("$", "");
                var price2 = priceArray[1].replace("$", "");
            }
            console.log(category);
            console.log(color);
            console.log(price1);
            console.log(price2);
            console.log(feature);
            // Gửi dữ liệu bằng AJAX
            $.ajax({
                url: "../backend/Product.php",
                method: "POST",
                data: {
                    category: category,
                    price1: price1,
                    price2: price2,
                    color: color,
                    feature,
                    key: 'filter'
                },
                success: function(response) {
                    $(".row.showsp").html(response);
                    $('.dataTables_paginate.paging_simple_numbers').hide();
                }
            });
            $("#filter").slideToggle();

        });

        // Bắt sự kiện click trên nút Reset
        $(".btn-outline-danger").click(function() {
            // Reset các input radio
            $("input[type='radio']").prop("checked", false);
        });

        //đây là search
        $("#search-inp").change(function() {
            var searchText = $(this).val();

            if (searchText == "") {
                countPage();
                return loadData(1);
            }

            $.ajax({
                url: '../backend/Product.php',
                type: 'get',
                data: {
                    searchText: searchText,
                    key: "search-client"
                },
                //dataType: 'json',
                success: function(response) {
                    $('.row.showsp').html(response);
                    $('.dataTables_paginate.paging_simple_numbers').hide();
                }
            });
            $("#search").slideToggle();
        });

    });
</script>

<style>
    #dg {
        padding-top: 52px;
    }

    .filter-col1,
    .filter-col4 {
        width: 15%;
    }

    .filter-col2,
    .filter-col3 {
        width: 25%;
    }

    #annou {
        padding-left: 500px;
    }
</style>

<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <div class="flex-w flex-sb-m p-b-52" id="dg">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button type="button" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" id="allpro" name="all">
                    All Products
                </button>
                <?php foreach ($cates as $cate) : ?>
                    
                        <button type="button" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 cate-click" name="<?php echo $cate['CategoryID']; ?>">
                            <?php echo $cate['CategoryName']; ?>
                        </button>
                    
                <?php endforeach; ?>
                <!-- <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
                            Women
                        </button>

                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
                            Men
                        </button>

                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".bag">
                            Bag
                        </button>

                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".shoes">
                            Shoes
                        </button>

                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".watches">
                            Watches -->
                </button>
            </div>

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list" id="show"></i>
                    Filter
                </div>

                <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                    <i class="cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                    Search
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15" id="search">
                <div class="bor8 dis-flex p-l-15">
                    <span class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </span>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search" id="search-inp">

                    <button class="flex-c-m stext-106 cl6 bor4 pointer hov-btn3 trans-04 btn btn-light">
                        <i class="cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        Search
                    </button>
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10" id="filter">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Category
                        </div>

                        <ul>
                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="cate" value="">
                                <label class="form-check-label">All</label>
                            </div>

                            <?php foreach ($cates as $cate) : ?>
                                
                                    <div class="form-check p-b-6">
                                        <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="cate" value="<?php echo $cate['CategoryID']; ?>">
                                        <label class="form-check-label"><?php echo $cate['CategoryName']; ?></label>
                                    </div>
                               
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="filter-col2 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Price
                        </div>

                        <ul>
                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="All">
                                <label class="form-check-label">All</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="$0.00-$500.00">
                                <label class="form-check-label">$0.00 - $500.00</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="$500.00-$1000.00">
                                <label class="form-check-label">$500.00 - $1000.00</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="$1000.00-$1500.00">
                                <label class="form-check-label">$1000.00 - $1500.00</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="$1500.00-$2000.00">
                                <label class="form-check-label">$1500.00 - $2000.00</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="price" value="$2000.00-$2500.00">
                                <label class="form-check-label">$2000.00 - $2500.00</label>
                            </div>
                        </ul>
                    </div>

                    <div class="filter-col3 p-r-15 p-b-27">

                        <div class="mtext-102 cl2 p-b-15">
                            Color
                        </div>

                        <div class="row">
                            <ul class="col-md-6">
                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="">
                                    <label class="form-check-label">All</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="White">
                                    <label class="form-check-label">White</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Black">
                                    <label class="form-check-label" style="color: black;">Black</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Red">
                                    <label class="form-check-label" style="color:red;">Red</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Yellow">
                                    <label class="form-check-label" style="color: gold;">Yellow</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Green">
                                    <label class="form-check-label" style="color:green;">Green</label>
                                </div>
                            </ul>

                            <ul class="col-md-6">
                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Brown">
                                    <label class="form-check-label" style="color:brown;">Brown</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Blue">
                                    <label class="form-check-label" style="color:blue;">Blue</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Grey">
                                    <label class="form-check-label" style="color: grey;">Grey</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Violet">
                                    <label class="form-check-label" style="color: violet;">Violet</label>
                                </div>

                                <div class="form-check p-b-6">
                                    <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="color" value="Navy">
                                    <label class="form-check-label" style="color: navy;">Navy</label>
                                </div>
                            </ul>
                        </div>



                    </div>

                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Featured
                        </div>

                        <ul>
                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="feat" value="">
                                <label class="form-check-label">All</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="feat" value="Feature">
                                <label class="form-check-label">Feature</label>
                            </div>

                            <div class="form-check p-b-6">
                                <input type="radio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 form-check-input" name="feat" value="None">
                                <label class="form-check-label">None</label>
                            </div>
                        </ul>
                    </div>

                    <div class="p-t-100">
                        <button type="submit" class="btn btn-outline-success size-104">Filter</button>
                    </div>
                    <div class="p-l-15 p-t-100">
                        <button type="reset" class="btn btn-outline-danger size-104">
                            X Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row showsp">

        </div>
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="margin-left: 500px;">
                    <ul class="pagination">
                        <!-- <li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" class="page-link">Previous</a></li>
                                <li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                                <li class="paginate_button page-item next disabled" id="example1_next"><a href="#" class="page-link">Next</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>