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
            <div class="float-right">
                         <a href="{{url('admin/add/cycllcalnutrition/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Add / Edit</samp>
                        </a></div>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                     
                      <th>Title</th>
                      <th>Details</th>
                      
                      <th>Data</th>
                     
                    </tr>

                    </thead>
                    
                     <thead class='text-center'>
                        
                           @if (!empty($cycllcalnutrition->title))
                     
                           <td class='text-uppercase'>{{$cycllcalnutrition->title}}</td>
                           @else
                                <td>No Data</td>
                              @endif

                              @if (!empty($cycllcalnutrition->body))
                     
                              <td class='text-uppercase'>{{$cycllcalnutrition->body}}</td>
                              @else
                                   <td>No Data</td>
                                 @endif
                                 @if (!empty($cycllcalnutrition->created_at))
                     
                                 <td>{{\Carbon\Carbon::parse($cycllcalnutrition->created_at)->format('j F, Y') }}</td>
                                 @else
                                      <td>No Data</td>
                                    @endif
                     
                    
                    
 
                     

                      
                      
                     </thead>
                    
                 

                 
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

