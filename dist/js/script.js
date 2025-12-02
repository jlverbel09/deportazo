$(document).ready(function () {
    redireccion('inicio')
    /* redireccion('torneos', { 'id_torneo': 5 }) */
    /* redireccion('voleybol') */
    /* redireccion('torneos', { 'id_torneo': 2 }) */
    /* redireccion('lista_torneos') */
    /* redireccion('triunfos') */
    /*  redireccion('galeria') */
    /*  redireccion('miembros') */

    /* setTimeout(() => {
        $('#enfrentamiento').modal('show')
    }, 3000); */
    //redireccion('enfrentamiento_rapido')

})
document.addEventListener("keypress", function (event) {
    if (event.keyCode == 48) {
        actualizarEnfrentamientosAuto(document.getElementById('id_torneo').value)
    }
});


function actualizarEnfrentamientosAuto(id) {
    redireccion('torneos', { 'id_torneo': id })
    setTimeout(() => {
        $('html, body').animate({ scrollTop: '530px' }, 0);
    }, 1000);
}

function actualizarEnfrentamientos(id) {
    redireccion('torneos', { 'id_torneo': id })
    setTimeout(() => {
        $('#enfrentamiento').modal('show')
    }, 3000);
}

$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
}




function redireccion(ruta, data = {}) {
    $('#contenido').html('')
    $.ajax({
        type: "GET",
        url: './services/' + ruta + '.php',
        data: data,
        dataType: "json",
        success: async function (respuesta) {
            titulo = respuesta['titulo']
            contenido = respuesta['contenido']
            $('.tituloprincipal').html(titulo)
            $('#contenido').html(contenido)


            if (ruta == 'enfrentamiento_rapido') {

                await cargarEnfrentamiento()
            }
        }
    });
}

