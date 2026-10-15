
function fileValidation() {
    var fileInput =
        document.getElementById('file');

    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions =
        /(\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Por favor seleccione una imagen PNG',
            showConfirmButton: false,
            timer: 1500000000000
        })
        fileInput.value = '';
        return false;
    } else {

        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(
                    'imagePreview').innerHTML =
                    '<img height="150" width="150" src="' + e.target.result +
                    '"/><br><br>';
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}

function fileValidation2() {
    var fileInput =
        document.getElementById('file');

    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions =
        /(\.png | \.jpg)$/i;

    if (!allowedExtensions.exec(filePath)) {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Por favor seleccione una imagen png o jpg',
            showConfirmButton: false,
            timer: 1500000000000
        })
        fileInput.value = '';
        return false;
    } else {

        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById(
                    'imagePreview').innerHTML =
                    '<img height="150" width="150" src="' + e.target.result +
                    '"/><br><br>';
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}




$(document).ready(function () {
    $('#agregar_empleado').on('submit', function (e) {
        e.preventDefault();
        var nombre_empleado = $('input[name="nombre_empleado"]').val().trim();
        var rol_empleado = $('input[name="rol_empleado"]').val().trim();
        var dui_empleado = $('input[name="dui_empleado"]').val().trim();
        var tel_empleado = $('input[name="tel_empleado"]').val().trim();
        var cod_empleado = $('input[name="cod_empleado"]').val().trim();
        var tipo_empleado = $('select[name="tipo_empleado"]').val().trim();
        if (nombre_empleado === '' || rol_empleado === '' || dui_empleado === '' || tel_empleado === '' || cod_empleado === '' || tipo_empleado === '') {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Por favor no dejar espacios en blanco',
                showConfirmButton: false,
                timer: 1500000000000,
                showCloseButton: true

            });
            return false;
        } else {
            var form_data = new FormData(this);
            form_data.append('agregar_empleado', 'true');
            $.ajax({
                type: 'POST',
                url: 'backend/backend.php',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response === 'success') {
                        window.location.href = 'planilla.php?add=success'
                    } else {
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
                },
                error: function () {
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
        }
    });

});


$(document).ready(function () {
    $('#agregar_encargado').on('submit', function (e) {
        e.preventDefault();
        var nombre_encargado = $('input[name="nombre_encargado"]').val().trim();
        var dui_encargado = $('input[name="dui_encargado"]').val().trim();
        var tel_encargado = $('input[name="tel_encargado"]').val().trim();
        var pwd_encargado = $('input[name="pwd_encargado"]').val().trim();

        if (nombre_encargado === '' || dui_encargado === '' || tel_encargado === '' || pwd_encargado === '') {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Por favor no dejar espacios en blanco',
                showConfirmButton: false,
                timer: 1500000000000,
                showCloseButton: true

            });
            return false;
        } else {
            var form_data = new FormData(this);
            form_data.append('agregar_encargado', 'true');
            $.ajax({
                type: 'POST',
                url: 'backend/backend.php',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response === 'success') {
                        window.location.href = 'users.php?add=success'
                    } else {
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
                },
                error: function () {
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
        }
    });

});


$(document).ready(function () {
    $('#editar_empleado').on('submit', function (e) {
        e.preventDefault();
        var nombre_empleado = $('input[name="nombre_empleado"]').val().trim();
        var rol_empleado = $('input[name="rol_empleado"]').val().trim();
        var dui_empleado = $('input[name="dui_empleado"]').val().trim();
        var tel_empleado = $('input[name="tel_empleado"]').val().trim();
        var cod_empleado = $('input[name="cod_empleado"]').val().trim();
        var tipo_empleado = $('select[name="tipo_empleado"]').val().trim();
        if (nombre_empleado === '' || rol_empleado === '' || dui_empleado === '' || tel_empleado === '' || cod_empleado === '' || tipo_empleado === '') {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Por favor no dejar espacios en blanco',
                showConfirmButton: false,
                timer: 1500000000000,
                showCloseButton: true

            });
            return false;
        } else {
            var form_data = new FormData(this);
            form_data.append('editar_empleado', 'true');
            $.ajax({
                type: 'POST',
                url: 'backend/backend.php',
                data: form_data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response === 'success') {
                        window.location.href = 'planilla.php?edit=success';
                    } else {
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
                },
                error: function () {
                    // Hubo un error al enviar la petici贸n
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
        }
    });
});



