<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="AttendanceTrack - Smart Attendance and Shift Control System">
    <meta name="author" content="AttendanceTrack">
    <title>AttendanceTrack - Control de Asistencia y Turnos</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.svg" type="image/svg+xml" />

    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .portal-card {
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.25) !important;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .action-card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-radius: 0.85rem;
            padding: 1.5rem 1rem;
            text-align: center;
            text-decoration: none !important;
            display: block;
            height: 100%;
            border: 2px solid transparent;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12);
        }

        .action-card.entry {
            background-color: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }
        .action-card.entry:hover {
            background-color: #dcfce7;
        }

        .action-card.exit {
            background-color: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }
        .action-card.exit:hover {
            background-color: #fee2e2;
        }

        .action-card.admin {
            background-color: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
        }
        .action-card.admin:hover {
            background-color: #dbeafe;
        }

        .action-card i {
            font-size: 2.25rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .action-card h5 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .action-card p {
            font-size: 0.85rem;
            margin-bottom: 0;
            opacity: 0.85;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 col-md-11">
                <div class="card portal-card border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="brand-header">
                            <img src="./images/logo.svg" alt="AttendanceTrack Logo">
                            <h2 class="h3 font-weight-bold text-gray-900 mb-1">AttendanceTrack</h2>
                            <p class="text-muted">Control Inteligente de Asistencias y Turnos</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4 mb-3">
                                <a class="action-card entry" href="agregar_entrada.php">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <h5>Marcar Entrada</h5>
                                    <p>Escaneo de credencial QR al iniciar jornada</p>
                                </a>
                            </div>

                            <div class="col-md-4 mb-3">
                                <a class="action-card exit" href="agregar_salida.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <h5>Marcar Salida</h5>
                                    <p>Registro de salida y cálculo de horas</p>
                                </a>
                            </div>

                            <div class="col-md-4 mb-3">
                                <a class="action-card admin" href="admin/">
                                    <i class="fas fa-user-shield"></i>
                                    <h5>Panel Administrativo</h5>
                                    <p>Gestión de personal, proyectos y reportes</p>
                                </a>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="text-center text-muted small">
                            <span>AttendanceTrack &bull; Sistema Seguro de Asistencia y Turnos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
