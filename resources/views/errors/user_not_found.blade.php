
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>noitem</title>
      <!-- Bootstrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    

</head>
<body>
    <h1 class="container text-center mt-5">  User Not Found</h1>
    <div class="dropdown ms-5" style="position:absolute;top:10px;right:20px;">
    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
      {{Auth()->user()->name}}
    </button>
    <ul class="dropdown-menu">
      <a class=" text-dark nav-item text-decoration-none" href="{{ route('logout') }}"
      onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
       {{ __('Logout') }}
   </a>
   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
       @csrf
   </form>
    </ul>
  </div>
  <div style="position :absolute;top:10px;right:180px;">
     
     </div>
 
      </div>
   
    
</body>
</html>