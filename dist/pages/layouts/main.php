<?php

if (empty($responseTorneo['id'])) {
    $torneo = 0;
} else {
    $torneo = $responseTorneo['id'];
}

?>



<?php if ((isset($_GET['public']) && $_GET['public'] == 0) || !isset($_GET['public'])): ?>

    <aside class="app-sidebar bg-principal shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand justify-content-start ">
            <!--begin::Brand Link--> <a href="#" onClick="redireccion('inicio')" class="brand-link">
                <!--begin::Brand Image-->

                <img src="../../dist/assets/img/logo.png"
                    style="width: 100%; max-height: initial !important;" alt="AdminLTE Logo"
                    class="brand-image  shadow">
                <!--end::Brand Image-->
                <!--begin::Brand Text-->
                <span class="brand-text fw-light">Deportazo</span>
                <!--end::Brand Text-->
            </a>
            <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">


            <nav class="mt-2 nav-compact">
                <!--begin::Sidebar Menu-->


                <ul class="nav sidebar-menu flex-column nav-child-indent" data-lte-toggle="treeview" role="menu"
                    data-accordion="false">
                    <li>
                        <ul class="row p-0 m-0 ">
                            <div class="col-3">
                                <img src="../../dist/assets/img/usuarios/<?= ($_SESSION['usuario']['avatar']) ?>" class=" w-100 rounded elevation-2"
                                    alt="User Image">
                            </div>
                            <div class="col-8 align-items-center d-flex text-white p-0">
                                <?= ucwords($_SESSION['usuario']['nombre']) ?>


                            </div>
                            <hr class="mt-2 bg-white text-white">
                        </ul>
                    </li>

                    <li>
                        <div class="logotipo">
                            <img src="../assets/img/grupos/corazonlatino.png" alt="" width="auto">
                        </div>
                    </li>


                    <!-- ---------------- -->

                    <li class="nav-item ">
                        <a type="button" onClick="redireccion('inicio')" class="nav-link "> <i class="nav-icon bi bi-house"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                    <a type="button" onclick="redireccion('dashboard')" class="nav-link"> <i
                            class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li> -->

                    <?php
                    if ($_SESSION['usuario']['id_rol'] == 1):
                    ?>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('usuarios')" class="nav-link"> <i class="nav-icon bi bi-people"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>

                    <?php
                    endif
                    ?>



                    <!-- <li class="nav-item ">
                    <a class="nav-link "> <i class="nav-icon bi bi-gear"></i>
                        <p>
                            Configuración
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('dashboard')" class="nav-link "> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Menús</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('dashboard')" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Páginas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('dashboard')" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                    <!-- <li class="nav-item ">
                    <a href="#" class="nav-link "> <i class="nav-icon bi bi-grid-3x3-gap"></i>
                        <p>
                            Deportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('futbol')" class="nav-link "> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Futbol</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('voleybol')" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Voleybol</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('dashboard')" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Baloncesto</p>
                            </a>
                        </li>
                    </ul>
                </li> -->

                    <li class="nav-item">
                        <a type="button" onclick="redireccion('voleybol', {'torneo':<?= $torneo ?>}) " class="nav-link"> <i class="nav-icon bi bi-grid-3x3-gap"></i>
                            <p>Voleibol</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a type="button" onclick="redireccion('lista_torneos')" class="nav-link"> <i class="nav-icon bi bi-globe2"></i>
                            <p>Torneos</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                <a type="button" onclick="redireccion('calendar')" class="nav-link"> <i class="nav-icon bi bi-calendar-check"></i>
                <p>Calendario</p>
                    </a>
                </li> -->
                    <!-- <li class="nav-item">
                    <a type="button" onclick="redireccion()" class="nav-link"> <i class="nav-icon bi bi-newspaper"></i>
                    <p>Noticias y Eventos</p>
                </a>
            </li> -->
                    <li class="nav-item">
                        <a type="button" onclick="redireccion('galeria')" class="nav-link"> <i class="nav-icon bi bi-images"></i>
                            <p>Galería</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a type="button" onclick="redireccion('triunfos')" class="nav-link"> <i class="nav-icon bi bi-award"></i>
                            <p>Triunfos</p>
                        </a>
                    </li>

                    <?php
                    if ($_SESSION['usuario']['id_rol'] == 1):
                    ?>
                        <li class="nav-item">
                            <a type="button" onclick="redireccion('enfrentamiento_rapido')" class="nav-link"> <i class="nav-icon fa fa-group"></i>
                                <p>Enfrentamiento Rapido</p>
                            </a>
                        </li>



                    <?php endif ?>
                    <li class="nav-item">
                        <a type="button" target="_blank" onclick="redireccion('miembros')" class="nav-link"> <i class="nav-icon fa fa-users"></i>
                            <p>Miembros</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a type="button" target="_blank" href="./../../web/index" class="nav-link"> <i class="nav-icon bi bi-globe"></i>
                            <p>Web</p>
                        </a>
                    </li>




                </ul>
                <!--end::Sidebar Menu-->
            </nav>
        </div>
        <!--end::Sidebar Wrapper-->
    </aside>

<?php endif; ?>