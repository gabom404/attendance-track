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
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Generar reportes de asistencias</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <form method="POST" action="reporte_horas.php">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <label for="rango1">De:</label>
                                    <input type="date" id="rango1" name="rango1">
                                    <label for="rango2">A:</label>
                                    <input type="date" id="rango2" name="rango2">
                                    <button type="submit" class="btn btn-primary" name="generar">Generar reportes</button>
                            </form>
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
