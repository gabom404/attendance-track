<?php
$nivel = $_SESSION['level'];

if ($nivel != '1') {
    echo '
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../images/logo.svg" width="40px" height="40px" alt="AttendanceTrack">
        </div>
        <div class="sidebar-brand-text mx-2">AttendanceTrack</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel de control</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Gestión de usuarios
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-user"></i>
            <span>Encargados</span>
        </a>
        <div id="collapseUsuarios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="users.php">Manejo de usuarios</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Manejo de Empleados
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmnpleados" aria-expanded="true" aria-controls="collapseEmnpleados">
            <i class="fas fa-fw fa-book"></i>
            <span>Planilla</span>
        </a>
        <div id="collapseEmnpleados" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="planilla.php">Ver lista de empleados</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Proyectos
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProyectos" aria-expanded="true" aria-controls="collapseProyectos">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Proyectos</span>
        </a>
        <div id="collapseProyectos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="proyectos.php">Ver lista de proyectos</a>
            </div>
        </div>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCargo" aria-expanded="true" aria-controls="collapseCargo">
            <i class="fas fa-fw fa-check"></i>
            <span>Mis proyectos a cargo</span>
        </a>
        <div id="collapseCargo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="mis_proyectos.php">Asistentes / Justificaciones</a>
            </div>
        </div>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Asistencias
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAsistencias" aria-expanded="true" aria-controls="collapseAsistencias">
            <i class="fas fa-fw fa-signal"></i>
            <span>Reportes</span>
        </a>
      
        <div id="collapseAsistencias" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="horas.php">Reporte de asistencias</a>
        </div>
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAsistenciasqr" aria-expanded="true" aria-controls="collapseAsistenciasqr">
            <i class="fas fa-table"></i>
            <span>Agregar Registro Manual</span>
        </a>
      
        <div id="collapseAsistenciasqr" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="agregar.php">Agregar</a>
        </div>
    </div>
    </li>
    



</ul>
<!-- End of Sidebar -->';
} else if ($nivel == '1') {
    echo '
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../images/logo.svg" width="40px" height="40px" alt="AttendanceTrack">
        </div>
        <div class="sidebar-brand-text mx-2">AttendanceTrack</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Panel de control</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Gestión de planilla
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-user"></i>
            <span>Mis proyectos a cargo</span>
        </a>
        <div id="collapseUsuarios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="mis_proyectos.php">Justificación de asistencia</a>
            </div>
        </div>
    </li>

</ul>
<!-- End of Sidebar -->';
}
