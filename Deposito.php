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
     
}


?>