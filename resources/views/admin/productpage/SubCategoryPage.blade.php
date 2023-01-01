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
          <h1 class="h3 mb-2 text-gray-800">Subcategory Page</h1>
          <div class="w3agile-top" style="font-size: 16px;">
           
          </div>

         
         

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
                <div class="float-right">
              
                    <a href="{{url('admin/add/subcategory/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
                    <samp class="iglyphicon  text-center">Add Subcategory</samp>
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
                      <th>Title</th>
                      <th>Category Name</th>
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                    @foreach( $subcategories as $subcategory)
                     <thead class='text-center'>
                        
                        <td>{{ $loop->index+1}}</td>
                           <td class='text-uppercase'>{{$subcategory->title}}</td>
                          <td>{{$subcategory->catname}}</td>
                           <td>{{\Carbon\Carbon::parse($subcategory->created_at)->format('j F, Y') }}</td>
                           <td class="align-items-center">
                            <div style="float: left;">
                            <a href="{{url('admin/subcategory/edit/byid/'.Auth::guard('admin')->user()->id.'/'.$subcategory->id)}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center"><i class='fas fa-edit'></i></samp>
                           </a>
                            </div>
                            
                        
                         
                           <a href="{{url('admin/subcategory/delete/'.Auth::guard('admin')->user()->id.'/'.$subcategory->id)}}" class="btn btn-danger">
                             <samp class="iglyphicon  text-center"><i class='fas fa-trash'></i></samp>
                           </a>
                         
                            
                         </td>
                      
                     </thead>
                    
                     @endforeach

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{$subcategories->links('pagination::bootstrap-4')}}</div>
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

