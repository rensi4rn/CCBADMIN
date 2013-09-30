<?php
/**
*@package pXP
*@file gen-MODDetalleEvento.php
*@author  (admin)
*@date 24-02-2013 13:45:38
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODDetalleEvento extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarDetalleEvento(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_detalle_evento_sel';
		$this->transaccion='CCB_DEV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_detalle_evento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('catidad','int4');
		$this->captura('id_region_evento','int4');
		$this->captura('id_tipo_ministerio','int4');
		$this->captura('obs','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_tipo_ministerio','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarDetalleEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_detalle_evento_ime';
		$this->transaccion='CCB_DEV_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('catidad','catidad','int4');
		$this->setParametro('id_region_evento','id_region_evento','int4');
		$this->setParametro('id_tipo_ministerio','id_tipo_ministerio','int4');
		$this->setParametro('obs','obs','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarDetalleEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_detalle_evento_ime';
		$this->transaccion='CCB_DEV_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_detalle_evento','id_detalle_evento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('catidad','catidad','int4');
		$this->setParametro('id_region_evento','id_region_evento','int4');
		$this->setParametro('id_tipo_ministerio','id_tipo_ministerio','int4');
		$this->setParametro('obs','obs','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarDetalleEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_detalle_evento_ime';
		$this->transaccion='CCB_DEV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_detalle_evento','id_detalle_evento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>