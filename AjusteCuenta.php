<?php
/**7- AjusteCuenta.php (por POST),
Se ingresa el número de extracción o depósito afectado al ajuste y el motivo del
mismo. El número de extracción o depósito debe existir.
Guardar en el archivo ajustes.json
Actualiza en el saldo en el archivo banco.json */
include './Ajuste.php';

function ajusteCuenta(){
    if(isset($_POST["idOperacion"]) && $_POST["motivo"]){
        $idOperacion = $_POST["idOperacion"];
        $motivo = $_POST["motivo"];
        if($motivo == "deposito"){
            if($deposito = Deposito::BuscarDeposito($idOperacion)){
                $ajuste = new Ajuste($idOperacion, $motivo, $deposito->deposito);
                if(Cuenta::AjustarCuenta($deposito->numeroCuenta, $deposito->deposito)){
                    $ajustes = Ajuste::LeerJSONAjuste();
                    $ajustes[] = $ajuste;
                    Ajuste::EscribirJSONAjuste($ajustes);
                    echo "El ajuste de deposito se realizó exitosamente";
                }else{
                    echo "No se encontro el numero de cuenta";
                }
                
            }else{
                echo "El deposito no existe";
            }
        }else if($motivo == "retiro"){
            if($retiro = Retiro::BuscarRetiro($idOperacion)){
                $ajuste = new Ajuste($idOperacion, $motivo, $retiro->monto);
                if(Cuenta::AjustarCuenta($retiro->numeroCuenta, (-$retiro->monto))){
                    $ajustes = Ajuste::LeerJSONAjuste();
                    $ajustes[] = $ajuste;
                    Ajuste::EscribirJSONAjuste($ajustes);
                    echo "El ajuste de retiro se realizó exitosamente";
                }else{
                    echo "No se encontro el numero de cuenta";
                }
            }else{
                echo "El retiro no existe";
            }
        }
    }else{
        echo "Parametros insufientes para el ajuste de cuenta. ";
    }
}

?>