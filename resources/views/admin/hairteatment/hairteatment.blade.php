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
          <h1 class="h3 mb-2 text-gray-800">Hair Therapist List</h1>
          <div class="w3agile-top" style="font-size: 16px;">
           
          </div>

         
         

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
                <div class="float-right">
              
                    <a href="{{url('admin/add/therapist/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
                    <samp class="iglyphicon  text-center">Add</samp>
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
                      <th>Serial</th>
                      <th>Name</th>
                      <th>Address</th>
                     
                      <th>Action</th>
                    </tr>

                    </thead>
                    @foreach( $dates as $date)
                     <thead class='text-center'>
                        
                        <td>{{ $loop->index+1}}</td>
                           <td class='text-uppercase'>{{$date->title}}</td>
                          <td>{{$date->url}}</td>
                           <td class="align-items-center">
                            <div >
                            <a href="{{url('admin/therapist/edit/byid/'.Auth::guard('admin')->user()->id.'/'.$date->id)}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center"><i class='fas fa-edit'></i></samp>
                           </a>
                            </div>
                            <br>
                        
                            <div >
                           <a href="{{url('admin/therapist/delete/'.Auth::guard('admin')->user()->id.'/'.$date->id)}}" class="btn btn-danger">
                             <samp class="iglyphicon  text-center"><i class='fas fa-trash'></i></samp>
                           </a>
                            </div>
                         
                            
                         </td>
                      
                     </thead>
                    
                     @endforeach

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{$dates->links('pagination::bootstrap-4')}}</div>
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

