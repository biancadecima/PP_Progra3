<?php 
/*DepositoCuenta.php: (por POST) se recibe el Tipo de Cuenta, Nro de Cuenta y
Moneda y el importe a depositar, si la cuenta existe en banco.json, se incrementa el
saldo existente según el importe depositado y se registra en el archivo depósitos.json
la operación con los datos de la cuenta y el depósito (fecha, monto) e id
autoincremental). Si la cuenta no existe, informar el error.

b- Completar el depósito con imagen del talón de depósito con el nombre: Tipo de
Cuenta, Nro. de Cuenta e Id de Depósito, guardando la imagen en la carpeta
/ImagenesDeDepositos2023.*/
include './Cuenta.php';
include './Deposito.php';

function depositoCuenta($ruta){
    if(!isset($_POST["tipoCuenta"]) || !isset($_POST["numeroCuenta"]) || !isset($_POST["moneda"]) || !isset($_POST["deposito"]) || !isset($_FILES["imagen"])){
        return 'Error. Faltan parametros para la consulta de la venta.';
    }else{
        $tipoCuenta = $_POST["tipoCuenta"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $moneda = $_POST["moneda"];
        $deposito = $_POST["deposito"];
        $imagen = $_FILES["imagen"];
        if($cuenta = Cuenta::CuentaExiste($numeroCuenta)){
            $nuevoSaldo = $cuenta->saldo + $deposito;
            var_dump($nuevoSaldo);
            $cuenta->ActualizarSaldo($nuevoSaldo);
            $deposito = new Deposito($tipoCuenta, $numeroCuenta, $moneda, $deposito);
            $depositos = Deposito::LeerJSONDeposito();
            $depositos[] = $deposito;
            Deposito::EscribirJSONDeposito($depositos);
            $respuesta = 'Se depositó exitosamente. ';
            if(move_uploaded_file($imagen['tmp_name'], $deposito->DestinoImagenDeposito($ruta))){
                $respuesta = $respuesta.' '.'Se guardó la imagen';
            }else{
                $respuesta = $respuesta.' '.'La imagen no pudo ser guardada';
            }
        }else{
            return 'Cuenta no existe';
        }

        return $respuesta;
    }
}


?>