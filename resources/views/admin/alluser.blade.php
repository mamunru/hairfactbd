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
          <h1 class="h3 mb-2 text-gray-800">User Verification Page</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pending Users</h6>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Picture</th>
                      <th>Mobile</th>
                      <th>email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $alluserdata as $userdata)
                     <thead class='text-center'>
                     
                     <td>{{$userdata->userid}}</td>
                     <td class='text-uppercase'>{{$userdata->name}}</td>
                     @if (!empty($userdata->image))
                     <td><img src="{{$userdata->image}}" alt="User Profile", width="80" height="80"></td>
                     @else
                          <td>No Picture</td>
                        @endif
                    <td>{{$userdata->mobile}}</td>
                     
                        
                      
                        
                      
                      
                      
                     <td>{{\Carbon\Carbon::parse($userdata->created_at)->format('j F, Y') }}</td>

                      @if ($userdata->status==0)
                         <td>Pending</td>
                          @else
                          <td><samp class="iglyphicon  text-center text-success">Approve</samp></td>
                        @endif

                       <td class="align-items-center">
                         
                         
                     
                      <div style="whide:5px"></div>
                        <a href="{{url('admin/user/delete/'.Auth::guard('admin')->user()->id.'/'.$userdata->userid)}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Delete</samp>
                        </a>
                      
                         
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $alluserdata->links('pagination::bootstrap-4') }}</div>
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

