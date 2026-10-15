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

                            <h6 class="m-0 font-weight-bold text-primary">Empleado nuevo
                            </h6>


                        </div>
                        <div class="card-body">
                            <div class="col-md-6 mb-6">

                                <form id="agregar_empleado" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Nombre del empleado</label>
                                            <input type="text" placeholder="Escribe el nombre del empleado" name="nombre_empleado" class="form-control"><br>
                                            <label for="">Rol del empleado</label>
                                            <input type="text" placeholder="Escribe el rol del empleado" name="rol_empleado" class="form-control">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Número telefónico del empleado</label>
                                            <input type="number" placeholder="Escribe el número de teléfono del empleado" name="tel_empleado" class="form-control"><br>
                                            <label for="">DUI del empleado</label>
                                            <input type="text" placeholder="Escribe el DUI del empleado" name="dui_empleado" class="form-control"><br>
                                            <label for="">Código del empleado</label>
                                            <input type="text" placeholder="Escribe el código del empleado" name="cod_empleado" class="form-control">
                                            <table>
                                        </div>
                                        <div>
                                            <thead>
                                                <tr>
                                                    <th>Día de la semana</th>
                                                    <th>Hora de entrada</th>
                                                    <th>Hora de salida</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lunes</td>
                                                    <td><input type="time" name="lunes_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="lunes_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Martes</td>
                                                    <td><input type="time" name="martes_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="martes_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Miércoles</td>
                                                    <td><input type="time" name="miercoles_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="miercoles_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jueves</td>
                                                    <td><input type="time" name="jueves_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="jueves_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Viernes</td>
                                                    <td><input type="time" name="viernes_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="viernes_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Sábado</td>
                                                    <td><input type="time" name="sabado_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="sabado_salida" class="form-control" step="60"></td>
                                                </tr>
                                                <tr>
                                                    <td>Domingo</td>
                                                    <td><input type="time" name="domingo_entrada" class="form-control" step="60"></td>
                                                    <td><input type="time" name="domingo_salida" class="form-control" </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-12">
                                            <label for="">Imagen del empleado (Avatar de caracter ilustrativo)</label><br>
                                            <div id="imagePreview">
                                                <img src="../images/picture.png" height="150" width="150" alt=""><br><br>
                                            </div>
                                            <input type="file" id="file" onchange="return fileValidation()" class="form-control-file" name="img_empleado">

                                            <br>
                                            <div class=" form-group">
                                                <label for="exampleFormControlSelect1">Tipo de empleado</label>
                                                <select class="form-control" id="exampleFormControlSelect1" name="tipo_empleado">
                                                    <option value="Fijo">Fijo</option>
                                                    <option value="Eventual">Eventual</option>
                                                </select>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="admin" class="form-check-input" id="checkbox">
                                                <label class="form-check-label" for="exampleCheck1">Administrador</label><br>
                                            </div>
                                            <label for="" id="texto-label" style="display: none;">Contraseña</label>
                                            <input type="text" placeholder="Escribe la contraseña del encargado" id="texto" style="display: none;" name="pass" class="form-control">
                                        </div>
                                    </div>


                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-12">
                                            <button type="submit" class="btn btn-primary" name="agregar_empleado">Guardar Cambios</button>
                                        </div>
                                    </div>
                                    <br>

                                </form>

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
