   
   <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark min-height:0px">
      <div class="collapse navbar-collapse"  id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
               <a class="navbar brand" style="padding-top: 0px;">
               <img src="/imgs/logo-new.png" class="rounded" height='30' style="background-color: white">
               </a>
            </li>



            <li class="nav-item active">
               <a class="nav-link" href=" {{ url('/home') }}">Home</a>
            </li>


            @foreach($rotinas as $rotina)

               @switch($rotina->id_rotina)
                  @case(1)
                     <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $rotina->nome }}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="{{ action('perfilUsuarioController@index') }}">Perfil de Usuário</a>
                           <a class="dropdown-item" href="{{ action('usuarioController@index') }}">Usuários</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="{{ action('empresaController@index') }}">Empresas do Grupo</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">Tipo de Evento</a>
                           <a class="dropdown-item" href="#">Tipo de Serviço</a>
                        </ul>
                     </li>
                     @break
                  @case(3)
                     <li class="nav-item active">
                        <a class="nav-link" href=" {{ url('/home') }}">{{ $rotina->nome }}</a>
                     </li>
                     @break
               @endswitch

            @endforeach

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


