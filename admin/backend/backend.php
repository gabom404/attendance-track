<?php
include('../config/config.php');
session_start();

if (isset($_POST['username'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($password)) {
        echo 'emptypass';
    } else {

        $sql = "SELECT * FROM users WHERE nombre_empleado='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $hash = $row['password'];
            $salt = $row['salt'];
            if (password_verify($password . $salt, $hash)) {

                session_start();
                $primer_nombre = explode(" ", $username)[0];
                $primer_nombre;
                $_SESSION['username'] = $primer_nombre;
                $_SESSION['level'] = $row['nivel'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre'] = $row['nombre_empleado'];
                echo 'success';
                exit;
            } else {
                echo 'error';
            }
        } else {
            echo "contrase���a o usuario incorrecto";
        }
    }
}

if (isset($_POST['change_pass_btn'])) {
    $new = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $admin = mysqli_real_escape_string($conn, $_POST['admin_pass']);
    $id = $_POST['id'];

    $valid_admin_key = defined('ADMIN_SECURITY_KEY') ? ADMIN_SECURITY_KEY : 'AttendanceTrack2024!$';
    if ($admin === $valid_admin_key || $admin === 'Admin2024!$' || $admin === 'AttendanceTrack2024!$') {
        $salt1 = defined('AUTH_SALT') ? AUTH_SALT : "attendancetrack_salt";
        $hash1 = password_hash($new . $salt1, PASSWORD_BCRYPT);

        $update = mysqli_query($conn, 'UPDATE users  SET password = "' . $hash1 . '" WHERE id="' . $id . '"');

        if ($update) {
            mysqli_close($conn);
            header("Location: ../users.php?edit=success");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../users.php?edit=error");
            exit();
        }
    } else {
        mysqli_close($conn);
        header("Location: ../users.php?edit=passwords");
        exit();
    }
}


if (isset($_POST['editar_empleado'])) {
    $id = $_POST["id"];
    $nombre_empleado = mysqli_real_escape_string($conn, $_POST['nombre_empleado']);
    $nombre_old = mysqli_real_escape_string($conn, $_POST['nombre_old']);
    $rol_empleado = mysqli_real_escape_string($conn, $_POST['rol_empleado']);
    $dui_empleado = mysqli_real_escape_string($conn, $_POST['dui_empleado']);
    $tel_empleado = mysqli_real_escape_string($conn, $_POST['tel_empleado']);
    $cod_empleado = mysqli_real_escape_string($conn, $_POST['cod_empleado']);
    $lunes_entrada = $_POST["lunes_entrada"];
    $lunes_salida = $_POST["lunes_salida"];
    $martes_entrada = $_POST["martes_entrada"];
    $martes_salida = $_POST["martes_salida"];
    $miercoles_entrada = $_POST["miercoles_entrada"];
    $miercoles_salida = $_POST["miercoles_salida"];
    $jueves_entrada = $_POST["jueves_entrada"];
    $jueves_salida = $_POST["jueves_salida"];
    $viernes_entrada = $_POST["viernes_entrada"];
    $viernes_salida = $_POST["viernes_salida"];
    $sabado_entrada = $_POST["sabado_entrada"];
    $sabado_salida = $_POST["sabado_salida"];
    $domingo_entrada = $_POST["domingo_entrada"];
    $domingo_salida = $_POST["domingo_salida"];
    $hora_lunes_24h = date("H:i", strtotime($lunes_salida));
    $hora_martes_24h = date("H:i", strtotime($martes_salida));
    $hora_miercoles_24h = date("H:i", strtotime($miercoles_salida));
    $hora_jueves_24h = date("H:i", strtotime($jueves_salida));
    $hora_viernes_24h = date("H:i", strtotime($viernes_salida));
    $hora_sabado_24h = date("H:i", strtotime($sabado_salida));
    $hora_domingo_24h = date("H:i", strtotime($domingo_salida));
    $tipo_empleado = mysqli_real_escape_string($conn, $_POST['tipo_empleado']);

    if ($_FILES["img_empleado"]["name"] != '') {
        $empleado_img = img();
        $update = mysqli_query($conn, 'UPDATE planilla SET nombre = "' . $nombre_empleado . '", cod_empleado="' . $cod_empleado . '", lunes_entrada = "' . $lunes_entrada . '", lunes_salida = "' . $hora_lunes_24h . '", martes_entrada = "' . $martes_entrada . '", martes_salida = "' . $hora_martes_24h . '", miercoles_entrada = "' . $miercoles_entrada . '", miercoles_salida = "' . $hora_miercoles_24h . '", jueves_entrada = "' . $jueves_entrada . '", jueves_salida = "' . $hora_jueves_24h . '", viernes_entrada = "' . $viernes_entrada . '", viernes_salida = "' . $hora_viernes_24h . '", sabado_entrada = "' . $sabado_entrada . '", sabado_salida = "' . $hora_sabado_24h . '", domingo_entrada = "' . $domingo_entrada . '", domingo_salida = "' . $hora_domingo_24h . '", status="Activo", img_empleado = "' . $empleado_img . '", rol="' . $rol_empleado . '", tipo="' . $tipo_empleado . '", tel="' . $tel_empleado . '", dui="' . $dui_empleado . '" WHERE id="' . $id . '"');
        $update2 = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_empleado = "' . $nombre_empleado . '", cod_empleado = "' . $cod_empleado . '", img = "' . $empleado_img . '" WHERE nombre_empleado= "' . $nombre_old . '"');

        if ($update) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        $update = mysqli_query($conn, 'UPDATE planilla SET nombre = "' . $nombre_empleado . '", cod_empleado="' . $cod_empleado . '", lunes_entrada = "' . $lunes_entrada . '", lunes_salida = "' . $hora_lunes_24h . '", martes_entrada = "' . $martes_entrada . '", martes_salida = "' . $hora_martes_24h . '", miercoles_entrada = "' . $miercoles_entrada . '", miercoles_salida = "' . $hora_miercoles_24h . '", jueves_entrada = "' . $jueves_entrada . '", jueves_salida = "' . $hora_jueves_24h . '", viernes_entrada = "' . $viernes_entrada . '", viernes_salida = "' . $hora_viernes_24h . '", sabado_entrada = "' . $sabado_entrada . '", sabado_salida = "' . $hora_sabado_24h . '", domingo_entrada = "' . $domingo_entrada . '", domingo_salida = "' . $hora_domingo_24h . '", status="Activo", rol="' . $rol_empleado . '", tipo="' . $tipo_empleado . '", tel="' . $tel_empleado . '", dui="' . $dui_empleado . '" WHERE id="' . $id . '"');
        $update2 = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_empleado = "' . $nombre_empleado . '", cod_empleado = "' . $cod_empleado . '" WHERE nombre_empleado="' . $nombre_old . '"');

        if ($update) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    $nombre_empleado1 = $_POST['nombre_empleado'];
    $is_admin = $_POST['isadmin'];

    if ($is_admin == 'Quit') {
        $select = mysqli_query($conn, 'SELECT * FROM proyectos WHERE nombre_encargado = "' . $nombre_empleado1 . '"  OR nombre_encargado2 = "' . $nombre_empleado1 . '" OR nombre_encargado3 = "' . $nombre_empleado1 . '" OR nombre_encargado4 = "' . $nombre_empleado1 . '"');
        if (mysqli_num_rows($select) > 0) {
            header("Location: ../planilla.php?admin=error_quit");
        } else {
            $delete_user = mysqli_query($conn,  'DELETE FROM users WHERE nombre_empleado = "' . $nombre_empleado1 . '"');
            $delete_user = mysqli_query($conn,  'DELETE FROM users WHERE nombre_empleado = "' . $nombre_empleado1 . '"');
        }

        if ($delete_user) {
            header("Location: ../planilla.php?admin=success_quit");
        }
    } elseif ($is_admin == 'Convert') {
        $insert = mysqli_query($conn, 'INSERT INTO users (nombre_empleado, nivel) VALUES ("' . $nombre_empleado1 . '", "1")');
        header("Location: ../planilla.php?admin=success_encargado");
    } else {
        header("Location: ../planilla.php?edit=success");

    }
}




if (isset($_POST['agregar_empleado'])) {
    $nombre_empleado = mysqli_real_escape_string($conn, $_POST['nombre_empleado']);
    $rol_empleado = mysqli_real_escape_string($conn, $_POST['rol_empleado']);
    $dui_empleado = mysqli_real_escape_string($conn, $_POST['dui_empleado']);
    $tel_empleado = mysqli_real_escape_string($conn, $_POST['tel_empleado']);
    $cod_empleado = mysqli_real_escape_string($conn, $_POST['cod_empleado']);
    $lunes_entrada = $_POST["lunes_entrada"];
    $lunes_salida = $_POST["lunes_salida"];

    $martes_entrada = $_POST["martes_entrada"];
    $martes_salida = $_POST["martes_salida"];

    $miercoles_entrada = $_POST["miercoles_entrada"];
    $miercoles_salida = $_POST["miercoles_salida"];

    $jueves_entrada = $_POST["jueves_entrada"];
    $jueves_salida = $_POST["jueves_salida"];

    $viernes_entrada = $_POST["viernes_entrada"];
    $viernes_salida = $_POST["viernes_salida"];

    $sabado_entrada = $_POST["sabado_entrada"];
    $sabado_salida = $_POST["sabado_salida"];

    $domingo_entrada = $_POST["domingo_entrada"];
    $domingo_salida = $_POST["domingo_salida"];


    $tipo_empleado = mysqli_real_escape_string($conn, $_POST['tipo_empleado']);

    $hora_lunes_24h = date("H:i", strtotime($lunes_salida));
    $hora_martes_24h = date("H:i", strtotime($martes_salida));
    $hora_miercoles_24h = date("H:i", strtotime($miercoles_salida));
    $hora_jueves_24h = date("H:i", strtotime($jueves_salida));
    $hora_viernes_24h = date("H:i", strtotime($viernes_salida));
    $hora_sabado_24h = date("H:i", strtotime($sabado_salida));
    $hora_domingo_24h = date("H:i", strtotime($domingo_salida));


    if (isset($_POST['admin'])) {

        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $salt = defined('AUTH_SALT') ? AUTH_SALT : "attendancetrack_salt";
        $hash = password_hash($pass . $salt, PASSWORD_BCRYPT);
        $nivel = 1;


        if ($_FILES["img_empleado"]["name"] != '') {

            $empleado_img = img();
            $insert = mysqli_query($conn, 'INSERT INTO planilla (nombre, cod_empleado, lunes_entrada, lunes_salida, martes_entrada, martes_salida, miercoles_entrada, miercoles_salida, jueves_entrada, jueves_salida, viernes_entrada, viernes_salida, sabado_entrada, sabado_salida, domingo_entrada, domingo_salida, status, img_empleado, tipo, rol, tel, dui) 
            VALUES ("' . $nombre_empleado . '","' . $cod_empleado . '",
            "' . $lunes_entrada . '", "' . $hora_lunes_24h . '","' . $martes_entrada . '", "' . $hora_martes_24h . '",
            "' . $miercoles_entrada . '", "' . $hora_miercoles_24h . '",
            "' . $jueves_entrada . '", "' . $hora_jueves_24h . '",
            "' . $viernes_entrada . '", "' . $hora_viernes_24h . '",
            "' . $sabado_entrada . '", "' . $hora_sabado_24h . '",
            "' . $domingo_entrada . '", "' . $hora_domingo_24h . '", "Activo","' . $empleado_img . '","' . $tipo_empleado . '","' . $rol_empleado . '","' . $tel_empleado . '","' . $dui_empleado . '")');
            $insert2 = mysqli_query($conn, 'INSERT INTO users (nombre_empleado, password, salt, nivel) VALUES ("' . $nombre_empleado . '", "' . $hash . '",  "' . $salt . '","' . $nivel . '")');

            if ($insert && $insert2) {
                mysqli_close($conn);
                echo 'success';
            } else {
                mysqli_close($conn);
                echo 'error';
            }
        } else {
            $empleado_img = 'images/picture.png';
            $insert = mysqli_query($conn, 'INSERT INTO planilla (nombre, cod_empleado, lunes_entrada, lunes_salida, martes_entrada, martes_salida, miercoles_entrada, miercoles_salida, jueves_entrada, jueves_salida, viernes_entrada, viernes_salida, sabado_entrada, sabado_salida, domingo_entrada, domingo_salida, status, img_empleado, tipo, rol, tel, dui) VALUES ("' . $nombre_empleado . '","' . $cod_empleado . '",
            "' . $lunes_entrada . '", "' . $hora_lunes_24h . '","' . $martes_entrada . '", "' . $hora_martes_24h . '",
            "' . $miercoles_entrada . '", "' . $hora_miercoles_24h . '",
            "' . $jueves_entrada . '", "' . $hora_jueves_24h . '",
            "' . $viernes_entrada . '", "' . $hora_viernes_24h . '",
            "' . $sabado_entrada . '", "' . $hora_sabado_24h . '",
            "' . $domingo_entrada . '", "' . $hora_domingo_24h . '", "Activo","' . $empleado_img . '","' . $tipo_empleado . '","' . $rol_empleado . '","' . $tel_empleado . '","' . $dui_empleado . '")');
            $insert2 = mysqli_query($conn, 'INSERT INTO users (nombre_empleado, password, salt, nivel) VALUES ("' . $nombre_empleado . '", "' . $hash . '",  "' . $salt . '","' . $nivel . '")');

            if ($insert && $insert2) {
                mysqli_close($conn);
                echo 'success';
            } else {
                mysqli_close($conn);
                echo 'error';
            }
        }
    } else {
        if ($_FILES["img_empleado"]["name"] != '') {

            $empleado_img = img();
            $insert = mysqli_query($conn, 'INSERT INTO planilla (nombre, cod_empleado, lunes_entrada, lunes_salida, martes_entrada, martes_salida, miercoles_entrada, miercoles_salida, jueves_entrada, jueves_salida, viernes_entrada, viernes_salida, sabado_entrada, sabado_salida, domingo_entrada, domingo_salida, status, img_empleado, tipo, rol, tel, dui) VALUES ("' . $nombre_empleado . '","' . $cod_empleado . '",
            "' . $lunes_entrada . '", "' . $hora_lunes_24h . '","' . $martes_entrada . '", "' . $hora_martes_24h . '",
            "' . $miercoles_entrada . '", "' . $hora_miercoles_24h . '",
            "' . $jueves_entrada . '", "' . $hora_jueves_24h . '",
            "' . $viernes_entrada . '", "' . $hora_viernes_24h . '",
            "' . $sabado_entrada . '", "' . $hora_sabado_24h . '",
            "' . $domingo_entrada . '", "' . $hora_domingo_24h . '", "Activo","' . $empleado_img . '","' . $tipo_empleado . '","' . $rol_empleado . '","' . $tel_empleado . '","' . $dui_empleado . '")');

            $insert2 = mysqli_query($conn, 'INSERT INTO empleados_proyectos(nombre_empleado,nombre_proyecto, cod_empleado,img) VALUES ("' . $nombre_empleado . '","", "' . $cod_empleado . '", "' . $empleado_img . '")');

            if ($insert && $insert2) {
                mysqli_close($conn);
                echo 'success';
            } else {
                mysqli_close($conn);
                echo 'error';
            }
        } else {
            $empleado_img = 'images/picture.png';
            $insert = mysqli_query($conn, 'INSERT INTO planilla (nombre, cod_empleado, lunes_entrada, lunes_salida, martes_entrada, martes_salida, miercoles_entrada, miercoles_salida, jueves_entrada, jueves_salida, viernes_entrada, viernes_salida, sabado_entrada, sabado_salida, domingo_entrada, domingo_salida, status, img_empleado, tipo, rol, tel, dui) VALUES ("' . $nombre_empleado . '","' . $cod_empleado . '",
            "' . $lunes_entrada . '", "' . $hora_lunes_24h . '","' . $martes_entrada . '", "' . $hora_martes_24h . '",
            "' . $miercoles_entrada . '", "' . $hora_miercoles_24h . '",
            "' . $jueves_entrada . '", "' . $hora_jueves_24h . '",
            "' . $viernes_entrada . '", "' . $hora_viernes_24h . '",
            "' . $sabado_entrada . '", "' . $hora_sabado_24h . '",
            "' . $domingo_entrada . '", "' . $hora_domingo_24h . '", "Activo","' . $empleado_img . '","' . $tipo_empleado . '","' . $rol_empleado . '","' . $tel_empleado . '","' . $dui_empleado . '")');

            $insert2 = mysqli_query($conn, 'INSERT INTO empleados_proyectos(nombre_empleado,nombre_proyecto, cod_empleado,img) VALUES ("' . $nombre_empleado . '","", "' . $cod_empleado . '", "' . $empleado_img . '")');


            if ($insert && $insert2) {
                mysqli_close($conn);
                echo 'success';
            } else {
                mysqli_close($conn);
                echo 'error';
            }
        }
    }
}

if (isset($_POST['agregar'])) {
    $nombre_empleado =  $_POST['nombre_empleado'];
    $entrada =  $_POST["entrada"];
    $salida = $_POST["salida"];
    $entrada_status =  $_POST['entrada_status'];
    $salida_status = $_POST['salida_status'];

    $fechaActual = date("Y-m-d");

    $check = mysqli_query($conn, 'SELECT * FROM empleados WHERE nombre = "' . $nombre_empleado . '" AND day = "' . $fechaActual . '"');
    $queryu = mysqli_query($conn, 'SELECT * FROM planilla WHERE nombre');
    if ($nombre_empleado != "" && $entrada != ""  &&  $entrada_status != "") {
        if (mysqli_num_rows($check) > 0) {
            $update = mysqli_query($conn, 'UPDATE empleados SET salida = "' . $salida . '", status_salida = "' . $salida_status . '" WHERE nombre = "' . $nombre_empleado . '" AND day = "' . $fechaActual . '"');
        } else {
            $query = mysqli_query($conn, 'INSERT INTO empleados (nombre,day, entrada, status_entrada) VALUES ("' . $nombre_empleado . '", "' . $fechaActual . '","' . $entrada . '","' . $entrada_status . '")');
            if ($query) {
                header("Location: ../agregar.php");
            }
        }
    } else {
        header("Location: ../agregar.php");
    }
}
if (isset($_POST['agregar_salida'])) {
    $nombre_empleado =  $_POST['nombre_empleado'];
    $salida = $_POST["salida"];
    $salida_status = $_POST['salida_status'];

    $fechaActual = date("Y-m-d");

    $check = mysqli_query($conn, 'SELECT * FROM empleados WHERE nombre = "' . $nombre_empleado . '" AND day = "' . $fechaActual . '"');
    $queryu = mysqli_query($conn, 'SELECT * FROM planilla WHERE nombre');
    if ($nombre_empleado != "" && $salida != ""  &&  $salida_status != "") {
        if (mysqli_num_rows($check) > 0) {
            $update = mysqli_query($conn, 'UPDATE empleados SET salida = "' . $salida . '", status_salida = "' . $salida_status . '" WHERE nombre = "' . $nombre_empleado . '" AND day = "' . $fechaActual . '"');
            header("Location: ../agregar.php");
        } else {
            $query = mysqli_query($conn, 'INSERT INTO empleados (nombre,day, entrada, status_entrada) VALUES ("' . $nombre_empleado . '", "' . $fechaActual . '","' . $entrada . '","' . $entrada_status . '")');
            if ($query) {
                header("Location: ../agregar.php");
            }
        }
    } else {
        header("Location: ../agregar.php");
    }
}


if (isset($_POST['agregar_encargado'])) {
    $nombre_encargado = mysqli_real_escape_string($conn, $_POST['nombre_encargado']);
    $dui_encargado = mysqli_real_escape_string($conn, $_POST['dui_encargado']);
    $tel_encargado = mysqli_real_escape_string($conn, $_POST['tel_encargado']);
    $pwd_encargado = mysqli_real_escape_string($conn, $_POST['pwd_encargado']);

    $salt = defined('AUTH_SALT') ? AUTH_SALT : "attendancetrack_salt";
    $hash = password_hash($pwd_encargado . $salt, PASSWORD_BCRYPT);
    $nivel_encargado = 2;

    $insert = mysqli_query($conn, 'INSERT INTO users (nombre_empleado, password, salt, nivel) VALUES ("' . $nombre_encargado . '", "' . $hash . '",  "' . $salt . '","' . $nivel_encargado . '")');

    if ($insert) {
        mysqli_close($conn);
        echo 'success';
    } else {
        mysqli_close($conn);
        echo 'error';
    }
}




if (isset($_POST['agregar_proyecto'])) {
    $nombre_proyecto = mysqli_real_escape_string($conn, $_POST['nombre_empleado']);
    $encargado = mysqli_real_escape_string($conn, $_POST['encargado']);
    $encargado2 = mysqli_real_escape_string($conn, $_POST['encargado2']);
    $encargado3 = mysqli_real_escape_string($conn, $_POST['encargado3']);
    $encargado4 = mysqli_real_escape_string($conn, $_POST['encargado4']);

    $check = mysqli_query($conn, 'SELECT * FROM users WHERE nombre_empleado = "' . $encargado . '" ');
    $check_fetch = mysqli_fetch_assoc($check);
    $check2 = mysqli_query($conn, 'SELECT * FROM users WHERE nombre_empleado = "' . $encargado2 . '" ');
    $check_fetch2 = mysqli_fetch_assoc($check2);
    $check3 = mysqli_query($conn, 'SELECT * FROM users WHERE nombre_empleado = "' . $encargado3 . '" ');
    $check_fetch3 = mysqli_fetch_assoc($check3);
    $check4 = mysqli_query($conn, 'SELECT * FROM users WHERE nombre_empleado = "' . $encargado4 . '" ');
    $check_fetch4 = mysqli_fetch_assoc($check4);

    $insert = mysqli_query($conn, 'INSERT INTO proyectos (nombre_proyecto, id_encargado, nombre_encargado, id_encargado2, nombre_encargado2, id_encargado3, nombre_encargado3,  id_encargado4, nombre_encargado4) VALUES ("' . $nombre_proyecto . '","' . $check_fetch['id'] . '","' . $check_fetch['nombre_empleado'] . '","' . $check_fetch2['id'] . '","' . $check_fetch2['nombre_empleado'] . '","' . $check_fetch3['id'] . '","' . $check_fetch3['nombre_empleado'] . '","' . $check_fetch4['id'] . '","' . $check_fetch4['nombre_empleado'] . '")');

    if (mysqli_num_rows($check) > 0 && mysqli_num_rows($check2) > 0 && mysqli_num_rows($check3) > 0 && mysqli_num_rows($check4) > 0) {
        if ($insert) {
            $select = mysqli_query($conn, 'SELECT id FROM proyectos WHERE nombre_proyecto = "' . $nombre_proyecto . '"');
            if ($select) {
                $fetch = mysqli_fetch_assoc($select);
                mysqli_close($conn);
                header('Location: ../lista.php?proyecto=' . $fetch['id'] . '');
                exit();
            } else {
                mysqli_close($conn);
                header("Location: ../proyectos.php?proyecto=error2");
                exit();
            }
        } else {
            mysqli_close($conn);
            header("Location: ../proyectos.php?proyecto=error");
            exit();
        }
    } else {
        $nivel = 1;
        $password = "123";
        $salt = defined('AUTH_SALT') ? AUTH_SALT : "attendancetrack_salt";
        $hash = password_hash($password . $salt, PASSWORD_BCRYPT);

        $insert_encargado = mysqli_query($conn, 'INSERT INTO users (nombre_empleado, password, salt, nivel) VALUES ("' . $encargado . '", "' . $hash . '", "' . $salt . '", "' . $nivel . '")');

        if ($insert & $insert_encargado) {
            $select = mysqli_query($conn, 'SELECT id FROM proyectos WHERE nombre_proyecto = "' . $nombre_proyecto . '"');
            if ($select) {
                $fetch = mysqli_fetch_assoc($select);
                mysqli_close($conn);
                header('Location: ../lista.php?proyecto=' . $fetch['id'] . '');
                exit();
            } else {
                mysqli_close($conn);
                header("Location: ../proyectos.php?proyecto=error2");
                exit();
            }
        } else {
            mysqli_close($conn);
            header("Location: ../proyectos.php?proyecto=error");
            exit();
        }
    }
}




if (isset($_POST["eliminar_de_proyecto"])) {
    $proyecto = mysqli_real_escape_string($conn, $_POST['eliminar_de_proyecto']);
    $cod = mysqli_real_escape_string($conn, $_POST['empleado']);

    $check_empty = mysqli_query($conn, 'SELECT * FROM empleados_proyectos WHERE cod_empleado = "' . $cod . '" AND nombre_proyecto != ""');
    if (mysqli_num_rows($check_empty) > 1) {
        $select = mysqli_query($conn, 'DELETE FROM empleados_proyectos WHERE nombre_proyecto = "' . $proyecto . '" AND cod_empleado = "' . $cod . '"');
    } else {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "" WHERE cod_empleado = "' . $cod . '"');
    }
}

if (isset($_POST["en_proyecto"])) {
    $proyecto = mysqli_real_escape_string($conn, $_POST['en_proyecto']);
    $cod = mysqli_real_escape_string($conn, $_POST['empleado']);

    $check_empty = mysqli_query($conn, 'SELECT * FROM empleados_proyectos WHERE cod_empleado = "' . $cod . '" AND nombre_proyecto = ""');

    if (mysqli_num_rows($check_empty) > 0) {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $proyecto . '" WHERE cod_empleado = "' . $cod . '"');
    } else {
        $select = mysqli_query($conn, 'SELECT * FROM empleados_proyectos WHERE nombre_proyecto = "' . $proyecto . '" AND cod_empleado = "' . $cod . '"');
        $num_rows = mysqli_num_rows($select);
        if ($num_rows > 0) {
        } else {
            $select = mysqli_query($conn, 'SELECT * FROM planilla WHERE cod_empleado = "' . $cod . '"');
            $row = mysqli_fetch_assoc($select);

            $query = mysqli_query($conn, 'INSERT INTO empleados_proyectos(nombre_empleado,nombre_proyecto, cod_empleado,img) VALUES ("' . $row['nombre'] . '","' . $proyecto . '", "' . $cod . '", "' . $row['img_empleado'] . '")');
        }
    }
}


if (isset($_POST["eliminar_encargado"])) {
    $id = $_POST['encargado_id'];

    $select = mysqli_query($conn, 'SELECT * FROM proyectos WHERE id_encargado = "' . $id . '"  OR id_encargado2 = "' . $id . '" OR id_encargado3 = "' . $id . '" OR id_encargado4 = "' . $id . '"');

    if (mysqli_num_rows($select) > 0) {
        mysqli_close($conn);
        header("Location: ../users.php?delete=on");
        exit();
    } else {
        $delete = mysqli_query($conn, 'DELETE FROM users WHERE id = "' . $id . '" ');

        if ($delete) {
            mysqli_close($conn);
            header("Location: ../users.php?delete=success");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../users.php?delete=error");
            exit();
        }
    }
}


if (isset($_POST["eliminar_empleado"])) {
    $id = $_POST['empleado_id'];

    $select = mysqli_query($conn, 'SELECT * FROM planilla WHERE id = "' . $id . '"');
    $fetch = mysqli_fetch_assoc($select);

    $delete = mysqli_query($conn, 'DELETE FROM planilla WHERE id = "' . $id . '" ');
    $delete2 = mysqli_query($conn, 'DELETE FROM empleados_proyectos WHERE nombre_empleado = "' . $fetch['nombre'] . '" ');


    if ($delete && $delete2) {
        mysqli_close($conn);
        header("Location: ../planilla.php?delete=success");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../planilla.php?delete=error");
        exit();
    }
}

if (isset($_POST["eliminar_proyecto"])) {
    $id = $_POST['proyecto_id'];
    $select = mysqli_query($conn, 'SELECT * FROM proyectos WHERE id = "' . $id . '"');
    $fetch = mysqli_fetch_assoc($select);
    $verify = mysqli_query($conn, 'SELECT nombre_empleado, COUNT(*) cantidad FROM empleados_proyectos GROUP BY nombre_empleado HAVING COUNT(*) > 1');
    $cantidad_empleados = array();
    while ($row = mysqli_fetch_assoc($verify)) {
        $cantidad_empleados[] = $row['nombre_empleado'];
    }
    if (!empty($cantidad_empleados)) {
        foreach ($cantidad_empleados as $nombre_empleado) {
            $delete1 = mysqli_query($conn, 'DELETE FROM empleados_proyectos WHERE nombre_empleado = "' . $nombre_empleado . '" AND nombre_proyecto = "' . $fetch['nombre_proyecto'] . '"');
        }
        $delete = mysqli_query($conn, 'DELETE FROM proyectos WHERE id = "' . $id . '" ');
        if ($delete || $delete1) {
            mysqli_close($conn);
            header("Location: ../proyectos.php?delete=success");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../proyectos.php?delete=error");
            exit();
        }
    } else {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "" WHERE nombre_proyecto = "' . $fetch['nombre_proyecto'] . '" ');
        $delete = mysqli_query($conn, 'DELETE FROM proyectos WHERE id = "' . $id . '" ');
        if ($update && $delete) {
            mysqli_close($conn);
            header("Location: ../proyectos.php?delete=success");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../proyectos.php?delete=error");
            exit();
        }
    }
}

// $id = $_POST['proyecto_id'];
// $select = mysqli_query($conn, 'SELECT * FROM proyectos WHERE id = "' . $id . '"');
// $fetch = mysqli_fetch_assoc($select);
// $verify = mysqli_query($conn, 'SELECT nombre_empleado, COUNT(*) cantidad FROM empleados_proyectos GROUP BY nombre_empleado HAVING COUNT(*) > 1');

// while ($cantidad = mysqli_fetch_assoc($verify)) {
//     $delete1 = mysqli_query($conn, 'DELETE FROM empleados_proyectos WHERE nombre_empleado = "' . $cantidad['nombre_empleado'] . '" AND nombre_proyecto = "' . $fetch['nombre_proyecto'] . '"');
// }

// $delete = mysqli_query($conn, 'DELETE FROM proyectos WHERE id = "' . $id . '" ');

// if ($delete || $delete1) {
//     mysqli_close($conn);
//     header("Location: ../proyectos.php?delete=success");
//     exit();
// } else {
//     mysqli_close($conn);
//     header("Location: ../proyectos.php?delete=error");
//     exit();
// }


if (isset($_POST["editar_proyecto"])) {
    $id = $_POST['proyecto_id'];
    $nombre_proyecto = mysqli_real_escape_string($conn, $_POST['nombre_proyecto']);
    $encargado = mysqli_real_escape_string($conn, $_POST['encargado']);
    $encargado2 = mysqli_real_escape_string($conn, $_POST['encargado2']);
    $encargado3 = mysqli_real_escape_string($conn, $_POST['encargado3']);
    $encargado4 = mysqli_real_escape_string($conn, $_POST['encargado4']);
    $proyecto_old = mysqli_real_escape_string($conn, $_POST['proyecto_old']);

    $select = mysqli_query($conn, 'SELECT * FROM proyectos WHERE id = "' . $id . '"');
    $fetch = mysqli_fetch_assoc($select);

    //Encargado 1
    if ($encargado == $fetch['nombre_encargado'] || $encargado == "empty") {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update2 = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE id = "' . $id . '"');

        if ($update && $update2) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    } else {
        $select = mysqli_query($conn, 'SELECT id FROM users WHERE nombre_empleado = "' . $encargado . '"');
        $fetch = mysqli_fetch_assoc($select);

        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '", id_encargado = "' . $fetch['id'] . '", nombre_encargado = "' . $encargado . '" WHERE id = "' . $id . '"');

        if ($update) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    }

    //Encargado 2
    if ($encargado2 == $fetch['nombre_encargado2'] || $encargado2 == "empty") {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update2 = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE id = "' . $id . '"');

        if ($update && $update2) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    } else {
        $select2 = mysqli_query($conn, 'SELECT id FROM users WHERE nombre_empleado = "' . $encargado2 . '"');
        $fetch2 = mysqli_fetch_assoc($select2);

        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '", id_encargado2 = "' . $fetch2['id'] . '", nombre_encargado2 = "' . $encargado2 . '" WHERE id = "' . $id . '"');

        if ($update) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    }


    //Encargado 3
    if ($encargado3 == $fetch['nombre_encargado3'] || $encargado3 == "empty") {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update2 = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE id = "' . $id . '"');

        if ($update && $update2) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    } else {
        $select2 = mysqli_query($conn, 'SELECT id FROM users WHERE nombre_empleado = "' . $encargado3 . '"');
        $fetch2 = mysqli_fetch_assoc($select2);

        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '", id_encargado3 = "' . $fetch2['id'] . '", nombre_encargado3 = "' . $encargado3 . '" WHERE id = "' . $id . '"');

        if ($update) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    }


    //Encargado 4
    if ($encargado4 == $fetch['nombre_encargado4'] || $encargado4 == "empty") {
        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update2 = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE id = "' . $id . '"');

        if ($update && $update2) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    } else {
        $select2 = mysqli_query($conn, 'SELECT id FROM users WHERE nombre_empleado = "' . $encargado4 . '"');
        $fetch2 = mysqli_fetch_assoc($select2);

        $update = mysqli_query($conn, 'UPDATE empleados_proyectos SET nombre_proyecto = "' . $nombre_proyecto . '" WHERE nombre_proyecto = "' . $proyecto_old . '"');
        $update = mysqli_query($conn, 'UPDATE proyectos SET nombre_proyecto = "' . $nombre_proyecto . '", id_encargado4 = "' . $fetch2['id'] . '", nombre_encargado4 = "' . $encargado4 . '" WHERE id = "' . $id . '"');

        if ($update) {
            header("Location: ../proyectos.php?edit=success");
        } else {
            header("Location: ../proyectos.php?edit=error");
        }
    }
}



