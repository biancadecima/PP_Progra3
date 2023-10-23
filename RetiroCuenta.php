<?php
/**6- RetiroCuenta.php: (por POST) se recibe el Tipo de Cuenta, Nro de Cuenta y Moneda
y el importe a depositar, si la cuenta existe en banco.json, se decrementa el saldo
existente según el importe extraído y se registra en el archivo retiro.json la operación
con los datos de la cuenta y el depósito (fecha, monto) e id autoincremental.
Si la cuenta no existe o el saldo es inferior al monto a retirar, informar el tipo de error. */
include './Cuenta.php';
include './Retiro.php';

function retirarCuenta(){
    if(isset($_POST["tipoCuenta"]) && isset($_POST["numeroCuenta"]) && isset($_POST["moneda"]) && isset($_POST["monto"])){
        $tipoCuenta = $_POST["tipoCuenta"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $moneda = $_POST["moneda"];
        $monto = $_POST["monto"];
        if(Cuenta::CuentaExiste($numeroCuenta) != false){
            if(Cuenta::RetirarDinero($numeroCuenta, $monto) != false){
                $retiros = Retiro::LeerJSONRetiro(); 
                $retiro = new Retiro($tipoCuenta, $numeroCuenta, $moneda, $monto);
                $retiros[] = $retiro;
                Retiro::EscribirJSONRetiro($retiros);
                echo 'Se realizo el retiro. ';
            }else{
                echo "El monto de retiro es mayor que el saldo de la cuenta";
            }
        }else{
            echo "La cuenta no existe";
        }
    }else{
        echo "Faltan parametros para el retiro de cuenta";
    }
}
?>