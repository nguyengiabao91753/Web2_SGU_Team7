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
require_once("../chucnang/recursiveCate.php");
require_once('../controller/CategoryController.php');
$categories = getAllCategory();
$CountCate =  countCate();




?>
<script>
    // Nút thêm(addButton)
    $(document).ready(function() {
        var addButton = $("#addbutton");
        var updateform = $(".updateCate");
        var addForm = $("#formadd");

        addButton.click(function() {
            addForm.slideDown();
            addForm.find('input[name="CategoryName"]').val('');
            addForm.find('select[name="parentID"]').val('0').find('option[value="0"]').prop('selected', true);

        });


        <?php
        if (isset($_GET['id'])) {
            $id =  $_GET['id'];
            $cate = getCateByID($id);
        ?>
            addForm.slideDown();
        <?php
        }

        ?>

    });
    // Nút đóng(removeButton)
    $(document).ready(function() {
        var removeButton = $("#remove");
        var addForm = $("#formadd");

        removeButton.click(function() {
            addForm.slideToggle();
        });
    });

    //phân trang đê
    // $(document).ready(function() {
    //     var rowofPage = $(".custom-select").val();
    //     var tableName = "Categories";
    //     var ID = "CategoryID";
    //     $.ajax({
    //             url: '../chucnang/phantrang.php',
    //             type: 'get',
    //             data: {
    //                 tableName: tableName,
    //                 rowofPage: rowofPage,
    //                 pageNumber: 1,
    //                 ID: ID
    //             },
    //             dataType: 'json',
    //             success: function(response) {
    //                 var categories = response;

    //                 // Build the tbody content using a loop
    //                 var tbodyContent = "";
    //                 for (var i = 0; i < categories.length; i++) {
    //                     var category = categories[i];

    //                     var parentName = (category.parentID != 0) ? category.parentName : "";

    //                     tbodyContent += "<tr>";
    //                     tbodyContent += "  <td>" + category.CategoryID + "</td>";
    //                     tbodyContent += "  <td>" + parentName + "</td>";
    //                     tbodyContent += "  <td>" + category.CategoryName + "</td>";
    //                     tbodyContent += "  <td>";
    //                     tbodyContent += "    <a href=\"index.php?page=pages/Category/list.php&id=" + category.CategoryID + "\">";
    //                     tbodyContent += "      <button type=\"button\" class=\"updateCate btn btn-success\">";
    //                     tbodyContent += "        <i class=\"far fa-edit\"></i>";
    //                     tbodyContent += "      </button>";
    //                     tbodyContent += "    </a>";
    //                     tbodyContent += "  </td>";
    //                     tbodyContent += "  <td>";
    //                     tbodyContent += "    <a onclick=\"return confirmDelete()\" href=\"../controller/CategoryController.php?delete_category=" + category.CategoryID + "\">";
    //                     tbodyContent += "      <button class=\"btn btn-danger\">";
    //                     tbodyContent += "        <i class=\"far fa-trash-alt\"></i>";
    //                     tbodyContent += "      </button>";
    //                     tbodyContent += "    </a>";
    //                     tbodyContent += "  </td>";
    //                     tbodyContent += "</tr>";
    //                 }

                    
    //                 $("tbody").html(tbodyContent);
    //             }
            
    //     });
    // });
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
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add</b>
        </button>
        <!--addForm-->
        <form method="post" action="../controller/CategoryController.php" id="formadd">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Category create</h3>
                    <input type="text" value="<?php echo (isset($cate)) ? $cate['CategoryID'] : '' ?>" name="CategoryID" hidden>
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
                    <div class="form-group">
                        <label>Parent ID:</label>
                        <select name="parentID" id="">
                            <option value="0">-----------Root-----------</option>
                            <?php
                            recursiveCategory($categories, (isset($cate)) ? $cate['parentID'] : 0);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="CategoryName" name="CategoryName" value="<?php echo (isset($cate)) ? $cate['CategoryName'] : '' ?>">
                    </div>

                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" name="<?php echo (!empty($cate)) ? 'update_category' : 'add_category'; ?>" id="" value="Submit">
                </div>
            </div>

            <!-- /.card -->
        </form>

    </div>

    <div class="card-header">
        <!-- <h3>List</h3> -->
    </div>
    <!-- <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="example2_length" style="float: left; margin-left: 4%;">
                <label>Show
                    <select name="example2_length" aria-controls="example2" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div id="example1_filter" class="dataTables_filter" style="float: right; margin-right: 4%;">
                Search:<input type="search" class="form-control form-control-sm" placeholder="">
            </div>
        </div>
    </div> -->

    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ParentID</th>
                    <th>Name</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category) : ?>
                    <?php
                    $Name = ($category['parentID'] != 0) ? getCateByID($category['parentID'])['CategoryName'] : "";
                    ?>
                    <tr>
                        <td>
                            <?php echo $category['CategoryID'] ?>
                        </td>
                        <td>
                            <?php echo $Name ?>
                        </td>
                        <td>
                            <?php echo $category['CategoryName'] ?>
                        </td>
                        <td>
                            <a href="index.php?page=pages/Category/list.php&id=<?php echo $category['CategoryID']; ?>"><button type="button" class="updateCate btn btn-success">
                                    <i class="far fa-edit">
                                    </i>
                                </button></a>

                        </td>
                        <td>
                            <a onclick="return confirmDelete()" href="../controller/CategoryController.php?delete_category=<?php echo $category['CategoryID']; ?>"><button class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>ParentID</th>
                    <th>Name</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" style="float: left; margin-left: 4%;">Showing 1 to 6 of 6 entries</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                <ul class="pagination" style="float: right; margin-right: 4%;">
                    <li class="paginate_button page-item previous" id="example1_previous"><a href="#" class="page-link">Previous</a></li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item next " id="example1_next"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div> -->
</div>