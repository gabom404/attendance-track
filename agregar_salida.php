<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AttendanceTrack - Registrar Salida">
    <meta name="author" content="AttendanceTrack">

    <title>AttendanceTrack - Registrar Salida</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.svg" type="image/svg+xml" />
    <script src="./vendor/html5-qrcode/html5-qrcode.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
        }

        main {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #reader {
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px dashed #e74a3b;
            background: #f8f9fc;
        }

        #result {
            text-align: center;
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-11">
                <div class="card o-hidden border-0 shadow-lg my-3" style="border-radius: 1rem;">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <a href="index.php">
                                <img src="./images/logo.svg" width="60" height="60" alt="AttendanceTrack" class="mb-2">
                            </a>
                            <h2 class="h4 text-gray-900 font-weight-bold">Registro de Salida</h2>
                            <p class="text-muted small">Acerque el código QR de su credencial frente a la cámara</p>
                        </div>

                        <?php
                        if (isset($_REQUEST['q'])) {
                            if ($_REQUEST['q'] == "salida") {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading font-weight-bold"><i class="fas fa-check-circle mr-2"></i>Jornada Completada</h4>
                                    <p class="mb-0">Hora de salida registrada exitosamente a tiempo.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                            } elseif ($_REQUEST['q'] == "salidatemp") {
                                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Salida Anticipada</h4>
                                    <p class="mb-0">Salida registrada antes del horario regular de turno finalizado.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                            } elseif ($_REQUEST['q'] == "res") {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading font-weight-bold"><i class="fas fa-times-circle mr-2"></i>Entrada No Registrada</h4>
                                    <p class="mb-0">No se localizó registro de entrada para el día de hoy.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                            } elseif ($_REQUEST['q'] == "already") {
                                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Aviso</h4>
                                    <p class="mb-0">Su salida ya fue procesada anteriormente el día de hoy.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                            } elseif ($_REQUEST['q'] == "error") {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading font-weight-bold"><i class="fas fa-times-circle mr-2"></i>Error</h4>
                                    <p class="mb-0">El código escaneado no corresponde a ningún empleado activo.</p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>';
                            }
                        }
                        ?>

                        <div>
                            <main>
                                <div id="reader"></div>
                                <div id="result" class="p-3"></div>
                            </main>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between flex-wrap">
                            <a class="btn btn-outline-secondary btn-sm mb-2" href="index.php">
                                <i class="fas fa-home mr-1"></i> Inicio
                            </a>
                            <a class="btn btn-outline-success btn-sm mb-2" href="agregar_entrada.php">
                                <i class="fas fa-sign-in-alt mr-1"></i> Marcar Entrada
                            </a>
                            <a class="btn btn-outline-primary btn-sm mb-2" href="admin/">
                                <i class="fas fa-user-shield mr-1"></i> Panel Administrador
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 20,
        });

        scanner.render(success, error);

        function success(result) {
            <?php
            date_default_timezone_set('America/El_Salvador');
            $fechaActual = date("Y-m-d H:i:s");
            ?>

            document.getElementById('result').innerHTML = `
                <div class="card p-3 shadow-sm border-0 bg-light">
                    <h5 class="font-weight-bold text-gray-900 mb-3">Empleado Identificado</h5>
                    <div class="text-center">
                        <img id="imagen" src="images/picture.png" height="110" width="110" class="rounded-circle shadow-sm border mb-3" style="object-fit: cover;" alt="Avatar">
                    </div>
                    <form class="user" action="asistencia_salida.php" method="post">
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-muted">Código de Empleado</label>
                            <input type="text" class="form-control text-center font-weight-bold" name="id_code" value="${result}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted">Fecha y Hora</label>
                            <input type="text" class="form-control text-center" name="fecha" value="<?php echo $fechaActual; ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block py-2 font-weight-bold">
                            <i class="fas fa-sign-out-alt mr-2"></i>Confirmar Salida
                        </button>
                    </form>
                </div>
            `;

            try {
                scanner.clear();
            } catch(e) {}

            var readerEl = document.getElementById('reader');
            if (readerEl) readerEl.remove();

            var inputValue = result;
            fetch('obtener_imagen.php?id_code=' + encodeURIComponent(inputValue))
                .then(function(response) {
                    return response.text();
                })
                .then(function(data) {
                    if (data && data.trim() !== '') {
                        var imgEl = document.getElementById('imagen');
                        if (imgEl) imgEl.src = data.trim();
                    }
                });
        }

        function error(err) {
            // Scanning in progress
        }
    </script>
</body>

</html>
