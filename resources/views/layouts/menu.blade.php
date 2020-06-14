   
   <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark min-height:0px">
      <div class="collapse navbar-collapse"  id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
               <a class="nav-link" href=" {{ url('/home') }}">Home</a>
            </li>
         </ul>

         <ul class="navbar-nav ml-auto nav-flex-icons">

            <li class="nav-item active dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->nome }}
               </a>
               <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item text-right" href="">Perfil</a>
                  <a class="dropdown-item text-right" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                  <form id="frm-logout"  action="{{ route('logout') }}" method="POST" style="display: none;">
                     {{ csrf_field() }}
                  </form>
               </ul>
            </li>
            
         </ul>
      </div>
   </nav>


