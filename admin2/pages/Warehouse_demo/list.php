<?php
array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">');


array_push($jsStack, '<script src="plugins/datatables/jquery.dataTables.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>');
array_push($jsStack, '<script src="plugins/jszip/jszip.min.js"></script>');
array_push($jsStack, '<script src="plugins/pdfmake/pdfmake.min.js"></script>');
array_push($jsStack, '<script src="plugins/pdfmake/vfs_fonts.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>');
array_push($jsStack, '<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>');


array_push($jsStack, '
        <script>
            $(function() {
                $("#example1, #example2").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": true
                }).buttons().container().appendTo(\'#example1_wrapper .col-md-6:eq(0)\');
            });

            function confirmDelete() {
                return confirm(\'Are you sure you want to delete this?\');
            }
        </script>
    ');


?>
<?php

require_once('../backend/Warehouse_demo.php');
require_once("../chucnang/recursiveCate.php");
require_once('../backend/Category.php');
require_once('../backend/Supplier.php');
$categories = getAllCategory();
$Supplier = getAllSupplier();

?>
<script>
    //phân trang đê


    //load dữ liệu
    function loadData(pageNumber) {
        var rowofPage = $(".custom-select").val();
        $("tbody").empty();
        $.ajax({
            url: '../chucnang/phantrang.php',
            type: 'get',
            data: {
                tableName: "goodsreceipt",
                rowofPage: rowofPage,
                pageNumber: pageNumber,
                ID: "ReceiptId"
            },
            // dataType: 'json',
            success: function(response) {
                $("tbody").html(response);

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
        var rowofPage = $(".custom-select").val();

        $.ajax({
            url: '../backend/Warehouse_demo.php',
            type: 'post',
            data: {
                rowofPage: rowofPage,
                key: 'countwarehouse'
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

        $(".custom-select").change(function() {
            countPage();

            loadData(1);
        });


        //đây là search
        $("#filter").change(function() {
            var searchText = $(this).val();
            if (searchText == "") return loadData(1);

            $.ajax({
                url: '../backend/Warehouse_demo.php',
                type: 'post',
                data: {
                    searchText: searchText
                },
                //dataType: 'json',
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        })
    });



    //update
    function update(element) {
        $("#formadd").slideDown();
        //element.preventDefault();


        var suppId = $(element).attr('id').split('-')[1];
        // alert(suppId);
        $.ajax({
            url: '../chucnang/update.php',
            type: 'post',
            data: {
                tableName: 'suppliers',
                Id: parseInt(suppId)
            },
            dataType: 'json',
            success: function(response) {

                if (response.error) {

                    alert('wrong');
                } else {

                    var addForm = $("#formadd");
                    addForm.find('input[id="inpSupID"]').val(response['data'].SuppliId);
                    addForm.find('input[id="name"]').val(response['data'].Name);
                    addForm.find('input[id="address"]').val(response['data'].Address);
                    addForm.find('input[id="email"]').val(response['data'].Email);
                    addForm.find('input[value="Submit"]').attr('name', 'update_receipt');


                }
            },
            error: function(error) {
                alert('errrr');

            }
        });

    }
    // Nút thêm(addButton)
       $(document).ready(function() {
        var addButton = $("#addbutton");
        var addForm = $("#formadd");

        addButton.click(function() {
            addForm.slideDown();
            addForm.find('input[value="Submit"]').attr('name', 'add_receipt');
            addForm.find('input[name="name"]').val('');
            addForm.find('input[name="email"]').val('');
            addForm.find('input[name="address"]').val('');

        });

        1
    });
    // Nút đóng(removeButton)
    $(document).ready(function() {
        var removeButton = $("#remove");
        var addForm = $("#formadd");

        removeButton.click(function() {
            addForm.slideToggle();
            document.querySelector("#formadd").reset();
            addForm.find('input[value="Submit"]').attr('name', 'add_product');
        });


        $('#productFormsContainer').on('change', '.color', function() {
            var selectedColor = $(this).val(); // Lấy giá trị màu đã chọn
            //alert(selectedColor);
            $(this).closest(".form-group").find(".showcolor").css("background-color", selectedColor);
            $(this).closest(".form-group").find(".showcolor").css("border", selectedColor);
           
        });


    });





    //JS PHẦN FORM GIAO DIỆN 
    //kiểm tra id sản phẩm
    $(document).ready(function(){
        var formCounter = 2;

        $('.new_product').hide();
        $('.exists_product').hide();

        $('#productFormsContainer').on('click', '.check_product', function() {
            var dataId = $(this).attr('data-id');
            var $newProductForm = $('.new_product[data-id="' + dataId + '"]');
            var $existsProductForm = $('.exists_product[data-id="' + dataId + '"]');
            var ProductID = $('.ProductID[data-id="' + dataId + '"]').val();
            $('.ProductID[data-id="' + dataId + '"]').prop('readonly', true);
            $.ajax({
                url: '../backend/Warehouse_demo.php',
                type: 'post',
                data: {
                    checkproduct: true,
                    ProductID: ProductID
                },
                success: function(response) {
                    //alert(response);
                    response = response.trim();
                    if (response == 'new' ) {
                        $newProductForm.show();
                        $existsProductForm.remove();
                    } else if (response == 'exists') {
                        $newProductForm.remove();
                        $existsProductForm.show();
                    }
                },
            });


        });
        $('#productFormsContainer').on('click', '.remove', function() {
            var dataId = $(this).attr('data-id');

            var item = $(this).closest('#item_add');

            item.remove();
        });

        $('#addMore').click(function() {
            //Cach 1
            //var newProductForm = $('#item_add').first().clone(); 
            //Cach 2
            var newProductFormHtml = `
            <div id="item_add">
                <hr><hr>
                <!-- Product check -->
                <div class="form-group">
                    <label for="">Product Id</label>
                    <div class="row">
                        <div class="col-md-11">
                            <input type="number" name="ProductID[]" data-id="${formCounter}" class="form-control ProductID" placeholder="Enter Product Id" required>
                        </div>
                        <div class="col-md-1">
                            <input type="button" class="btn btn-info check_product" name="" data-id="${formCounter}" value="Check">
                        </div>
                    </div>
                </div>
                <!-- Existing product -->
                <div class="exists_product" data-id="${formCounter}">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" id="ex_quantity" class="form-control" placeholder="Enter quantity" name="ex_quantity[]" required>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" id="ex_price" class="form-control" placeholder="Enter Price" name="ex_price[]" required>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-danger remove" data-id="${formCounter}" value="X">
                    </div>
                </div>
                <!-- New product -->
                <div class="new_product" data-id="${formCounter}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Series</label>
                                <input type="number" min="0" class="form-control" name="series[]" id="series" placeholder="Enter Series">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CategoryID:</label>
                                <select name="CategoryID[]" class="selectParent form-control">
                                    <option value="0">-----------Root-----------</option>
                                    <?php recursiveCategory($categories, 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product name</label>
                                <input type="text" class="form-control" placeholder="Enter Product name" name="productname[]" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="new_price[]" id="new_price" min="0" placeholder="Enter Price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Color</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="color[]"  class="form-control color">
                                            <option value="White">White</option>
                                            <option value="Black">Black</option>
                                            <option value="Red">Red</option>
                                            <option value="Yellow">Yellow</option>
                                            <option value="Green">Green</option>
                                            <option value="Brown">Brown</option>
                                            <option value="Blue">Blue</option>
                                            <option value="Grey">Grey</option>
                                            <option value="Violet">Violet</option>
                                            <option value="Navy">Navy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control showcolor" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="number" name="size[]" id="size" placeholder="Enter size" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="new_quantity[]" id="new_quantity" placeholder="Enter quantity" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-danger remove" data-id="${formCounter}" value="X">
                    </div>
                </div>
            </div>`;

            var newProductForm = $(newProductFormHtml);

            newProductForm.find('input[type="number"]').val('').attr('disabled', false);


            newProductForm.find('[data-id]').each(function() {
                var oldId = $(this).attr('data-id');
                $(this).attr('data-id', formCounter);
            });
            newProductForm.find('.new_product').hide();
            newProductForm.find('.exists_product').hide();
            formCounter++;

            $('#productFormsContainer').append(newProductForm);
        });

    });

</script>
<style>
    #formadd {
        display: none;
    }

    #addbutton {
        width: 89.49px;
        height: 60px;
        font-size: 20px;
        margin: 5px 0 0 10px;
    }
</style>





<div class="card">
    <!--addButton and searchButton-->
    <div class="addform">
    <?php if(getFeaturebyAction('Warehouse','Create')): ?>
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <?php endif; ?>
        <!--addForm-->
        <form method="post" action="../backend/Warehouse_demo.php" id="formadd">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Receipt good create</h3>
                    <input type="text" value="" id="inpRecID" name="ReceiptId" hidden>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" id="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <input type="button" class="btn btn-info" id="addMore" value="More">
                    <div id="productFormsContainer">
                        <div class="form-group">
                            <label>Supplier</label>
                            <select name="SuppliId" class="form-control" id="" required>
                                <option value="">------Select Supplier------</option>
                                <?php foreach ($Supplier as $sup) : ?>
                                    <option value="<?php echo $sup['SuppliId']; ?>"><?php echo $sup['Name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="item_add">
                            <!-- Doạn check sản phẩm -->

                            <div class="form-group">
                                <label for="">Product Id</label>
                                <div class="row">
                                    <div class="col-md-11">
                                        <input type="number" name="ProductID[]" data-id="1" class="form-control ProductID" placeholder="Enter Product Id" required>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="button" class="btn btn-info check_product" name="" data-id="1" id="" value="Check">
                                    </div>
                                </div>
                            </div>
                            <!-- Sản phẩm đã có -->
                            <div class="exists_product" data-id="1">

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" id="ex_quantity" class="form-control" placeholder="Enter quantity" name="ex_quantity[]" required>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" id="ex_price" class="form-control" placeholder="Enter Price" name="ex_price[]" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label></label>
                                    <input type="number" id="ex_price" class="form-control" placeholder="Enter Price" name="ex_price[]" required>
                                </div> -->
                                <div class="form-group">
                                    <input type="button" class="btn btn-danger remove" data-id="1" value="X">
                                </div>
                            </div>
                            <!-- Sản phẩm mới -->
                            <div class="new_product" data-id="1">
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Series</label>
                                            <input type="number" min="0" class="form-control" name="series[]" id="series" placeholder="Enter Series">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CategoryID:</label>
                                            <select name="CategoryID[]" class="selectParent form-control" id="">
                                                <option value="0">-----------Root-----------</option>
                                                <?php
                                                recursiveCategory($categories, 0);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product name</label>
                                            <input type="text" class="form-control" placeholder="Enter Product name" name="productname[]" value="">
                                        </div>
                                    </div>
                                </div>




                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="number" name="new_price[]" id="new_price" min="0" placeholder="Enter Price" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Color</label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select name="color[]" class="form-control color">
                                                        <option value="White">White</option>
                                                        <option value="Black">Black</option>
                                                        <option value="Red">Red</option>
                                                        <option value="Yellow">Yellow</option>
                                                        <option value="Green">Green</option>
                                                        <option value="Brown">Brown</option>
                                                        <option value="Blue">Blue</option>
                                                        <option value="Grey">Grey</option>
                                                        <option value="Violet">Violet</option>
                                                        <option value="Navy">Navy</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control showcolor" disabled >
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <input type="number" name="size[]" id="size" placeholder="Enter size" min="0" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" name="new_quantity[]" id="new_quantity" placeholder="Enter quantity" min="0" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="button" class="btn btn-danger remove" data-id="1" value="X">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" name="add_receipt" id="" value="Submit">
                </div>
            </div>

            <!-- /.card -->
        </form>

    </div>

    <div class="card-header">
        <!-- <h3>List</h3> -->
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="example2_length" style="float: left; margin-left: 4%;">
                <label>Show
                    <select name="example2_length" aria-controls="example2" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="example1_filter" class="dataTables_filter" style="float: right; margin-right: 4%;">
                Search:<input type="search" id="filter" class="form-control form-control-sm" placeholder="Enter Category Name">
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="example" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>CreatedAt</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Employee Name</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>CreatedAt</th>
                    <th>Detail</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <!-- <div class="dataTables_info" style="float: left; margin-left: 4%;">Showing 1 to 6 of 6 entries</div> -->
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                <ul class="pagination" style="float: right; margin-right: 4%;">
                    <!-- <li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" class="page-link">Previous</a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item next disabled" id="example1_next"><a href="#" class="page-link">Next</a></li> -->
                </ul>
            </div>
        </div>
    </div>
</div>