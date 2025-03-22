<aside class="main-sidebar sidebar-dark-primary elevation-4 menu_lateral">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <!-- Iniciales en un círculo -->
            <div class="image">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                    style="width: 35px; height: 35px;">
                    <?php
                    // Obtener las iniciales del nombre y apellido
                    $nombre = $_SESSION['nombres'] ?? 'Usuario';
                    $apellido = $_SESSION['apellidos'] ?? 'Anónimo';
                    $inicialNombre = substr($nombre, 0, 1); // Primera letra del nombre
                    $inicialApellido = substr($apellido, 0, 1); // Primera letra del apellido
                    echo '<span class="text-white font-weight-bold text-uppercase">' . strtoupper($inicialNombre . $inicialApellido) . '</span>';
                    ?>
                </div>
            </div>
            <!-- Nombre y apellido -->
            <div class="info ml-3">
                <a href="#" class="d-block text-white"><?php echo $_SESSION['nombres'] ?? 'Usuario'; ?></a>
                <a href="#" class="d-block text-white"><?php echo $_SESSION['apellidos'] ?? 'Anónimo'; ?></a>
            </div>
        </div>

        <!-- Resto del código del sidebar -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/dashboard.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Gestión de Trabajadores -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/trabajadores.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Trabajadores</p>
                    </a>
                </li>

                <!-- Gestión de Técnicos -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/tecnicos.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Técnicos</p>
                    </a>
                </li>
                <!-- Gestión de Roles y Permisos (Menú desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Seguridad <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/roles.php')" class="nav-link"
                                style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/permisos.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permisos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Inventario (Menú desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Inventario <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/gestion_inventario.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestión de Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/reporte_inventario.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Tickets (Menú desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>Tickets <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/gestion_tickets.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gestión de Tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/reporte_tickets.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Problemas -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/problemas.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-exclamation-triangle"></i>
                        <p>Problemas</p>
                    </a>
                </li>

                <!-- Tips -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/tips.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-lightbulb"></i>
                        <p>Tips</p>
                    </a>
                </li>

                <!-- Preguntas Frecuentes -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/preguntas_frecuentes.php')"
                        class="nav-link" style="cursor: pointer;">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Preguntas Frecuentes</p>
                    </a>
                </li>

                <!-- Manuales -->
                <li class="nav-item">
                    <a onclick="cargarContenido('content-wrapper','vistas/modulos/manuales.php')" class="nav-link"
                        style="cursor: pointer;">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Manuales</p>
                    </a>
                </li>
                <!-- Papelera de Reciclaje (Menú desplegable) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-trash"></i>
                        <p>Papelera <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_trabajadores.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Trabajadores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_tecnicos.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Técnicos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_roles.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_inventario.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inventario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_tickets.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_problemas.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Problemas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_tips.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tips</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_preguntas_frecuentes.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Preguntas Frecuentes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="cargarContenido('content-wrapper','vistas/modulos/papelera_manuales.php')"
                                class="nav-link" style="cursor: pointer;">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manuales</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Opción para Cerrar Sesión -->
                <li class="nav-item">
                <a href="<?php echo BASE_URL; ?>/controladores/LogoutControlador.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>