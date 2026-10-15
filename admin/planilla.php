<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if (isset($_SESSION['level']) && $_SESSION['level'] != '2') {
    header("Location: index.php?permiso=nope");
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
                    <?php
                    if (isset($_REQUEST['edit'])) {
                        if ($_REQUEST['edit'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> Los datos del empleado se han actualizado exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    if (isset($_REQUEST['add'])) {
                        if ($_REQUEST['add'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> El empleado se agregó exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }



                    if (isset($_REQUEST['delete'])) {
                        if ($_REQUEST['delete'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> El empleado se eliminó exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['delete'] == 'error') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El empleado no se pudo eliminar debido a un error inesperado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    if (isset($_REQUEST['admin'])) {
                        if ($_REQUEST['admin'] == 'success_quit') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> Se ha eliminado el rol de encargado con exito.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['admin'] == 'error_quit') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El usuario no se puede eliminar debido a que se encuentra a cargo de un proyecto actual.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['admin'] == 'success_encargado') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> El usuario se ha convertido en encargado correctamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        
                    }
                    ?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Lista de empleados</h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">Empleados - <a href="agregar_empleado.php" class="btn btn-dark btn-circle btn-sm">
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
                                            <th>Nombre</th>
                                            <th>Código de empleado</th>
                                            <th>Imagen</th>

                                            <th>Acciones</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>Código de empleado</th>
                                            <th>Imagen</th>

                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        include("config/config.php");
                                        $counter = 0;
                                        $query = mysqli_query($conn, 'SELECT id, nombre, cod_empleado, img_empleado FROM planilla ');
                                        while ($row = mysqli_fetch_array($query)) {
                                            $counter++;

                                        ?>
                                            <tr>
                                                <td><?php echo $counter ?></td>
                                                <td><?php echo $row['nombre'] ?></td>
                                                <td><?php echo $row['cod_empleado'] ?></td>
                                                <td><img src="../<?php echo $row['img_empleado'] ?>" width="75" height="75" class="img-fluid img-thumbnail"></td>
                                                <td>

                                                    <a href="editar_empleado.php?q=<?php echo $row['id'] ?>" class="btn btn-warning btn-circle btn-sm"">
                                                    <i class=" fas fa-edit"></i>
                                                    </a>
                                                    <a target="_blank" href="qrcode.php?q=<?php echo $row['cod_empleado'] ?>" class="btn btn-dark btn-circle btn-sm"">
                                                    <i class=" fas fa-qrcode"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo $row['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="deleteModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar empleado <?php echo $row['nombre'] ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="empleado_id" value="<?php echo $row['id']; ?>">
                                                                <p>¿Desea eliminar este empleado del sistema?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <input type="submit" class="btn btn-danger" name="eliminar_empleado" value="Eliminar"></input>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>


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
