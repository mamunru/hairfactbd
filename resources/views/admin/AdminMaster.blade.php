<!DOCTYPE html>
<html lang="en">

<head>

 @include('admin.fixedpart.adHeader')
 @yield('csrf')
 
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
  	<!-- Slider -->
    @include('admin.fixedpart.adSlider')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      @include('admin.fixedpart.adLogo')

        <!-- Begin Page Content -->
       
        <!-- /.container-fluid -->
        @yield('content')
        
      </div>

    
      <!-- End of Main Content -->

      <!-- Footer -->
      @include('admin.fixedpart.adfooter')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

     @include('admin.fixedpart.splogout')

     @yield('category_js')
     
</body>

</html>
