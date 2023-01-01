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
          <h1 class="h3 mb-2 text-gray-800">Category Page</h1>
          <div class="w3agile-top" style="font-size: 16px;">
            @empty($edit)
          <form method="POST" action="{{route('category_upload-file')}}" enctype="multipart/form-data">
            @csrf
          
          <div class="form-group">
            <label for="exampleFormControlInput1">Category Name</label>
            
             <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="category Name" >
             <input name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
             
             @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
             @enderror
          
          </div>

           <!-- File Button --> 
           <div class="form-group">
            <label class=" control-label" for="filebutton">Main Image</label>
            <div class="col-md-12 mb-2">
              <img id="image_preview_container" src="{{ asset('storage/image/image-preview.png') }}"
                  alt="preview image" style="max-height: 150px;">
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <input type="file" required="Main File Required"  name="main_image" placeholder="Choose image" id="image">
                  <span class="text-danger">{{ $errors->first('main_image') }}</span>
              </div>
          </div>
          </div>

         
          <div class="form-group row">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                  </div>
        </form>
        @endempty
         @if (!empty($edit))
           <form method="POST" action="{{route('category_upload-file')}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
            <label for="exampleFormControlInput1">category Edit</label>
             <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="category Name" value="{{$edit->name}}" >
             <input id="invisible_id" name="id" type="hidden" value="{{$edit->id}}">
             <input name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
             <input type="hidden" name="file_real_name" value="{{$edit->file_real_name}}">
             @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
             @enderror
          </div>

           <!-- File Button --> 
           <div class="form-group">
            <label class=" control-label" for="filebutton">Main Image</label>
            <div class="col-md-12 mb-2">
              <img id="image_preview_container" src="{{$edit->url}}"
                  alt="preview image" style="max-height: 150px;">
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <input type="file" required="Main File Required" name="main_image" placeholder="Choose image" id="image">
                  <span class="text-danger">{{ $errors->first('main_image') }}</span>
              </div>
          </div>
          </div>



         
          <div class="form-group row">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
        </form>
          
          @endif
         </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                      <th>Serial</th>
                      <th>Title</th>
                     <th>Image</th>
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                    @foreach( $categories as $category)
                     <thead class='text-center'>
                        
                        <td>{{ $loop->index+1}}</td>
                           <td class='text-uppercase'>{{$category->name}}</td>
                           <td ><img src="{{$category->url}}" width="100px", height="100px"/></td>
                          
                           <td>{{\Carbon\Carbon::parse($category->created_at)->format('j F, Y') }}</td>
                           <td class="align-items-center">
                            <div style="float: left;">
                            <a href="{{url('admin/category/edit/byid/'.Auth::guard('admin')->user()->id.'/'.$category->id)}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center"><i class='fas fa-edit'></i></samp>
                           </a>
                            </div>
                            
                        
                         <div style="whide:5px"></div>
                           <a href="{{url('admin/category/delete/'.Auth::guard('admin')->user()->id.'/'.$category->id)}}" class="btn btn-danger">
                             <samp class="iglyphicon  text-center"><i class='fas fa-trash'></i></samp>
                           </a>
                         
                            
                         </td>
                      
                     </thead>
                    
                     @endforeach

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{$categories->links('pagination::bootstrap-4')}}</div>
              </div>
            </div>
          </div>

        </div>
        

          <!-- Content Row -->


          
        </div>
      </div>
    </div>
  </div>


@endsection

@section('category_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#country-dd').on('change', function () {
            var idCountry = this.value;
            $("#state-dd").html('');
            $.ajax({
                url: "{{url('api/fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state-dd').html('<option value="">Select Subcategory</option>');
                    $.each(result.subcategories, function (key, value) {
                        $("#state-dd").append('<option value="' + value
                            .id + '">' + value.title + '</option>');
                    });
                    $('#city-dd').html('<option value="">Select Subcategory</option>');
                }
            });
        });
        $('#state-dd').on('change', function () {
            var idState = this.value;
            $("#city-dd").html('');
            $.ajax({
                url: "{{url('api/fetch-cities')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dd').html('<option value="">Select City</option>');
                    $.each(res.cities, function (key, value) {
                        $("#city-dd").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });


    $(document).ready(function (e) {
   
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
   });
  
   $('#image').change(function(){
           
    let reader = new FileReader();

    reader.onload = (e) => { 

      $('#image_preview_container').attr('src', e.target.result); 
    }

    reader.readAsDataURL(this.files[0]); 
  
   });
  
   $('#upload_image_form').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{url('/admin/save/product')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
           this.reset();
           alert('Image has been uploaded successfully');
        },
        error: function(data){
           console.log(data);
         }
       });
   });
});

$(document).ready(function(){
 $('#file-input').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
         
        var data = $(this)[0].files; //this file data
         
        $.each(data, function(index, file){ //loop though each file
            if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                var fRead = new FileReader(); //new filereader
                fRead.onload = (function(file){ //trigger function on successful read
                return function(e) {
                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                    $('#thumb-output').append(img); //append image to output element
                };
                })(file);
                fRead.readAsDataURL(file); //URL representing the file's data.
            }
        });
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });
});

</script>
@endsection



