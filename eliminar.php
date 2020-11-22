<?php
require_once 'functions.php';
use Illuminate\Database\Capsule\Manager as DB;

$aviso = $esp = $mate = $hist = "";

echo'
<body>
';


if($loggedin)
{
    require_once 'header.php';
    if($rol == 1)
    {
        if(isset($_GET['id_eliminar']))
        {
            $id_eliminar = $_GET['id_eliminar'];

            $alumno = DB::table('miembros')->where('id_miembros', $id_eliminar)->first();

            $nombre_alumno = $alumno->nombre;

            $eliminar = DB::table('calificaciones')->where('miembros_id_miembros', $id_eliminar)->delete();

            if($eliminar)
            {
                $aviso = '<p class="is-size-4 is-center mb-4">Haz eliminado las calificaciones de '.$nombre_alumno.'</p>';
            }
        }

        $alumnos = DB::table('calificaciones')
        ->where('id_miembros','<>',1)
        ->leftJoin('miembros', 'calificaciones.miembros_id_miembros', '=', 'miembros.id_miembros')
        ->orderBy('apellido')
        ->get();

        echo'
    <div class="container">
        <div class="card mt-6 mb-6">
            <header class="card-header">
                <p class="card-header-title">
                    Elige un alumno para eliminar sus calificaciones
                </p>
                <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content">
                <div class="content">
                    '.$aviso.'
                    <table class="table">
                        <thead>
                            <tr>
                                <th><abbr title="Num">No. Lista</abbr></th>
                                <th><abbr title="Nombre">Nombre</abbr></th>
                                <th><abbr title="Apellido">apellido</abbr></th>
                                <th><abbr title="Cali1">Español</abbr></th>
                                <th><abbr title="Cali2">Matemáticas</abbr></th>
                                <th><abbr title="Cali3">Historia</abbr></th>
                                <th><abbr title="Botón">Acción</abbr></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><abbr title="Num">No. Lista</abbr></th>
                                <th><abbr title="Nombre">Nombre</abbr></th>
                                <th><abbr title="Apellido">apellido</abbr></th>
                                <th><abbr title="Cali1">Español</abbr></th>
                                <th><abbr title="Cali2">Matemáticas</abbr></th>
                                <th><abbr title="Cali3">Historia</abbr></th>
                                <th><abbr title="Botón">Acción</abbr></th>
                            </tr>
                        </tfoot>
                        <tbody>';
                        $lista=0;
                        foreach($alumnos as $a)
                        {
                            $lista+=1;
                            echo'
                            <tr>
                                <th>'.$lista.'</th>
                                <td>'.$a->nombre.'</td>
                                <td>'.$a->apellido.'</td>
                                <td>'.$a->Mate.'</td>
                                <td>'.$a->español.'</td>
                                <td>'.$a->historia.'</td>
                                <td><a class="button is-link" href="eliminar.php?id_eliminar='.$a->id_miembros.'">Eliminar</a></td>
                            </tr>
                            ';
                        }
                        echo'
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    ';
    }
    else
    {
        echo"<p class='is-size-5 is-center mt-6'>No tienes permisos para estar aquí <a href='index.php'>click aquí para regresar al inicio</a></p>";
    }
}
else{
    echo"<p class='is-size-5 is-center mt-6'>Necesitas una cuenta para usar este sistema <a href='login.php'>click aquí para regresar al login</a></p>";
}

echo'
    </body>
</html>
';
?>