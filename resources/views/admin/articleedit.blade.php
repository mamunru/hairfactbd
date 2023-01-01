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
          @empty($article->inclinicid)
          <h1 class="h3 mb-2 text-gray-800">Article Page</h1>
          @endempty
          @if (!empty($article->inclinicid))
          <h1 class="h3 mb-2 text-gray-800">{{$article->title}}</h1>
          @endempty
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-danger">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('edit-article-file')}} "  enctype="multipart/form-data">
                @csrf    
              <div class="form-group">
                <label for="exampleInputEmail1">File Name</label>
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" value="{{$article->title}}" aria-describedby="" placeholder="Enter File Name">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}"> 
                <input name="id" type="hidden" value="{{$article->id}}"> 
                @empty($article->inclinicid)
                @endempty
                @if (!empty($article->inclinicid))
                <input name="incid" type="hidden" value="{{$article->inclinicid}}"> 
                
                @endempty      
                <input name="file_real_name" type="hidden" value="{{$article->file_real_name}}">   
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Details</label>
                <textarea class="form-control" name="details"  id="exampleFormControlTextarea1" rows="2">{{$article->details}}</textarea>
              </div>

              <div class="form-group">
                <label for="exampleFormControlFile1">Upload file</label>
                <input type="file" name="file"  class="form-control-file @error('file') is-invalid @enderror" id="">
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

