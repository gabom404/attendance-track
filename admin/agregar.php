<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

if (isset($_SESSION['level']) && $_SESSION['level'] != '2') {
    header("Location: index.php?permiso=nope");
}

include('includes/header.php');
include('./config/config.php');

?>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">


        <!-- Sidebar -->
        <?php
        include('includes/sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("includes/navbar.php");
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Empleado nuevo</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6 mb-6">
                                <form action="backend/backend.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col">


                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalHoraEntrada">Agregar Hora de Entrada</button>

                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalHoraSalida">Agregar Hora de Salida</button>
                                        </div>
                                    </div>
                                   
                            
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de hora de entrada -->
    <div class="modal fade" id="modalHoraEntrada" tabindex="-1" role="dialog" aria-labelledby="modalHoraEntradaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHoraEntradaLabel">Agregar Hora de Entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">
                        <label for="">Nombre del empleado</label>
                        <select name="nombre_empleado" class="form-control">
                            <?php
                            $result = mysqli_query($conn, 'SELECT * FROM planilla');

                            $nombreOptions = "";
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $nombreOptions .= "<option>" . $row['nombre'] . "</option>";
                                }
                            }
                            ?>
                            <option value="">Seleccione un nombre</option>
                            <?php echo $nombreOptions; ?>
                        </select>
                        <div class="form-group">
                            <label for="horaEntrada">Hora de entrada:</label>
                            <input type="time" class="form-control" id="entrada" name="entrada">
                        </div>
                        <div>
                            <select name="entrada_status" class="form-control">
                                <option value="">Seleccione una opción</option>
                                <option value="Presente">Presente</option>
                                <option value="Tarde">Tarde</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="agregar">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de hora de salida -->
    <div class="modal fade" id="modalHoraSalida" tabindex="-1" role="dialog" aria-labelledby="modalHoraSalidaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHoraSalidaLabel">Agregar Hora de Salida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="backend/backend.php" method="POST" enctype="multipart/form-data">
                        <label for="">Nombre del empleado</label>
                        <select name="nombre_empleado" class="form-control">
                            <?php
                            $result = mysqli_query($conn, 'SELECT * FROM planilla');

                            $nombreOptions = "";
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $nombreOptions .= "<option>" . $row['nombre'] . "</option>";
                                }
                            }
                            ?>
                            <option value="">Seleccione un nombre</option>
                            <?php echo $nombreOptions; ?>
                        </select>
                        <div class="form-group">
                            <label for="horaEntrada">Hora de salida:</label>
                            <input type="time" class="form-control" id="salida" name="salida">
                        </div>
                        <div>
                        <select name="salida_status" class="form-control">
                            
                            <option value="Incompleto">Incompleto</option>
                            <option value="Completo">Completo</option>
                        </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="agregar_salida">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/footer.php');
    ?>
    <script>
        const checkbox = document.getElementById("checkbox");
        const texto = document.getElementById("texto");
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
</body>

</html>
