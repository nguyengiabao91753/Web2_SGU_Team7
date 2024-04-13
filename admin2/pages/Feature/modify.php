<?php
require_once('../controller/UserfunctionController.php');
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
                url: '../controller/UserfunctionController.php',
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
                                $("#formlevel").find('input[name="' + response.data[i].FunctId + '"]').prop('checked', true);
                            }
                        }
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


<div class="addform">
    <div style="width: 400px;">
    <button id="addbutton" class="btn btn-tool">
        <i class="fa fa-plus-square"></i> <b>Add New Level</b>
    </button>
    </div>
    <!--addForm-->
    <form method="post" action="../controller/UserfunctionController.php" id="formadd">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Level Create</h3>
                <input type="text" value="" id="inpCategoryID" name="CategoryID" hidden>
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
                    <label>Level</label>
                    <input type="text" name="levName" class="form-control" style="width: 30%;" id="LevelName">
                </div>

            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary" name="add_level" id="" value="Submit">
            </div>
        </div>

        <!-- /.card -->
    </form>

</div>

<form method="post" action="../controller/UserfunctionController.php" id="formlevel">

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
                            <?php foreach ($functions as $function) : ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1" style="padding-right: 0px;">
                                            <input type="checkbox" class="form-control form-control-sm" name="<?php echo $function['FunctionId']; ?>" value="<?php echo $function['FunctionId']; ?>">
                                        </div>
                                        <div class="col-md-11" style="padding-left: 0px;">
                                            <label class=""><?php echo $function['Name']; ?></label>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>


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