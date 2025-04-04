<!-- C:\wamp64\www\helpmdq\vistas\modulos\layout\sidebar_lateral.php -->
<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 menu_lateral h-100 d-flex flex-column position-fixed">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="vistas/assets/dist/img/escudo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Portal MDQ</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user-->
        <div class="user-panel mt-2 pb-2 mb-2 d-flex">
            <div class="image d-flex align-items-center">
                <!-- <img src="vistas/assets/dist/img/user1-128x128.jpg" class="img-circle elevation-2" alt="User Image"> -->
                <svg id="userIcon" width="35" height="35" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                    <!-- Círculo de fondo -->
                    <circle cx="25" cy="25" r="24" fill="#28a745" />
                    <!-- Texto de iniciales (dinámico) -->
                    <text id="initials" x="50%" y="60%" font-size="18" font-weight="bold" text-anchor="middle"
                        fill="white" font-family="Arial">
                        <?php
                        // Obtener las iniciales del nombre y apellido
                        $nombre = $_SESSION['Login_NombresUsuario'] ?? 'Usuario';
                        $apellido = $_SESSION['Login_ApellidosUsuario'] ?? 'Anónimo';
                        $inicialNombre = substr($nombre, 0, 1); // Primera letra del nombre
                        $inicialApellido = substr($apellido, 0, 1); // Primera letra del apellido
                        echo strtoupper($inicialNombre . $inicialApellido);
                        ?>
                    </text>
                </svg>
            </div>
            <div class="info">
                <a href="#" class="d-block" style="font-size: 12px;"><?php echo $_SESSION['Login_NombresUsuario'] ?? 'Usuario';
                echo $_SESSION['Login_ApellidosUsuario'] ?? 'Usuario'; ?></a>
                <a href="#" class="d-block"
                    style="font-size: 14px;"><?php echo $_SESSION['Login_NombreRol'] ?? 'Anónimo'; ?></a>
            </div>
        </div>

        <!-- Resto del código del sidebar -->
        <nav class="mt-2 flex-grow-1">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Contenido del menú lateral -->




                <!-- Dashboard -->
                <?php if ($_SESSION['Login_Permisos']['Dashboard']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <?php endif; ?>





                <!-- Gestión de Trabajadores -->
                <?php if ($_SESSION['Login_Permisos']['Trabajadores']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=trabajadores" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Trabajadores</p>
                        </a>
                    </li>
                <?php endif; ?>





                <!-- Gestión de Técnicos -->
                <?php if ($_SESSION['Login_Permisos']['Soportes']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=soportes" class="nav-link">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Soportes</p>
                        </a>
                    </li>
                <?php endif; ?>




                <!-- Gestión de Roles y Permisos (Menú desplegable) -->
                <?php if ($_SESSION['Login_Permisos']['Roles']['Leer'] == 1 && $_SESSION['Login_Permisos']['Permisos']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Seguridad <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">

                            <?php if ($_SESSION['Login_Permisos']['Roles']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=roles" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>





                <!-- Inventario (Menú desplegable) -->
                <?php if ($_SESSION['Login_Permisos']['Gestión de Inventario']['Leer'] == 1 && $_SESSION['Login_Permisos']['Reportes de Inventario']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Inventario <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">

                            <?php if ($_SESSION['Login_Permisos']['Gestión de Inventario']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=gestioninventario" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gestión de Inventario</p>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <?php if ($_SESSION['Login_Permisos']['Reportes de Inventario']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=reporteinventario" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>





                <!-- Tickets (Menú desplegable) -->
                <?php if ($_SESSION['Login_Permisos']['Gestión de Tickets']['Leer'] == 1 && $_SESSION['Login_Permisos']['Reportes de Tickets']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Tickets <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">

                            <?php if ($_SESSION['Login_Permisos']['Gestión de Tickets']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=gestiontickets" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gestión de Tickets</p>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <?php if ($_SESSION['Login_Permisos']['Reportes de Tickets']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=reportetickets" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reportes</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>





                <!-- Gestión de Problemas y subproblemas (Menú desplegable) -->
                <?php if ($_SESSION['Login_Permisos']['Problemas']['Leer'] == 1 && $_SESSION['Login_Permisos']['Subproblemas']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Problemas<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($_SESSION['Login_Permisos']['Problemas']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=problemas" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gestión de Problemas</p>
                                    </a>
                                </li>
                            <?php endif; ?>


                            <?php if ($_SESSION['Login_Permisos']['Subproblemas']['Leer'] == 1): ?>
                                <li class="nav-item">
                                    <a href="index.php?ruta=subproblemas" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sub Problemas</p>
                                    </a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>








                <!-- Tips -->
                <?php if ($_SESSION['Login_Permisos']['Tips']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=tips" class="nav-link">
                            <i class="nav-icon fas fa-lightbulb"></i>
                            <p>Tips</p>
                        </a>
                    </li>
                <?php endif; ?>





                <!-- Preguntas Frecuentes -->
                <?php if ($_SESSION['Login_Permisos']['Preguntas Frecuentes']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=preguntasfrecuentes" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Preguntas Frecuentes</p>
                        </a>
                    </li>
                <?php endif; ?>





                <!-- Manuales -->
                <?php if ($_SESSION['Login_Permisos']['Manuales']['Leer'] == 1): ?>
                    <li class="nav-item">
                        <a href="index.php?ruta=manuales" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Manuales</p>
                        </a>
                    </li>
                <?php endif; ?>





                <!-- Papelera de Reciclaje (Menú desplegable) -->
                <?php if ($_SESSION['Login_Permisos']['Papelera']['Leer'] == 1): ?>
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
                <?php endif; ?>
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