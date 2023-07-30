<?php

use App\Http\Controllers\TaskController;
$total = TaskController::totalTask();
?>
@extends('layouts.app')
@section('content')
<div class="container mb-5">           
    <nav>
        <div class="navbar navbar-light justify-content-center fs-3" style="">
                   Task Details
          </div>
   </nav>
        <div class="row">
           <div class="col-lg-12">
            <!-- Card start -->
          <div class=" container " >
            <div class="card-header" style="">
                <h5 class="">
                  Task Detail
                </h5>
            </div>
            <!-- Card body starts  -->
            <div class="card-body" style="">
                
            @if (count($tasks) > 0)
            @foreach ($tasks as $task )
               
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">
                       Task{{ $task->id }}
    
                    </label>
                    <div class="col-sm-10">
                        <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->task }}</p>
                    </div><hr>
                    <label for="name" class="col-sm-2 col-form-label">
                        Description
     
                     </label>
                     <div class="col-sm-10">
                         <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->description }}</p>
                     </div><hr>
                     <label for="name" class="col-sm-2 col-form-label">
                        Position
     
                     </label>
                     <div class="col-sm-10">
                         <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->position }}</p>
                     </div><hr>
                      <label for="name" class="col-sm-2 col-form-label">
                        Staring Date
     
                     </label>
                     <div class="col-sm-10">
                         <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->start_date }}</p>
                     </div><hr>
                     <label for="name" class="col-sm-2 col-form-label">
                       End Date
     
                     </label>
                     <div class="col-sm-10">
                         <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->end_date }}</p>
                     </div><hr>
                     <label for="name" class="col-sm-2 col-form-label">
                       Progress
                      </label>
                      <div class="col-sm-10">
                          <p class="border border-light py-1 px-2" style="width: 850px">{{ $task->progress}}</p>
                      </div>
                     <hr>
                    <form action="{{ route('tasks.update-progress', $task->id) }}"  method="POST">
                        @csrf
                        @method('PUT')
        
                        <label for="progress" class="form-label">Update Progress:</label>
                        <input type="text" name="progress" id="progress" class="  btn border" style="margin-left:79px" >
                        <button type="submit" class="btn btn-primary text-white">Update</button>
                        
                    </form>
                </div>
                <hr style="border-top: 1px solid  green ;width:100%" >
               
                    @endforeach     
                    @else
                    <div class="container justify-content-center" >
                        <p>No tasks found for the user.</p>
                    </div>
                @endif
            </div>
          </div>
          <!-- Card End -->
           </div>
    
           
        </div>
   </div>
</div>
@endsection()