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
          <h1 class="h3 mb-2 text-gray-800">All Product Page</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="float-right">
              
                <a href="{{url('admin/add/product/'.Auth::guard('admin')->user()->id)}}" class="btn btn-success">
                <samp class="iglyphicon  text-center">Add New Product</samp>
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
                      <th>ID</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Subcategory</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Rate</th>
                      <th>Comision Rate</th>
                      <th>QNT</th>
                      <th>Status</th>
                      <th>Date</th>
                      
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $products as $product)
                     <thead class='text-center'>
                     
                    <td>{{ $loop->index+1}}</td>
                     <td class='text-uppercase'>{{$product->title}}</td>
                     <td>{{ Str::limit($product->description, 50) }}</td>
                     <td>{{$product->catname}}</td>
                     <td>{{$product->subcatname}}</td>
                     @if (!empty($product->image))
                        <td><img src="{{$product->image}}" alt="User Profile", width="80" height="80"></td>
                     @else
                        <td>No Picture</td>
                     @endif
                    <td>{{$product->price}}</td>
                    <td>{{$product->rate}}</td>
                    <td>{{$product->comisionrate}}</td>
                    <td>{{$product->qnt}}</td>
                    @if ($product->status==1)
                    <td class="text-success" >Published</td>
                    @else
                    <td class="text-danger">Unpublished</td>
                    @endif
                    
                   
                     <td>{{\Carbon\Carbon::parse($product->created_at)->format('j F, Y') }}</td>

                     

                       <td class="align-items-center">
                         <div >
                         <a href="{{url('admin/edit/product/'.Auth::guard('admin')->user()->id.'/'.$product->id)}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center"><i class="fas fa-fw fa-edit"></i></samp>
                        </a>
                         </div>
                         
                     
                      <div style="height: 5px"></div>
                        <a href="{{url('admin/product/delete/'.Auth::guard('admin')->user()->id.'/'.$product->id)}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center"><i class="fas fa-fw fa-trash"></i></samp>
                        </a>
                      
                         
                      </td>
                      
                      
                     </thead>
                    @endforeach
                 

                 
                  <tbody>
                    
                    
                   
                  </tbody>
                </table>
                <div  class='float-right'>{{ $products->links('pagination::bootstrap-4') }}</div>
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

