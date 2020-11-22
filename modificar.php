<?php
require_once 'functions.php';
use Illuminate\Database\Capsule\Manager as DB;

$error = $esp = $mate = $hist = "";

echo'
<body>
';


if($loggedin)
{
    require_once 'header.php';
    if($rol == 1)
    {

        if(isset($_POST['alumno']))
        {
            $alumno = sanitizeString($_POST['alumno']);
            $esp = sanitizeString($_POST['esp']);
            $hist = sanitizeString($_POST['hist']);
            $mate = sanitizeString($_POST['mate']);

            if($esp == "" || $hist == "" || $mate == "")
            {
                $error = '<p class="is-size-5">Falta algún dato</p>';
            }
            else
            {
                $verificar_alumno = DB::table('calificaciones')->where('miembros_id_miembros', $alumno)->first();

                if($verificar_alumno)
                {
                    $nueva_calificación = DB::table('calificaciones')
                    ->where('miembros_id_miembros', $alumno)
                    ->update(['español' => $esp, 'Mate' => $mate, 'historia' => $hist]);

                    if($nueva_calificación)
                    {
                        die('<p class="is-size-4 is-center mt-6">Haz modificado las calificaciones de un alumno, <a href="modificar.php">click aquí para regresar al sistema</a></p>
                        </div></body></html>');
                    }
                    else
                    {
                        $error = "Ese alumno ya tiene calificaciones";
                    }
                }
                else
                {
                    $nueva_calificación = DB::table('calificaciones')->insert(
                        ['miembros_id_miembros' => $alumno, 'español'=>$esp, 'historia'=>$hist, 'Mate'=>$mate]
                    );

                    if($nueva_calificación)
                    {
                        die('<p class="is-size-4 is-center mt-6">Ha agregado las calificaciones de un alumno, <a href="modificar.php">click aquí para regresar al sistema</a></p>
                        </div></body></html>');
                    }
                }
            }
        }

        $alumnos = DB::table('miembros')
        ->leftJoin('calificaciones', 'miembros.id_miembros', '=', 'calificaciones.miembros_id_miembros')
        ->where('miembros.id_miembros','<>',1)
        ->orderBy('apellido')
        ->get();

        echo'
        <div class="container">
            <div class="card mt-6 mb-6">
                <header class="card-header">
                    <p class="card-header-title">
                        Selecciona a un alumno
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
                        <span class="icon">
                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </a>
                </header>
                <div class="card-content">
                    <div class="content">
                        <form method="post" action="modificar.php">
                            '.$error.'
                            <div class="field">
                                <label class="label">Alumno</label>
                                <div class="control">
                                    <div class="select is-medium">
                                        <select name="alumno">
        ';
                                            foreach($alumnos as $a)
                                            {
                                                echo'<option value="'.$a->id_miembros.'">'. $a->nombre . " " . $a->apellido .'</option>';
                                            }
        echo'
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label class="label mt-4">Español</label>
                            <div class="control">
                                <input class="input" type="number" max="10" name="esp" placeholder="Español" value="'. $esp .'">
                            </div>
                            <label class="label mt-4">Matemáticas</label>
                            <div class="control">
                                <input class="input" type="number" max="10" name="mate" placeholder="Matemáticas" value="'. $mate .'">
                            </div>
                            <label class="label mt-4">Historia</label>
                            <div class="control">
                                <input class="input" type="number" max="10" name="hist" placeholder="Historia" value="'. $hist .'">
                            </div>
                            <button type="submit" class="button is-link mt-5">Actualizar</button>
                        </form>
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