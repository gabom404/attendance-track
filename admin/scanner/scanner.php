<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="../../vendor/html5-qrcode/html5-qrcode.min.js"></script>
    <style>
    main {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #reader {
        width: 600px;
    }
    #result {
        text-align: center;
        font-size: 1.5rem;
    }
</style>


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                       
<?php
if(isset($_REQUEST['q'])){
    if($_REQUEST['q']=="presente"){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h1><strong>Excelente!</strong> </h1><h4>Te has registrado como presente con éxito.</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        ';
    }elseif($_REQUEST['q']=="salida"){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h1><strong>Jornada terminada a tiempo</strong> </h1><h4>Hora de salida registrada como con éxito.</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        ';
    }
    elseif($_REQUEST['q']=="salidatemp"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h1><strong>Salida antes de tiempo!</strong> </h1><h4>Se ha completado tú registro exitosamente.</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    

      
    }
    elseif($_REQUEST['q']=="error"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h1><strong>Error!</strong> </h1><h4>Este empleado no esta registrado en el sistema.</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      
    }
    elseif($_REQUEST['q']=="xd"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h1><strong>Error!</strong> </h1><h4>Hora de llegada tarde      .</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
}

?>
                        <div>
                                <main>
                                    <div id="reader"></div>
                                    <div id="result" class="p-5"></div>
                                </main> 

                            </div>
                            <div class="col-lg-6">
                                <div id="result" class="p-5">

                                    
                                </div>

                               <!--  <div class="p-5">
                                    
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <a href="index.html" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a>
                                        <hr>
                                        </form>
                                    <hr>
                                  
                                </div> -->
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

        const scanner = new Html5QrcodeScanner('reader', { 
            // Scanner will be initialized in DOM inside element with id of 'reader'
            qrbox: {
                width: 350,
                height: 350,
            },  // Sets dimensions of scanning box (set relative to reader element width)
            fps: 20, // Frames per second to attempt a scan
        });
    
    
        scanner.render(success, error);
        // Starts scanner
     
        function success(result) {
// crea un nuevo objeto `Date`
var today = new Date();
 
// `getDate()` devuelve el día del mes (del 1 al 31)
var day = today.getDate();
 
// `getMonth()` devuelve el mes (de 0 a 11)
var month = today.getMonth() + 1;
 
// `getFullYear()` devuelve el año completo
var year = today.getFullYear();


 
// obtener la fecha de hoy en formato `MM/DD/YYYY`
var now = today.toLocaleDateString('es-SV');
console.log(now);
 
 <?php
 date_default_timezone_set('America/El_Salvador');

 $fechaActual = date("Y-m-d H:i:s");
 ?>

             document.getElementById('result').innerHTML = `
            <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">AttendanceTrack</h1>
                                    </div>
                                    <form class="user" action="asistencia.php" method="post">
                                    <img src="images/${result}.png" height="50px" width="50px">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="id_code" aria-describedby="emailHelp"
                                                 value="${result}">
                                                 
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="fecha"  value="<?php echo $fechaActual;?>">
                                        </div>
                    <input type ="submit" class="btn btn-primary btn-user btn-block">                 
                </form>
            </div>
           
            `;
            // Prints result as a link inside result element
    
            scanner.clear();
            // Clears scanning instance
    
            document.getElementById('reader').remove();
            // Removes reader element from DOM since no longer needed
        
        }
    
        function error(err) {
            console.error(err);
            // Prints any errors to the console
        }
    
    </script>
</body>

</html>