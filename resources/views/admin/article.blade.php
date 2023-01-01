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
          @empty($inclinic)
          <h1 class="h3 mb-2 text-gray-800">Article Page</h1>
          @endempty
          @if (!empty($inclinic))
          <h1 class="h3 mb-2 text-gray-800">{{$inclinic->name}}</h1>
          @endempty

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
          
            <div class="card-header py-3">
            <div class="float-right">
              @empty($inclinic)
              <a href="{{url('admin/add/article/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
              <samp class="iglyphicon  text-center">Add File</samp>
              </a>
              @endempty
              @if (!empty($inclinic))
              <a href="{{url('admin/add/inclinic/'.Auth::guard('admin')->user()->id.'/'.$inclinic->id)}}" class="btn btn-success">
                <samp class="iglyphicon  text-center">Add File</samp>
                </a>
            @endempty
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
                      <th>File Name</th>
                      <th>Details</th>
                      <th>File</th>
                      <th>Data</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $articles as $article)
                     <thead class='text-center'>
                     
                     <td>{{$loop->index+1}}</td>
                     <td class='text-uppercase'>{{$article->title}}</td>
                     <td class='text-uppercase'>{{$article->details}}</td>
                     @if (!empty($article->url))
                     
                     <td><a href="{{$article->url}}" download> Download</td>
                     @else
                          <td>No Picture</td>
                        @endif
                 
 
                     <td>{{\Carbon\Carbon::parse($article->created_at)->format('j F, Y') }}</td>

                       <td class="align-items-center">
                         <div >
                          @empty($inclinic)
                          <div >
                         <a href="{{url('admin/article/edit/'.Auth::guard('admin')->user()->id.'/'.$article->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Edit</samp> </a>
                         </div>
                         <div style="height:2pt" ></div>
                         <div>
                          <a href="{{url('admin/article/delete/'.Auth::guard('admin')->user()->id.'/'.$article->id)}}" class="btn btn-danger">
                            <samp class="iglyphicon  text-center">Delete</samp>
                          </a>
                         </div>
                        @endempty
                        @if (!empty($inclinic))
                        <a href="{{url('admin/inclinic/edit/inclinicfile/'.Auth::guard('admin')->user()->id.'/'.$article->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Edit</samp>
                        </a>
                        <div style="height:2pt" ></div>
                        <a href="{{url('admin/inclinic/delete/inclinicfile/'.Auth::guard('admin')->user()->id.'/'.$article->id)}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Delete</samp>
                        </a>
                        @endempty
                         </div>
                         
                         
                     
                      
                         
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $articles->links('pagination::bootstrap-4') }}</div>
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

