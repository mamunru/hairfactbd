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
          <h1 class="h3 mb-2 text-gray-800">Doctor Verification</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Doctors Pending</h6>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
              <button type='button'  class='float-right btn btn-primary'> <a style='text-decoration: none;color: white;' href="{{url('/admin/registration')}}">
                  
                  Add New Users
                </a>
                </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class='text-center'>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Action</th>
                    
                    </tr>

                    </thead>
                     @foreach( App\Admin::where('id','!=',Auth::guard('admin')->user()->id)->get() as $doctor)
                     <thead class='text-center'>
                     
                     <td>{{$doctor->id}}</td>
                     <td class='text-uppercase'>{{$doctor->name}}</td>
                     <td class=''>{{$doctor->email}}</td>
                     
                     <td class="align-items-center">
                        <a href="{{url('admin/delete/'.Auth::guard('admin')->user()->id.'/'.$doctor->id)}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Delete</samp>
                        </a>
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
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

