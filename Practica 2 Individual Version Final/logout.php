<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    <title>DISTRIB SL</title>
</head>
<body>
    <h1>Cerrar sesión</h1>
    <br/>
</body>
</html>
<?php
include_once 'lib.php';
View::navigation();
User::logout();
if(User::getLoggedUser()==false){
    echo 'Se ha cerrado la sesión correctamente<br/>Redireccionando a la página principal...<br/><br/>';
    echo '<meta http-equiv="refresh" content="3; url=index.php">';
}
View::end();
?>