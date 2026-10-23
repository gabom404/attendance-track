<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
include('includes/header.php');



error_reporting(0);
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
                if (isset($_REQUEST['edit'])) {
                    if ($_REQUEST['edit'] == 'success') {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                    }
                }
                ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Lista de asistentes y justificaciones</h1>


                    <!-- DataTales Example-->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="table-responsive">
                                <form method="POST">
                                    <label for="fecha_busqueda">Buscar por fecha:</label>
                                    <input type="date" id="fecha_busqueda" name="fecha_busqueda" value="<?php
    date_default_timezone_set('America/El_Salvador');
    echo date('Y-m-d');
?>">
                                    <button type="submit" class="btn btn-danger">Buscar</button>
                                </form>
                                <form method="POST" action="backend/backend.php" enctype="multipart/form-data">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addAbsentModal">Agregar ausencias</button>
                                    <div class="modal fade" id="addAbsentModal" tabindex="-1" role="dialog" aria-labelledby="addAbsentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addAbsentModalLabel">Agregar ausencias</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="">Nombre del empleado:</label>
                                                    <select class="form-control form-control-sm" name="nombre" id="nombre">
                                                        <option value="">--Seleccione un usuario-</option>
                                                        <?php
                                                        include("config/config.php");
                                                        $proyecto = $_GET['proyecto'];
                                                        $select = safe_query($conn, 'SELECT nombre_proyecto FROM proyectos WHERE id = ?', [$proyecto]);
                                                        $fetch = mysqli_fetch_assoc($select);
                                                        $select1 = safe_query($conn, 'SELECT * FROM empleados_proyectos WHERE nombre_proyecto = ?', [$fetch['nombre_proyecto']]);
                                                        while ($row = mysqli_fetch_assoc($select1)) {
                                                            echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="">Justificación de ausencia</label>
                                                    <select class="form-control form-control-sm" name="ausencia" id="ausencia">
                                                        <option value="">--Seleccione una justificación-</option>
                                                        <option value="ISSS">ISSS</option>
                                                        <option value="PERMISO">PERMISO</option>
                                                        <option value="FALTA SIN JUSTIFICACIÓN">FALTA SIN JUSTIFICACIÓN</option>
                                                        <option value="INCAPACITADO">INCAPACITADO</option>
                                                        <option value="PATERNIDAD">PATERNIDAD</option>
                                                    </select><br>
                                                    <input type="text" id="justificado_por" name="proyecto" value="<?php echo $proyecto; ?>" hidden>

                                                    <input type="text" id="justificado_por" name="justificado_por" class="form-control" value="<?php echo $_SESSION['nombre']; ?>" hidden>

                                                    <input type="text" id="notas" name="notas" class="form-control" placeholder="Ingrese una nota">


                                                    <div class="form-check">
                                                        <input type="checkbox" name="admin" class="form-check-input" id="checkbox">
                                                        <label class="form-check-label" for="exampleCheck1">Imagen de justificante</label>
                                                    </div>

                                                    <input type="file" id="file" style="display: none;" onchange="return fileValidation()" name="img_empleado" class="form-control-file">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" name="agregar_ausencias">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>Código de empleado</th>
                                            <th>Día</th>
                                            <!-- <th>Status</th> -->
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Horas extra</th>
                                            <th>Ver registro</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>Código de empleado</th>
                                            <th>Día</th>
                                            <!-- <th>Status</th> -->
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Horas extra</th>
                                            <th>Ver registro</th>
                                        </tr>
                                    </tfoot>
                                    <tbody><?php

                                            $fechaBusqueda = $_POST['fecha_busqueda'];
                                            $fechaActual = date("Y-m-d", strtotime($fechaBusqueda));
                                            include("config/config.php");
                                            $counter = 0;
                                            $proyecto = $_GET['proyecto'];
                                            $select = safe_query($conn, 'SELECT nombre_proyecto FROM proyectos WHERE id = ?', [$proyecto]);
                                            $fetch = mysqli_fetch_assoc($select);
                                            $query = safe_query($conn, 'SELECT * FROM empleados WHERE proyecto = ? AND day = ?', [$fetch['nombre_proyecto'], $fechaBusqueda]);
                                            while ($row = mysqli_fetch_array($query)) {
                                                $counter++;

                                                echo '<tr>
                                                <td>' . $counter . '</td>
                                                <td>' . $row['nombre'] . '</td>
                                                <td>' . $row['cod_empleado'] . '</td>
                                                <td>' . $row['day'] . '</td>
                                             
                                                <input type="hidden" name="empleado_id" value="' . $row['id'] . '">';
                                                echo '<td>';
                                                if ($row["status_entrada"] == "Tarde") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-danger">Tarde</button>';
                                                } else if ($row["status_entrada"] == "Presente") {
                                                    echo '<button type="submit" name="opcion" value=" " class="btn btn-success">Presente</button>';
                                                } else if ($row["status_entrada"] == "H.E AUTORIZADA" || $row["status_entrada"] == "ISSS" || $row["status_entrada"] == "PERMISO" || $row["status_entrada"] == "FALTA SIN JUSTIFICACIÓN" || $row["status_entrada"] == "INCAPACITADO" || $row["status_entrada"] == "PATERNIDAD") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-warning">Justificado</button>';
                                                }
                                                echo '</td>';
                                                echo '<td>';
                                                if ($row["status_salida"] == "Incompleto") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-danger">Incompleto</button>';
                                                } else if ($row["status_salida"] == "Completo") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-success">Completo</button>';
                                                } else if ($row["status_horas"] == "H.E NO AUTORIZADA") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-success">Horas extras </button>';
                                                } else if ($row["status_salida"] == "H.E AUTORIZADA" || $row["status_salida"] == "ISSS" || $row["status_salida"] == "PERMISO" || $row["status_salida"] == "FALTA SIN JUSTIFICACIÓN" || $row["status_salida"] == "INCAPACITADO" || $row["status_salida"] == "PATERNIDAD") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-warning">Justificado</button>';
                                                } else {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-warning">En espera</button>';
                                                }
                                                echo '</td>';
                                                echo '<td>';
                                                if ($row["status_horas"] == "H.E NO AUTORIZADA") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-danger">No autorizado</button>';
                                                } else if ($row["status_horas"] == "H.E AUTORIZADA") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-danger">Autorizado</button>';
                                                } else if ($row["status_horas"] == "") {
                                                    echo '<button type="submit" name="opcion" value="en_espera" class="btn btn-danger">Sin H.E</button>';
                                                }
                                                echo '</td>';
                                                echo '<td>';
                                                echo '<a href="#" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#editModal' . $row["id"] . '">
                                                    <i class="fas fa-eye"></i>
                                                    </a>';
                                                if ($row["status_horas"] == "H.E NO AUTORIZADA") {
                                                    echo '
                                                    <a href="#" class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#autorizarModal' . $row["id"] . '">
                                                    <i class="fas fa-check"></i>
                                                    </a>
                                             
                                                    </td>';
                                                }
                                            ?>
                                            <div class="modal fade" id="editModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Detalles del registro <strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                if ($row["status_salida"] == "H.E AUTORIZADA" || $row["status_salida"] == "ISSS" || $row["status_salida"] == "PERMISO" || $row["status_salida"] == "FALTA SIN JUSTIFICACIÓN" || $row["status_salida"] == "INCAPACITADO" || $row["status_salida"] == "PATERNIDAD") {
                                                                ?>
                                                                    <label for="">Razon de la justificación</label>
                                                                    <input type="text" disabled class="form-control" value="<?php echo $row['justificacion'] ?>"><br>
                                                                    <label for="">Nota</label>
                                                                    <input type="text" disabled class="form-control" value="<?php echo $row['notas'] ?>"><br>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <label for="">Asistencia</label>
                                                                    <input type="text" disabled class="form-control" value="<?php echo $row['justificacion'] ?>"><br>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row["status_horas"] != "") {
                                                                ?>
                                                                    <label for="">Estado de horas extras:</label>
                                                                    <input type="text" disabled class="form-control" value="<?php echo $row['status_horas'] ?>"><br>
                                                                <?php
                                                                }
                                                                if ($row["horas_extra"] != 0) {
                                                                ?>
                                                                    <label for="">Total de horas extra:</label>
                                                                    <input type="text" disabled class="form-control" value="<?php echo $row['horas_extra'] ?>"><br>
                                                                <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($row["img"] != "") {
                                                                ?>
                                                                    <label for="">Imagen de la justificación</label>
                                                                    <img class="img-fluid img-thumbnail" src="<?php echo $row['img'] ?>"><br>
                                                                <?php
                                                                }
                                                                ?>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>


                                            <div class="modal fade" id="autorizarModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">

                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                                <h5 class="modal-title" id="exampleModalLabel">Horas extras <strong></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-warning" name="autorizar">Autorizar horas extras</button>

                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>

                                        <?php

                                            }




                                        ?>





                                        <?php

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


            <script>
                /* $(document).ready(function() {
                    $('#confirmar').on('click', function() {
                        var idby_row = $('#cod_' + $(this).closest('tr').find('input[name="confirmar"]').val()).val();

                        $.ajax({
                            url: 'backend/backend.php',
                            type: 'POST',
                            data: {
                                id: idby_row
                                
                            },
                            success: function(response) {
                                if (response == 'success') {
                                    alert('El registro ha sido actualizado correctamente.');
                                } else {
                                    alert('Ha ocurrido un error al intentar actualizar el registro.');
                                }
                            },
                            error: function() {
                                alert('Ha ocurrido un error al intentar actualizar el registro.');
                            }
                        });
                    });
                }); */
                const checkbox = document.getElementById("checkbox");
                const texto = document.getElementById("file");
                const textoLabel = document.getElementById("texto-label");

                checkbox.addEventListener("change", function() {
                    if (this.checked) {
                        texto.style.display = "block";

                        textoLabel.style.display = "inline-block";
                    } else {
                        texto.style.display = "none";
                        texto.value = "";
                        textoLabel.style.display = "none";
                    }
                });
            </script>

            <?php
            function img()
            {
                if (isset($_FILES["img_empleado"])) {
                    $data = ['uploadimageType' => strtolower(pathinfo($_FILES["img_empleado"]["name"], PATHINFO_EXTENSION))];
                    $fechaActual = date("Y-m-d");
                    $cod_empleado = $_POST["username"];
                    $destination = 'justificaciones/' . $fechaActual . $cod_empleado . '.' . $data['uploadimageType'];
                    $move_destino = 'justificaciones/' . $fechaActual . $cod_empleado . '.' . $data['uploadimageType'];
                    move_uploaded_file($_FILES['img_empleado']['tmp_name'], $destination);
                    return $move_destino;
                }
            }
            ?>

</body>

</html>
