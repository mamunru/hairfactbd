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
          
          <h1 class="h3 mb-2 text-gray-800">Image Slider Page</h1>
         

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            <div class="float-right">
              
              <a href="{{url('admin/add/imageslider/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
              <samp class="iglyphicon  text-center">Add File</samp>
              </a>
              
            </div>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                      <th>ID</th>
                      <th>Image Name</th>
                     
                      <th>File</th>
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $images as $image)
                     <thead class='text-center'>
                     
                     <td>{{ $loop->index+1}}</td>
                     <td class='text-uppercase'>{{$image->title}}</td>
                     
                     @if (!empty($image->url))
                     
                     <td><img src="{{$image->url}}" width="80" height="100"/></td>
                     @else
                          <td>No Picture</td>
                        @endif
                 
 
                     <td>{{\Carbon\Carbon::parse($image->created_at)->format('j F, Y') }}</td>

                       <td class="align-items-center">
                         <div >
                         
                         <a href="{{url('admin/imageslider/edit/'.Auth::guard('admin')->user()->id.'/'.$image->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Edit</samp>
                        </a>
                       
                         </div>
                         <br>
                         <div>
                          <a href="{{url('admin/imageslider/delete/'.Auth::guard('admin')->user()->id.'/'.$image->id)}}" class="btn btn-danger">
                            <samp class="iglyphicon  text-center">Delete</samp>
                          </a>
                        </div>
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $images->links('pagination::bootstrap-4') }}</div>
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

