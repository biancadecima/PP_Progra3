<?php
$rutaImagenCuenta = 'C:\xampp\htdocs\PP_Progra3\ImagenesCuentas\2023';
$rutaImagenDeposito = 'C:\xampp\htdocs\PP_Progra3\ImagenesDepositos\2023';

switch($_SERVER['REQUEST_METHOD']){
    case "POST":
        if(isset($_POST['accion'])){
            switch($_POST['accion']){
                case 'alta':
                    include './CuentaAlta.php';
                    echo cuentaAlta($rutaImagenCuenta);
                    break;
                case 'consultar':
                    include './ConsultarCuenta.php';
                    echo consultarCuenta();
                    break;
                case 'depositar':
                    include './DepositoCuenta.php';
                    echo depositoCuenta($rutaImagenDeposito);
                    break;
                case 'retirar':
                    include './RetiroCuenta.php';
                    retirarCuenta();
                    break;
                case 'ajustar':
                    include './AjusteCuenta.php';
                    ajusteCuenta();
                    break;
                }
        }else{
            echo "Error. Faltan parametros.";
        }   
    break;
    case "PUT":
        parse_str(file_get_contents('php://input'), $_PUT);
        if(isset($_PUT['accion'])){
            switch($_PUT['accion']){
            case 'modificar':
                include './ModificarCuenta.php';
                modificarCuenta($_PUT);
                break;
            }
        }else{
            echo "Error. Faltan parametros.";
        }   
        break;
    case "GET":
        if(isset($_GET['accion'])){
            switch($_GET['accion']){
                case 'consultar':
                    include './ConsultaMovimientos.php';
                    switch($_GET["listado"]){
                        case "A":
                            echo consultaTotalDeposito();
                            break;
                        case "B":
                            consultaDepositoUsuario();
                            break;
                        case "C":
                            consultaEntreDosFechas();
                            break;
                        case "D":
                            consultaPorTipoCuenta();
                            break;
                        case "E":
                            consultaPorMoneda();
                            break;
                        default:
                            echo 'No existe el listado';
                            break;
                    }
                    break;
            }
        }else{
            echo "Error. Faltan parametros.";
        }   
        break; 
}    
?>