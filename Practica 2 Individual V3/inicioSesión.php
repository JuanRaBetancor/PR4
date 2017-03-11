<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Iniciar sesión</h1>

<?php
include_once 'lib.php';
View::navigation();

if(isset($_GET['nombre'])){
    if(User::login($_GET['nombre'],$_GET['contra'])==true){
        echo '<br/> Se ha inciado sesión correctamente';
        echo '<br/>';
        if(User::getLoggedUser()==false){
        }else{
            echo 'Sesión iniciada. Bienvenido: ';
            $aux=User::getLoggedUser();
            next($aux);
            echo current($aux);
            echo '<br/>Redireccionando a la página principal<br/><br/>';
            echo '<meta http-equiv="refresh" content="3; url=index.php">';
        }
    }else{
        echo 'Error, el usuario o la contraseña no existe. Intente de nuevo <br/>';
    }
}
?>

<br/>
<form method="get">
<fieldset>
       <legend>Datos personales</legend>
       <label for="nombre">Nombre :</label>
       <input type="text" name="nombre" id="nombre" size="20" /><br />
       <label for="contra">Contaseña :<input type="password" name="contra" id="contra" size="20" /></label><br />
       <input type="submit" value="Enviar"/> <input type="reset" value="Limpiar" size="20" />
</fieldset>
</form>
<br/>
<footer>
    Distrib SL ©Todos los derechos reservados contacto@distrib.com
</footer>
</body>
</html>