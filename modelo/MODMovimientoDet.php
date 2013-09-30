<?php
/**
*@package pXP
*@file gen-MODMovimientoDet.php
*@author  (admin)
*@date 25-03-2013 02:03:18
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODMovimientoDet extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarMovimientoDet(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_det_sel';
		$this->transaccion='CCB_MOVD_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento_det','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_movimiento','int4');
		$this->captura('monto','numeric');
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('desc_tipo_movimiento','varchar');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarMovimientoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_det_ime';
		$this->transaccion='CCB_MOVD_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMovimientoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_det_ime';
		$this->transaccion='CCB_MOVD_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento_det','id_movimiento_det','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarMovimientoDet(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_det_ime';
		$this->transaccion='CCB_MOVD_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento_det','id_movimiento_det','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>