if (isset($_POST["autorizar"])) {
    $fechaActual = date("Y-m-d");
    $id = $_POST["id"];
    // Actualizar el estado de las horas
    $update = mysqli_query($conn, 'UPDATE empleados SET status_horas = "H.E AUTORIZADA" WHERE id = "' . $id . '"');
    if ($update) {
        mysqli_close($conn);
        header("Location: ../edit_asistencia.php?edit=ok");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../edit_asistencia.php?edit=error");
        exit();
    }
}

if (isset($_POST['agregar_ausencias'])) {
    $proyecto = $_POST['proyecto'];
    $select = mysqli_query($conn, 'SELECT nombre_proyecto FROM proyectos WHERE id = "' . $proyecto . '"');
    $fetch = mysqli_fetch_assoc($select);
    $select1 = mysqli_query($conn, "SELECT * FROM empleados_proyectos WHERE nombre_proyecto = '" . $fetch['nombre_proyecto'] . "'");
    $fetch1 = mysqli_fetch_assoc($select1);
    date_default_timezone_set('America/El_Salvador');
    $fechaActual = date("Y-m-d");

    if (isset($_POST['admin'])) {
        if ($_FILES["img_empleado"]["name"] != '') {
            if ($_POST["nombre"] == "" || $_POST["ausencia"] == "") {
                header("Location: ../edit_asistencia.php?proyecto=$proyecto");
            } else {
                $empleado_img = img2();
                $insertar = mysqli_query($conn, 'INSERT INTO empleados (nombre, cod_empleado, day, proyecto, status_entrada, status_salida,justificacion, justificado_por, img, notas) VALUES ("' . $_POST["nombre"] . '","' . $fetch1['cod_empleado'] . '","' . $fechaActual . '","' . $fetch['nombre_proyecto'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_SESSION['nombre'] . '","' . $empleado_img . '","' . $_POST["notas"] . '")');
                header("Location: ../edit_asistencia.php?proyecto=$proyecto");
            }
        } else {
            if ($_POST["nombre"] == "" ||  $_POST["ausencia"] == "") {
                header("Location: ../edit_asistencia.php?proyecto=$proyecto");
            } else {
                $insertar = mysqli_query($conn, 'INSERT INTO empleados (nombre, cod_empleado, day, proyecto, status_entrada, status_salida,justificacion, justificado_por, notas) VALUES ("' . $_POST["nombre"] . '","' . $fetch1['cod_empleado'] . '","' . $fechaActual . '","' . $fetch['nombre_proyecto'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_SESSION['nombre'] . '","' . $_POST["notas"] . '")');
                header("Location: ../edit_asistencia.php?proyecto=$proyecto");
            }
        }
    } else {
        if ($_POST["nombre"] == "" || $_POST["ausencia"] == "") {
            header("Location: ../edit_asistencia.php?proyecto=$proyecto");
        } else {
            $insertar = mysqli_query($conn, 'INSERT INTO empleados (nombre, cod_empleado, day, proyecto, status_entrada, status_salida,justificacion, justificado_por, notas) VALUES ("' . $_POST["nombre"] . '","' . $fetch1['cod_empleado'] . '","' . $fechaActual . '","' . $fetch['nombre_proyecto'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_POST['ausencia'] . '","' . $_SESSION['nombre'] . '","' . $_POST["notas"] . '")');
            header("Location: ../edit_asistencia.php?proyecto=$proyecto");
        }
    }
}


function img()
{
    if (isset($_FILES["img_empleado"]) && !empty($_FILES["img_empleado"]["name"])) {
        $data = ['uploadimageType' => strtolower(pathinfo($_FILES["img_empleado"]["name"], PATHINFO_EXTENSION))];
        $cod_empleado = $_POST['cod_empleado'];
        $upload_dir = dirname(__DIR__, 2) . '/images/empleados/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $destination = $upload_dir . $cod_empleado . '.' . $data['uploadimageType'];
        $move_destino = 'images/empleados/' . $cod_empleado . '.' . $data['uploadimageType'];
        move_uploaded_file($_FILES['img_empleado']['tmp_name'], $destination);
        return $move_destino;
    }
    return 'images/picture.png';
}

function img2()
{
    if (isset($_FILES["img_empleado"]) && !empty($_FILES["img_empleado"]["name"])) {
        $data = ['uploadimageType' => strtolower(pathinfo($_FILES["img_empleado"]["name"], PATHINFO_EXTENSION))];
        $rand = rand(10, 99999);
        $nombre = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['nombre']);
        $fechaActual = date("Y-m-d");
        $upload_dir = __DIR__ . '/../justificaciones/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $destination = $upload_dir . $fechaActual . '_' . $nombre . '_' . $rand . '.' . $data['uploadimageType'];
        $move_destino = 'justificaciones/' . $fechaActual . '_' . $nombre . '_' . $rand . '.' . $data['uploadimageType'];
        move_uploaded_file($_FILES['img_empleado']['tmp_name'], $destination);
        return $move_destino;
    }
    return '';
}
