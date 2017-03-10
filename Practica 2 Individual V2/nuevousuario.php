<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Crear nuevo usuario</h1>

<?php
include_once 'lib.php';
View::navigation();
    $mayor=0;
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $res=$db->prepare('SELECT id FROM usuarios');
    $res->execute();
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
                if($value>$mayor){
                    $mayor=$value;
                }
            }
        }
    }
    $idlastuser=$mayor+1;

if(isset($_POST['nombre']) && isset($_POST['contra']) && isset($_POST['usuario']) && isset($_POST['tipo'])){
    echo '<br/><h4>Se ha creado correctamente</h4><br/>';
    $usuario=$_POST['usuario'];
    $clave=md5($_POST['contra']);
    $nombre=$_POST['nombre'];
    $tipo=$_POST['tipo'];
    $poblacion=$_POST['poblacion'];
    $direccion=$_POST['direccion'];
    
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $res=$db->prepare('INSERT INTO usuarios (id,usuario,clave,nombre,tipo,poblacion,direccion) VALUES (?,?,?,?,?,?,?)');
    $res->execute(array($idlastuser,$usuario,$clave,$nombre,$tipo,$poblacion,$direccion));
    echo '<meta http-equiv="refresh" content=" ; url=editarusuarios.php">';
}
?>
<br/>
<form method="post">
<fieldset>
       <legend>Datos personales</legend>
       <label for="usuario">Usuario :</label><input type="text" name="usuario" id="usuario" size="20" /><br />
       <label for="contra">Contaseña :<input type="password" name="contra" id="contra" size="20" /></label><br />
       <label for="nombre">Nombre completo :<input type="text" name="nombre" id="nombre" size="20" /></label><br />
       <label for="tipo">Tipo :</label><select name="tipo">
           <option value="1">Administrador</option>
           <option value="2">Cliente</option>
           <option value="3">Repartidor</option>
       </select><br />
       <label for="poblacion">Población :<input type="text" name="poblacion" id="poblacion" size="20" /></label><br />
       <label for="direccion">Dirección :<input type="text" name="direccion" id="direccion" size="20" /></label><br />
       <input type="submit" value="Enviar"/> <input type="reset" value="Limpiar" size="20" />
</fieldset>
</form>
<footer>
    Distrib SL ©Todos los derechos reservados contacto@distrib.com
</footer>
</body>
</html>


