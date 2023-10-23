<?php
/**ModificarCuenta.php (por PUT)
Debe recibir todos los datos propios de una cuenta (a excepción del saldo); si dicha
cuenta existe (comparar por Tipo y Nro. de Cuenta) se modifica, de lo contrario
informar que no existe esa cuenta. */
include './Cuenta.php';
function modificarCuenta(){
    if(isset($_POST["numeroCuenta"]) && isset($_POST["nombre"]) && isset($_POST["tipoDoc"]) && isset($_POST["numeroDoc"]) && isset($_POST["mail"]) && isset($_POST["tipoCuenta"]) && isset($_POST["moneda"])){
        $numeroCuenta = $_POST["numeroCuenta"];
        $nombre = $_POST["nombre"];
        $tipoDoc = $_POST["tipoDoc"];
        $numeroDoc = $_POST["numeroDoc"];
        $mail = $_POST["mail"];
        $tipoCuenta = $_POST["tipoCuenta"];
        $moneda = $_POST["moneda"];
        
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
