<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Direct Quick Link to Scanner -->
        <li class="nav-item">
            <a class="nav-link text-primary font-weight-bold" href="../index.php" title="Ir al Portal de Escaneo">
                <i class="fas fa-qrcode mr-1"></i>
                <span class="d-none d-md-inline">Portal de Asistencias</span>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario';
                ?>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($username); ?></span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" alt="User">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../index.php">
                    <i class="fas fa-qrcode fa-sm fa-fw mr-2 text-gray-400"></i>
                    Portal de Asistencias
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>
    </ul>

</nav>
<!-- End of Topbar -->