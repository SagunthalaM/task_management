@extends('backend.layouts.app')
@section('content')


<div class="content-wrapper">

    <!DOCTYPE html>
    <html>
    <head>
        <title>All users</title>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
          <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />     
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <style>
            .alert {
     position: relative;
     z-index: 1;
}
        </style>
    </head>
    <body>
       
      <section style="padding-top:10px">
        @if(Session::has('danger'))
        <div class="alert alert-danger ">
            {{ Session::get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>    
     @endif
       
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col">
                <button class="btn btn-dark mb-3">
                <a href="{{URL::to('/tasks')}}" class="text-decoration-none text-white">Back</a>
                </button>   

                <table id="data" class="table table-striped  table-hover">
            <thead class="table-dark" >
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th style="width: 200px">Task</th>
                    <th style="width: 300px">Description</th>
                    <th>S Date</th>
                    <th>E Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$show_task->id}}</td>
                    <td>@foreach ($show_task->users as $user )
                        {{ $user->name }}
                    @endforeach
                    </td>
                    <td>{{$show_task->task}}</td>
                    <td>{{ $show_task->description }}</td>
                    <td>{{ $show_task->start_date }}</td>
                    <td>{{ $show_task->end_date }}</td>


                </tr>
            </tbody>

       
        </table>
                </div>
            </div>
        </div>
    
    </section>
    
      
    </body>
    </html>
</div>


@endsection()