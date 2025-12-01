<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<style>
    .shadows-into-light-regular {
        font-family: "Sour Gummy", sans-serif;
  font-optical-sizing: auto;
  font-style: normal;
  font-variation-settings:
    "wdth" 100;
}
</style>

<?php if ((isset($_GET['public']) && $_GET['public'] == 0) || !isset($_GET['public'])): ?>
<nav class="app-header navbar navbar-expand bg-principal">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item "> <a class="nav-link ps-0" data-lte-toggle="sidebar" href="#" role="button"> <i
                        class="bi bi-list"></i> </a>
            </li>
            <li class="nav-item pt-2">
                <b  class="shadows-into-light-regular text-white">🏐CORAZÓN LATINO🏐</b>
            </li>
            <!-- <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li> -->
            <!--  <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Amigos</a> </li>

            <li>
                <input type="text" style="width: 500px !important" autofocus class="form-control-sm mt-1 ms-3 w-100" placeholder="Buscar...">
            </li> -->
        </ul>

        <ul class="navbar-nav ms-auto">



            <!--  <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i
                        class="bi bi-search"></i> </a> </li> -->

            <!-- <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i
                        class="bi bi-chat-text"></i> <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <a href="#"
                        class="dropdown-item">
                      
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/avatar/<?= ($_SESSION['usuario']['avatar']) ?>"
                                    alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-end fs-7 text-danger"><i
                                            class="bi bi-star-fill"></i></span>
                                </h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                    Ago
                                </p>
                            </div>
                        </div>
                        
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">
                       
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/avatar/<?= ($_SESSION['usuario']['avatar']) ?>"
                                    alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-end fs-7 text-secondary"> <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">I got your message bro</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                    Ago
                                </p>
                            </div>
                        </div>
                        
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">
                        
                        <div class="d-flex">
                            <div class="flex-shrink-0"> <img src="../../dist/assets/img/avatar/<?= ($_SESSION['usuario']['avatar']) ?>"
                                    alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-end fs-7 text-warning"> <i class="bi bi-star-fill"></i>
                                    </span>
                                </h3>
                                <p class="fs-7">The subject goes here</p>
                                <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours
                                    Ago
                                </p>
                            </div>
                        </div>
                        
                    </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">See
                        All Messages</a>
                </div>
            </li> -->

            <!-- <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i
                        class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span
                        class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                            class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                            class="bi bi-people-fill me-2"></i> 8 friend requests
                        <span class="float-end text-secondary fs-7">12 hours</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i
                            class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                        <span class="float-end text-secondary fs-7">2 days</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">
                        See All Notifications
                    </a>
                </div>
            </li> -->
            <li class="nav-item "> <a class="nav-link btn border movil" target="_blank" href="./app.php" > 
                
                <i class="bi bi-phone"></i>
                <span class="pe-3 textoapp">DESCARGAR APP CORAZON LATINO</span>
            </a>
            </li>


            <li class="nav-item"> <a class="nav-link pe-0" href="#" data-lte-toggle="fullscreen"> <i
                        data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i
                        data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a>
            </li>

            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"> <img src="../../dist/assets/img/avatar/<?= ($_SESSION['usuario']['avatar']) ?>"
                        class="user-image rounded-circle shadow" alt="User Image"> <span
                        class="d-none d-md-inline"><?= ucwords($_SESSION['usuario']['nombre']) ?>
                    </span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

                    <li class="user-header text-bg-primary"> <img src="../../dist/assets/img/avatar/<?= ($_SESSION['usuario']['avatar']) ?>"
                            class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?= ucwords($_SESSION['usuario']['nombre']) ?>

                            <small> <?= ucwords($_SESSION['usuario']['user']) ?></small>
                        </p>
                    </li>

                    <li class="user-footer"> <!-- <a href="#" class="btn btn-default btn-flat">Perfil</a> --> <a
                            href="#" onclick="cerrarSesion()" class="btn btn-default btn-flat float-end">Cerrar Sesión</a> </li>

                </ul>
            </li>

        </ul>

    </div>

</nav>

<?php endif; ?>