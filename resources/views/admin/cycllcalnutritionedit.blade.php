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
          <h1 class="h3 mb-2 text-gray-800">Cycllcalnutrition Page</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-danger">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('edit-cycllcalnutrition-file')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">File Name</label>
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" value="{{!empty($cycllcalnutrition->title)?$cycllcalnutrition->title:''}}" aria-describedby="" placeholder="Enter File Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}"> 
                <input name="id" type="hidden" value="{{!empty($cycllcalnutrition->id)?$cycllcalnutrition->id:''}}">   
                  
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Details</label>
                <textarea class="form-control" name="details"  id="exampleFormControlTextarea1" rows="2">{{!empty($cycllcalnutrition->body)?$cycllcalnutrition->body:''}}</textarea>
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

