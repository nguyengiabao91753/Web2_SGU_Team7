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
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo(\'#example1_wrapper .col-md-6:eq(0)\');
            });

            function confirmDelete() {
                return confirm(\'Are you sure you want to delete this?\');
            }
        </script>
    ');


require_once("../chucnang/recursiveCate.php");
require_once('../backend/CategoryController.php');
$categories = getAllCategory();
require_once("../backend/Product.php");

?>

<script>
    // Nút thêm(addButton)
    $(document).ready(function() {
        var addButton = $("#addbutton");
        var addForm = $("#formadd");

        addButton.click(function() {
            addForm.slideDown(); // Sử dụng .show() của jQuery để hiển thị form
        });
    });
    // Nút đóng(removeButton)
    $(document).ready(function() {
        var removeButton = $("#remove");
        var addForm = $("#formadd");

        removeButton.click(function() {
            addForm.slideToggle();
        });

        $("#color").change(function () {
        var selectedColor = $(this).val(); // Lấy giá trị màu đã chọn
        $("#showcolor").css("background-color", selectedColor); // Đặt màu nền của phần tử thành màu đã chọn
        $("#showcolor").css("border", selectedColor); // Đặt màu nền của phần tử thành màu đã chọn
        });

    });
    //Hiển thị ảnh sau khi chọn file từ máy
    $(document).ready(function() {
        $('#uploadimg').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                    $('#preview').show(); // Hiển thị hình ảnh khi đã được tải lên
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    //phân trang đê


    //load dữ liệu
    function loadData(pageNumber) {
        var rowofPage = $(".custom-select").val();
        $("tbody").empty();
        $.ajax({
            url: '../chucnang/phantrang.php',
            type: 'get',
            data: {
                tableName: "products",
                rowofPage: rowofPage,
                pageNumber: pageNumber,
                ID: "ProductID"
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
            url: '../backend/Product.php',
            type: 'get',
            data: {
                rowofPage: rowofPage
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
                url: '../backend/Product.php',
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

    //tính số trang
    $(document).ready(function() {
            <?php
            // $totalPage  = $CountCate / 
            ?>
     });
</script>
<style>
      #formadd {
        display: none;
      }

      #addbutton{
        width: 89.49px; 
        height: 60px;
        font-size: 20px;
        margin: 5px 0 0 10px;
      }
      #feature{
        height: 38px;
        width: 284.45px;
      }
      #color{
        height: 38px;
        width: 184.63px;
     }
     #showcolor{
        width: 38px;
        height: 38px;
        margin-top: 31.5px;
     }
     #preview{
        width: auto;
        height: 116.6px;
        margin-top: 3px;
     }
   </style>





<div class="card">

    <!--addButton and searchButton-->
    <div class="addform">
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <!--addForm-->
        <form method="post" action="../backend/Product.php" id="formadd" enctype="multipart/form-data">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Product</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" id="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Series</label>
                                <input type="number" min="0" class="form-control" name="series" id="series" placeholder="Enter Series">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CategoryID:</label>
                                <select name="CategoryID" class="selectParent form-control" id="">
                                    <option value="0">-----------Root-----------</option>
                                    <?php
                                    recursiveCategory($categories, 0);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product name</label>
                                <input type="text" class="form-control" placeholder="Enter Product name" name="productname" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Images</label>
                                <input type="file" name="uploadimg" id="uploadimg" class="form-control" accept="image/*"  onchange="previewImage(event)">
                                <img src="" alt="Preview Image" id="preview" style="display:none;">
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" cols="30" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Feature</label>
                                <br>
                                <select name="feature" id="feature">
                                    <option value="" class="form-control">Feature</option>
                                    <option value="" class="form-control">None</option>
                                </select>
                                </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" id="price" min="0" placeholder="Enter Price" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Color</label>
                                <br>
                                <select name="color" id="color">
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
                        </div>

                        <div class="col-md-1">
                            <div>
                                <input type="text" disabled id="showcolor">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="number" name="size" id="size" placeholder="Enter size" min="0" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total quantity</label>
                                <input type="number" name="totalquan" id="totalquan" placeholder="Enter total Quantity" min="0" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity" id="quantity" placeholder="Enter quantity" min="0" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sale Quantity</label>
                                <input type="number" name="salequan" id="salequan" placeholder="Enter Sale quantity" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="createButton" id="createButton" value="submit">Submit</button>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </form>

    </div>

    <div class="card-header">
        <!-- <h3 class="card-title">Customer list</h3> -->
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
                    <th>ProductID</th>
                    <th>Category</th>
                    <th>Series</th>
                    <th>Product name</th>
                    <th>Image</th>
                    <th>Feature</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Total Quantity</th>
                    <th>See details</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                    $kq = getAll_Product();
                    
                        foreach ($kq as $sp) {
                        echo '  <tr>
                                    <td>'.$sp['ProductID'].'</td>
                                    <td>'.$sp['Series'].'</td>
                                    <td>'.$sp['ProductName'].'</td>
                                    <td><img src="'.$sp['Image'].'" width="100px" height="50px"></td>
                                    <td>'.$sp['Feature'].' At</td>
                                    <td>'.$sp['Color'].'</td> 
                                    <td>'.$sp['Price'].'</td>
                                    <td>'.$sp['TotalQuantity'].'</td>
                                    <td><a href="" style="text-decoration: underline;">View more</a></td>
                                    <td><a href="" style="color: #0066ff;"><i class="fas fa-edit"></i> Update</a></td>
                                    <td><a href="" style="color: red;"><i class="far fa-trash-alt"></i> Delete</a></td>
                                </tr>';
                        }
                    ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>ProductID</th>
                    <th>Category</th>
                    <th>Series</th>
                    <th>Product name</th>
                    <th>Image</th>
                    <th>Feature</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Total Quantity</th>
                    <th>See details</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" style="float: left; margin-left: 4%;">Showing 1 to 6 of 6 entries</div>
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