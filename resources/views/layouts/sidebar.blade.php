<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link text-decoration-none">
      <img src="{{asset ('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3  d-flex">
        <div class="image">
          <img src="{{asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          
        </div>
        <div class="info text-white ">
        <h5 > {{ auth()->user()->username }}
        </h5>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
        @if(auth()->user()->role=='Admin')
        
          <li class="nav-item">
            <a href="/home" class="nav-link bg-secondary  active mb-2">
               <i class="nav-icon fas fa-home " ></i>
               <p class="ps-5">
                  Home
               </p>
             </a>
            <a href="#" class="nav-link  active">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                 Product Management
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav ">
              <li class="nav-item">
                <!-- here is an url -->
                <a href="{{ URL::to('admin/products') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Products</p>
                </a>
              </li>
              <li class="nav-item">
                <!-- Here I did it -->
                <a href="{{ URL::to('admin/products/create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <!-- Here I did it -->
                <a href="{{ URL::to('totalcarts') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cart List</p>
                </a>
              </li>
              <li class="nav-item">
                <!-- Here I did it -->
                <a href="{{ URL::to('totalorders') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Details</p>
                </a>
              </li>
            </ul>
            
            <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    User Management
                    <!-- <span class="badge badge-info right">6</span> -->
                  </p>
                </a>
                <ul class="nav ">
                  <li class="nav-item">
                    <!-- here is an url -->
                    <a href="{{ URL::to('admin/users') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>All User</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <!-- Here I did it -->
                    <a href="{{ URL::to('admin/add-user') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add User</p>
                    </a>
                  </li>
               
           @endif
           <a href="{{ route('logout') }}" class="nav nav-link bg-danger active mb-2">
            <i class="nav-icon material-symbols-outlined text-white " >logout</i>
            <p class="ps-5">
              Logout
            </p>
          </a>
            <!-- Here ends the User management -->
            </ul>
          </li>  
        </ul>
       
      </nav>
      <!-- /.sidebar-menu -->
    <!-- Logout bar -->
    
    </div>
    <!-- /.sidebar -->

  </aside>