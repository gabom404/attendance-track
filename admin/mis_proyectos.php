<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include('includes/header.php');
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include('includes/sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include('includes/navbar.php');
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Lista de proyectos</h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">Proyectos - <a href="agregar_proyectos.php" class="btn btn-dark btn-circle btn-sm">
                                    <i class=" fas fa-plus"></i>
                                </a></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">

                                    </a>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre del proyecto</th>
                                            <th>Acciones</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre del proyecto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        include("config/config.php");
                                        $session = $_SESSION['id'];
                                        $counter = 0;
                                        if ($_SESSION['level'] == '2') {
                                            $query = mysqli_query($conn, 'SELECT id, nombre_proyecto FROM proyectos');
                                        } else {
                                            $query = safe_query($conn, 'SELECT id, nombre_proyecto FROM proyectos WHERE id_encargado = ? OR id_encargado2 = ? OR id_encargado3 = ? OR id_encargado4 = ?', [$session, $session, $session, $session]);
                                        }
                                        while ($row = mysqli_fetch_array($query)) {
                                            $counter++;
                                        ?>
                                            <tr>
                                                <td><?php echo $counter ?></td>
                                                <td><?php echo $row['nombre_proyecto'] ?></td>
                                                <td>


                                                    <a href="edit_asistencia.php?proyecto=<?php echo $row['id'] ?>" class="btn btn-info ">
                                                        Editar asistencia
                                                    </a>

                                                </td>
                                            </tr>

                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($_SESSION['level'] == '2') {
                                        ?>
                                            <tr>
                                                <td>/</td>
                                                <td>EMPLEADOS NO ASIGNADOS A UN PROYECTO</td>
                                                <td>


                                                    <a href="edit_asistencia.php?proyecto=no" class="btn btn-info ">
                                                        Editar asistencia
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php
            include('includes/footer.php');
            ?>


</body>
<script>
$(document).ready(function() {
  $('#miTabla').DataTable({
    "iDisplayLength": 9999,
    // y otros parámetros de configuración
  });
});
</script>
</html>
