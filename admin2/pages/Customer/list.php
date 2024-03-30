<?php
    array_push($cssStack,'<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">');
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
    var removeButton =$("#remove");
    var addForm =$("#formadd");

    removeButton.click(function(){
        addForm.slideToggle();
    });
});
// Nút tạo(createButton)


</script>





<div class="card">
    <!--addButton and searchButton-->
    <div class="addform_n_search">
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <button id="searchbutton" class="btn btn-tool">
            <i class="fa fa-search"></i>
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
                                <input type="text" class="form-control" placeholder="Enter your first name" name="firstname" value="" >
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
                    <button type="submit" class="btn btn-primary" id="createButton">Create</button>
                </div>
            </div>

            <!-- /.card -->
        </form>

    </div>        

    <div class="card-header">
        <h3 class="card-title">Customer list</h3>
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
</div>