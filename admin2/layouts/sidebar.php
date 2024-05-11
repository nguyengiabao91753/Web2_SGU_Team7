<style>
  
</style> 
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
     <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light">Websell-SGU</span>
   </a>

   <!-- Sidebar -->
   <?php
 
    require_once '../backend/User.php';
  
    $id = $_COOKIE['user_id'];
    $user_login = getCusbyId($id);

    ?>
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">

         <a href="#" class="d-block"><?php echo $user_login['FirstName'] . ' ' . $user_login['LastName'] ?></a>

       </div>
     </div>
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="col-md-12" style="text-align: center;">
         <a href="../backend/Logout.php?user_id=true" class="btn btn-block btn-outline-danger"><i class="fas fa-power-off"></i><span class=""> Logout</span></a>
       </div>

     </div>

     <!-- SidebarSearch Form -->
     <div class="form-inline">
       <div class="input-group" data-widget="sidebar-search">
         <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
         <div class="input-group-append">
           <button class="btn btn-sidebar">
             <i class="fas fa-search fa-fw"></i>
           </button>
         </div>
       </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php if (getLevelbyUserId() == 'Admin') :  ?>
         <li class="nav-item">
           <a href="?page=Statistical" class="nav-link">
             <i class="nav-icon fas fa-sitemap"></i>
             <p>
               Statistical
             </p>
           </a>
         </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Category')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-sitemap"></i>
               <p>
                 Category
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="index.php?page=Category/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Product')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-box"></i>
               <p>
                 Product
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="index.php?page=Product/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Order')) :  ?>
           <?php
            $query = "SELECT COUNT(*) AS pending
            FROM orders
            WHERE Status = 1;";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_row($result);
            $count = (int)$row[0];
            if($count==0) $count = '';
            ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 Order
                 <i class="right fas fa-angle-left"></i>
                 <span class="badge badge-danger right"><?php echo $count ?></span>
               </p>
             </a>
             <ul class="nav nav-treeview">
             <?php if(getFeaturebyAction('Order','Pending')): ?>
               <li class="nav-item">
                 <a href="index.php?page=Order/pending" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Pending</p>
                   <span class="badge badge-danger right"><?php echo $count ?></span>
                 </a>
               </li>
               <?php endif; ?>
               <?php if(getFeaturebyAction('Order','Delivering')): ?>
               <li class="nav-item">
                 <a href="index.php?page=Order/delivering" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Delivering</p>
                 </a>
               </li>
               <?php endif; ?>
               <?php if(getFeaturebyAction('Order','Delivered')): ?>
               <li class="nav-item">
                 <a href="index.php?page=Order/delivered" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Delivered</p>
                 </a>
               </li>
               <?php endif; ?>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Customer')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 Customer
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <!-- <li class="nav-item">
               <a href="index.php?page=Customer/create" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Create</p>
               </a>
             </li> -->
               <li class="nav-item">
                 <a href="index.php?page=Customer_backup/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="index.php?page=Customer_backup/account" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Account</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Employee')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 Employee
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <!-- <li class="nav-item">
               <a href="index.php?page=Customer/create" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Create</p>
               </a>
             </li> -->
               <li class="nav-item">
                 <a href="index.php?page=Employee/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="index.php?page=Employee/account" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Account</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Warehouse')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 Warehouse
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="index.php?page=Warehouse_demo/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getFeaturebyName('Supplier')) :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-sitemap"></i>
               <p>
                 Supplier
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="index.php?page=Supplier/list" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>List</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
         <?php if (getLevelbyUserId() == 'Admin') :  ?>
           <li class="nav-item">
             <a href="#" class="nav-link">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 Feature
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="index.php?page=Feature/modify" class="nav-link">
                   <i class="far fa-circle nav-icon"></i>
                   <p>Modify</p>
                 </a>
               </li>
             </ul>
           </li>
         <?php endif; ?>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>