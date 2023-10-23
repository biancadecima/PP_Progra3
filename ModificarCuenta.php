<?php
/**ModificarCuenta.php (por PUT)
Debe recibir todos los datos propios de una cuenta (a excepción del saldo); si dicha
cuenta existe (comparar por Tipo y Nro. de Cuenta) se modifica, de lo contrario
informar que no existe esa cuenta. */
include './Cuenta.php';
function modificarCuenta($_PUT){
   // parse_str(file_get_contents('php://input'), $_PUT);
    if(isset($_PUT["numeroCuenta"]) && isset($_PUT["nombre"]) && isset($_PUT["tipoDoc"]) && isset($_PUT["numeroDoc"]) && isset($_PUT["mail"]) && isset($_PUT["tipoCuenta"]) && isset($_PUT["moneda"])){
        $numeroCuenta = $_PUT["numeroCuenta"];
        $nombre = $_PUT["nombre"];
        $tipoDoc = $_PUT["tipoDoc"];
        $numeroDoc = $_PUT["numeroDoc"];
        $mail = $_PUT["mail"];
        $tipoCuenta = $_PUT["tipoCuenta"];
        $moneda = $_PUT["moneda"];

        if(Cuenta::ModificarCuenta($numeroCuenta, $tipoCuenta, $nombre, $tipoDoc, $numeroDoc, $mail, $moneda)){
            echo 'Se modificó exitosamente la cuenta';
        }else{
            echo 'No existe la cuenta';
        }
    }else{
        echo "Parametros insuficientes para modificar cuenta. ";
    }
}
?>
