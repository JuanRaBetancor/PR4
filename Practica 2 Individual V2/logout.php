<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilos.css">
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
    echo 'Se ha cerrado la sesión correctamente<br/><br/>';
    echo '<meta http-equiv="refresh" content=" ; url=index.php">';
}
View::end();
?>