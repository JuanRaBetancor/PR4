<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Pedidos en proceso</h1>
<?php
include_once 'lib.php';
View::navigation();
$aux=User::getLoggedUser();
$idr=current($aux);
$fecha=date(time());
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$res=$db->prepare('SELECT * FROM pedidos WHERE idrepartidor=?');
$res->execute(array($idr));
$primer=true;
$primero=false;
$auxiliar=0;
$auxiliar2=0;

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
            echo "<th>En reparto</th>";
            echo "<th>Entregado</th>";
            echo "</tr>";
        }
        echo "<tr>";
        $primero=true;
        foreach($game as $value){
            echo "<td>$value</td>";
            if($primero==true){
                $auxiliar=$value;
                $auxiliar2=$value;
                $primero=false;
            }
        }
        echo "<td><form method=\"post\">
            <input class=\"boton\" type=\"submit\" value=\"$auxiliar\" name=\"OK1\" />
            </form></a></td>";
        echo "<td><form method=\"post\">
            <input class=\"boton\" type=\"submit\" value=\"$auxiliar2\" name=\"OK2\" />
            </form></a></td>";
        echo "</tr>";
    }
    echo '</table>';
    echo '<br/>';
}
 
if(isset($_POST['OK1'])){
    $valor=$_POST['OK1'];
    $res=$db->prepare('UPDATE pedidos SET horareparto=? WHERE id=?');
    $res->execute(array($fecha,$valor));
    echo '<meta http-equiv="refresh" content=" ; url=pedidosenproceso.php">';
}

if(isset($_POST['OK2'])){
    $val=$_POST['OK2'];
    $res=$db->prepare('UPDATE pedidos SET horaentrega=? WHERE id=?');
    $res->execute(array($fecha,$val));
    echo '<meta http-equiv="refresh" content=" ; url=pedidosenproceso.php">';
}

View::end();
?>


