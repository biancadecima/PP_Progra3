<?php
/**9- BorrarCuenta.php (por DELETE), debe recibir un número el tipo y número de cuenta
y debe realizar la baja de la cuenta (soft-delete, no físicamente) y la foto relacionada a
esa venta debe moverse a la carpeta /ImagenesBackupCuentas/2023. */
include './Cuenta.php';

function borrarCuenta($_DELETE, $rutaOrigen, $rutaEliminada){
    if(isset($_DELETE["tipoCuenta"]) && $_DELETE["numeroCuenta"]){
        $tipoCuenta = $_DELETE["tipoCuenta"];
        $numeroCuenta = $_DELETE["numeroCuenta"];
        if($cuentaABorrar = Cuenta::CuentaExiste($numeroCuenta)){
            $imagenOrigen = $cuentaABorrar->DestinoImagenCuenta($rutaOrigen);
            $imagenBorrada = $cuentaABorrar->DestinoImagenCuenta($rutaEliminada);
            if(rename($imagenOrigen, $imagenBorrada)){
                echo 'Se movió la imagen a backup. ';
            }else{
                echo 'No se pudo mover la imagen. ';
            }
            if(Cuenta::DesactivarCuenta($numeroCuenta)){
                echo ' Se desactivo la cuenta. ';
            }else{
                echo "no se puso desactivar la cuenta";
            }
        }
    }else{
        echo ' Faltan Parametros para desactivar la cuenta. ';
    }

}
?>