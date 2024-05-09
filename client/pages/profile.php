<?php
require_once '../backend/Order.php';
require_once '../backend/Product.php';
require_once '../backend/User.php';
require_once '../backend/Account.php';
if (isset($_COOKIE['client'])) {
  $orders = getAllOrder();
  $cus = getCusbyId($_COOKIE['client']);
  $acc = getAccountByID($_COOKIE['client']);
}
?><style>
  /* Ẩn chữ "Choose File" */
  input[type="file"]::-webkit-file-upload-button {
    display: none;
    color: transparent;
  }
</style>
<script>
  function previewImage(input) {
    var preview = document.getElementById('avatarPreview');
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>


<section class="bg0 p-t-104 p-b-116">
  <div class="container">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <?php if ($acc['Avatar'] == NULL) : ?>
                      <!-- <span><i class="fas fa-comments" style="width: 30px;"></i></span> -->
                      <img class="profile-user-img img-fluid img-circle" style="width: 30px; height: 30px; object-fit: cover;" src="./images/user.png" alt="User profile picture">
                    <?php else : ?>
                      <img class="profile-user-img img-fluid img-circle" style="width: 30px; height: 30px; object-fit: cover;" src="<?php echo $acc['Avatar'] ?>" alt="User profile picture">
                    <?php endif; ?>

                  </div>

                  <h3 class="profile-username text-center"><?php echo $cus['FirstName'] . ' ' . $cus['LastName'] ?></h3>

                  <!-- <p class="text-muted text-center">Software Engineer</p> -->

                  <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email:</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone:</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Address</b> <a class="float-right">13,287</a>-->
                  </li>
                  </ul>

                  <a href="../backend/Logout.php?client=true" class="btn btn-danger btn-block"><b>Logout</b></a>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->

              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#pending" data-toggle="tab">Order in pending</a></li>
                    <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Order on delivering</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">My orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profile</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="pending">
                      <!-- Post -->
                      <?php $count1 = 0;
                      foreach ($orders as $order) :
                        if ($order['Status'] == 1) :
                          $count1 += 1;
                          $items = getItemsbyOrderID($order['OrderID']);
                      ?>

                          <div class="post">
                            <?php foreach ($items as $item) :
                              $sp = getProByID($item['ProductID']);
                            ?>

                              <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                  <span>COZA STORE</span>
                                  <span class="badge bg-success">Pending</span>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <img src="<?php echo $sp['Image']; ?>" class="img-fluid" alt="Ảnh sản phẩm">
                                    </div>
                                    <div class="col-md-6">
                                      <h5 class="card-title"><?php echo $sp['ProductName']; ?></h5>
                                      <p class="card-text">Quantity: <?php echo $item['Quantity']; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                      <p class="card-text"><?php echo $item['Subtotal']; ?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-end">
                                  <a class="btn btn-primary">Detail</a>
                                  <a class="btn btn-danger">Cancel order</a>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php if ($count1 == 0) : ?>
                        <div class="post" style=" text-align: center; ">


                          <span>HAVE NO ORDER</span>



                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="activity">
                      <!-- Post -->

                      <?php $count2 = 0;
                      foreach ($orders as $order) :
                        if ($order['Status'] == 2) :
                          $count2 += 1;
                          $items = getItemsbyOrderID($order['OrderID']);
                      ?>

                          <div class="post">
                            <?php foreach ($items as $item) :
                              $sp = getProByID($item['ProductID']);
                            ?>

                              <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                  <span>COZA STORE</span>
                                  <span class="badge bg-success">Delivering</span>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <img src="<?php echo $sp['Image']; ?>" class="img-fluid" alt="Ảnh sản phẩm">
                                    </div>
                                    <div class="col-md-6">
                                      <h5 class="card-title"><?php echo $sp['ProductName']; ?></h5>
                                      <p class="card-text">Quantity: <?php echo $item['Quantity']; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                      <p class="card-text"><?php echo $item['Subtotal']; ?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-footer text-end">
                                  <a class="btn btn-primary">Detail</a>

                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php if ($count2 == 0) : ?>
                        <div class="post" style=" text-align: center; ">


                          <span>HAVE NO ORDER</span>



                        </div>
                      <?php endif; ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                      <!-- Post -->

                      <?php $count3 = 0;
                      foreach ($orders as $order) :

                        if ($order['Status'] == 3) :
                          $count3 += 1;
                          $items = getItemsbyOrderID($order['OrderID']);
                      ?>

                          <div class="post">
                            <?php foreach ($items as $item) :
                              $sp = getProByID($item['ProductID']);
                            ?>
                              <div class="card">

                                <div class="card-header d-flex justify-content-between align-items-center">
                                  <span>COZA STORE</span>
                                  <span class="badge badge-success">Delivered</span>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <img src="<?php echo $sp['Image']; ?>" class="img-fluid" alt="Ảnh sản phẩm">
                                    </div>
                                    <div class="col-md-6">
                                      <h5 class="card-title"><?php echo $sp['ProductName']; ?></h5>
                                      <p class="card-text">Quantity: <?php echo $item['Quantity']; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                      <h5>Price:</h5>
                                      <p class="card-text" style="color: #ee4d2d;">$<?php echo $item['Price']; ?></p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach; ?>
                            <div class="card-footer text-end">
                              <p style="float: inline-end; font-size: 14px;">Total: <span style="color: #ee4d2d; font-size: 24px;">$<?php echo $order['TotalAmount']; ?></span></p>
                              <a class="btn btn-outline-info" href="?content=order_detail&Id=1" >Detail</a>

                            </div>

                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <?php if ($count3 == 0) : ?>
                        <div class="post" style=" text-align: center; ">


                          <span>HAVE NO ORDER</span>



                        </div>
                      <?php endif; ?>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">


                      <form class="form-horizontal" action="../backend/User.php" method="post">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-4 col-form-label">First Name</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="firstname" placeholder="First Name" value="<?php echo $cus['FirstName'] ?>">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputName" class="col-sm-4 col-form-label">Last Name</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="<?php echo $cus['LastName'] ?>" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                              <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $cus['Email'] ?>" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputName2" class="col-sm-4 col-form-label">Phone</label>
                              <div class="col-sm-8">
                                <input type="number" class="form-control" name="phone" placeholder="Phone number" value="<?php echo $cus['Phone'] ?>" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputExperience" class="col-sm-4 col-form-label">Address</label>
                              <div class="col-sm-8">
                                <input type="text" name="address" id="" class="form-control" placeholder="Address" value="<?php echo $cus['Address'] ?>" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="inputSkills" class="col-sm-4 col-form-label">Password</label>
                              <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $acc['Password'] ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" style="flex-direction: column; align-items: center;">
                              <label for="inputSkills" class="col-sm-4 col-form-label">Avatar</label>
                              <div class="text-center">
                                <?php if ($acc['Avatar'] == NULL) : ?>
                                  <!-- <span><i class="fas fa-comments" style="width: 30px;"></i></span> -->
                                  <img id="avatarPreview" class="profile-user-img img-fluid img-circle" style="width: 200px; height: 200px; object-fit: cover;" src="./images/user.png" alt="User profile picture">
                                <?php else : ?>
                                  <img id="avatarPreview" class="profile-user-img img-fluid img-circle" style="width: 200px; height: 200px; object-fit: cover;" src="<?php echo $acc['Avatar'] ?>" alt="User profile picture">
                                <?php endif; ?>

                              </div>
                              <div class="col-sm-8" style="flex-direction: column; align-items: center;">
                                <label for="fileInput" class="btn btn-info btn-large" style="display: block;margin-top: 10px;">
                                  Choose Image
                                </label>
                                <input type="file" id="fileInput" name="avatar" hidden onchange="previewImage(this)">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="offset-sm-2 col-sm-8">
                              <input type="submit" class="btn btn-info" value="Submit">
                            </div>
                          </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="">

                    </div>
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  </div>
</section>