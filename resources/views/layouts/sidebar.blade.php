 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         
        </div>
        <div class="info">
          <a href="#" class="d-block">Welcome! {{ Session::get('username')}}</a>
          <form method="POST" action="{{ route('logout') }}"> @csrf <button style="float: right; margin-top: 20px;" onclick="logoutThis();">Logout</button></form>
          
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        

          <li class="nav-item has-treeview @if(Route::current()->getName() == 'dashboard') menu-open  @endif">
            <a href="{{ route('dashboard') }}" class="nav-link @if(Route::current()->getName() == 'dashboard') active  @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Dashboard
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="">
              <i class="nav-icon fas fa-table"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview @if(Route::current()->getName() == 'roleManage') menu-open  @endif ">
            <a href="{{ route('roleManage') }}" class="nav-link @if(Route::current()->getName() == 'roleManage') active @endif ">
              <i class="nav-icon fas fa-table"></i>
              <p style="margin-left: 40px;">
                Role
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview @if(Route::current()->getName() == 'userManage') menu-open  @endif ">
            <a href="{{ route('userManage') }}" class="nav-link @if(Route::current()->getName() == 'userManage') active @endif ">
              <i class="nav-icon fas fa-table"></i>
              <p style="margin-left: 40px;">
                User
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Expenses Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview @if(Route::current()->getName() == 'expenseCategories') menu-open  @endif ">
            <a href="{{ route('expenseCategories') }}" class="nav-link @if(Route::current()->getName() == 'expenseCategories') active @endif ">
              <i class="nav-icon fas fa-table"></i>
              <p style="margin-left: 40px;">
                Expense Categories
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview @if(Route::current()->getName() == 'expenses') menu-open @endif ">
            <a href="{{ route('expenses') }}" class="nav-link @if(Route::current()->getName() == 'expenses') active @endif ">
              <i class="nav-icon fas fa-table"></i>
              <p style="margin-left: 40px;">
                Expenses
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>