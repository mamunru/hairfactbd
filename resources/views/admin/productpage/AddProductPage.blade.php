@extends('admin.AdminMaster')

@section('csrf')
<meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .thumb{
          margin: 10px 5px 0 0;
          width: 150px;
      } 
      </style>
    
@endsection

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
          
          <h1 class="h3 mb-2 text-gray-800">Product Add Page</h1>
          
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form  method="POST" action="{{route('form_add_product')}}"  enctype="multipart/form-data">
                @csrf    
                <fieldset>

                 
                    <!-- Text input-->
                    <div class="form-group">
                      <label class=" control-label" for="product_name">Product Name</label>  
                      <div class="">
                      <input id="product_name" name="title" placeholder="Product Name" class="form-control input-md" required="" type="text">
                      <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->id}}">
                      </div>
                    </div>
                    
                    <!-- Textarea -->
                    <div class="form-group">
                      <label class=" control-label" for="PRICE">Product Description</label>
                      <div class="">                     
                        <textarea required='' class="form-control" id="price" name="description"></textarea>
                      </div>
                    </div>
                    
                    <!-- Select Basic -->
                    <div class="form-group">
                      <label class=" control-label" for="product_categorie">Product Category</label>
                      <div class="">
                        <select required='' name="categoty"  id="country-dd" class="form-control">
                          <option  value="">Select Category</option>
                          @foreach ($countries as $data)
                          <option value="{{$data->id}}">
                              {{$data->name}}
                          </option>
                          @endforeach
                      </select>
                      </div>
                    </div>

                     <!-- Select Basic -->
                     <div class="form-group">
                      <label class=" control-label" for="product_categorie"> Subcategory</label>
                      <div class="">
                        <select name="subcategory" id="state-dd" class="form-control">
                        </select>
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class=" control-label" for="available_quantity"> Quantity </label>  
                      <div class="">
                      <input id="available_quantity" name="qnt" placeholder="Available quantity" class="form-control input-md" required="" type="text">
                        
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      <label class=" control-label" for="product_weight">Product Rate</label>  
                      <div class="">
                      <input id="product_weight" name="rate" placeholder="Product Rate" class="form-control input-md" required="" type="text">
                        
                      </div>
                    </div>
                     <!-- Text input-->
                     <div class="form-group">
                      <label class=" control-label" for="product_weight">Product Price</label>  
                      <div class="">
                      <input id="product_weight" name="price" placeholder="Product Price" class="form-control input-md" required="Product Price is Required" type="text">
                        
                      </div>
                    </div>
                    
                   
                    
                    <!-- Textarea -->
                    <div class="form-group">
                      <label class=" control-label"  for="product_name_fr">Product Comission  % </label>
                      <div class="">                     
                        <input class="form-control" required='Comision is required' id="product_name_fr" name="comisionrate">
                      </div>
                    </div>
                    
                    <!-- Text input-->
                    <div class="form-group">
                      
                      <div class="">
                        
                     <!-- File Button --> 
                    <div class="form-group">
                      <label class=" control-label" for="filebutton">Main Image</label>
                      <div class="col-md-12 mb-2">
                        <img id="image_preview_container" src="{{ asset('storage/image/image-preview.png') }}"
                            alt="preview image" style="max-height: 150px;">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" required="Main File Required" name="main_image" placeholder="Choose image" id="image">
                            <span class="text-danger">{{ $errors->first('main_image') }}</span>
                        </div>
                    </div>
                    </div>
                    <div class="form-group" id='create'>
                      <label class=" control-label" for="filebutton">Image Gallery (Please Select All File in a Time)</label>
                    <div class="col-md-12">
                      <button type="button" id="reset" style="display: none" class="btn btn-info">Re-select</button>
                      <input type="file"  name="gallery[]"  id="file-input"  multiple />
                      
                    <span class="text-danger">{{ $errors->first('gallery') }}</span>
                    <div id="thumb-output"></div>
                    </div>
                    </div>
                    <!-- File Button --> 
                    
                    
                    <!-- Button -->
                    <div class="form-group">
                     <div class="float-left">
                        <button value="1" id="singlebutton" name="status" class="btn btn-primary">Published</button>
                      </div>
                      <div class="float-left" style="width: 100px"></div>
                      <div class="" style="padding-left: 100px">
                        <button value="0" id="singlebutton" name="status" class="btn btn-success">Draft Save</button>
                      </div>
                      </div>
                    
                    </fieldset>
                    
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
                    $('#state-dd').html('<option value="0">Select Subcategory</option>');
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
  $('#reset').on('click', function(){ 
  document.getElementById("file-input").style.display = "block";
  document.getElementById("reset").style.display = "none";
  $('#thumb-output').remove();
  
  
  document.getElementById('file-input').value='';
  
 });
});

$(document).ready(function(){
  

 $('#file-input').on('change', function(){ //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {

      
         
        var data = $(this)[0].files;
        
        $('#create').append("<div id='thumb-output'></div>"); //this file data
         
        $.each(data, function(index, file){ //loop though each file
            if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                var fRead = new FileReader(); //new filereader
                fRead.onload = (function(file){ //trigger function on successful read
                return function(e) {
                    var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element 
                    $('#thumb-output').append(img);
                    //append image to output element
                };
                })(file);
                fRead.readAsDataURL(file); //URL representing the file's data.
            }
        });

        document.getElementById("file-input").style.display = "none";
        document.getElementById("reset").style.display = "block";
         
    }else{
        alert("Your browser doesn't support File API!"); //if File API is absent
    }
 });
});

</script>
@endsection

