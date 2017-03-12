<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="estiloTables.css"/>
    <title>DISTRIB SL</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    </head>
    <body>
        <img src="img/IconoEmpresa.png" title="Empresa" alt="Empresa" id="logotipo" /> 
        <h1>DISTRIB SL</h1>
        <h2>Productos</h2>
        <br/>
        <nav>
            <a href="index.php">Inicio</a>
        </nav>
        
        <?php
        include_once 'lib.php';
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
        $res=$db->prepare('SELECT marca,PVP,stock FROM bebidas');
        $res->execute();
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            foreach($res as $game){
                if($first){
                    echo "<table class=\"tabla\"><tr>";
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
        View::end();
        ?>
