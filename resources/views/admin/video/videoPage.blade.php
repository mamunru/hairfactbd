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
          
          <h1 class="h3 mb-2 text-gray-800">Video Page</h1>
         

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            <div class="float-right">
              
              <a href="{{url('admin/add/video/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
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
                      <th>Video Name</th>
                     
                      <th>File</th>
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $videos as $video)
                     <thead class='text-center'>
                     
                     <td>{{ $loop->index+1}}</td>
                     <td class='text-uppercase'>{{$video->title}}</td>
                     
                     @if (!empty($video->url))
                     
                     <td><a href="{{$video->url}}" target="_blank"> View</td>
                     @else
                          <td>No Picture</td>
                        @endif
                 
 
                     <td>{{\Carbon\Carbon::parse($video->created_at)->format('j F, Y') }}</td>

                       <td class="align-items-center">
                         <div >
                         
                         <a href="{{url('admin/video/edit/'.Auth::guard('admin')->user()->id.'/'.$video->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Edit</samp>
                        </a>
                        <div style="height:2pt" ></div>
                         <a href="{{url('admin/video/delete/'.Auth::guard('admin')->user()->id.'/'.$video->id)}}" class="btn btn-danger">
                           <samp class="iglyphicon  text-center">Delete</samp>
                         </a>
                       
                         </div>
                         
                         
                     
                      
                         
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $videos->links('pagination::bootstrap-4') }}</div>
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

