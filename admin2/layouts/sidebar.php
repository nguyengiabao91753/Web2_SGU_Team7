 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="index3.html" class="brand-link">
     <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
     <span class="brand-text font-weight-light">AdminLTE 3</span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">

          <a href="#" class="d-block">Alexander Pierce</a>

       </div>
     </div>
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="col-md-12" style="text-align: center;">
        <a href="../backend/Logout.php?user_id=true" class="btn btn-block btn-outline-danger"><i class="fas fa-power-off"></i> Logout</a>
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
          <li class="nav-item">
           <a href="" class="nav-link">
             <i class="nav-icon fas fa-sitemap"></i>
             <p>
               Statistical
             </p>
           </a>
         </li>
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
               <a href="index.php?page=pages/Category/list" class="nav-link">
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
          <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-users"></i>
             <p>
               Order
               <i class="right fas fa-angle-left"></i>
             </p> 
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="index.php?page=pages/order/order&status=1" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Pending</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="index.php?page=pages/order/order&status=2" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Delivering</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="index.php?page=pages/order/order&status=3" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Delivered</p>
               </a>
             </li>
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
             <li class="nav-item">
               <a href="index.php?page=pages/Customer/create" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Create</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="index.php?page=pages/Customer/list" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>List</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="index.php?page=pages/Customer/account" class="nav-link">
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
               <a href="index.php?page=pages/Feature/modify" class="nav-link">
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