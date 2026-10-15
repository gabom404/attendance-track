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
                    if (isset($_REQUEST['delete'])) {
                        if ($_REQUEST['delete'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> El proyecto se eliminó exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['delete'] == 'error') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El proyecto no se pudo eliminar debido a un error inesperado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    if (isset($_REQUEST['edit'])) {
                        if ($_REQUEST['edit'] == 'success') {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Excelente!</strong> El proyecto se actualizó exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                        if ($_REQUEST['edit'] == 'error') {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Lo sentimos!</strong> El proyecto no se pudo editar debido a un error inesperado.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        }
                    }
                    ?>
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
                                            <th>Empleados en el proyecto</th>
                                            <th>Acciones</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre del proyecto</th>
                                            <th>Empleados en el proyecto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        include("config/config.php");
                                        $counter = 0;
                                        $query = mysqli_query($conn, 'SELECT * FROM proyectos ');
                                        while ($row = mysqli_fetch_array($query)) {
                                            $counter++;
                                        ?>
                                            <tr>
                                                <td><?php echo $counter ?></td>
                                                <td><?php echo $row['nombre_proyecto'] ?></td>
                                                <td>

                                                    <a href="lista.php?proyecto=<?php echo $row['id'] ?>" class="btn btn-info ">
                                                        Agregar empleado
                                                    </a>
                                                    <a href="edit_lista.php?proyecto=<?php echo $row['id'] ?>" class="btn btn-warning ">
                                                        Eliminar empleado
                                                    </a>



                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#editModal<?php echo  $row['id'] ?>">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo  $row['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#viewModal<?php echo  $row['id'] ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="deleteModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar proyecto <strong><?php echo $row['nombre_proyecto'] ?></strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="proyecto_id" value="<?php echo $row['id']; ?>">
                                                                <p>¿Desea eliminar este proyecto del sistema?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <input type="submit" class="btn btn-danger" name="eliminar_proyecto" value="Eliminar"></input>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>

                                            <div class="modal fade" id="viewModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Encargados de proyecto <strong><?php echo $row['nombre_proyecto'] ?></strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="">Encargado #1</label>
                                                                <input type="text" class="form-control"  value="<?php echo $row['nombre_encargado']; ?>" disabled>
                                                                <label for="">Encargado #2</label>
                                                                <input type="text" class="form-control"  value="<?php echo $row['nombre_encargado2']; ?>" disabled>
                                                                <label for="">Encargado #3</label>
                                                                <input type="text" class="form-control"  value="<?php echo $row['nombre_encargado3']; ?>" disabled>
                                                                <label for="">Encargado #4</label>
                                                                <input type="text" class="form-control"  value="<?php echo $row['nombre_encargado4']; ?>" disabled>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <input type="submit" class="btn btn-danger" name="eliminar_proyecto" value="Eliminar"></input>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModal">Editar proyecto <strong><?php echo $row['nombre_proyecto'] ?></strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body"> <input type="hidden" name="proyecto_old" value="<?php echo $row['nombre_proyecto']; ?>">

                                                                <input type="hidden" name="proyecto_id" value="<?php echo $row['id']; ?>">
                                                                <label for="">Nombre del proyecto</label>
                                                                <input type="text" placeholder="Escribe el nombre del proyecto" name="nombre_proyecto" class="form-control" value="<?php echo $row['nombre_proyecto'] ?>"><br>
                                                                <input type="text" hidden name="old_proyecto" class="form-control" value="<?php echo $row['nombre_proyecto'] ?>"><br>


                                                                <label for="">Encargado 1 :</label>
                                                                <select class="form-control form-control-sm" name="encargado" id="encargado">


                                                                    <option value="empty">--Seleccione un usuario encargado--</option>
                                                                    <?php
                                                                    $select = mysqli_query($conn, 'SELECT * FROM users');

                                                                    while ($row = mysqli_fetch_assoc($select)) {

                                                                        echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <label for="">Encargado 2 :</label>
                                                                <select class="form-control form-control-sm" name="encargado2" id="encargado2">


                                                                    <option value="empty">--Seleccione un usuario encargado--</option>
                                                                    <?php
                                                                    $select = mysqli_query($conn, 'SELECT * FROM users');

                                                                    while ($row = mysqli_fetch_assoc($select)) {

                                                                        echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <label for="">Encargado 3 :</label>
                                                                <select class="form-control form-control-sm" name="encargado3" id="encargado3">


                                                                    <option value="empty">--Seleccione un usuario encargado--</option>
                                                                    <?php
                                                                    $select = mysqli_query($conn, 'SELECT * FROM users');

                                                                    while ($row = mysqli_fetch_assoc($select)) {

                                                                        echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <label for="">Encargado 4 :</label>
                                                                <select class="form-control form-control-sm" name="encargado4" id="encargado4">


                                                                    <option value="empty">--Seleccione un usuario encargado--</option>
                                                                    <?php
                                                                    $select = mysqli_query($conn, 'SELECT * FROM users');

                                                                    while ($row = mysqli_fetch_assoc($select)) {

                                                                        echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <input type="submit" class="btn btn-success" name="editar_proyecto" value="Guardar Cambios"></input>
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
            // y otros par��metros de configuraci��n
        });
    });
</script>

</html>
