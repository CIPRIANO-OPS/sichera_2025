<div class="topbar">
    <!-- Start row -->
    <div class="row align-items-center">
        <!-- Start col -->
        <div class="col-md-12 align-self-center">
            <div class="togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="javascript:void();">
                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                <i class="ri-close-line menu-hamburger-close"></i>
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="searchbar">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Buscar..." aria-label="Search" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit" id="button-addon2">
                                            <i class="ri-search-2-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="infobar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="settingbar">
                            <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon">
                                <i class="ri-settings-line"></i>
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="notifybar">
                            <div class="dropdown">
                                <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-notification-line"></i>
                                    <span class="live-icon"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                    <div class="notification-dropdown-title">
                                        <h5>Notificaciones<a href="#">Limpiar todo</a></h5>
                                    </div>
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-primary">
                                                <i class="ri-bank-card-2-line"></i>
                                            </span>
                                            <div class="media-body">
                                                <h5 class="action-title">Nueva venta registrada</h5>
                                                <p><span class="timing">Hoy, 09:05 AM</span></p>
                                            </div>
                                        </li>
                                        <li class="media dropdown-item">
                                            <span class="action-icon badge badge-success">
                                                <i class="ri-file-user-line"></i>
                                            </span>
                                            <div class="media-body">
                                                <h5 class="action-title">Nuevo cliente registrado</h5>
                                                <p><span class="timing">Ayer, 02:30 PM</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="notification-dropdown-footer">
                                        <h5><a href="#">Ver todas</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="profilebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" class="img-fluid" alt="profile">
                                    <span class="live-icon">{{ Auth::user()->name ?? 'Usuario' }}</span>
                                    <i class="ri-arrow-down-s-line"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                    <div class="dropdown-item">
                                        <div class="profilename">
                                            <h5>{{ Auth::user()->name ?? 'Usuario' }}</h5>
                                            <p>{{ Auth::user()->email ?? 'usuario@ejemplo.com' }}</p>
                                        </div>
                                    </div>
                                    <div class="userbox">
                                        <ul class="list-unstyled mb-0">
                                            <li class="media dropdown-item">
                                                <a href="{{ route('profile.edit') }}" class="profile-icon">
                                                    <i class="ri-user-line"></i>
                                                </a>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0"><a href="{{ route('profile.edit') }}">Mi Perfil</a></h5>
                                                    <p>Configuración de cuenta</p>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <a href="#" class="profile-icon">
                                                    <i class="ri-settings-line"></i>
                                                </a>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0"><a href="#">Configuración</a></h5>
                                                    <p>Preferencias del sistema</p>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <a href="{{ route('logout') }}" class="profile-icon" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="ri-logout-box-line"></i>
                                                </a>
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-0">
                                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                                                    </h5>
                                                    <p>Salir del sistema</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>