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
        }
        if($arrayaux[1]<$cantidad2 && !empty($_POST['n2'])){
            $nosepuede=true;
        }
        if($arrayaux[2]<$cantidad3 && !empty($_POST['n3'])){
            $nosepuede=true;
        }
        if($arrayaux[3]<$cantidad4 && !empty($_POST['n4'])){
            $nosepuede=true;
        }
        if($arrayaux[4]<$cantidad5 && !empty($_POST['n5'])){
            $nosepuede=true;
        }
        if($arrayaux[5]<$cantidad6 && !empty($_POST['n6'])){
            $nosepuede=true;
        }
        if($arrayaux[6]<$cantidad7 && !empty($_POST['n7'])){
            $nosepuede=true;
        }
        if($nosepuede==false){
            $PVPtotal=$cantidad1*1.05+$cantidad2*1.25+$cantidad3*1.75+$cantidad4*1.60+$cantidad5*1.90+$cantidad6*5.35+$cantidad7*10.75;
            $res=$db->prepare('INSERT INTO pedidos (id,idcliente,horacreacion,poblacionentrega,direccionentrega,PVP) VALUES (?,?,?,?,?,?)');
            $res->execute(array($idpedido,$idcliente,$horacreacion,$poblacion,$direccion,$PVPtotal));
            echo 'Tramitando el pedido, espere...<br/>';
            echo '<meta http-equiv="refresh" content="5; url=pedidosclientes.php">';
        }else{
            echo 'No se pudo crear el pedido. Asegúrese de que tenemos stock, para ello, compruebe la tabla de productos que aparece abajo.<br/>';
            echo 'No se pudo crear el pedido por los siguientes motivos:<br/>';
        }
    }else{
        if($stocktotal<=0){
            echo '<h4>Se nos han acabado las provisiones</h4>';
        }else{
            echo '<h4>Rellene los campos</h4>';
        }
    }
    
    
    if(!empty($_POST['n1'])){
        $aux=$idpedido;
        $cantidad=$_POST['n1'];
        $iden=1;
        $cantres=$arrayaux[0]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,1.05));
            $idline=$idline+1;
        }
    }
    
    if(!empty($_POST['n2'])){
        $cantidad=$_POST['n2'];
        $iden=2;
        $cantres=$arrayaux[1]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,1.25));
            $idline=$idline+1;
        }
    }
    
    if(!empty($_POST['n3'])){
        $cantidad=$_POST['n3'];
        $iden=3;
        $cantres=$arrayaux[2]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,1.75));
            $idline=$idline+1;       
        }
    }
    
    if(!empty($_POST['n4'])){
        $cantidad=$_POST['n4'];
        $iden=4;
        $cantres=$arrayaux[3]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,1.60));
            $idline=$idline+1;
        }
    }
    
    if(!empty($_POST['n5'])){
        $cantidad=$_POST['n5'];
        $iden=5;
        $cantres=$arrayaux[4]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,1.90));
            $idline=$idline+1;    
        }
    }
    
    if(!empty($_POST['n6'])){
        $cantidad=$_POST['n6'];
        $iden=6;
        $cantres=$arrayaux[5]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,5.35));
            $idline=$idline+1;
        }
    }
    
    if(!empty($_POST['n7'])){
        $cantidad=$_POST['n7'];
        $iden=7;
        $cantres=$arrayaux[6]-$cantidad;
        if($cantres<0){
            echo ' -No disponemos de la cantidad de bebidas deseada en stock. ID de la bebida: '.$iden.'.<br/>';
        }else{
            $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
            $res->execute(array($cantres,$iden));
            $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
            $res->execute(array($idline,$idpedido,$iden,$cantidad,10.75));
            $idline=$idline+1;
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
       <label for="n7">Vino aAzul :<input type="number" name="n7" id="n7" size="20" /></label><br />
       <input type="submit" value="Enviar"/> <input type="reset" value="Limpiar" size="20" />
</fieldset>
</form>

