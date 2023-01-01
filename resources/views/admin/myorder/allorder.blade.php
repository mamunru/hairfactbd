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
          <h1 class="h3 mb-2 text-gray-800">All Orders</h1>
          

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="float-right">
              
                
              </div>
              <h3 class="text-center text-success">{{Session::get('message')}}</h3>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="overflow-x: auto;">
                <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
                  <thead class='text-center'>
                    <tr>
                     <th>Order Number</th>
                      <th>Product Name</th>
                      <th>User info</th>
                      <th>Price</th>
                      <th>Address</th>
                      <th>Image</th>
                      <th>QTY</th>
                      <th>Txid</th>
                      <th>Status</th>
                      <th>Shipping Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>

                    </thead>
                     @foreach( $products as $product)
                     <thead class='text-center'>
                     
                    <td>ord-{{$product->id}}</td>
                     <td class='text-uppercase'>{{$product->name}}</td>
                     <td>{{$product->user_name}} <br>{{$product->mobile}}</td>
                     <td>{{$product->price}}</td>
                     
                     <td>{{$product->address}}</td>
                     @if (!empty($product->image))
                        <td><img src="{{$product->image}}" alt="Image", style="width:100px;height:100px;">
                          </td>
                     @else
                        <td>No Picture</td>
                     @endif
                    
                    <td>{{$product->qty}}</td>
                    <td>{{$product->txid}}</td>
                    @if ($product->status=='COD')
                    <td class="text-info" >COD</td>
                    @elseif($product->status=='Processing')
                    <td class="text-success">Paid</td>
                    @else
                    <td class="text-danger">Faild</td>
                    @endif
                    <td class="text-danger">{{$product->shipping}}</td>
                     <td>{{\Carbon\Carbon::parse($product->created_at)->format('j F, Y') }}</td>

                     

                       <td class="align-items-center">

                        @if ($product->shipping=='Pending')
                         <div >
                         <a href="{{url('admin/shipping/'.Auth::guard('admin')->user()->id.'/'.$product->txid.'/1')}}" class="btn btn-success">
                          <samp class="iglyphicon  text-center">Shipping</samp>
                        </a>
                         </div>
                         @endif
                         <div style="height: 5px"></div>
                         @if($product->shipping =='Shipping')
                         <div >
                            <a href="{{url('admin/shipping/'.Auth::guard('admin')->user()->id.'/'.$product->txid.'/2')}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center">Done</samp>
                           </a>
                            </div>
                         
                            
                      <div style="height: 5px"></div>
                        <a href="{{url('admin/shipping/'.Auth::guard('admin')->user()->id.'/'.$product->txid.'/3')}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Cancel</samp>
                        </a>
                        @endif


                         @if ($product->shipping=='Pending' && $product->done == 'Pending')
                         <div >
                            <a href="{{url('admin/shipping/'.Auth::guard('admin')->user()->id.'/'.$product->txid.'/2')}}" class="btn btn-success">
                             <samp class="iglyphicon  text-center">Done</samp>
                           </a>
                            </div>
                         
                            
                      <div style="height: 5px"></div>
                        <a href="{{url('admin/shipping/'.Auth::guard('admin')->user()->id.'/'.$product->txid.'/3')}}" class="btn btn-danger">
                          <samp class="iglyphicon  text-center">Cancel</samp>
                        </a>
                        
                            
                        @endif
                        @if ($product->done=='Done')
                            <p class="text-success">{{$product->done}}</p>
                        @elseif($product->done=='Faild')  
                        <p class="text-danger">{{$product->done}}</p>  
                        @endif

                        
                      
                         
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

