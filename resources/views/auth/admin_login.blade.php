<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <title>Admin</title>
</head>
<body>
   <div class="container mt-5">
      <div class="row">
         <div class="col-md-3"></div>
         <div class="col-md-6 text-center">
            <div class="card">
               <div class="card-body">
                  <form id="sign_in_adm" method="POST" action="{{ route('admin.login.submit') }}">
                     {{ csrf_field() }}
                  <h1>Admin Login</h1>
                  <h4 class="text-center text-danger">{{Session::get('message')}}</h4>
                  <div class="form-line">
                     <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                  </div>
                  @if ($errors->has('email'))
                  <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                  @endif
                  <br>
                  <div class="form-line">
                     <input type="password" class="form-control" name="password" placeholder="Password" required>
                  </div>
                  <br>
                  <div class="text-center">
                     <button type="submit" class="btn  btn-info">SIGN IN</button>
                  </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-md-3"></div>
      </div>
   </div>
</body>
</html>