<?php
@ob_start();
session_start();

use Illuminate\Database\Capsule\Manager as DB;
require 'vendor/autoload.php';
require 'config/database.php';

echo '
<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">

        <link rel="stylesheet" href="css/style.css">

        <title>Sistema escolar</title>
    </head>
';

if(isset($_SESSION['user'])){
    $user     = $_SESSION['user'];
    $loggedin = TRUE;

    $users = DB::table('miembros')->where('usuario','=',$user)->first();

    $nombre = $users->nombre;
    $ape = $users->apellido;
    $rol = $users->rol;
    $id = $users->id_miembros;

}else $loggedin = FALSE;

function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}
?>