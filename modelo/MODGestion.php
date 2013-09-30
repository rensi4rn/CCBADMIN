<?php
/**
*@package pXP
*@file gen-MODGestion.php
*@author  (admin)
*@date 13-01-2013 14:01:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODGestion extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarGestion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_gestion_sel';
		$this->transaccion='CCB_GES_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_gestion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('gestion','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarGestion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_gestion_ime';
		$this->transaccion='CCB_GES_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('gestion','gestion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarGestion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_gestion_ime';
		$this->transaccion='CCB_GES_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('gestion','gestion','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarGestion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_gestion_ime';
		$this->transaccion='CCB_GES_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_gestion','id_gestion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>