function simuladorEnfrentamiento(id_torneo) {
    
         Swal.fire({
            title: "Esta seguro?",
            text: "Esta a punto de generar los enfrentamientos!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No"
        }).then(async (result) => {
            if (result.isConfirmed) {
                $('.loading').css('display', 'flex')
                $.ajax({
                    type: "POST",
                    url: './services/simulador.php',
                    data: { id_torneo: id_torneo },
                    dataType: "json",
                    success: function (data) {

                        setTimeout(() => {
                            $('.loading').css('display', 'none')
                            redireccion('torneos', { 'id_torneo': id_torneo })
                        }, 3000);


                    }
                });


            }

        });
    

    }

    function simuladorEnfrentamientoGrupo(id_torneo) {
        $('.loading').css('display', 'none !important')
        $.ajax({
            type: "POST",
            url: './services/simulador_grupo.php',
            data: { id_torneo: id_torneo },
            dataType: "json",
            success: async function (data) {
                /* console.log(data) */
                if (data.faltantes == 0) {
                    await Swal.fire({
                        title: "Esta seguro?",
                        text: "Esta a punto de generar los enfrentamientos de la siguiente fase",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si",
                        cancelButtonText: "No"
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            if (data.tipo == 1) {
                                if (data.fase == 0) {
                                    await enfrentarFase1()
                                } else if (data.fase == 1) {
                                    await enfrentarFase2()
                                } else if (data.fase == 2) {
                                    await enfrentarFase3()
                                }
                            } else if (data.tipo == 2) {
                                if (data.fase == 0) {
                                    await enfrentarFinal2doTipo()
                                }
                            } else if (data.tipo == 3) {
                                if (data.fase == 0) {
                                    await enfrentarSeminfinales()
                                } else if (data.fase == 1) {
                                    await enfrentarFinal()
                                }
                            } else if (data.tipo == 4) {
                                if (data.fase == 0) {
                                    await enfrentarSeminfinales()
                                } else if (data.fase == 1) {
                                    await enfrentarFinal()
                                }
                            }

                        }

                    });

                }
                $('.loading').css('display', 'flex')
                setTimeout(() => {
                    $('.loading').css('display', 'none')
                    redireccion('torneos', { 'id_torneo': id_torneo })
                }, 2000);




            }
        });

    }


    function enfrentarSeminfinales() {
        var id_torneo = $('#id_torneo').val();
        var primerEquipo = $('#primerEquipo').val()
        var segundoEquipo = $('#segundoEquipo').val()
        var tercerEquipo = $('#tercerEquipo').val()
        var cuartoEquipo = $('#cuartoEquipo').val()

        $.ajax({
            type: "POST",
            url: './services/simulador_semifinal.php',
            data: { id_torneo: id_torneo, primerEquipo: primerEquipo, segundoEquipo: segundoEquipo, tercerEquipo: tercerEquipo, cuartoEquipo: cuartoEquipo },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }




    function enfrentarFase1() {
        var id_torneo = $('#id_torneo').val();
        var primerEquipo = $('#primerEquipo').val()
        var segundoEquipo = $('#segundoEquipo').val()
        var tercerEquipo = $('#tercerEquipo').val()
        var cuartoEquipo = $('#cuartoEquipo').val()

        $.ajax({
            type: "POST",
            url: './services/simulador_via_finales.php',
            data: { id_torneo: id_torneo, primerEquipo: primerEquipo, segundoEquipo: segundoEquipo, tercerEquipo: tercerEquipo, cuartoEquipo: cuartoEquipo },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }


    function enfrentarFase2() {
        var id_torneo = $('#id_torneo').val();

        var primerEquipo = $('#primerEquipo').val()
        var segundoEquipo = $('#segundoEquipo').val()
        var tercerEquipo = $('#tercerEquipo').val()
        var cuartoEquipo = $('#cuartoEquipo').val()

        var primerEquipoFinal = $('#primerEquipoFinal').val()


        $.ajax({
            type: "POST",
            url: './services/simulador_via_finales.php',
            data: {
                id_torneo: id_torneo, primerEquipo: primerEquipo, segundoEquipo: segundoEquipo, tercerEquipo: tercerEquipo, cuartoEquipo: cuartoEquipo,
                primerEquipoFinal: primerEquipoFinal
            },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }


    function enfrentarFase3() {
        var id_torneo = $('#id_torneo').val();

        var primerEquipo = $('#primerEquipo').val()
        var segundoEquipo = $('#segundoEquipo').val()
        var tercerEquipo = $('#tercerEquipo').val()
        var cuartoEquipo = $('#cuartoEquipo').val()

        var primerEquipoFinal = $('#primerEquipoFinal').val()
        var segundoEquipoFinal = $('#segundoEquipoFinal').val()

        $.ajax({
            type: "POST",
            url: './services/simulador_via_finales.php',
            data: { id_torneo: id_torneo, primerEquipo: primerEquipo, segundoEquipo: segundoEquipo, tercerEquipo: tercerEquipo, cuartoEquipo: cuartoEquipo, primerEquipoFinal: primerEquipoFinal, segundoEquipoFinal: segundoEquipoFinal },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }




    function enfrentarFinal() {
        var id_torneo = $('#id_torneo').val();
        var primerEquipoFinal = $('#primerEquipoFinal').val()
        var segundoEquipoFinal = $('#segundoEquipoFinal').val()
        $.ajax({
            type: "POST",
            url: './services/simulador_finales.php',
            data: { id_torneo: id_torneo, primerEquipoFinal: primerEquipoFinal, segundoEquipoFinal: segundoEquipoFinal },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }
    function enfrentarFinal2doTipo() {
        var id_torneo = $('#id_torneo').val();
        var primerEquipoFinal = $('#primerEquipo').val()
        var segundoEquipoFinal = $('#segundoEquipo').val()
        $.ajax({
            type: "POST",
            url: './services/simulador_finales_2dotipo.php',
            data: { id_torneo: id_torneo, primerEquipoFinal: primerEquipoFinal, segundoEquipoFinal: segundoEquipoFinal },
            dataType: "json",
            success: function (data) {

                console.log(data);

            }
        });
    }


    function save_usuarios() {
        var id = $('#id_user').val();
        var nombre = $('#nombre').val();
        var usuario = $('#usuario').val();
        var contraseña = $('#contraseña').val();
        var correo = $('#correo').val();


        if (nombre == '') {
            Swal.fire({
                text: "ingrese un nombre",
                icon: "question"
            });
        } else if (usuario == '') {
            Swal.fire({
                text: "ingrese un nombre de usuario",
                icon: "question"
            });
        } else if (correo == '') {
            Swal.fire({
                text: "ingrese un whatsapp",
                icon: "question"
            });
        } else {

            if (id == '') {
                data = { nombre: nombre, usuario: usuario, contraseña: contraseña, correo: correo, accion: 'crear' }
                if (contraseña == '') {
                    Swal.fire({
                        text: "ingrese una contraseña",
                        icon: "question"
                    });
                    return
                }
            } else {
                data = { id: id, nombre: nombre, usuario: usuario, contraseña: contraseña, correo: correo, accion: 'editar' }
            }
            $.ajax({
                type: "POST",
                url: './services/usuarios_actions.php',
                data: data,
                dataType: "json",
                success: function (respuesta) {

                    if (respuesta.estado == 'success') {
                        Swal.fire({
                            position: "center",
                            icon: respuesta.estado,
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        redireccion('usuarios')
                    } else {
                        alert('Error al realizar la accion')
                    }


                }
            });
        }


    }

    function load_usuario(id) {
        $(window).scrollTop(0);
        $.ajax({
            type: "POST",
            url: './services/usuarios_actions.php',
            data: { id: id, accion: 'cargar' },
            dataType: "json",
            success: function (respuesta) {

                if (respuesta.estado == 'success') {
                    $('#id_user').val(respuesta.body.id);
                    $('#nombre').val(respuesta.body.nombre);
                    $('#usuario').val(respuesta.body.user);
                    $('#correo').val(respuesta.body.correo);
                } else {
                    alert('Error al cargar los datos')
                }


            }
        });
    }

    function delete_usuario(id) {

        Swal.fire({
            title: "Esta usted seguro?",
            text: "No se puede revertir esta accion!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: './services/usuarios_actions.php',
                    data: { id: id, accion: 'eliminar' },
                    dataType: "json",
                    success: function (respuesta) {

                        if (respuesta.estado == 'success') {
                            Swal.fire({
                                position: "center",
                                icon: respuesta.estado,
                                title: respuesta.mensaje,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            redireccion('usuarios')
                        } else {
                            alert('Error al eliminar')
                        }


                    }
                });



            }
        });


    }

    /* ---------------------------------- */

    function save_torneo() {
        var torneo_nombre = $('#torneo_nombre').val();
        var torneo_deporte = $('#torneo_deporte').val();
        var torneo_nro_equipos = $('#torneo_nro_equipos').val();
        var torneo_tipo_juego = $('#torneo_tipo_juego').val();
        var torneo_descripcion = $('#torneo_descripcion').val();
        var torneo_fecha = $('#torneo_fecha').val();
        var torneo_direccion = $('#torneo_direccion').val();

        if (torneo_nombre == '') {
            Swal.fire({
                text: "ingrese un nombre",
                icon: "question"
            });
            return
        }
        if (torneo_deporte == '') {
            Swal.fire({
                text: "Seleccione un deporte",
                icon: "question"
            });
            return
        }
        if (torneo_nro_equipos == '') {
            Swal.fire({
                text: "ingrese la cantidad de equipos a participar",
                icon: "question"
            });
            return
        }
        if (torneo_tipo_juego == '') {
            Swal.fire({
                text: "Seleccione el tipo de torneo",
                icon: "question"
            });
            return
        }
        if (torneo_descripcion == '') {
            Swal.fire({
                text: "ingrese una descripcion breve acerca el torneo",
                icon: "question"
            });
            return
        }
        if (torneo_fecha == '') {
            Swal.fire({
                text: "Seleccione la fecha y hora del torneo",
                icon: "question"
            });
            return
        }
        if (torneo_direccion == '') {
            Swal.fire({
                text: "ingrese la dirección donde se jugara el torneo",
                icon: "question"
            });
            return
        }
        data = {
            torneo_nombre: torneo_nombre,
            torneo_deporte: torneo_deporte,
            torneo_nro_equipos: torneo_nro_equipos,
            torneo_tipo_juego: torneo_tipo_juego,
            torneo_descripcion: torneo_descripcion,
            torneo_fecha: torneo_fecha,
            torneo_direccion: torneo_direccion,
            accion: 'crear_torneo'
        }
        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: function (respuesta) {
                $('#nuevoTorneo').modal('hide')

                if (respuesta.estado == 'success') {
                    Swal.fire({
                        position: "center",
                        icon: respuesta.estado,
                        title: respuesta.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    redireccion('voleybol')

                } else {
                    alert('Error al realizar la accion')
                }
            }
        });

    }

    function save_equipo() {

        var id_torneo = $('#id_torneo').val()
        var nombre_equipo = $('#nombre_equipo').val()
        var deporte = $('#deporte').val()
        if (id_torneo == '') {
            Swal.fire({
                text: "Seleccione el torneo",
                icon: "question"
            });
            return
        }
        if (nombre_equipo == '') {
            Swal.fire({
                text: "Ingrese el nombre del jugador",
                icon: "question"
            });
            return
        }

        data = { id_torneo: id_torneo, nombre_equipo: nombre_equipo, deporte: deporte, accion: 'crear_equipo' }

        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: function (respuesta) {
                $('#nuevoEquipo').modal('hide')

                if (respuesta.estado == 'success') {
                    Swal.fire({
                        position: "center",
                        icon: respuesta.estado,
                        title: respuesta.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    redireccion('voleybol', { 'torneo': id_torneo, 'equipo': 1 })

                } else {
                    alert('Error al realizar la accion')
                }
            }
        });

    }

    function buscarEquipo(id_jugador) {
        $('#id_equipo').val(id_jugador)
    }

    function save_jugador() {

        var id_torneo = $('#id_torneo').val()
        var id_equipo = $('#id_equipo').val()
        var asig_jugador = $('#asig_jugador').val()
        var asig_posicion = $('#asig_posicion').val()
        var asig_numero = $('#asig_numero').val()

        if (asig_jugador == '') {
            Swal.fire({
                text: "Seleccione un jugador",
                icon: "question"
            });
            return
        }
        if (asig_posicion == '') {
            Swal.fire({
                text: "Seleccione la posicion",
                icon: "question"
            });
            return
        }
        if (asig_numero == '') {
            Swal.fire({
                text: "Ingrese el numero del jugador",
                icon: "question"
            });
            return
        }


        data = {
            id_torneo: id_torneo, id_equipo: id_equipo, asig_jugador: asig_jugador, asig_posicion: asig_posicion,
            asig_numero: asig_numero, accion: 'asignar_jugador'
        }

        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: function (respuesta) {
                $('#asignarJugador').modal('hide')

                if (respuesta.estado == 'success') {
                    Swal.fire({
                        position: "center",
                        icon: respuesta.estado,
                        title: respuesta.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    redireccion('voleybol', { 'torneo': id_torneo, 'equipo': id_equipo })

                } else {
                    alert('Error al realizar la accion')
                }
            }
        });

    }

    function vermarcador(id) {

        var data = { id: id, accion: 'ver_marcador' }
        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: function (respuesta) {
                if (respuesta.estado == 'success') {

                    $('#marcador_equipo_local').html(respuesta.body.equipo_local)
                    $('#marcador_equipo_visitante').html(respuesta.body.equipo_visitante)

                    $('#id_equipoLocal').val(respuesta.body.id_equipo_local)
                    $('#id_equipoVisitante').val(respuesta.body.id_equipo_visitante)

                    $('#m_equipoLocal').val(respuesta.body.marcador_local)
                    $('#m_equipoVisitante').val(respuesta.body.marcador_visitante)
                    $('#color_equipo_local').css({ color: respuesta.body.color_equipo_local })
                    $('#color_equipo_visitante').css({ color: respuesta.body.color_equipo_visitante })

                    $('#id_enfrentamiento').val(respuesta.body.id)

                }
            }
        });
    }

    function marcar(accionPunto, equipoMarcador) {

        var valor_local = $('#m_equipoLocal').val()
        var valor_visitante = $('#m_equipoVisitante').val()

        if (equipoMarcador == 'local') {
            if (accionPunto == 'restar') {
                if (valor_local > 0) {
                    $('#m_equipoLocal').val(parseInt(valor_local) - parseInt(1))
                } else {
                    return
                }

            } else if (accionPunto == 'sumar') {
                $('#m_equipoLocal').val(parseInt(valor_local) + parseInt(1))
            }
        } else if (equipoMarcador == 'visitante') {
            if (accionPunto == 'restar') {
                if (valor_visitante > 0) {
                    $('#m_equipoVisitante').val(parseInt(valor_visitante) - parseInt(1))
                } else {
                    return
                }

            } else if (accionPunto == 'sumar') {
                $('#m_equipoVisitante').val(parseInt(valor_visitante) + parseInt(1))
            }
        }


        var id_enfrentamiento = $('#id_enfrentamiento').val()
        var m_equipoVisitante = $('#m_equipoVisitante').val()
        var m_equipoLocal = $('#m_equipoLocal').val()
        var id_equipoLocal = $('#id_equipoLocal').val()
        var id_equipoVisitante = $('#id_equipoVisitante').val()

        var data = {
            accionPunto: accionPunto, equipoMarcador: equipoMarcador, id_enfrentamiento: id_enfrentamiento,
            m_equipoLocal: m_equipoLocal, m_equipoVisitante: m_equipoVisitante,
            id_equipoLocal: id_equipoLocal, id_equipoVisitante: id_equipoVisitante,
            accion: 'guardarAnotacion'
        }
        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: function (respuesta) {
                //console.log(respuesta);
            }
        });
    }


    function cargarInputsEquipos(cantidad) {

        var inputs = '';
        for (let i = 1; i <= cantidad; i++) {
            inputs += '<label>Equipo ' + i + '</label><input required id="equipo_' + i + '" type="text"  class="form-control" >'
        }

        $('#listInputs').html('<div class="col-md-12">' + inputs + '</div>')
    }

    function crearEnfrentamiento() {

        var cant_equipos = $('#cant_equipos').val()
        var equipo_1 = $('#equipo_1').val()
        var equipo_2 = $('#equipo_2').val()
        var equipo_3 = $('#equipo_3').val()
        var equipo_4 = $('#equipo_4').val()
        var equipo_5 = $('#equipo_5').val()
        var equipo_6 = $('#equipo_6').val()

        if (!equipo_1) {
            equipo_1 = '';
        }
        if (!equipo_2) {
            equipo_2 = '';
        }
        if (!equipo_3) {
            equipo_3 = '';
        }
        if (!equipo_4) {
            equipo_4 = '';
        }
        if (!equipo_5) {
            equipo_5 = '';
        }
        if (!equipo_6) {
            equipo_6 = '';
        }


        var data = {
            cant_equipos: cant_equipos,
            equipo_1: equipo_1,
            equipo_2: equipo_2,
            equipo_3: equipo_3,
            equipo_4: equipo_4,
            equipo_5: equipo_5,
            equipo_6: equipo_6,
            accion: 'guardarEnfrentamiento'
        }
        $.ajax({
            type: "POST",
            url: './services/voleybol_actions.php',
            data: data,
            dataType: "json",
            success: async function (respuesta) {
                if (respuesta.estado == 'success') {
                    Swal.fire({
                        position: "center",
                        icon: respuesta.estado,
                        title: respuesta.mensaje,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    await cargarEnfrentamiento()
                } else {
                    alert('Error al realizar la accion')
                }
            }
        });
    }


    function finalizarEnfrentamiento() {
        $.ajax({
            type: "GET",
            url: './services/voleybol_actions.php?accion=finalizarEnfrentamiento',
            data: {},
            dataType: "json",
            success: function (respuesta) {
                redireccion('enfrentamiento_rapido')
            }
        });
    }

    function cargarEnfrentamiento() {
        $.ajax({
            type: "GET",
            url: './services/voleybol_actions.php?accion=cargarEnfrentamiento',
            data: {},
            dataType: "json",
            success: function (respuesta) {

                setTimeout(() => {

                    $('#cant_equipos option[value="' + respuesta.body.cantidad_equipos + '"]').prop('selected', true);
                    $('#listInputs').html(respuesta.html)
                    $('#cant_equipos').prop('disabled', true)
                    $('#cuadroCrearEnfrentamiento').css('display', 'none ')
                    $('div#cuadroPararEnfrentamientos').css({ 'display': 'block' })
                    $('#restaurarReencuentros').css('visibility', 'initial')
                }, 1000);

            }
        });
    }

    function cambiarEstado(id) {

        $.ajax({
            type: "GET",
            url: './services/voleybol_actions.php?accion=cambiarEstado&id=' + id,
            data: {},
            dataType: "json",
            success: function (respuesta) {

                cargarEnfrentamiento()
            }
        });
    }

    function restaurarReencuentros() {
        $.ajax({
            type: "GET",
            url: './services/voleybol_actions.php?accion=restaurarReencuentros',
            data: {},
            dataType: "json",
            success: function (respuesta) {

                cargarEnfrentamiento()
            }
        });
    }