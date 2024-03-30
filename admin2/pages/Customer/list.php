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
                    "autoWidth": false
                }).buttons().container().appendTo(\'#example1_wrapper .col-md-6:eq(0)\');
            });

            function confirmDelete() {
                return confirm(\'Are you sure you want to delete this?\');
            }
        </script>
    ');

// array_push($cssStack, '<style>
//     #overlay {
//     display: none;
//     position: fixed;
//     top: 0;
//     left: 0;
//     width: 100%;
//     height: 100%;
//     background-color: rgba(0, 0, 0, 0.5); /* Màu nền với độ trong suốt */
//     z-index: 9999; /* Đảm bảo form hiển thị trên các phần tử khác */
// }

// #addForm {
//     display: none;
//     position: fixed;
//     top: 50%;
//     left: 50%;
//     transform: translate(-50%, -50%);
//     background-color: white;
//     padding: 20px;
//     z-index: 10000; /* Đảm bảo form hiển thị trên overlay */
// }

// </style>
    
//     ');

//     array_push($jsStack, '
//         <script>
//         document.getElementById(\'add\').addEventListener(\'click\', function() {
//             // Hiển thị overlay và form
//             document.getElementById(\'overlay\').style.display = \'block\';
//             document.getElementById(\'addForm\').style.display = \'block\';
//         });
//         </script>
//     ');

//     array_push($jsStack, '
//         <script>
//         document.getElementById(\'removeform\').addEventListener(\'click\', function() {
//             // tắt overlay và form
//             document.getElementById(\'overlay\').style.display = \'none\';
//             document.getElementById(\'addForm\').style.display = \'none\';
//         });
//         </script>
//     ');

?>

<!-- <div id="overlay"></div> -->
<!-- <div id="addForm" style="display: none;">
    <form method="post" action="">

       
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer create</h3>

                <div class="card-tools">
                    <button type="button" id="removeform" class="btn btn-tool">
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
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>

       
    </form>
</div> -->


<div class="card">
    <button class="btn btn-primary" style="width: 80px; margin-left: 95%;border-radius: 10px;" id="add">Add</button>
    <div class="card-header">
        <h3 class="card-title">Customer list</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6">
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="example1_filter" class="dataTables_filter" style="float: right; margin-right: 5%;">
                <label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example1"></label>
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
            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite" style="margin-left: 2%;">Showing 1 to 6 of 6 entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="float: right; margin-right: 5%;">
                <ul class="pagination">
                    <li class="paginate_button page-item previous" id="example1_previous"><a href="#"class="page-link">Previous</a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="example1"class="page-link">1</a></li>
                    <li class="paginate_button page-item next" id="example1_next"><a href="#"class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>