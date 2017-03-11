<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Pedidos no asignados</h1>
<?php
include_once 'lib.php';
View::navigation();
echo '<a class="button white" href="pedidosenproceso.php">Pedidos en proceso</a>';
$contador=1;
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$res=$db->prepare('SELECT * FROM pedidos WHERE idrepartidor IS NULL');
$res->execute();
$primero=false;
$auxiliar=0;
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
            echo "<th>Asignarme</th>";
            echo "</tr>";
        }
        echo "<tr>";
        $primero=true;
        foreach($game as $value){
            echo "<td>$value</td>";
            if($primero==true){
                $auxiliar=$value;
                $primero=false;
            }
        }
        echo "<td><form method=\"post\">
            <input class=\"boton\" type=\"submit\" value=\"$auxiliar\" name=\"OK\" />
            </form></a></td>";
        echo "</tr>";
    }
    echo '</table>';
    echo '<br/>';
}

$aux=User::getLoggedUser();
$idr=current($aux);
$fecha=date(time());

if(isset($_POST['OK'])){
    $valor=$_POST['OK'];
    $res=$db->prepare('UPDATE pedidos SET idrepartidor=? WHERE id=?');
    $res->execute(array($idr,$valor));
    $res=$db->prepare('UPDATE pedidos SET horaasignacion=? WHERE id=?');
    $res->execute(array($fecha,$valor));
    echo '<meta http-equiv="refresh" content=" ; url=pedidosrepartidores.php">';
}

View::end();
?>


