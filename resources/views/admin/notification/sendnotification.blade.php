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
          
          <h1 class="h3 mb-2 text-gray-800">Send Notification</h1>
         
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                
              <!-- Mycode-->

              <form method="POST" action="{{route('send_notification')}} "  enctype="multipart/form-data">
                @csrf    
              

             <!-- Select Basic -->
             <div class="form-group">
              <label class=" control-label" for="product_categorie" >Select User</label>
              <select name="userid"  id="country-dd" class="form-control">
               
              <div class="">
                <option value="0">
                  All User
              </option>
                  @foreach ($userprofiles as $data)
                  <option value="{{$data->id}}">
                      {{$data->name}}
                  </option>
                  @endforeach
              </select>
              </div>
            </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                     
                
                <input type="text"  class="form-control @error('title') is-invalid @enderror" name="title" aria-describedby="" placeholder="Enter title">
                <input id="authid" name="authid" type="hidden" value="{{Auth::guard('admin')->user()->id}}">
                    
                
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
               @enderror
            </div>

            <div class="form-group">
              <label for="exampleFormControlTextarea1">Message</label>
              <textarea class="form-control" name="message"  id="exampleFormControlTextarea1" placeholder="Message" rows="2"></textarea>
            </div>

              
              <button type="submit" class="btn btn-primary">Send</button>
            </form>

              </div>
            </div>
          </div>

        </div>
        </div>
      </div>
    </div>
  </div>


@endsection

