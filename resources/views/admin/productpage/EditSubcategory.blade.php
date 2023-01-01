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
          @empty($subcategory)
          <h1 class="h3 mb-2 text-gray-800">Subcategory Page</h1>
          @endempty
          @if (!empty($subcategory))
          <h1 class="h3 mb-2 text-gray-800">{{$subcategory->title}} Subcategory Page Update</h1>
          @endempty
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('subcategory_data_save')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">Subcategory Name</label>
                     
                @empty($subcategory)
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter Subcategory Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
                <input id="authid" name="" type="hidden" >     
                @endempty
                @if (!empty($subcategory))
                <input type="text" value="{{$subcategory->title}}"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter Subcategory Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
                <input id="id" name="id" type="hidden" value="{{$subcategory->id}}">     
                  
                @endempty
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>

              <!-- Select Basic -->
              <div class="form-group">
                <label class=" control-label" for="product_categorie" >Select Category</label>
                <select name="categoty"  id="country-dd" class="form-control">
                  @if (!empty($subcategory))
                  @foreach ($categories as $data)
                  @if ($subcategory->catid==$data->id)
                  <option value="{{$subcategory->id}}" >
                      {{$data->name}}
                    </option>
                  @endif
               
                  @endforeach
                  
                  @else
                      
                  <option value="" >Select Category</option>
                  @endif
                
                <div class="">
                  
                    
                    @foreach ($categories as $data)
                    <option value="{{$data->id}}">
                        {{$data->name}}
                    </option>
                    @endforeach
                </select>
                </div>
              </div>

              
              <button type="submit" class="btn btn-primary">Save</button>
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

