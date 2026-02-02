<div class="sidebar-wrapper" id="mysidebar">
    <div>
        
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt="" style="max-width: 10em">
                <img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt="" style="background-color: #F7F9FC; padding:2px;">
            </a>
            <div class="back-btn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-left"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/icon-avion.png') }}" alt="">
                <img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/icon-avion.png') }}" alt="" style="background-color: #F7F9FC; padding:2px;">
            </a>
        </div>        
        
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar" style="min-height: 100vh;">
                    <li class="back-btn">
                        <a href="{{ route('dashboard') }}">
                            <img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo.png') }}" alt="" style="max-width: 10em">
                            <img class="img-fluid for-dark" 
                                src="{{ asset('assets/images/logo/logo.png') }}" alt="" style="background-color: #F7F9FC; padding:2px;">
                            </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h4>General </h4>
                        </div>
                    </li>
                    <li class="sidebar-list"> 
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="home"></i>
                            <span class="lan-3">Dashboard</span>
                            <!-- <span  class="badge badge-primary">2</span> -->
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a class="lan-3" href="{{ route('dashboard') }}">Default</a></li>
                        </ul>
                    </li>

                   
                    <li class="sidebar-main-title">
                        <div>
                            <h4>Operaciones </h4>
                        </div>
                    </li>

                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Bitácoras</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @hasanyrole('Admin|Piloto|Instructor')
                            <li><a href="{{ route('log_entries.index') }}">Mis vuelos</a></li>
                            @endhasanyrole                            
                            <li><a href="{{ route('log_entries.reports') }}">Consultas</a></li>
                            <li><a href="{{ route('reports.index') }}">Reportes</a></li>
                            @hasanyrole('Admin|Oficial de Operaciones')
                            <li><a href="{{ route('reports.index') }}">Logbook</a></li>
                            @endhasanyrole  
                        </ul>
                    </li>                    
                    
                    @hasanyrole('Admin|Oficial de Operaciones')
                    <li class="sidebar-main-title">
                        <div>
                            <h4>Catalogos maestros</h4>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Pilotos</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('pilots.index') }}">Gestionar</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Aeronaves</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('aircraft_categories.index') }}">Categorías de Aeronaves</a></li>
                            <li><a href="{{ route('aircraft_models.index') }}">Modelos de Aeronaves</a></li>
                            <li><a href="{{ route('aircraft.index') }}">Gestionar Aeronave</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Aeropuertos</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('airports.index') }}">Gestionar Aeropuertos</a></li>
                        </ul>
                    </li>
                    @endhasanyrole
                    @role('Admin')
                    <li class="sidebar-main-title">
                        <div>
                            <h4>Usuarios y roles </h4>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Usuarios</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('users.index') }}">Gestionar</a></li>
                        </ul>
                    </li>
                    <!--
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >Roles</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="># </a></li>
                        </ul>
                    </li>-->
                    @endrole

                    <li class="sidebar-main-title">
                        <div>
                            <h4> Cuenta y Datos</h4>
                        </div>
                    </li>
                   <!--<li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('profile.show') }}">
                            <i data-feather="users"></i> 
                            <span>Mi cuenta</span>
                        </a>
                    </li>-->
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('logout') }}">
                            <i data-feather="users"></i> 
                            <span>Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
