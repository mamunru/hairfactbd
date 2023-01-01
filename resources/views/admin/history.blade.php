@extends('admin.AdminMaster')

@section('content')

<div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">History</h1>
         

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Dr name</th>
                      <th>Patient Name</th>
                      <th>Status</th>
                      <th>Serial</th>
                      
                    </tr>
                  </thead>
                 
                  
                     
                </table>
              </div>
            </div>
          </div>

        </div>

@endsection

