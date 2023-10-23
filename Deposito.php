<?php
class Deposito{
    public $id;
    public $tipoCuenta;
    public $numeroCuenta;
    public $moneda;
    public $deposito;
    public $fecha;

    public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct4($tipoCuenta, $numeroCuenta, $moneda, $deposito){
        $this->id = rand(100, 999);
        $this->tipoCuenta = $tipoCuenta;
        $this->numeroCuenta = $numeroCuenta;
        $this->moneda = $moneda;
        $this->deposito = $deposito;
        $this->fecha = date("d-m-Y");
    }

    public function __construct6($id, $tipoCuenta, $numeroCuenta, $moneda, $deposito, $fecha){
        $this->id = $id;
        $this->tipoCuenta = $tipoCuenta;
        $this->numeroCuenta = $numeroCuenta;
        $this->moneda = $moneda;
        $this->deposito = $deposito;
        $this->fecha = $fecha;
    }

    public static function LeerJSONDeposito(){
        $pathJSON = './depositos.json';
        if(file_exists($pathJSON)){
            $depositos = json_decode(file_get_contents($pathJSON), true);
            if($depositos != null){
                $depositosObj = array();
                foreach($depositos as $deposito){
                    $depositoObj = new Deposito($deposito['id'], $deposito['tipoCuenta'], $deposito['numeroCuenta'], $deposito['moneda'], $deposito['deposito'], $deposito['fecha']); 
                    $depositosObj[] = $depositoObj;
                }
                return $depositosObj;
            }  
        }
        return [];
    }

    public static function EscribirJSONDeposito($depositos){
        if(file_put_contents('depositos.json', json_encode($depositos)) != false){
            return true;
        }
        
        return false;
    }

    public function DestinoImagenDeposito($ruta){
        $destino = $ruta."\\".$this->tipoCuenta."-".$this->numeroCuenta."-".$this->id.".png";
        return $destino;
    }
    
    public static function DepositoPorCuentaYMoneda($tipoCuenta, $moneda, $fecha){
        $total = 0;
        $depositos = Deposito::LeerJSONDeposito();
        if(count($depositos)>0){
            foreach($depositos as $deposito){
                if($deposito->tipoCuenta == $tipoCuenta && $deposito->fecha == $fecha && $deposito->moneda == $moneda){
                    $total += $deposito->deposito;
                }
            }
            return $total;
        }
    }

    public static function DepositosPorUsuario($numeroCuenta){
        $depositosUsuario = array();
        $depositos = Deposito::LeerJSONDeposito();
        if(count($depositos)>0){
            foreach($depositos as $deposito){
                if($deposito->numeroCuenta == $numeroCuenta){
                    array_push($depositosUsuario, $deposito);
                }
            }
            return $depositosUsuario;
        }
        return false;
    } 

    public static function MostrarDepositos($depositos){
        if(count($depositos)>0){
            foreach($depositos as $deposito){
                echo "ID: ", $deposito->id, "\n";
                echo "Tipo Cuenta: ", $deposito->tipoCuenta, "\n";
                echo "Numero Cuenta: ", $deposito->numeroCuenta, "\n";
                echo "Moneda: ", $deposito->moneda, "\n";
                echo "Deposito: ", $deposito->deposito, "\n";
                echo "Fecha: ", $deposito->fecha, "\n\n";
            }
        }
    }

    public function FechaDentroRango($fechaInicio, $fechaLimite)
    {
        $fechaDeposito = strtotime($this->fecha);
        $inicio = strtotime($fechaInicio);
        $fin = strtotime($fechaLimite);
        if($fechaDeposito >= $inicio && $fechaDeposito <=$fin)
        {
            return true;
        }
        return false;
    }
    public static function FiltrarDepositosPorFecha($fechaInicio, $fechaLimite)
    {
        $nuevoArrayFiltrado = array();
        $depositos = Deposito::LeerJSONDeposito();
        if(count($depositos) > 0)
        {
            foreach($depositos as $deposito){
                if($deposito->FechaDentroRango($fechaInicio, $fechaLimite)){
                    array_push($nuevoArrayFiltrado, $deposito);
                }
            }
        }
        return $nuevoArrayFiltrado;
    }

    public static function CompararNumeroCuenta($a, $b){
        return $a->numeroCuenta > $b->numeroCuenta;
    }
    public static function OrdenarDepositosPorNumeroCuenta($depositos){
        usort($depositos, 'Deposito::CompararNumeroCuenta');
        return $depositos;
    }

    public static function BuscarDeposito($id){
        $depositos = Deposito::LeerJSONDeposito();
        foreach($depositos as $deposito){
            if($deposito->id == $id){
                return $deposito;
            }
        }
        return false;
    }


    
}


?>