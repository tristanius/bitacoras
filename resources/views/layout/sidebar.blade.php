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
                            <h4>Menú </h4>
                        </div>
                    </li>
                    
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i> 
                            <span class="lan-3">Dashboard</span>
                        </a>
                    </li>
                    <hr>
                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i class="fa fa-table"></i> 
                            <span >Bitácoras</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @hasanyrole('Admin|Piloto|Instructor')
                            <li><a href="{{ route('log_entries.index') }}">Mis vuelos</a></li>
                            @endhasanyrole                            
                            <li><a href="{{ route('log_entries.reports') }}">Consultas</a></li>
                            <li><a href="{{ route('reports.index') }}">Reportes</a></li>
                            @hasanyrole('Admin|Oficial de Operaciones')
                            <!--<li><a href="{{ route('reports.index') }}">Logbook</a></li>-->
                            @endhasanyrole  
                        </ul>
                    </li>
                    <hr>
                    @hasanyrole('Admin|Oficial de Operaciones')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('pilots.index') }}">
                            <i class="fa fa-id-badge"></i> 
                            <span>Pilotos</span>
                        </a>
                    </li>
                    @endhasanyrole
                    
                    @hasanyrole('Admin|Oficial de Operaciones|Piloto')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i class="fa fa-plane"></i> 
                            <span >Aeronaves</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @hasanyrole('Admin|Oficial de Operaciones')
                            <li><a href="{{ route('aircraft_categories.index') }}">Categorías</a></li>
                            <li><a href="{{ route('aircraft_models.index') }}">Modelos </a></li>
                            @endhasanyrole
                            @hasanyrole('Admin|Oficial de Operaciones|Piloto')
                            <li><a href="{{ route('aircraft.index') }}"> Aeronaves</a></li>
                            @endhasanyrole
                        </ul>
                    </li>
                    @endhasanyrole
                    
                    @hasanyrole('Admin|Oficial de Operaciones')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('airports.index') }}">
                            <i class="fa fa-map-marker"></i> 
                            <span>Aeropuertos</span>
                        </a>
                    </li>
                    @endhasanyrole
                    
                    @role('Admin')
                    <hr>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('users.index') }}">
                            <i class="fa fa-user-circle-o"></i>
                            <span>Usuarios</span>
                        </a>
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
                    <hr>
                   <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('profile.show') }}">
                            <i data-feather="users"></i> 
                            <span>Mi cuenta</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('logout') }}">
                            <i class="fa fa-sign-out"></i> 
                            <span>Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
