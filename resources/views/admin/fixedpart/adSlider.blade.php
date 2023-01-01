 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('admin')}}">
        <div class="sidebar-brand-icon rotate-n-15">
          
        </div>
        <div class="sidebar-brand-text mx-3"><img src="{{asset('MainBody/images/logo.png')}}" width="100" height="60"> </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{url('admin')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

     
    
      <!-- Nav Item - Pages Collapse Menu 
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li> -->
       <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{url('admin')}}">
          <i class="fas fa-fw fa-home"></i>
          <span>Home Page</span></a>
      </li>

      
      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="{{url('admin/new/order/'.Auth::guard('admin')->user()->id)}}">
          <i class="fas fa-fw fa-shopping-bag"></i>
          <span>Today Order</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('admin/form/notification/'.Auth::guard('admin')->user()->id)}}">
          <i class="fas fa-fw fa-bell"></i>
          <span>Send Notification </span></a>
       
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('admin/add/product/'.Auth::guard('admin')->user()->id)}}">
          <i class="fas fa-fw fa-plus-square"></i>
          <span>Add New Product</span></a>
      </li>

    

      <!-- Nav Item - Tables -->
      
       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Literatures & Gallery</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">List Category :</h6>
            <a class="collapse-item" href="{{url('admin/imageslider/'.Auth::guard('admin')->user()->id)}}">Image Banner</a>
            <a class="collapse-item" href="{{url('admin/article/'.Auth::guard('admin')->user()->id)}}">Article</a>
            <a class="collapse-item" href="{{url('admin/cycllcalnutrition/'.Auth::guard('admin')->user()->id)}}">Cycllcal Nutrition </a>
            <a class="collapse-item" href="{{url('admin/inclinic/'.Auth::guard('admin')->user()->id)}}">InClinic Input</a>
            <a class="collapse-item" href="{{url('admin/video/'.Auth::guard('admin')->user()->id)}}">Video</a>
            <a class="collapse-item" href="{{url('admin/image/'.Auth::guard('admin')->user()->id)}}">Images</a>
            <a class="collapse-item" href="{{url('admin/hairtherapi/'.Auth::guard('admin')->user()->id)}}">Hair Therapist</a>
            <div class="collapse-divider"></div>
           
            
          </div>
        </div>
      </li> 
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa fa-cube"></i>
          <span>Product Section</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Product Section :</h6>
            <a class="collapse-item" href="{{url('admin/all/product/'.Auth::guard('admin')->user()->id)}}">All Product</a>
            <a class="collapse-item" href="{{url('admin/category/'.Auth::guard('admin')->user()->id)}}">Category</a>
            <a class="collapse-item" href="{{url('admin/subcategory/'.Auth::guard('admin')->user()->id)}}">Sub Category</a>
            <div class="collapse-divider"></div>
           
            
          </div>
        </div>
      </li> 

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-shopping-cart"></i>
          <span>Orders & Account</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">List Category :</h6>
            <a class="collapse-item" href="{{url('admin/new/order/'.Auth::guard('admin')->user()->id)}}">New Order</a>
            <a class="collapse-item" href="{{url('admin/order/'.Auth::guard('admin')->user()->id)}}">History Order</a>
            <a class="collapse-item" href="{{url('admin/approve/user/'.Auth::guard('admin')->user()->id)}}">Users</a>
            <a class="collapse-item" href="{{url('admin/product/return/request/'.Auth::guard('admin')->user()->id)}}">Return</a>
            
            <div class="collapse-divider"></div>
           
            
          </div>
        </div>
      </li> 
      
    

     
       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-money-bill-alt"></i>
          <span>Payment</span>
        </a>
        <div id="collapsethree" class="collapse" aria-labelledby="headingthree"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">List Category :</h6>
            <a class="collapse-item" href="{{url('admin/withdraw/pending/'.Auth::guard('admin')->user()->id)}}">
              Withdraw Request </a>
            <a class="collapse-item" href="{{url('admin/withdraw/'.Auth::guard('admin')->user()->id)}}">Withdraw History</a>
            <a class="collapse-item" href="{{url('admin/give/bonus/'.Auth::guard('admin')->user()->id)}}">Give Bonus </a>
            
            <div class="collapse-divider"></div>
           
            
          </div>
        </div>
      </li> 


       <!-- Nav Item - Pages Collapse Menu -->
       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-bell"></i>
          <span>Notification</span>
        </a>
        <div id="collapsefour" class="collapse" aria-labelledby="headingthree"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">List Category :</h6>
            
            <a class="collapse-item" href="{{url('admin/form/notification/'.Auth::guard('admin')->user()->id)}}">Send Notification</a>
            <a class="collapse-item" href="{{url('admin/all/notification/'.Auth::guard('admin')->user()->id)}}">Notification Histiry </a>
            
            <div class="collapse-divider"></div>
           
            
          </div>
        </div>
      </li> 
      
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
