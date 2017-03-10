<!DOCUMENT html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="estiloTables.css">
    <title>DISTRIB SL</title>
</head>
<body>
<h1>Crear nuevo pedido</h1>
<?php

include_once 'lib.php';
View::navigation();
    
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
    
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
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
    
    $count=1;
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $res=$db->prepare('SELECT marca,PVP,stock FROM bebidas');
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
    
    
    if(isset($_GET['n1']) || isset($_GET['n2']) || isset($_GET['n3']) || isset($_GET['n4']) || isset($_GET['n5']) || isset($_GET['n6']) || isset($_GET['n7'])){
        $aux=User::getLoggedUser();
        $idcliente=current($aux);
        $horacreacion=date(time());
        next($aux);
        next($aux);
        next($aux);
        next($aux);
        next($aux);
        $poblacion=current($aux);
        $direccion=next($aux);
        $PVPtotal=$_GET['n1']*1.05+$_GET['n2']*1.25+$_GET['n3']*1.75+$_GET['n4']*1.60+$_GET['n5']*1.90+$_GET['n6']*5.35+$_GET['n7']*10.75;
        $db = new PDO("sqlite:./datos.db");
        $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
        $res=$db->prepare('INSERT INTO pedidos (id,idcliente,horacreacion,poblacionentrega,direccionentrega,PVP) VALUES (?,?,?,?,?,?)');
        $res->execute(array($idpedido,$idcliente,$horacreacion,$poblacion,$direccion,$PVPtotal));
        echo '<meta http-equiv="refresh" content=" ; url=pedidosclientes.php">';
    }
    
    
    if(isset($_GET['n1'])){
        $aux=$idpedido;
        $cantidad=$_GET['n1'];
        $precio='1,05';
        $iden=1;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n2'])){
        $aux=$idpedido;
        $cantidad=$_GET['n2'];
        $precio='1,25';
        $iden=2;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n3'])){
        $aux=$idpedido;
        $cantidad=$_GET['n3'];
        $precio='1,75';
        $iden=3;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n4'])){
        $aux=$idpedido;
        $cantidad=$_GET['n4'];
        $precio='1,60';
        $iden=4;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n5'])){
        $aux=$idpedido;
        $cantidad=$_GET['n5'];
        $precio='1,90';
        $iden=5;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n6'])){
        $aux=$idpedido;
        $cantidad=$_GET['n6'];
        $precio='5,35';
        $iden=6;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
    
    if(isset($_GET['n7'])){
        $aux=$idpedido;
        $cantidad=$_GET['n7'];
        $precio='10,75';
        $iden=7;
        $cantres=0;
        $res=$db->prepare('SELECT stock FROM bebidas WHERE id=?');
        $res->execute(array($iden));
        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            foreach($res as $game){
                foreach($game as $value){
                   $cantres=$value;
                }
            }
        }
        $cantres=$cantres-$cantidad;
        $res=$db->prepare('UPDATE bebidas SET stock=? WHERE id=?');
        $res->execute(array($cantres,$iden));
        $res=$db->prepare('INSERT INTO lineaspedido (id,idpedido,idbebida,unidades,PVP) VALUES (?,?,?,?,?)');
        $res->execute(array($idline,$aux,$iden,$cantidad,$precio));
        $idline=$idline+1;
    }
?>
<br/>
<form method="get">
<fieldset>
       <legend>Lista de la compra: Cantidades</legend>
       <label for="n1">Agua artificial :<input type="number" name="n1" id="n1" size="20" /></label><br />
       <label for="n2">Poca Cola :</label><input type="number" name="n2" id="n2" size="20" /><br />
       <label for="n3">Falta naranja :<input type="number" name="n3" id="n3" size="20" /></label><br />
       <label for="n4">Six up :<input type="number" name="n4" id="n4" size="20" /></label><br />
       <label for="n5">Cerveza subtropical :<input type="number" name="n5" id="n5" size="20" /></label><br />
       <label for="n6">Vino Pinto :<input type="number" name="n6" id="n6" size="20" /></label><br />
       <label for="n7">Vino aAzul :<input type="number" name="n7" id="n7" size="20" /></label><br />
       <input type="submit" value="Enviar"/> <input type="reset" value="Limpiar" size="20" />
</fieldset>
</form>

