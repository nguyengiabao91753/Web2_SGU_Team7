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

        </script>
    ');


?>
<?php

require_once('../backend/Account.php');
require_once('../backend/Userfunction.php');


?>
<script>
    function confirmDelete() {
        <?php if (!getFeaturebyAction('Employee', 'Delete')) : ?>
            alert("There are no permissions for this function");
            return false;
        <?php endif; ?>
        return confirm('Are you sure you want to delete this?');
    }
    //phân trang đê


    //load dữ liệu
    function loadData(pageNumber) {
        var rowofPage = $(".custom-select").val();
        $("tbody").empty();
        $.ajax({
            url: '../chucnang/phantrang.php',
            type: 'get',
            data: {
                tableName: "Accounts",
                rowofPage: rowofPage,
                pageNumber: pageNumber,
                ID: "AccountID",
                key:'accemp'
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
        //alert(rowofPage);
        $.ajax({
            url: '../backend/Account.php',
            type: 'post',
            data: {
                rowofPage: rowofPage,
                key: 'countempacc'
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
                url: '../backend/Account.php',
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
        <?php if(!getFeaturebyAction('Employee','Update')): ?>
            return alert("There are no permissions for this function");
        <?php endif; ?>
        $("#formadd").slideDown();
        //element.preventDefault();

       
        var userId = element;
        //alert(userId);
        $.ajax({
            url: '../chucnang/update.php',
            type: 'post',
            data: {
                tableName: 'accounts',
                Id: element
            },
            dataType: 'json',
            success: function(response) {

                // if (response.error) {
                
                //     alert('wrong');
                // } else {
                    //alert('vô');
                    var addForm = $("#formadd");
                    addForm.find('input[id="inpUserID"]').val(response['data'].userID);
                    addForm.find('input[id="firstname"]').val(response['data'].firstname);
                    addForm.find('input[id="lastname"]').val(response['data'].lastname);
                    addForm.find('input[name="phone"]').val(response['data'].phone);
                    addForm.find('input[id="address"]').val(response['data'].address);
                    addForm.find('input[name="email"]').val(response['data'].email);
                    addForm.find('input[value="Submit"]').attr('name', 'update_user');
                // }
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
            addForm.find('input[value="Submit"]').attr('name', 'add_user');
            addForm.find('input[name="firstname"]').val('');
            addForm.find('input[name="lastname"]').val('');
            addForm.find('input[name="phone"]').val('');
            addForm.find('input[name="email"]').val('');
            addForm.find('input[name="address"]').val('');
            addForm.find('select[name="level"]').val(response['data'].level).find('option[value="' + response['data'].level + '"]').prop('selected', true);

        });

1
    });
    // Nút đóng(removeButton)
    $(document).ready(function() {
        var removeButton = $("#remove");
        var addForm = $("#formadd");

        removeButton.click(function() {
            addForm.slideToggle();

        });


       


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
        <!-- <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button> -->
        <!--addForm-->
    </div>

    <div class="card-header">
        <!-- <h3>List</h3> -->
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="example2_length" style="float: left; margin-left: 4%;">
                <label>Show
                    <select name="example2_length" aria-controls="example2" class="custom-select custom-select-sm form-control form-control-sm">
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
                        <th>UserName</th>
                        <th>Password</th>
                        <th>Status</th>
                
                        <th>Action</th>
                        
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                        <th>UserName</th>
                        <th>Password</th>
                        <th>Status</th>
                
                        <th>Action</th>
                        
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