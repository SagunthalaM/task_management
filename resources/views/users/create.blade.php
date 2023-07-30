@extends('backend.layouts.app')
@section('content')

<div class="wrapper " style="background-color: white">
<section class="content-wrapper ">
   <head>
      <!-- Bootstrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Include Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Include Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
         
   </head>
    <div class="row">
       <div class="">
        @if(Session::has('success'))
        <div class="alert alert-success  alert-dismissible  show " role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>    
     @endif
       </div>

       <div class="col-lg-10">
        <!-- Card start -->
      <div class=" container " style="box-shadow:1px 2px 5px gray ;padding:20px 20px;margin:10px 10px 10px 100px;">
        <div class="card-header">
            <h5 class="">
                Add User
            </h5>
        </div>
        <!-- Card body starts  -->
        <div class="card-body">
            <form action="{{ URL::to('admin/insert-user') }}" role="form" method="post" novalidate>
                @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">
                    User name<span style="color:red;">*</span>

                </label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control @error('name')
                        is-invalid
                    @enderror"
                     placeholder="Enter your name" value="{{ old('name') }}"
                     id="name" required>

                </div>
                @error('name')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">User email
                    <span style="color:red;">*</span>
                </label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control @error('email')
                        is-invalid
                    @enderror" 
                    placeholder="Enter email Address" value="{{ old('email') }}" required>
                </div>
                
                @error('email')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password
                    <span style="color:red;">*</span>
                </label>
                <div class="col-sm-10">
                    <input type="password" name="password"
                     class="form-control @error('password')
                         is-invalid
                     @enderror" placeholder="Enter your password"  required>
                </div>
                @error('password')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password
                    <span style="color:red;">*</span>
                </label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation"
                     class="form-control @error('password')
                         is-invalid
                     @enderror" placeholder="Enter your password"  required>
                </div>
                @error('password')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="role" class="col-sm-2 col-form-label">User role 
                    <span style="color:red;">*</span>
                </label>
                <div class="col-sm-10">
               <select name="role" class="form-control @error('role')
                   is-invalid
               @enderror custom-select" id="exampleFormControlSelect" required>
                  <option value="" >Select role</option>  
                <option value="Admin" name="role">Admin</option>
                    <option value="Developer" name="role">Developer</option>

               </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="auth_type" class="col-sm-2 col-form-label">createdBy
                    <span style="color:red;">*</span>
                </label>
                <div class="col-sm-10">
               <select name="auth_type" class="form-control @error('auth_type')
                   is-invalid
               @enderror custom-select" id="exampleFormControlSelect" required>
                  <option value="" >Select auth_type</option>  
                <option value="Admin" name="auth_type">Admin</option>
                    <option value="google" name="auth_type">google</option>
                    <option value="email" name="auth_type">email</option>
               </select>
                </div>
            </div>
            <!-- Card body ends -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ URL::to('/users') }}" class="ms-2 btn btn-dark">Back</a>
           
            </div>

            </form>
        </div>
      </div>
      <!-- Card End -->
       </div>

       
    </div>
</section>
</div>
@endsection