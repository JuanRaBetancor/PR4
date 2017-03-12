<?php
include_once 'lib.php';
    
    //Muestro el usuario loggeado
    if(User::getLoggedUser()==false){
        //NULL
    }else{
        echo 'Bienvenido: ';
        $aux=User::getLoggedUser();
        $usr=next($aux);
        echo $usr;
    }
    
//Muestro el panel de control a los usuarios que han hecho login
if(User::getLoggedUser()!=false){
    $aux=User::getLoggedUser();
    next($aux);next($aux);next($aux);
    $type=next($aux);
    if($type=="1"){
        View::navigationAdmin();
    }else{
        if($type=="2"){
            View::navigationClientes();
        }else{
            if($type=="3"){
                View::navigationRepartidores();
            }
        }
    }
}
View::start('DISTRIB SL');
View::end();
?>









