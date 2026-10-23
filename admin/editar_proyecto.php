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
                    <h1 class="h3 mb-2 text-gray-800">Lista de empleados que puedes agregar a este proyecto</h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

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
                                        $proyecto = $_GET['q'];
                                        $select = safe_query($conn, 'SELECT nombre_proyecto FROM proyectos WHERE id = ?', [$proyecto]);
                                        $fetch = mysqli_fetch_assoc($select);
                                        $query = mysqli_query($conn, 'SELECT id, nombre, cod_empleado, img_empleado FROM planilla ');
                                        while ($row = mysqli_fetch_array($query)) {
                                            $counter++;

                                            echo '<tr>
                                                
                                                 <td>' . $counter . '</td>
                                                 <td>' . $row['nombre'] . '</td>
                                                 <td>' . $row['cod_empleado'] . '</td>
                                                 <td><img src="' . $row['img_empleado'] . '" width="75" height="75" class="img-fluid img-thumbnail"></td>
                                                 <td>
                                                    <input type="text" name="empleado" id="cod_' . $row['cod_empleado'] . '" value="' . $row['cod_empleado'] . '" hidden/>
                                                    <input type="radio" name="en_proyecto" value="' . $fetch['nombre_proyecto'] . '" />En el proyecto 
                                                </td>
                                                </tr>
                                            ';
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

            <script>
                $(document).ready(function() {
                    $('input[type="radio"]').click(function() {
                        var en_proyecto = $(this).val();
                        var empleado = $('#cod_' + $(this).closest('tr').find('input[name="empleado"]').val()).val();
                        $.ajax({
                            url: "backend/backend.php",
                            method: "POST",
                            data: {
                                empleado: empleado,
                                en_proyecto: en_proyecto
                            },
                            success: function(data) {
                                $('#result').html(data);
                            }
                        });
                    });
                });
            </script>


</body>

</html>
