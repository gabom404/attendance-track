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

                            <h6 class="m-0 font-weight-bold text-primary">Encargado nuevo
                            </h6>


                        </div>
                        <div class="card-body">
                            <div class="col-md-6 mb-6">

                                <form id="agregar_encargado" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Nombre del encargado</label>
                                            <input type="text" placeholder="Escribe el nombre del encargado" name="nombre_encargado" class="form-control">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Número telefónico del encargado</label>
                                            <input type="number" placeholder="Escribe el número de teléfono del encargado" name="tel_encargado" class="form-control"><br>
                                            <label for="">DUI del encargado</label>
                                            <input type="text" placeholder="Escribe el DUI del encargado" name="dui_encargado" class="form-control"><br>
                                            <label for="">Contraseña del usuario encargado</label>
                                            <input type="text" placeholder="Escribe la contraseña del encargado" name="pwd_encargado" class="form-control"><br>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-12">
                                            <button type="submit" class="btn btn-primary" name="agregar_encargado">Guardar Cambios</button>
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
