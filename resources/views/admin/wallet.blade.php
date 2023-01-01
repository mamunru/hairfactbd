@extends('admin.AdminMaster')

@section('content')

<div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Tables</h1>
          <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables 
              Example</h6>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Doctor ID</th>
                      <th>Doctor Name</th>
                      <th>Doctor Bank Account</th>
                      <th>Total Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                 @foreach($wallets as $wallet)
                     </thead>
                     <td>{{$wallet->history}}</td>
                     <td>{{$wallet->doctor_id}}</td>
                     @foreach(App\Doctor_bank::where('doctor_id','=',$wallet->doctor_id)->get() as $doctorinfo)
                     <td>{{$doctorinfo->name}}</td>
                     <td>Bank Name: {{$doctorinfo->bank_name}}<br>Branch Name: {{$doctorinfo->branch_name}}<br>Account Number : {{$doctorinfo->account}}</td>
                     @endforeach
                     <td>{{$wallet->withdrow}}</td>
                      @if ($wallet->status==1)
                         <td class="text-primary" >Pandding</td>
                          @elseif($wallet->status==2)
                          <td class="text-success">Complate</td>
                          @else
                          <td class="text-danger">Faild</td>
                        @endif
                        @if ($wallet->status==1)
                        <td class="align-items-center">
                        <a href="{{url('doctor/balance/done/'.Auth::guard('admin')->user()->id.'/'.$wallet->doctor_id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">OK</samp>
                        </a>
                      </td>
                       @else
                          <td class="text-danger">No Action</td>
                      @endif
                     
                    </tbody>

                    @endforeach
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


@endsection