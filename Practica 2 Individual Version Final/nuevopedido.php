<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <link rel="shortcut icon" type="image/x-icon" href="img/icono.ico"/>
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Crear nuevo pedido</h1>
<?php

include_once 'lib.php';
View::navigation();
    
    //Obtengo el id del ultimo pedido
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $res=$db->prepare('SELECT id FROM pedidos');
    $res->execute();
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
            }
        }
    }
    $idpedido=$value+1;
    
    //Obtengo el ultimo id de la linea de pedidos
    $res=$db->prepare('SELECT id FROM lineaspedido');
    $res->execute();
    if($res){
        $res->setFetchMode(PDO::FETCH_NAMED);
        foreach($res as $game){
            foreach($game as $value){
                //Recorro hasta el ultimp id
            }
        }
    }
    $idline=$value+1;
    
    //Almaceno el stock actual en un array y su suma
    $arrayaux=array();
    $stocktotal=0;
    $res=$db->prepare('SELECT stock FROM bebidas');
        $res->execute();
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $arrayaux[]=$value;
                   $stocktotal+=$value;
                }
            }
        }
    
    //Mostramos todas las bebidas
    $res=$db->prepare('SELECT * FROM bebidas');
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
    }
    
    //compruebo si hay stock y al menos una petición
    if($stocktotal>0 && (!empty($_POST['n1']) || !empty($_POST['n2']) || !empty($_POST['n3']) || !empty($_POST['n4']) || !empty($_POST['n5']) || !empty($_POST['n6']) || !empty($_POST['n7']))){
        $aux=User::getLoggedUser();
        $idcliente=current($aux);
        $nosepuede=false;
        $horacreacion=date(time());
        next($aux);next($aux);next($aux);next($aux);next($aux);
        $poblacion=current($aux);$direccion=next($aux);
        $cantidad1=$_POST['n1'];$cantidad2=$_POST['n2'];$cantidad3=$_POST['n3'];$cantidad4=$_POST['n4'];$cantidad5=$_POST['n5'];$cantidad6=$_POST['n6'];
        $cantidad7=$_POST['n7'];
        //Compruebo si sobrepasa el stock actual
        if($arrayaux[0]<$cantidad1 && !empty($_POST['n1'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 1<br/>';
        }
        if($arrayaux[1]<$cantidad2 && !empty($_POST['n2'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 2<br/>';
        }
        if($arrayaux[2]<$cantidad3 && !empty($_POST['n3'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 3<br/>';
        }
        if($arrayaux[3]<$cantidad4 && !empty($_POST['n4'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 4<br/>';
        }
        if($arrayaux[4]<$cantidad5 && !empty($_POST['n5'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 5<br/>';
        }
        if($arrayaux[5]<$cantidad6 && !empty($_POST['n6'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 6<br/>';
        }
        if($arrayaux[6]<$cantidad7 && !empty($_POST['n7'])){
            $nosepuede=true;
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: 7<br/>';
        }
        if($nosepuede==false){
            $PVPtotal=$cantidad1*1.05+$cantidad2*1.25+$cantidad3*1.75+$cantidad4*1.60+$cantidad5*1.90+$cantidad6*5.35+$cantidad7*10.75;
            $res=$db->prepare('INSERT INTO pedidos (id,idcliente,horacreacion,poblacionentrega,direccionentrega,PVP) VALUES (?,?,?,?,?,?)');
            $res->execute(array($idpedido,$idcliente,$horacreacion,$poblacion,$direccion,$PVPtotal));
            echo 'Tramitando el pedido, espere...<br/>';
            
            //LINEAS DE PEDIDOS
            if(!empty($_POST['n1'])){
                $cantidad=$_POST['n1'];
                $iden=1;
                $cantres=$arrayaux[0]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,1));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,1,$cantidad,1.05));
                $idline=$idline+1;
            }
    
            if(!empty($_POST['n2'])){
                $cantidad=$_POST['n2'];
                $cantres=$arrayaux[1]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,2));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,2,$cantidad,1.25));
                $idline=$idline+1;
            }
    
            if(!empty($_POST['n3'])){
                $cantidad=$_POST['n3'];
                $cantres=$arrayaux[2]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,3));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,3,$cantidad,1.75));
                $idline=$idline+1;       
            }
            
            if(!empty($_POST['n4'])){
                $cantidad=$_POST['n4'];
                $cantres=$arrayaux[3]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,4));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,4,$cantidad,1.60));
                $idline=$idline+1;
            }
            
            if(!empty($_POST['n5'])){
                $cantidad=$_POST['n5'];
                $cantres=$arrayaux[4]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,5));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,5,$cantidad,1.90));
                $idline=$idline+1;    
            }
            
            if(!empty($_POST['n6'])){
                $cantidad=$_POST['n6'];
                $cantres=$arrayaux[5]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,6));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,6,$cantidad,5.35));
                $idline=$idline+1;
            }
            
            if(!empty($_POST['n7'])){
                $cantidad=$_POST['n7'];
                $cantres=$arrayaux[6]-$cantidad;
                $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
                $res->execute(array($cantres,7));
                $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
                $res->execute(array($idline,$idpedido,7,$cantidad,10.75));
                $idline=$idline+1;
            }
            //FIN LINEAS PEDIDO
            echo '<meta http-equiv="refresh" content="5; url=pedidosclientes.php">';
        }else{
            echo 'Debido a los motivos nombrados anteriormente no se ha podido crear el pedido.<br/>';
            echo 'Asegúrese de que tenemos stock, para ello, compruebe la tabla de productos que aparece abajo.<br/>';
        }
    }else{
        if($stocktotal<=0){
            echo '<h4>Se nos han acabado las provisiones</h4>';
        }else{
            echo '<h4>Rellene los campos</h4>';
        }
    }
?>
<br/>
<form method="post">
<fieldset>
       <legend>Lista de la compra: Cantidades</legend>
       <label for="n1">Agua artificial :<input type="number" name="n1" id="n1" size="20" /></label><br />
       <label for="n2">Poca Cola :</label><input type="number" name="n2" id="n2" size="20" /><br />
       <label for="n3">Falta naranja :<input type="number" name="n3" id="n3" size="20" /></label><br />
       <label for="n4">Six up :<input type="number" name="n4" id="n4" size="20" /></label><br />
       <label for="n5">Cerveza subtropical :<input type="number" id="n5" name="n5" size="20" /></label><br />
       <label for="n6">Vino Pinto :<input type="number" name="n6" id="n6" size="20" /></label><br />
       <label for="n7">Vino Azul :<input type="number" name="n7" id="n7" size="20" /></label><br />
       <input type="submit" value="Enviar"/> <input type="reset" value="Limpiar" size="20" />
</fieldset>
</form>
</body>
</html>
