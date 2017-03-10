<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Pedidos</h1>
<?php
include_once 'lib.php';
View::navigation();
echo '<a class="button white" href="detallespedidos.php">Detalles pedidos</a>';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$auxi=User::getLoggedUser();
$user=current($auxi);
$res=$db->prepare('SELECT * FROM pedidos WHERE idcliente=?');
$res->execute(array($user));
//Ejemplo de lectura de tabla
if($res){
    $res->setFetchMode(PDO::FETCH_NAMED);
    $first=true;
    foreach($res as $game){
        if($first){
            echo "<table><tr>";
            foreach($game as $field=>$value){
                echo "<th>$field</th>";
            }
            $first = false;
            echo "</tr>";
        }
        echo "<tr>";
        foreach($game as $value){
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo '</table>';
    echo '<br/>';
}
?>
</body>
<footer>
    Distrib SL ©Todos los derechos reservados contacto@distrib.com
</footer>
</html>
