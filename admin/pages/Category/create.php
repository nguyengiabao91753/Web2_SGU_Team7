<?php
    array_push($jsStack, ['link' => 'https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js']);
    array_push($jsStack, ['link' => 'https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js']);
    array_push($jsStack, ['link' => 'https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js']);
    array_push($jsStack, ['link' => 'https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js']);
    array_push($jsStack, ['link' => 'assets/js/main.js']);
?>
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-lg-4 col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Reader</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Reader </a></li>
                            <li><a href="#">Forms</a></li>
                            <li class="active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Create Form</strong> Reader Card
                    </div>
                    <div class="card-body card-block">
                        <form action=""  enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Full Name:</label></div>
                                <div class="col-12 col-md-4"><input type="text" id="text-input" name="text-input" placeholder="Enter your address" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-4"><input type="email" id="email-input" name="email-input" placeholder="Enter Email" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Addreess:</label></div>
                                <div class="col-12 col-md-4"><input type="text" id="text-input" name="text-input" placeholder="Enter your address" class="form-control"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Phone number:</label></div>
                                <div class="col-12 col-md-4"><input type="number" id="number-input" name="text-input" placeholder="Enter your phone number" class="form-control"></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">End Date</label></div>
                                <div class="col-12 col-md-4"><input type="date" id="date-input" name="text-input" placeholder="Text" class="form-control"></div>
                            </div>
                            <!-- <div class="row form-group">
                                <div class="col col-md-3"><label for="select" class=" form-control-label">Select Department</label></div>
                                <div class="col-12 col-md-3">
                                    <select name="select" id="select" class="form-control">
                                        <option value="0">Department</option>
                                        <option value="1">Option #1</option>
                                        <option value="2">Option #2</option>
                                        <option value="3">Option #3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="select" class=" form-control-label">Select Supervisor</label></div>
                                <div class="col-12 col-md-3">
                                    <select name="select" id="select" class="form-control">
                                        <option value="0">Supervisor</option>
                                        <option value="1">Option #1</option>
                                        <option value="2">Option #2</option>
                                        <option value="3">Option #3</option>
                                    </select>
                                </div>
                            </div> -->


                            
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="file-input" class=" form-control-label">File Avatar</label></div>
                                <div class="col-12 col-md-9"><input type="file" id="file-input" name="file-input" class="form-control-file"></div>
                            </div>
                            <hr><hr>
                            <button type="submit" class="form-group btn btn-primary">
                             Submit
                            </button>
                        </form>
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>


</div><!-- .animated -->