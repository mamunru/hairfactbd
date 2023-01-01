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
          @empty($inclinic)
          <h1 class="h3 mb-2 text-gray-800">Article Add File</h1>
          @endempty
          @if (!empty($inclinic))
          <h1 class="h3 mb-2 text-gray-800">{{$inclinic->name}} Add File</h1>
          @endempty
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('upload-file')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">File Name</label>
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter File Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">     
                @empty($inclinic)
                <input id="authid" name="" type="hidden" >     
                @endempty
                @if (!empty($inclinic))
                <input id="authid" name="incid" type="hidden" value="{{$inclinic->id}}">     
                @endempty
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Details</label>
                <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="2"></textarea>
              </div>

              <div class="form-group">
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

