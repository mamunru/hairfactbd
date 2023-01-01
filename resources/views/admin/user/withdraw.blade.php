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
          <h1 class="h3 mb-2 text-gray-800">Payment Page</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                      <th>id</th>
                      <th>Name</th>
                      <th>Picture</th>
                      <th>Mobile</th>
                      <th>Bank</th>
                      <th>Cash out</th>
                      <th>Old Balance</th>
                      <th>New Balance</th>
                      
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $userdatas as $userdata)
                     <thead class='text-center'>
                     <td>Dear--{{$userdata->userid}}</td>
                     
                     <td class='text-uppercase'>{{$userdata->name}}</td>
                     @if (!empty($userdata->image))
                     <td><img src="{{$userdata->image}}" alt="User Profile", width="80" height="80"></td>
                     @else
                          <td>No Picture</td>
                        @endif
                    <td>{{$userdata->mobile}}</td>
                    <td>{{$userdata->bank}}</td>
                    <td>{{$userdata->request_balance}}</td>
                    <td>{{$userdata->amount}}</td>
                    <td>{{$userdata->totalbalance}}</td>

                     <td>{{\Carbon\Carbon::parse($userdata->created_at)->format('j F, Y') }}</td>

                      @if ($userdata->status==0)
                         <td class="text-info">Pending</td>
                          @elseif($userdata->status==1)
                          <td class="text-success">Approve</td>
                          @else
                          <td class="text-danger">Faild</td>
                        @endif

                        @if ($userdata->status==0)
                       <td class="align-items-center">
                         <div >
                         <a href="{{url('admin/withdraw/success/'.Auth::guard('admin')->user()->id.'/'.$userdata->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Done</samp>
                        </a>
                         </div>
                         
                     
                      <div style="height:5px"></div>
                        <a href="{{url('admin/withdraw/faild/'.Auth::guard('admin')->user()->id.'/'.$userdata->id)}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Cancel</samp>
                        </a>
                      
                         
                      </td>
                     
                          
                      @else
                          <td>Done</td>
                      @endif
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $userdatas->links('pagination::bootstrap-4') }}</div>
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

