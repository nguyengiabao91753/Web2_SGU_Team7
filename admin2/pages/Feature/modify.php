<?php

require_once('../backend/Userfunction.php');
$functions = getAllFeature();
$levels = getAllLevel();
?>

<style>
    #formadd {
        display: none;
    }

    #addbutton {
        width: 200px;
        height: 60px;
        font-size: 20px;
        margin: 5px 0 0 10px;
    }

</style>


<script>
    $(document).ready(function() {
        var addButton = $("#addbutton");
        var addForm = $("#formadd");

        addButton.click(function() {
            addForm.slideDown();

        });


    });
    $(document).ready(function() {
        var removeButton = $("#remove");
        var addForm = $("#formadd");

        removeButton.click(function() {
            addForm.slideToggle();
            $("#LevelName").val('');
        });


    });
</script>

<script>
    $(document).ready(function() {
        $("#LevelId").change(function() {
            var LevelId = $("#LevelId").val();
            $("#formlevel input[type='checkbox']").prop('checked', false);
            //alert(LevelId);
            $.ajax({
                url: '../backend/Userfunction.php',
                type: 'post',
                dataType: 'json',
                data: {
                    LevelId: parseInt(LevelId),
                    getFeatureByLevel: true
                },
                success: function(response) {
                    if (response && response.data) {

                        //alert(response.data.length);

                        for (var i = 0; i < response.data.length; i++) {
                            if (response.data[i].Status == 1) {
                                $("#formlevel").find('input[name="' + response.data[i].FunctId + '-' + response.data[i].Action + '"]').prop('checked', true);

                            }
                        }

                        $(document).ready(function() {
                            $('ul.nav-pills').each(function() {
                                var ulHasCheckedInput = false;
                                $(this).find('input[type="checkbox"]').each(function() {
                                    if ($(this).is(':checked')) {
                                        ulHasCheckedInput = true;
                                        return false; // Break out of the loop since we've found a checked input
                                    }
                                });
                                if (ulHasCheckedInput) {
                                    $(this).closest('.collapse').collapse('show');
                                } else {
                                    $(this).closest('.collapse').collapse('hide');
                                }
                            });
                        });

                    } else {

                        alert("No data received from server.");
                    }
                },
                error: function(error) {
                    alert('error');

                }
            });

        })
    })
</script>
<script>
    $(document).ready(function() {
        $('.nav-link.functname').click(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a

            // Tìm collapse tương ứng với thẻ a được nhấp vào
            var collapseId = $(this).attr('data-target');
            var collapse = $(collapseId);

            // Toggle class 'show' của collapse để ẩn hoặc hiện
            collapse.toggleClass('show');

            // Thay đổi dấu mũi tên của thẻ i
            var icon = $(this).find('i');
            if (collapse.hasClass('show')) {
                icon.removeClass('fa-angle-left').addClass('fa-angle-down');
            } else {
                icon.removeClass('fa-angle-down').addClass('fa-angle-left');
            }
        });
    });
</script>

<div class="addform">
    <div style="width: 400px;">
        <button id="addbutton" class="btn btn-tool">
            <i class="fa fa-plus-square"></i> <b>Add New Level</b>
        </button>
    </div>
    <!--addForm-->
    <form method="post" action="../backend/Userfunction.php" id="formadd">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Level Create</h3>
                <!-- <input type="text" value="" id="inpCategoryID" name="CategoryID" hidden> -->
                <div class="card-tools">
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button> -->
                    <button type="button" class="btn btn-tool" id="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Level</label>
                    <input type="text" name="levName" class="form-control" style="width: 30%;" id="LevelName" required>
                </div>

            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" name="add_level" id="" value="Submit">
            </div>
        </div>

        <!-- /.card -->
    </form>

</div>

<form method="post" action="../backend/Userfunction.php" id="formlevel">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Granting permissions to Users</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-form-label">User's Levels</label>
                        <select name="LevelId" id="LevelId" class="form-control">
                            <option value="">Select Level</option>
                            <?php foreach ($levels as $level) : ?>
                                <option value="<?php echo $level['LevelId'] ?>"> <?php echo $level['Name'] ?> </option>
                            <?php endforeach; ?>
                        </select>


                    </div>

                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Feature</div>
                        <div class="card-body">
                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column">
                                    <?php foreach ($functions as $function) : ?>
                                        <?php if($function['Name'] != 'Feature'): ?>
                                        <li class="nav-item">
                                            <div class="row">
                                                <!-- <div class="col-md-1" style="display: flex;;justify-content: center;">
                                                    <input type="checkbox" name="<?php echo $function['FunctionId']; ?>" value="<?php echo $function['FunctionId']; ?>" class="form-control" style="width: 20px;">
                                                </div> -->
                                                <div class="col-md-11">
                                                    <a href="#" class="nav-link functname" type="button" data-toggle="collapse" data-target="#<?php echo $function['FunctionId']; ?>Collapse">
                                                        <p>
                                                            <h3><?php echo $function['Name']; ?></h3>
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="collapse" id="<?php echo $function['FunctionId']; ?>Collapse">
                                                <ul class="nav nav-pills nav-sidebar">
                                                    <li class="nav-item flex-column">
                                                        <div class="row form-group" style="text-align: center;">
                                                            <input type="checkbox" name="<?php echo $function['FunctionId']; ?>-Create" id="" value="create" class="form-control" style="width: 20px;">
                                                            <p class="form-control">Create</p>
                                                        </div>
                                                        <!-- <input type="checkbox" name="" id="" class="form-control" style="width: 20px;">
                                                        <a class="nav-link">
                                                            <p>Level 3</p>
                                                        </a> -->
                                                    </li>
                                                    <li class="nav-item">
                                                        <div class="row form-group" style="text-align: center;">
                                                            <input type="checkbox" name="<?php echo $function['FunctionId']; ?>-Update" value="update" id="" class="form-control" style="width: 20px;">
                                                            <p class="form-control">Update</p>
                                                        </div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <div class="row form-group" style="text-align: center;">
                                                            <input type="checkbox" name="<?php echo $function['FunctionId']; ?>-Delete" value="delete" id="" class="form-control" style="width: 20px;">
                                                            <p class="form-control">Delete</p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="updateUserFunction" id="" value="Submit">
        </div>
    </div>

    <!-- /.card -->
</form>