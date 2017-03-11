<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Detalles de pedidos</h1>
<?php
include_once 'lib.php';
View::navigation();
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$auxi=User::getLoggedUser();
$user=current($auxi);
$res=$db->prepare('SELECT id FROM pedidos WHERE idcliente=?');
$res->execute(array($user));

if($res){
    $res->setFetchMode(PDO::FETCH_NAMED);
    foreach($res as $game){
        foreach($game as $valor){
            $res2=$db->prepare('SELECT * FROM lineaspedido WHERE idpedido=?');
            $res2->execute(array($valor));
            if($res2){
                $res2->setFetchMode(PDO::FETCH_NAMED);
                $first=true;
                foreach($res2 as $game){
                    if($first){
                        echo '<b>Pedido con ID: </b>'.$valor;
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
        }
    }
}

View::end();
?>