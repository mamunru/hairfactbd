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
          @empty($therapists)
          <h1 class="h3 mb-2 text-gray-800">Therapist Add Page</h1>
          @endempty
          @if (!empty($therapists))
          <h1 class="h3 mb-2 text-gray-800">{{$therapists->title}} Edit</h1>
          @endempty
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('therapist_data_save')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">Therapists Name</label>
                     
                @empty($therapists)
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter Subcategory Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
                <input id="authid" name="" type="hidden" >     
                @endempty
                @if (!empty($therapists))
                <input type="text" value="{{$therapists->title}}"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter Subcategory Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
                <input id="id" name="id" type="hidden" value="{{$therapists->id}}">     
                  
                @endempty
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>

              <!-- Select Basic -->
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Address</label>
                <textarea class="form-control" name="url"  id="exampleFormControlTextarea1" rows="2">{{!empty($therapists->url)?$therapists->url:''}}</textarea>
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

