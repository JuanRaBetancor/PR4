<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
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
$db->exec('PRAGMA foreign_keys = ON;'); 

if(isset($_POST['OK1'])){
    $valor=$_POST['OK1'];
    $res=$db->prepare('SELECT horaentrega FROM pedidos WHERE id=?');
    $res->execute(array($valor));
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
            }
        }
    }
    if($value>0){
        echo '<br/><br/>¡El pedido ya ha sido entregado!<br/><br/>';
    }else{
        $res=$db->prepare('UPDATE pedidos SET horareparto=? WHERE id=?');
        $res->execute(array($fecha,$valor));
        echo '<meta http-equiv="refresh" content=" ; url=pedidosenproceso.php">';
    }
}

if(isset($_POST['OK2'])){
    $val=$_POST['OK2'];
    $res=$db->prepare('SELECT horareparto FROM pedidos WHERE id=?');
    $res->execute(array($val));
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
            }
        }
    }
    if($value>0){
        $res=$db->prepare('UPDATE pedidos SET horaentrega=? WHERE id=?');
        $res->execute(array($fecha,$val));
        echo '<meta http-equiv="refresh" content=" ; url=pedidosenproceso.php">';
    }else{
        echo '<br/><br/>¡El pedido todavía no está en reparto!<br/><br/>';
    }
}

$res=$db->prepare('SELECT * FROM pedidos WHERE idrepartidor=?');
$res->execute(array($idr));
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
View::end();
?>


