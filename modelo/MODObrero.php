<?php
/**
*@package pXP
*@file gen-MODObrero.php
*@author  (admin)
*@date 13-01-2013 12:24:54
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODObrero extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarObrero(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_obrero_sel';
		$this->transaccion='CCB_OBR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_obrero','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_region','int4');
		$this->captura('fecha_fin','date');
		$this->captura('fecha_ini','date');
		$this->captura('obs','text');
		$this->captura('id_tipo_ministerio','int4');
		$this->captura('id_persona','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_persona','text');
		$this->captura('desc_tipo_ministerio','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarObrero(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_obrero_ime';
		$this->transaccion='CCB_OBR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_ini','fecha_ini','date');
		$this->setParametro('obs','obs','text');
		$this->setParametro('id_tipo_ministerio','id_tipo_ministerio','int4');
		$this->setParametro('id_persona','id_persona','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarObrero(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_obrero_ime';
		$this->transaccion='CCB_OBR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('fecha_ini','fecha_ini','date');
		$this->setParametro('obs','obs','text');
		$this->setParametro('id_tipo_ministerio','id_tipo_ministerio','int4');
		$this->setParametro('id_persona','id_persona','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarObrero(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_obrero_ime';
		$this->transaccion='CCB_OBR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_obrero','id_obrero','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>