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
                            <strong>Excelente!</strong> La contraseña del administrador se ha actualizado exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        } else   if ($_REQUEST['edit'] == 'error') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Ha ocurrido un error inesperado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        } else  if ($_REQUEST['edit'] == 'passwords') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> La contraseña del administrador es incorrecta.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    if (isset($_REQUEST['add'])) {
                        if ($_REQUEST['add'] == 'success') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <strong>Excelente!</strong> El encargado se eliminó exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['delete'] == 'error') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El encargado no se pudo eliminar debido a un error inesperado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['delete'] == 'on') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El usuario no se puede eliminar debido a que se encuentra a cargo de un proyecto actual.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    ?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Lista de usuarios</h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary">Encargados - <a href="agregar_encargado.php" class="btn btn-dark btn-circle btn-sm">
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
                                            <th>Nombre encargado</th>
                                            <th>Control</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre encargado</th>
                                            <th>Control</th>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        include("config/config.php");
                                        $counter = 0;
                                        $query = mysqli_query($conn, 'SELECT * FROM users ');
                                        while ($row = mysqli_fetch_array($query)) {
                                            $counter++;

                                        ?>
                                            <tr>
                                                <td><?php echo $counter; ?></td>
                                                <td><?php echo $row['nombre_empleado'] ?></td>
                                                <td>



                                                    <?php
                                                    if ($row['id'] == '1') {
                                                        echo '  <a href="#" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#editModal' . $row['id'] . '">
                                                        <i class="fas fa-pen"></i>
                                                    </a>';
                                                    } else {
                                                        if ($_SESSION['id'] == $row['id']) {
                                                            echo ' ';
                                                        } else {
                                                            echo '
                                                           <a href="#" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#editModal' . $row['id'] . '">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                            <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal' . $row['id'] . '">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                   ';
                                                        }
                                                    }
                                                    ?>

                                                </td>
                                            </tr>

                                            <div class="modal fade" id="deleteModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar usuario <?php echo $row['nombre_empleado'] ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="encargado_id" value="<?php echo $row['id']; ?>">
                                                                <p>¿Desea eliminar esta usuario del sistema?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <input type="submit" class="btn btn-danger" name="eliminar_encargado" value="Eliminar"></input>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>

                                            <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form id="change_pass" method="POST" action="backend/backend.php">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña <strong><?php echo $row['nombre_empleado'] ?></strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <label for="">Llave de seguridad</label>
                                                                <input type="password" required placeholder="Llave de seguridad" name="admin_pass" class="form-control"><br>

                                                                <label for="">Contraseña nueva</label>
                                                                <input type=" password" required placeholder="Contraseña nueva" name="new_pass" class="form-control">
                                                            </div>
                                                            <div class=" modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary" name="change_pass_btn">Guardar Cambios</button>
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
