
function ingresar() {
    let user = $('#user').val();
    let password = $('#password').val();
    $.ajax({
        type: "POST",
        url: './services/login.php?accion=iniciarSesion',
        data: { user: user, password: password },
        dataType: "html",
        success: function (respuesta) {

            respuesta = JSON.parse(respuesta)
            if (respuesta.status == 'success') {
                location.href = 'index'
            } else {
                alert(respuesta.response)
            }


        }
    });
}


function cerrarSesion(){
    $.ajax({
        type: "POST",
        url: './services/login.php?accion=destruirSesion',
        dataType: "json",
        success: function (respuesta) {
            
            if (respuesta.response == 1) {
                location.href = 'login.php'
            }


        }
    });
}