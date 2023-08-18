  <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/')}}" class="nav-link">Home</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        {{-- <a href="#" class="nav-link"></a> --}}

        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            Logout <i class="fas fa-sign-out-alt"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

      </li>
    </ul>

    <!-- Right navbar links -->
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4 asidebar">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('dist/img/richlandlogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">
        {{DB::table('appinfo')->first()->appname}}
      </span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"><div class="os-resize-observer-host"><div class="os-resize-observer observed" style="left: 0px; right: auto;"></div></div><div class="os-size-auto-observer" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer observed"></div></div><div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 848px;"></div><div class="os-padding"><div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll; right: 0px; bottom: 0px;"><div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/avatar04.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column side" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">
            WALLET
          </li>
          <li class="nav-item">
            <a href="/transactions/view" class="nav-link {{(Request::Is('transactions/view')) ? 'active' : ''}}">
              
              <i class="nav-icon fa-solid fa-basket-shopping"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/" class="nav-link {{(Request::Is('studentinfo')) ? 'active' : ''}}">
              <i class="nav-icon fa-solid fa-list"></i>
              <p>
                Logs
              </p>
            </a>
          </li>
          
          <li class="nav-header">
            USERS
          </li>
          <li class="nav-item">
            <a href="/players/view" class="nav-link {{(Request::Is('players/view')) ? 'active' : 'aaa'}}">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>
                Players
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/view" class="nav-link {{(Request::Is('admin/view')) ? 'active' : ''}}">
              <i class="nav-icon fa-solid fa-user-shield"></i>
              <p>
                Admins
              </p>
            </a>
          </li>
          <li class="nav-header">
            MAINTENANCE
          </li>
          <li class="nav-item">
            <a href="{{route('users')}}" class="nav-link {{(Request::Is('users')) ? 'active' : ''}}">
              <i class="nav-icon fa-solid fa-gears"></i>
              <p>
                Settings
              </p>
            </a>
          </li>

      
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div></div></div><div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar os-scrollbar-vertical"><div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 61.2112%; transform: translate(0px, 0px);"></div></div></div><div class="os-scrollbar-corner"></div></div>
    <!-- /.sidebar -->
  </aside>