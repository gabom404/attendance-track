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

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Editar datos del empleado</h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <?php
                            include("config/config.php");
                            $id = $_GET['q'];
                            $counter = 0;
                            $query = mysqli_query($conn, 'SELECT nombre FROM planilla WHERE id = "' . $id . '"');
                            while ($row = mysqli_fetch_array($query)) {
                                echo '
                                    
                                        <h6 class="m-0 font-weight-bold text-primary">' . $row['nombre'] . ' 
                                        </h6>
                                        ';
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6 mb-6">
                                <?php
                                include("config/config.php");
                                $id = $_GET['q'];
                                $counter = 0;
                                $query = mysqli_query($conn, 'SELECT * FROM planilla WHERE id = "' . $id . '"');
                                while ($row = mysqli_fetch_array($query)) {
                                ?>

                            <form action="backend/backend.php" method="POST" enctype="multipart/form-data">
                                        <input type="text" value="<?php echo $row['id']; ?>" hidden name="id" />
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Nombre del empleado</label>
                                                <input type="text" placeholder="Escribe el nombre del empleado" name="nombre_empleado" value="<?php echo $row['nombre']; ?>" class="form-control"><br>
                                                <input type="text" hidden name="nombre_old" value="<?php echo $row['nombre']; ?>" class="form-control"><br>
                                                <label for="">Rol del empleado</label>
                                                <input type="text" placeholder="Escribe el rol del empleado" name="rol_empleado" value="<?php echo $row['rol']; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Número telefónico del empleado</label>
                                                <input type="number" placeholder="Escribe el número de teléfono del empleado" value="<?php echo $row['tel']; ?>" name="tel_empleado" class="form-control"><br>
                                                <label for="">DUI del empleado</label>
                                                <input type="text" placeholder="Escribe el DUI del empleado" name="dui_empleado" value="<?php echo $row['dui']; ?>" class="form-control"><br>
                                                <label for="">Código del empleado</label>
                                                <input type="text" placeholder="Escribe el código del empleado" name="cod_empleado" value="<?php echo $row['cod_empleado']; ?>" class="form-control">
                                                <table>
                                                    <br>
                                            </div>
                                            <div>
                                                <thead>
                                                    <tr>
                                                        <th>Día de la semana&nbsp&nbsp&nbsp&nbsp </th>
                                                        <th>Hora de entrada</th>
                                                        <th>Hora de salida</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Lunes</td>
                                                        <td><input type="time" name="lunes_entrada" value="<?php echo $row['lunes_entrada']; ?>" class="form-control" step="60"></td>
                                                        <td><input type="time" name="lunes_salida" class="form-control" value="<?php echo $row['lunes_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Martes</td>
                                                        <td><input type="time" name="martes_entrada" class="form-control" value="<?php echo $row['martes_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="martes_salida" class="form-control" value="<?php echo $row['martes_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Miércoles</td>
                                                        <td><input type="time" name="miercoles_entrada" class="form-control" value="<?php echo $row['miercoles_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="miercoles_salida" class="form-control" value="<?php echo $row['miercoles_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jueves</td>
                                                        <td><input type="time" name="jueves_entrada" class="form-control" value="<?php echo $row['jueves_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="jueves_salida" class="form-control" value="<?php echo $row['jueves_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Viernes</td>
                                                        <td><input type="time" name="viernes_entrada" class="form-control" value="<?php echo $row['viernes_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="viernes_salida" class="form-control" value="<?php echo $row['viernes_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sábado</td>
                                                        <td><input type="time" name="sabado_entrada" class="form-control" value="<?php echo $row['sabado_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="sabado_salida" class="form-control" value="<?php echo $row['sabado_salida']; ?>" step="60"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Domingo</td>
                                                        <td><input type="time" name="domingo_entrada" class="form-control" value="<?php echo $row['domingo_entrada']; ?>" step="60"></td>
                                                        <td><input type="time" name="domingo_salida" class="form-control" value="<?php echo $row['domingo_salida']; ?>" step="60"></td>
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
                                                    <img src="../<?php echo $row['img_empleado']; ?>" height="150" width="150" alt=""><br><br>
                                                </div>
                                                <input type="file" id="file" onchange="return fileValidation()" class="form-control-file" name="img_empleado">
                                                <br>
                                                <div class=" form-group">
                                                    <label for="exampleFormControlSelect1">Tipo de empleado</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" name="tipo_empleado">
                                                        <?php
                                                        if ($row['tipo'] == 'Fijo') {
                                                            echo '
                                                                <option selected value="Fijo">Fijo</option>
                                                                <option value="Eventual">Eventual</option>
                                                                ';
                                                        } elseif ($row['tipo'] == 'Eventual') {
                                                            echo '
                                                                <option value="Fijo">Fijo</option>
                                                                <option selected value="Eventual">Eventual</option>
                                                                ';
                                                        }
                                                        ?>

                                                    </select>
                                                    
                                                </div>
                                            <select name="isadmin" class="form-control">
                                            <?php
                                            $result = mysqli_query($conn, 'SELECT * FROM users WHERE nombre_empleado = "'.$row['nombre'].'"');
                                            $nombreOptions = "";
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $nombreOptions .= "<option value='Quit'>Quitar administrador</option>";
                                                }
                                            }else{
                                                $nombreOptions .= "<option value='Convert'>Convertir a administrador</option>";
                                            }
                                            ?>
                                            <option value="">Admin:</option>
                                            <?php echo $nombreOptions; ?>
                                        </select>  
                                            </div>
                                        </div>


                                        <br>
                                        <input type="submit" value="Guardar cambios" name="editar_empleado" class="btn btn-primary">
                                    </form>
                                <?php

                                }
                                ?>
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

</html>
