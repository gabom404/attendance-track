<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
include('config/config.php');
include('includes/header.php');
?>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenido de vuelta!</h1>
                                    </div>
                                    <form method="POST" id="form">

                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="username" id="username">
                                                <option>--Seleccione su usuario--</option>
                                                <?php
                                                $select = mysqli_query($conn, 'SELECT nombre_empleado FROM users');

                                                while ($row = mysqli_fetch_assoc($select)) {
                                                    echo '<option value="' . $row['nombre_empleado'] . '">' . $row['nombre_empleado'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <br>
                                            <input type="password" name="password" class="form-control form-control-sm" id="password" placeholder="Password">

                                        </div>
                                        <center>
                                            <input type="submit" class="btn btn-primary btn-user btn-block" value="Iniciar Sesión">
                                        </center>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small text-muted" href="../index.php"><i class="fas fa-arrow-left mr-1"></i> Volver al Portal de Asistencias</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        $(function() {
            $('#form').submit(function(e) {
                e.preventDefault(); // Evita que se envíe el formulario normalmente

                // Obtén los valores de los campos de entrada
                var username = $('#username').val();
                var password = $('#password').val();

                // Envía los datos al servidor utilizando AJAX
                $.ajax({
                    type: 'POST',
                    url: 'backend/backend.php',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        // La respuesta del servidor fue exitosa
                        if (response === 'success') {
                            // Redirecciona al usuario a la página de inicio
                            window.location.href = 'index.php';
                        } else if (response === 'emptypass') {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Digite la contraseña',
                                showConfirmButton: false,
                                timer: 1500000000000,
                                showCloseButton: true

                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Contraseña Incorrecta',
                                showConfirmButton: false,
                                timer: 1500000000000,
                                showCloseButton: true

                            })
                        }
                    },
                    error: function() {
                        // Hubo un error al enviar la petición
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Error inesperado',
                            text: 'Intente mas tarde nuevamente',
                            showConfirmButton: false,
                            timer: 1500000000000,
                            showCloseButton: true

                        })
                    }
                });
            });
        });
    </script>
</body>

</html>
