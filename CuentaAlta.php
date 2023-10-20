<?php
include './Cuenta.php';
function cuentaAlta($ruta){
    if(!isset($_POST["nombre"]) || !isset($_POST["tipoDoc"]) || !isset($_POST["numeroDoc"]) || !isset($_POST["mail"]) || !isset($_POST["tipoCuenta"]) || !isset($_POST["moneda"]) || !isset($_POST["saldo"]) || !isset($_FILES["imagen"])){
        return 'Error. Faltan parametros para el alta de venta.';
    }else{
        $nombre = $_POST['nombre'];
        $tipoDoc = $_POST['tipoDoc'];
        $numeroDoc = $_POST['numeroDoc'];
        $mail =  $_POST['mail'];
        $tipoCuenta = $_POST['tipoCuenta'];
        $moneda = $_POST['moneda'];
        $saldo = $_POST['saldo'];
        $imagen = $_FILES['imagen'];
 
        $cuenta = new Cuenta($nombre, $tipoDoc, $numeroDoc, $mail, $tipoCuenta, $moneda, $saldo);
        if($cuenta->ActualizarSaldo($saldo) == false){
            $cuentas = Cuenta::LeerJSONCuenta();
            $cuentaAlta = new Cuenta($nombre, $tipoDoc, $numeroDoc, $mail, $tipoCuenta, $moneda, 0);
            $cuentas[] = $cuentaAlta;
            Cuenta::EscribirJSONCuenta($cuentas);
            $respuesta = 'Se dió de alta la cuenta. ';
            if(move_uploaded_file($imagen['tmp_name'], $cuenta->DestinoImagenCuenta($ruta))){
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