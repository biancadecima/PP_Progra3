<?php
include './Cuenta.php';


/*ConsultarCuenta.php: (por POST) Se ingresa Tipo y Nro. de Cuenta, si coincide con
algún registro del archivo banco.json, retornar la moneda/s y saldo de la cuenta/s. De
lo contrario informar si no existe la combinación de nro y tipo de cuenta o, si existe el
número y no el tipo para dicho número, el mensaje: “tipo de cuenta incorrecto”. */
function consultarCuenta(){
    if(!isset($_POST["tipoCuenta"]) || !isset($_POST["numeroCuenta"])){
        return 'Error. Faltan parametros para la consulta de la venta.';
    }else{
        $tipoCuenta = $_POST["tipoCuenta"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $cuentaConsultada = Cuenta::CuentaExiste($numeroCuenta);
        if($cuentaConsultada){
            if($cuentaConsultada->TipoCuentaCorresponde($tipoCuenta)){
                return 'La moneda de la cuenta consultada es '.$cuentaConsultada->moneda.' y su saldo es de '.$cuentaConsultada->saldo;
            }
            return 'Tipo de cuenta incorrecto';
        }else{
            return 'No existe la cuenta';
        }
    }
}
?>