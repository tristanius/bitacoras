<div class="sidebar-wrapper">
    <div>
        
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img class="img-fluid for-light"
                    src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                <img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="">
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
                    src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                <img class="img-fluid for-dark"
                    src="{{ asset('assets/images/logo/logo-icon-dark.png') }}" alt="">
            </a>
        </div>        
        
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar" style="min-height: 100vh;">
                    <li class="back-btn">
                        <a href="{{ route('dashboard') }}">
                            <img class="img-fluid for-light"
                                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="">
                            <img class="img-fluid for-dark" 
                                src="{{ asset('assets/images/logo/logo-icon-dark.png') }}" alt="">
                            </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h4>1. General </h4>
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
                            <li><a href="{{ route('chart-widget') }}">Chart</a></li>
                        </ul>
                    </li>

                   
                    <li class="sidebar-main-title">
                        <div>
                            <h4>2. Operaciones </h4>
                        </div>
                    </li>

                     <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >2.1. Bitácoras</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('box-layout') }}">Add. nuevo registro</a></li>
                            <li><a href="{{ route('layout-rtl') }}">Consultas</a></li>
                            <li><a href="{{ route('layout-rtl') }}">informes</a></li>
                        </ul>
                    </li>                    

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >2.2. Informes</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('layout-rtl') }}">Consulta reportes</a></li>
                            <li><a href="{{ route('layout-rtl') }}">informes generados</a></li>
                        </ul>
                    </li>
                    
                    <li class="sidebar-main-title">
                        <div>
                            <h4>3. Catalogos maestros</h4>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >3.1. Pilotos</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('pilots.index') }}">Gestionar</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >3.2. Aeronaves</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('aircraft.index') }}">Gestionar Aeronave</a></li>
                            <li><a href="{{ route('aircraft_categories.index') }}">Categorías de Aeronaves</a></li>
                            <li><a href="{{ route('aircraft_models.index') }}">Modelos de Aeronaves</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >3.3. Aeropuertos</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('airports.index') }}">Gestionar Aeropuertos</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h4>4. Usuarios y roles </h4>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >4.1. Usuarios</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('box-layout') }}">Add. nuevo </a></li>
                            <li><a href="{{ route('layout-rtl') }}">Consultas</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >4.2. Roles</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('box-layout') }}">Add. nuevo </a></li>
                            <li><a href="{{ route('layout-rtl') }}">Consultas</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title" href="javascript:void(0)">
                            <i data-feather="layout"></i>
                            <span >4.3. Permisos de rol</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('box-layout') }}">Add. nuevo </a></li>
                            <li><a href="{{ route('layout-rtl') }}">Consultas</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h4>5. Cuenta y Datos</h4>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('support-ticket') }}">
                            <i data-feather="users"></i> 
                            <span>5.1. Mi cuenta</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav"
                            href="{{ route('support-ticket') }}">
                            <i data-feather="users"></i> 
                            <span>5.2. Salir</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
