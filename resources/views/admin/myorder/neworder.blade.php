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
          <h1 class="h3 mb-2 text-gray-800">Today Order List</h1>
          

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
                     
                      <th>Product Name</th>
                      <th>User Name</th>
                      <th>Price</th>
                      
                      <th>User Mobile</th>
                      <th>Address</th>
                      <th>Image</th>
                      <th>QTY</th>
                      <th>Txid</th>
                      <th>Status</th>
                      <th>Date</th>
                     
                    </tr>

                    </thead>
                     @foreach( $products as $product)
                     <thead class='text-center'>
                     
                    
                     <td class='text-uppercase'>{{$product->name}}</td>
                     <td>{{$product->user_name}}</td>
                     <td>{{$product->price}}</td>
                     <td>{{$product->mobile}}</td>
                     <td>{{$product->address}}</td>
                     @if (!empty($product->image))
                        <td><img src="{{$product->image}}" alt="Image", width="80" height="80"></td>
                     @else
                        <td>No Picture</td>
                     @endif
                    
                    <td>{{$product->qty}}</td>
                    <td>{{$product->txid}}</td>
                    @if ($product->status=='COD')
                    <td class="text-success" >COD</td>
                    @elseif($product->status=='Processing')
                    <td class="text-success">Paid</td>
                    @else
                    <td class="text-danger">Faild</td>
                    @endif
                    
                     <td>{{\Carbon\Carbon::parse($product->created_at)->format('j F, Y') }}</td>
                     </thead>
                    @endforeach

                
                @foreach( $codproducts as $product)
                <thead class='text-center'>
                
               
                <td class='text-uppercase'>{{$product->name}}</td>
                <td>{{$product->user_name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->mobile}}</td>
                <td>{{$product->address}}</td>
                @if (!empty($product->image))
                   <td><img src="{{$product->image}}" alt="Image", width="80" height="80"></td>
                @else
                   <td>No Picture</td>
                @endif
               
               <td>{{$product->qty}}</td>
               <td>{{$product->txid}}</td>
               @if ($product->status=='COD')
               <td class="text-success" >COD</td>
               @elseif($product->status=='Processing')
               <td class="text-success">Paid</td>
               @else
               <td class="text-danger">Faild</td>
               @endif
               
                <td>{{\Carbon\Carbon::parse($product->created_at)->format('j F, Y') }}</td>
                 
                 
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

