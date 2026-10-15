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
                    <h1 class="h3 mb-2 text-gray-800">Lista de empleados que puedes eliminar de este proyecto <a href="proyectos.php" class="btn btn-warning ">
                            Guardar
                        </a></h1>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="miTabla" width="100%" cellspacing="0">

                                    </a>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>CÃ³digo de empleado</th>
                                            <th>Imagen</th>
                                            <th>Acciones</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>CÃ³digo de empleado</th>
                                            <th>Imagen</th>

                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody> <?php
include("config/config.php");
$counter = 0;
$proyecto = $_GET['proyecto'];

// Consulta preparada para obtener el nombre del proyecto
$stmt = mysqli_prepare($conn, "SELECT nombre_proyecto FROM proyectos WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $proyecto);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $nombre_proyecto);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Consulta preparada para obtener los empleados del proyecto
$stmt = mysqli_prepare($conn, "SELECT * FROM empleados_proyectos WHERE nombre_proyecto = ?");
mysqli_stmt_bind_param($stmt, "s", $nombre_proyecto);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

while ($row = mysqli_fetch_array($resultado)) {
    $counter++;

    echo '<tr>
        <td>' . $counter . '</td>
        <td>' . $row['nombre_empleado'] . '</td>
        <td>' . $row['cod_empleado'] . '</td>
        <td><img src="../' . $row['img'] . '" width="75" height="75" class="img-fluid img-thumbnail"></td>
        <td>
            <input type="text" name="empleado" id="cod_' . $row['cod_empleado'] . '" value="' . $row['cod_empleado'] . '" hidden/>
            <input type="radio" name="en_proyecto" value="' . $nombre_proyecto . '" />Eliminar del proyecto 
        </td>
    </tr>';
}

mysqli_close($conn);
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
                        var eliminar_de_proyecto = $(this).val();
                        var empleado = $('#cod_' + $(this).closest('tr').find('input[name="empleado"]').val()).val();
                        $.ajax({
                            url: "backend/backend.php",
                            method: "POST",
                            data: {
                                empleado: empleado,
                                eliminar_de_proyecto: eliminar_de_proyecto
                            },
                            success: function(data) {
                                $('#result').html(data);
                            }
                        });
                    });
                });
                
                </script>
            <script>

$(document).ready(function() {
  $('#miTabla').DataTable({
    "iDisplayLength": 9999,
    // y otros par¨¢metros de configuraci¨®n
  });
});
</script>


</body>

</html>
