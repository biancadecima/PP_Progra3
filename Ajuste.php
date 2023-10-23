<?php

include './Cuenta.php';
include './Deposito.php';
include './Retiro.php';

class Ajuste{
    public $id;
    public $idOperacion;
    public $motivo;
    public $monto;

    public function __construct(){
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct4($id, $idOperacion, $motivo, $monto){
        $this->id = $id;
        $this->idOperacion = $idOperacion;
        $this->motivo = $motivo;
        $this->monto = $monto;
    }

    public function __construct3($idOperacion, $motivo, $monto){
        $this->id = rand(100, 999);
        $this->idOperacion = $idOperacion;
        $this->motivo = $motivo;
        $this->monto = $monto;
    }

    public static function LeerJSONAjuste(){
        $pathJSON = './ajustes.json';
        if(file_exists($pathJSON)){
            $ajustes = json_decode(file_get_contents($pathJSON), true);
            if($ajustes != null){
                $ajustesObj = array();
                foreach($ajustes as $ajuste){
                    $ajusteObj = new Ajuste($ajuste['id'], $ajuste['idOperacion'], $ajuste['motivo'], $ajuste['monto']); 
                    $ajustesObj[] = $ajusteObj;
                }
                return $ajustesObj;
            }  
        }
        return [];
    }

    public static function EscribirJSONAjuste($ajustes){
        if(file_put_contents('ajustes.json', json_encode($ajustes)) != false){
            return true;
        }
        
        return false;
    }

    public static function BuscarIdOperacion($motivo, $idOperacion){
        if($motivo == 'deposito'){
            $depositos = Deposito::LeerJSONDeposito();
            foreach($depositos as $deposito){
                if($deposito->id == $idOperacion){
                    return $deposito->deposito;
                }
            }
        }else if($motivo == 'retiro'){
            $retiros = Retiro::LeerJSONRetiro();
            foreach($retiros as $retiro){
                if($retiro->id == $idOperacion){
                    return $retiro;
                }
            }
        }
    }

}
?>