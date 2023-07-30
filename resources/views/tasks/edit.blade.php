@extends('backend.layouts.app')

@section('content')
<div class="container ">
                <div class="">
                    @if(Session::has('success'))
                    <div class="alert alert-success ">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>    
                 @endif
                   </div>
            <div class="container">
            
                <div class=" text-center mt-3 mb-2"><h5> Update Task </h5>
              </div>
            <div class="container d-flex justify-content-center">
                <form action="{{ URL::to('tasks/update/'.$edit->id) }}" method="post" role="form" novalidate style="min-width:300px;width:50vw;">
               
               @csrf
               <label for="users">Assign to Users:</label>
               <select name="users[]" id="users" class="form-control @error('users')
                   is-invalid
               @enderror">
                   @foreach($users as $user)
                       <option value="{{ $user->id }}" {{ $edit->users->contains($user->id)?'selected':'' }}>
                        {{ $user->name }}
                    </option>
                   @endforeach
               </select>
               <br>
                <div class="mb-3">
                <label for="task" class="">
                    Task
                </label>
                    <input type="text"  class="form-control @error('task')
                        is-invalid
                    @enderror" name="task" value="{{ $edit->task }}">
                    @error('task')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="description">Task Description:</label>
                        <textarea name="description" id="description"
                         rows="5" cols="155" 
                         class="form-control @error('address') is-invalid @enderror me-5" >
                            {{ old('description', $edit->description) }}
                        </textarea>
                      
                @error('description')
                <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                @enderror
                </div>
               
                <div class="form-group row mb-3">
                    <div class="col-sm-6">
                        <input type="position" placeholder="position"
                         class="form-control @error('position') is-invalid
                    @enderror" name="position" value="{{ $edit->position }}" >
                    @error('position')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                    @enderror

                    </div>
                    <div class="col-sm-6">
                   <select name="progress" class="form-control @error('progress')
                       is-invalid
                   @enderror custom-select" id="exampleFormControlSelect" required> 
                    <option value="Started{{ 'Started' == $edit->role?'selected':'' }}" name="progress">Started</option>
                        <option value="in-process{{ 'in-process' == $edit->role?'selected':'' }}" name="progress">In process</option>
                        <option value="Finished{{ 'Finished' == $edit->role?'selected':'' }}" name="progress">Finished</option>
                   </select>
                   @error('progress')
                   <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                   @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                    <label for="start_date" class="form-label">
                         Starting Date
                    </label>
                    <input type="date"  class="form-control @error('start_date')
                        is-invalid
                    @enderror" name="start_date" value="{{ $edit->start_date }}" >
                    @error('start_date')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="col">
                    <label for="end_date" class="form-label">
                      End Date
                    </label>
                    <input type="date" class="form-control @error('end_date')
                        is-invalid
                    @enderror" name="end_date" value="{{ $edit->end_date }}">
                    @error('end_date')
                    <div class="text-danger" style="margin-left:160px">{{ $message }}</div>
                    @enderror
                    </div>
                    </div>
                <div style="margin-bottom:10px;">
                <button style="margin-right:5px;" type="submit" class="btn btn-success">
                   Update
                </button><a href="{{ URL::to('tasks') }}" class="btn btn-danger">Cancel</a>
                </div>
                </form>
            </div>
            
            
            
            </div>
            
            
            <div style="position:fixed;text-decoration:none; text-dark;bottom:0;right:0;margin:25px;" >
                <div class="" >
                    <a class="" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            
                <!-- Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            
               
   
</div>
@endsection
