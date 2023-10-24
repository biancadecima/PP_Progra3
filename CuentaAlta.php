<?php
include './Cuenta.php';

/*8-CuentaAlta.php:
a- La validación de cuenta existente deberá hacerse considerando los atributos:
nro de cuenta y tipo de cuenta que deben ser únicos en el sistema.
b- Se debe adecuar la lógica desarrollada para permitir el ingreso por parámetro
opcional de saldo, que permita definir un saldo inicial en el alta de la cuenta.
c- Se identificó una mejora funcional por la que el atributo “tipo de cuenta”
contendrá la moneda siendo CA$ para caja de ahorro en pesos, CAU$S para caja
de ahorro en dólares y CC$ y CCU$S para las mismas variantes de Cuenta
Corriente
IMPORTANTE: verificar y adecuar todos los puntos funcionales donde estos cambios
pueden impactar.*/
function cuentaAlta($ruta){
    if(!isset($_POST["nombre"]) || !isset($_POST["tipoDoc"]) || !isset($_POST["numeroDoc"]) || !isset($_POST["mail"]) || !isset($_POST["tipoCuenta"]) || !isset($_POST["moneda"]) /*|| !isset($_POST["saldo"])*/ || !isset($_FILES["imagen"])){
        return 'Error. Faltan parametros para el alta de venta.';
    }else{
        $nombre = $_POST['nombre'];
        $tipoDoc = $_POST['tipoDoc'];
        $numeroDoc = $_POST['numeroDoc'];
        $mail =  $_POST['mail'];
        $tipoCuenta = $_POST['tipoCuenta'];
        $moneda = $_POST['moneda'];
        if(isset($_POST["saldo"])){
            $saldo = $_POST['saldo'];
        }else{
            $saldo = 0;
        }
        $imagen = $_FILES['imagen'];
 
        $cuenta = new Cuenta($nombre, $tipoDoc, $numeroDoc, $mail, $tipoCuenta, $moneda, $saldo);
        if($cuenta->ActualizarSaldo($saldo) == false){
            $cuentas = Cuenta::LeerJSONCuenta();
            $cuentaAlta = new Cuenta($nombre, $tipoDoc, $numeroDoc, $mail, $tipoCuenta, $moneda, $saldo);
            $cuentas[] = $cuentaAlta;
            Cuenta::EscribirJSONCuenta($cuentas);
            $respuesta = 'Se dió de alta la cuenta. ';
            if(move_uploaded_file($imagen['tmp_name'], $cuentaAlta->DestinoImagenCuenta($ruta))){
                $respuesta = $respuesta.' '.'Se guardó la imagen';
            }else{
                $respuesta = $respuesta.' '.'La imagen no pudo ser guardada';
            }
        }else{
           $respuesta = 'La cuenta ya existe, y su saldo fue actualizado'; 
        }   
    }

    return $respuesta; 
}

?>