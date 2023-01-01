@extends('admin.AdminMaster')

@section('content')
 <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            
            
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            
          
            <div class="container-fluid">

          <!-- Page Heading -->
          
          <h1 class="h3 mb-2 text-gray-800">Video Add File</h1>
          
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('upload_video-file')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">File Name</label>
                <input type="text" value="{{!empty($video->title)?$video->title:''}}"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter File Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">     
               <input id="vid" name="vid" type="hidden" value="{{!empty($video->id)?$video->id:''}}">
               <input id="text" name="file_real_name" type="hidden" value="{{!empty($video->file_real_name)?$video->file_real_name:''}}">
                
               @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
             </div>

             <div id="showmenu" class="menu"><samp class="iglyphicon btn btn-success  text-center">Add Video File</samp></div>
             <div id="showmenu2" class="myfile" style="display: none;" ><samp class="iglyphicon btn btn-success  text-center">Add Video URL</samp></div>
             
           <div style="height: 10px"></div>
             <div class="form-group menu" style="position: relative;">
                <input type="text" name="url" value="{{!empty($video->url)?$video->url:""}}" class="form-control" placeholder="Enter File URL">
                @error('url')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
             <div class="form-group myfile" style="display: none; position: relative;" >
                <label for="exampleFormControlFile1">Upload file</label>
                <input type="file" name="file" class="form-control-file @error('file') is-invalid @enderror" id="">
                @error('file')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>


              <button type="submit" class="btn btn-primary">Save File</button>
            </form>

              </div>
            </div>
          </div>

        </div>
        </div>
      </div>
    </div>
  </div>

  
@endsection

@section('category_js')
<script>
  $(document).ready(function() {
      var first = true;

      // Hide menu once we know its width
      $('#showmenu').click(function() {
          var $menu = $('.menu');
          var $myfile = $('.myfile');
          if ($menu.is(':visible')) {
              // Slide away
              $menu.animate({left: -($menu.outerWidth() + 10)}, function() {
                  $menu.hide();
                  $myfile.show();
              });
          }
          else {
              // Slide in
              $menu.show().css("left", -($menu.outerWidth() + 10)).animate({left: 0});
              $myfile.hide();
          }
      });

      $('#showmenu2').click(function() {
          var $menu = $('.menu');
          var $myfile = $('.myfile');
          if ($menu.is(':visible')) {
              // Slide away
              $menu.animate({left: -($menu.outerWidth() + 10)}, function() {
                  $menu.hide();
                  $myfile.show();
              });
          }
          else {
              // Slide in
              $menu.show().css("left", -($menu.outerWidth() + 10)).animate({left: 0});
              $myfile.hide();
          }
      });
  });
</script>
    
@endsection

