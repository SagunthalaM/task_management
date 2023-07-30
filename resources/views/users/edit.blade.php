@extends('backend.layouts.app')
@section('content')

<div class="wrapper">
<section class="content-wrapper">
    @if(Session::has('success'))
    <div class="alert alert-success  alert-dismissible  show " role="alert">
        {{ Session::get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>    
 @endif
    <div class="row">
       <div class="col-lg-1">

       </div>

       <div class="col-lg-10">
        <!-- Card start -->
      <div class="card">
        <div class="card-header">
            <h5 class="card-title">
              Edit User
            </h5>
        </div>
        <!-- Card body starts  -->
        <div class="card-body">
            <form action="{{URL::to('admin/update-user/'.$edit->id) }}" role="form" method="post">
                @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">User name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" 
                    placeholder="Enter your name" value="{{ $edit->name }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">User email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" placeholder="Enter email Address" value="{{ $edit->email }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" value="{{ $edit->password }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">User role type</label>
                <div class="col-sm-10">
               <select name="role" class="form-control" id="exampleFormControlSelect" required>
                    <option value="Admin"{{ 'Admin' == $edit->role?'selected':'' }}>Admin</option>
                    <option value="Developer"{{ 'Developer' == $edit->role?'selected':'' }}>Developer</option>
               </select>
                </div>
            </div>
            <!-- Card body ends -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ URL::to('/users') }}" class="ms-5 btn btn-dark">Back</a>
            </div>

            </form>
        </div>
      </div>
      <!-- Card End -->
       </div>

       <div class="col-lg-1">
        
       </div>
    </div>
</section>
</div>
@endsection