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
          <h1 class="h3 mb-2 text-gray-800">Inclinic Page</h1>
          <div class="w3agile-top" style="font-size: 16px;">
            @empty($edit)
          <form method="POST" action="{{route('inclinic_upload-file')}}">
            @csrf
          
          <div class="form-group">
            <label for="exampleFormControlInput1">Inclinic Name</label>
            
             <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Inclinic Name" >
             <input name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
             @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
             @enderror
          
          </div>

         
          <div class="form-group row">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                  </div>
        </form>
        @endempty
         @if (!empty($edit))
           <form method="POST" action="{{route('inclinic_edit_file')}}">
            @csrf

            <div class="form-group">
            <label for="exampleFormControlInput1">Inclinic Edit</label>
             <input name="name" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Inclinic Name" value="{{$edit->name}}" >
             <input id="invisible_id" name="id" type="hidden" value="{{$edit->id}}">
             <input name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
             
             @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
             @enderror
          </div>

         
          <div class="form-group row">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
        </form>
          
          @endif
         </div>

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
                     
                      <th>Title</th>
                     
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                    @foreach( $inclinics as $inclinic)
                     <thead class='text-center'>
                        
                          
                           <td class='text-uppercase'>{{$inclinic->name}}</td>
                          
                           <td>{{\Carbon\Carbon::parse($inclinic->created_at)->format('j F, Y') }}</td>
                           <td class="align-items-center">
                            <div style="float: left;">
                            <a href="{{url('admin/inclinic/files/byid/'.Auth::guard('admin')->user()->id.'/'.$inclinic->id)}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center"><i class='fas fa-plus'></i></samp>
                           </a>
                            </div>
                            
                        
                         <div style="whide:5px"></div>
                           <a href="{{url('admin/inclinic/edit/'.Auth::guard('admin')->user()->id.'/'.$inclinic->id)}}" class="btn btn-danger">
                             <samp class="iglyphicon  text-center"><i class='fas fa-edit'></i></samp>
                           </a>
                         
                            
                         </td>
                      
                     </thead>
                    
                     @endforeach

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $inclinics->links('pagination::bootstrap-4') }}</div>
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

