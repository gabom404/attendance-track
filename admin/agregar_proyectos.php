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

                            <h6 class="m-0 font-weight-bold text-primary">Proyecto nuevo
                            </h6>


                        </div>
                        <div class="card-body">
                            <div class="col-md-6 mb-6">

                                <form action="backend/backend.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Titulo del proyecto</label>
                                            <input type="text" placeholder="Escribe el titulo del proyecto" name="nombre_empleado" class="form-control"><br>
                                            <label for="">Encargado del proyecto 1</label>
                                            <select class="form-control form-control-sm" name="encargado" id="encargado">
                                                <?php
                                                include('config/config.php');
                                                $select = mysqli_query($conn, 'SELECT * FROM users');

                                                while ($row = mysqli_fetch_assoc($select)) {
                                                    echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <label for="">Encargado del proyecto 2</label>
                                             <select class="form-control form-control-sm" name="encargado2" id="encargado2">
                                                <?php
                                                include('config/config.php');
                                                $select = mysqli_query($conn, 'SELECT * FROM users');

                                                while ($row = mysqli_fetch_assoc($select)) {
                                                    echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <label for="">Encargado del proyecto 3</label>
                                             <select class="form-control form-control-sm" name="encargado3" id="encargado3">
                                                <?php
                                                include('config/config.php');
                                                $select = mysqli_query($conn, 'SELECT * FROM users');

                                                while ($row = mysqli_fetch_assoc($select)) {
                                                    echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <label for="">Encargado del proyecto 4</label>
                                             <select class="form-control form-control-sm" name="encargado4" id="encargado4">
                                                <?php
                                                include('config/config.php');
                                                $select = mysqli_query($conn, 'SELECT * FROM users');

                                                while ($row = mysqli_fetch_assoc($select)) {
                                                    echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                           
                                            <br>
                                        </div>
                                    </div>



                                    <div class=" row">
                                        <div class="col-md-12 mb-12">
                                            <button type="submit" class="btn btn-primary" name="agregar_proyecto">Siguiente</button>
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


</body>

</html>
