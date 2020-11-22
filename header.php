<?php

echo'
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="true">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu" id="navMenu">
            <div class="navbar-start">
                <span class="navbar-item">
                    Bienvenido: <h6 class="user ml-2">'. $nombre . " " . $ape .'</h6>
                </span>

                <a href="index.php" class="navbar-item linknav">
                    Inicio
                </a>
                ';

                if($rol == 1)
                {
                    echo'

                    <a href="modificar.php" class="navbar-item linknav">
                        Actualizar
                    </a>

                    <a href="eliminar.php" class="navbar-item linknav">
                        Borrar
                    </a>';
                }

echo'

                <a href="logout.php" class="navbar-item linknav">
                    Cerrar sesión
                </a>

            </div>
        </div>
    </nav>
';
?>
