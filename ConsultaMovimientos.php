<?php

include './Deposito.php';
/**4- ConsultaMovimientos.php: (por GET)
Datos a consultar:
a- El total depositado (monto) por tipo de cuenta y moneda en un día en
particular (se envía por parámetro), si no se pasa fecha, se muestran las del día
anterior.
b- El listado de depósitos para un usuario en particular.
c- El listado de depósitos entre dos fechas ordenado por nombre.
d- El listado de depósitos por tipo de cuenta.
e- El listado de depósitos por moneda. */
function consultaTotalDeposito(){
    if(isset($_GET["tipoCuenta"]) && isset($_GET["moneda"])){
        $tipoCuenta = $_GET["tipoCuenta"];
        $moneda = $_GET["moneda"];
        if(isset($_GET["fecha"])){
            $fecha = $_GET["fecha"];
            
            $totalDeposito = Deposito::DepositoPorCuentaYMoneda($tipoCuenta,$moneda,$fecha);
           
            if($totalDeposito > 0){
                return "El total de depositos por tipo de cuenta y moneda en la fecha ingresada es de: ".$totalDeposito;
            }else{
                return 'No se encontraron coincidencias con el tipo de cuenta, moneda y fecha de deposito';
            }
        }else{
            $fechaAnterior = date("d-m-Y", strtotime(date("d-m-Y") . "-1 day"));
            $totalDeposito = Deposito::DepositoPorCuentaYMoneda($tipoCuenta, $moneda, $fechaAnterior);
            if($totalDeposito > 0){
                return "El total de depositos por tipo de cuenta y moneda en la fecha del dia anterios es de: ".$totalDeposito;
            }else{
                return 'No se encontraron coincidencias con el tipo de cuenta, moneda y fecha de deposito';
            }
        }
    }else{
        return "Parametros insuficientes para la consulta A";
    }
}

function consultaDepositoUsuario(){
    if(isset($_GET["numeroCuenta"])){
        $numeroCuenta = $_GET["numeroCuenta"];
        $depositos = Deposito::DepositosPorUsuario($numeroCuenta);
        if($depositos != false){
            Deposito::MostrarDepositos($depositos);
        }
    }else{
        echo "Parametros insuficientes para la consulta B";
    }
}

function consultaEntreDosFechas(){
    if(isset($_GET["fechaUno"]) && isset($_GET["fechaDos"])){
        $fechaUno = $_GET["fechaUno"];
        $fechaDos = $_GET["fechaDos"];

        $depositosEntreFechas = Deposito::FiltrarDepositosPorFecha($fechaUno, $fechaDos);
        $depositosOrdenados = Deposito::OrdenarDepositosPorNumeroCuenta($depositosEntreFechas);
        Deposito::MostrarDepositos($depositosOrdenados);
    }else{
        echo "Parametros insuficientes para la consulta C";
    }
}

function consultaPorTipoCuenta(){
    if(isset($_GET["tipoCuenta"])){
        $tipo = $_GET["tipoCuenta"];
        $depositosPorTipo = array();
        $depositos = Deposito::LeerJSONDeposito();
        foreach($depositos as $deposito){
            if($deposito->tipoCuenta == $tipo){
                array_push($depositosPorTipo, $deposito);
            }    
        }
        Deposito::MostrarDepositos($depositosPorTipo); 
    }else{
        echo "Parametros insuficientes para la consulta D";
    }
} 

function consultaPorMoneda(){
    if(isset($_GET["moneda"])){
        $moneda = $_GET["moneda"];
        $depositosPorMoneda = array();
        $depositos = Deposito::LeerJSONDeposito();
        foreach($depositos as $deposito){
            if($deposito->moneda == $moneda){
                array_push($depositosPorMoneda, $deposito);
            }    
        }
        Deposito::MostrarDepositos($depositosPorMoneda); 
    }else{
        echo "Parametros insuficientes para la consulta E";
    }
}



?>