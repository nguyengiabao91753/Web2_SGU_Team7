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
    });
    // Nút tạo(createButton)
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
      
   </style>





<div class="card">
    <!--addButton and searchButton-->
    <div class="addform">
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <!--addForm-->
        <form method="post" action="" id="formadd">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer create</h3>

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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Enter your first name" name="firstname" value="">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter your last name" name="lastname" value="">
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Enter email" name="email" value="">
                    </div>


                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" placeholder="Enter phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Enter address" name="address">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="createButton">Submit</button>
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
           
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="example1_filter" class="dataTables_filter" style="float: right; margin-right: 4%;">
                Search:<input type="search" class="form-control form-control-sm" placeholder="">
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="example" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Create At</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Create At</th>
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
                    <li class="paginate_button page-item previous disabled" id="example1_previous"><a href="#" class="page-link">Previous</a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item next disabled" id="example1_next"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>