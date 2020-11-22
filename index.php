<?php
require_once 'functions.php';
use Illuminate\Database\Capsule\Manager as DB;

echo'
<body>
';

$error = $A_name = $name2 = $apellido = $apellido2 = "";

if(isset($_POST['nombre']))
{
    $A_name = sanitizeString($_POST['nombre']);
    $name2 = sanitizeString($_POST['nombre2']);
    $apellido = sanitizeString($_POST['apellido']);
    $apellido2 = sanitizeString($_POST['apellido2']);

    if($A_name == "" || $apellido == "" || $apellido2 == "")
    {
        $error = '<p class="is-size-5">Falta algún dato</p>';
    }
    else
    {
        $usuario = $A_name.$apellido;
        strtolower($usuario);
        $usuario = str_replace(" ", "", $usuario);

        $validar = DB::table('miembros')->where('usuario',$usuario)->first();

        if(!$validar)
        {
            $nombreC = $A_name . " " . $name2;
            $apellidoC =  $apellido . " " . $apellido2;
            $registrar = DB::table('miembros')->insertGetId(
                ['usuario' => $usuario, 'contra' => "escuela123", 'rol' => '2', 'nombre' => $nombreC, 'apellido' => $apellidoC]
            );

            die('<p class="is-size-4 is-center mt-6">Haz agregado un alumno, <a href="index.php">click aquí para regresar al sistema</a></p>
            </div></body></html>');
        }
        else
        {
            $error = "<p class='is-size-5'>Ese alumno ya ha sido regstrado</>";
            $A_name = "";
        }
    }
}

if($loggedin){
    require_once 'header.php';
    echo'
    <div class="container">
    ';

    if($rol == 1)
    {
        echo'
        <div class="card mt-6 mb-6">
            <header class="card-header">
                <p class="card-header-title">
                    Ingresa los datos para registrar a un alumno (el usuario será el primer nombre y apellido sin espacios en minúsculas y la contraseña "escuela123")
                </p>
                <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content">
                <div class="content">
                    <form method="post" action="index.php">
                        <div class="field">
                            '.$error.'
                            <label class="label mt-4">Nombre</label>
                            <div class="control">
                                <input class="input" type="text" maxlength="45" name="nombre" placeholder="Nombre" value="'. $A_name .'">
                            </div>
                            <label class="label mt-4">Segundo nombre</label>
                            <div class="control">
                                <input class="input" type="text" maxlength="45" name="nombre2" placeholder="Segundo nombre" value="'. $name2 .'">
                            </div>
                            <label class="label mt-4">Apellido Paterno</label>
                            <div class="control">
                                <input class="input" type="text" maxlength="45" name="apellido" placeholder="Apellido Paterno" value="'. $apellido .'">
                            </div>
                            <label class="label mt-4">Apellido Materno</label>
                            <div class="control">
                                <input class="input" type="text" maxlength="45" name="apellido2" placeholder="Apellido Materno" value="'. $apellido2 .'">
                            </div>
                        </div>
                        <button type="submit" class="button is-link mt-3">Registrar alumno</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    ';
    }
    else
    {
        $calificaciones = DB::table('calificaciones')->where('miembros_id_miembros', $id)->first();

        echo'
        <div class="card mt-6 mb-6">
            <header class="card-header">
                <p class="card-header-title">
                    Calificaciones y promedio general
                </p>
                <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content">
                <div class="content">';

                if($calificaciones)
                {
                    $esp = $calificaciones->español;
                    $hist = $calificaciones->historia;
                    $mate = $calificaciones->Mate;
                    $promedio = ($mate+$hist+$esp)/3;
                    echo'
                        <form>
                                <label class="label mt-4">Español</label>
                                <div class="control">
                                    <input class="input" type="number" max="10" name="esp" placeholder="Español" value="'. $esp .'" readonly>
                                </div>
                                <label class="label mt-4">Matemáticas</label>
                                <div class="control">
                                    <input class="input" type="number" max="10" name="mate" placeholder="Matemáticas" value="'. $mate .'" readonly>
                                </div>
                                <label class="label mt-4">Historia</label>
                                <div class="control">
                                    <input class="input" type="number" max="10" name="hist" placeholder="Historia" value="'. $hist .'" readonly>
                                </div>
                                <label class="label mt-6">Promedio General</label>
                                <div class="control">
                                    <input class="input" type="number" max="10" name="hist" value="'. $promedio .'" readonly>
                                </div>
                            </div>
                        </form>
                        ';
                }
                else
                {
                    echo'
                    <p class="is-size-4 is-center">No tienes calificaciones, por favor, contacta con tu profesor</p>
                    ';
                }
            echo'
                </div>
            </div>
        </div>
    </div>
    ';
    }
}
else{
    echo"<p class='is-size-5 is-center mt-6'>Necesitas una cuenta para usar este sistema <a href='login.php'>click aquí para regresar al login</a></p>";
}

echo'
    </body>
</html>
';