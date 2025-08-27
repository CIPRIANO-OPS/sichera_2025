<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Logobar -->
        <div class="logobar">
            <a href="{{ route('ejemplo') }}" class="logo logo-large">
                <img src="{{ asset('assets/images/logo.svg') }}" class="img-fluid" alt="logo">
            </a>
            <a href="{{ route('ejemplo') }}" class="logo logo-small">
                <img src="{{ asset('assets/images/small_logo.svg') }}" class="img-fluid" alt="logo">
            </a>
        </div>
        <!-- End Logobar -->

        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">


                <li>
                    <a href="{{ route('ejemplo') }}">
                        <i class="ri-file-text-line"></i><span>Vista de Ejemplo</span>
                    </a>
                </li>

                <li class="vertical-header">Gestión</li>

                <li>
                    <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                        <i class="ri-user-6-fill"></i><span>Clientes</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('empleados.index') }}" class="{{ request()->routeIs('empleados.*') ? 'active' : '' }}">
                        <i class="ri-team-fill"></i><span>Empleados</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ventas.index') }}" class="{{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                        <i class="ri-shopping-cart-fill"></i><span>Ventas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mesas.restaurant') }}" class="{{ request()->routeIs('mesas.*') ? 'active' : '' }}">
                        <i class="ri-restaurant-2-fill"></i><span>Mesas</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>