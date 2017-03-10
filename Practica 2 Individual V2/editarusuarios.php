<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Usuarios dados de alta</h1>
<?php
include_once 'lib.php';
View::navigation();
echo '<a class="button white" href="nuevousuario.php">Crear Usuario</a>';
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
$res=$db->prepare('SELECT * FROM usuarios;');
$res->execute();
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
            echo "<th>Modificar</th>";
            echo "<th>Borrar</th>";
            $first = false;
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
        echo "<td><form action=\"modificarusuario.php\" method=\"get\">
            <input class=\"boton\" type=\"submit\" value=\"$auxiliar\" name=\"OK\" />
            </form></a></td>";
            
        echo "<td><form method=\"post\">
            <input class=\"boton\" type=\"submit\" value=\"$auxiliar2\" name=\"OK1\" />
            </form></a></td>";
            
        echo "</tr>";
    }
    echo '</table>';
    echo '<br/>';
}

if(isset($_POST['OK1'])){
    $res=$db->prepare('DELETE FROM usuarios WHERE id=?');
    $idu=$_POST['OK1'];
    $res->execute(array($idu));
    
    $res=$db->prepare('SELECT id FROM usuarios WHERE id=?');
    $res->execute(array($idu));
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
            }
        }
    }
    if($value==$idu){ //o distinto de null
        echo '<meta http-equiv="refresh" content=" ; url=advertencia.php">';
    }else{
        echo '<meta http-equiv="refresh" content=" ; url=editarusuarios.php">';
    }
}

View::end();
?>




