<?php
class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
<html>
<head>
<meta charset=\"utf-8\">
<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"img/icono.ico\"/>
<link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
<script src=\"scripts.js\"></script>
<title>$title</title>
</head>
<body>
<img src=\"img/IconoEmpresa.png\" title=\"Distrib SL\" alt=\"Empresa\" id=\"logotipo\"/> 
<h1>DISTRIB SL</h1> 
<h2>Empresa distribuidora</h2>
<nav>
<a href=\"contacto.html\">Contáctenos</a>
<a href=\"inicioSesión.php\">Iniciar sesión</a>
</nav><br/>
<img src=\"img/almacen.jpg\" title=\"Almacen Arinaga\" alt=\"Almacen\" class=\"imagenes\"/> 
<img src=\"img/fachada.jpg\" title=\"Ubicación\" alt=\"Ubicación\" class=\"imagenes\"/>
<p class=\"texto\"><b>DISTRIB S.L.</b> tiene como misión ofrecer valor añadido a sus clientes, proveedores, marcas representadas y nuestros propios
accionistas, a traves del suministro, registro y distribución de bebidas y servicios asociados como transporte en el territorio nacional.
</p>
<blockquote class=\"texto\">La División de Bebidas de <b>DISTRIB SL</b> es un proveedor fiable, flexible y competitivo que ofrece a sus clientes un amplio
espectro de productos y <i>servicios dentro del mundo de la distribución</i>. 
</blockquote>
<br/><br/><br/>
<blockquote class=\"texto\">También disponemos de un alamacén donde administramos la mercancía y dónde también organizamos los pedidos a nuestros clientes, para ello
tenemos una flota de vehículos a nuestra disposición, tales como camiones y furgonetas para la correcta distribución.
</blockquote>
<br/>";
User::session_start();
echo $html;
    }
    public static function navigation(){
        echo '<nav>';
        echo '<a href="contacto.html">Contáctenos</a>'; 
        echo '<a href="index.php">Inicio</a>';
        echo '</nav><br/>';
    }
    public static function navigationAdmin(){
        echo '<nav class="panel">';
        echo '<a href="logout.php">Logout</a>';
        echo '<a href="editarusuarios.php">Editar usuarios</a>';
        echo '</nav><br/>';
    }
    public static function navigationClientes(){
        echo '<nav class="panel">';
        echo '<a href="logout.php">Logout</a>';
        echo '<a href="pedidosclientes.php">Pedidos</a>';
        echo '<a href="nuevopedido.php">Nuevo Pedido</a>';
        echo '<a href="tabla.php">Bebidas</a>';
        echo '</nav><br/>';
    }
    public static function navigationRepartidores(){
        echo '<nav class="panel">';
        echo '<a href="logout.php">Logout</a>';
        echo '<a href="pedidosrepartidores.php">Pedidos</a>';
        echo '</nav><br/>';
    }
    public static function end(){
        echo '<footer>Distrib SL  ©Todos los derechos reservados  contacto@distrib.com</footer>';
        echo '</body>
</html>';
    }
}

class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = $db = new PDO("sqlite:./datos.db");
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
        try {
            $db = $this->get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            echo '<h1>Error en al DB: ' . $e->getMessage() . '</h1>';
        }
        return $false;
    }
}
class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos del cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($usuario,$pass){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE usuario=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        return false;
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }
}
