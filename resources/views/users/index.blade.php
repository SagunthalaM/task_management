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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
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
        <div class="alert alert-danger alert-dismissible  show " role="alert ">
            {{ Session::get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>    
     @endif
       
        <div class="container mb-5">
            <div class="row">
                <div class="col">
                    <h6>User Details</h6>
                <table id="dataTable" class="table table-striped  table-hover">
            <thead class="table-dark" >
                <tr>
                    <th>Id</th>
                    <th>User Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
       
        </table>
                </div>
            </div>
        </div>
    
    </section>
    
        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('users.index') }}",
                    columns: [
                        { data: 'DT_RowIndex',name:'DT_RowIndex',orderable:false},
                        { data:'id', name:'id'},
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        {data: 'actions', name: 'actions', orderable: false, searchable: false}
                    ]
                });
            });
        </script>
    </body>
    </html>
</div>


@endsection()