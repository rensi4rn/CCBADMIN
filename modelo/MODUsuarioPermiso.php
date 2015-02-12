<?php
/**
*@package pXP
*@file gen-MODUsuarioPermiso.php
*@author  (admin)
*@date 12-02-2015 14:36:49
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODUsuarioPermiso extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarUsuarioPermiso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.ft_usuario_permiso_sel';
		$this->transaccion='CCB_usper_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_usuario_permiso','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('id_usuario_asignado','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_usuario','varchar');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarUsuarioPermiso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_usuario_permiso_ime';
		$this->transaccion='CCB_usper_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_usuario_asignado','id_usuario_asignado','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarUsuarioPermiso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_usuario_permiso_ime';
		$this->transaccion='CCB_usper_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_usuario_permiso','id_usuario_permiso','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_usuario_asignado','id_usuario_asignado','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarUsuarioPermiso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_usuario_permiso_ime';
		$this->transaccion='CCB_usper_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_usuario_permiso','id_usuario_permiso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>