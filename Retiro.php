<?php
class Retiro{
    public $id;
    public $tipoCuenta;
    public $numeroCuenta;
    public $moneda;
    public $monto;
    public $fecha;

    public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct4($tipoCuenta, $numeroCuenta, $moneda, $monto){
        $this->id = rand(100000, 999999);;
        $this->tipoCuenta = $tipoCuenta;
        $this->numeroCuenta = $numeroCuenta;
        $this->moneda = $moneda;
        $this->monto = $monto;
        $this->fecha = date("d-m-Y");
    }

    public function __construct6($id, $tipoCuenta, $numeroCuenta, $moneda, $monto, $fecha){
        $this->id = $id;
        $this->tipoCuenta = $tipoCuenta;
        $this->numeroCuenta = $numeroCuenta;
        $this->moneda = $moneda;
        $this->monto = $monto;
        $this->fecha = $fecha;
    }

    public static function LeerJSONRetiro(){
        $pathJSON = './retiros.json';
        if(file_exists($pathJSON)){
            $retiros = json_decode(file_get_contents($pathJSON), true);
            if($retiros != null){
                $retirosObj = array();
                foreach($retiros as $retiro){
                    $retiroObj = new Retiro($retiro['id'], $retiro['tipoCuenta'], $retiro['numeroCuenta'], $retiro['moneda'], $retiro['monto'], $retiro['fecha']); 
                    $retirosObj[] = $retiroObj;
                }
                return $retirosObj;
            }  
        }
        return [];
    }

    public static function EscribirJSONRetiro($retiros){
        if(file_put_contents('retiros.json', json_encode($retiros)) != false){
            return true;
        }
        
        return false;
    }

    public static function BuscarRetiro($id){
        $retiros = Retiro::LeerJSONRetiro();
        foreach($retiros as $retiro){
            if($retiro->id == $id){
                return $retiro;
            }
        }
        return false;
    }

}
?>