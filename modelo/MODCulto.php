<?php
/**
*@package pXP
*@file gen-MODCulto.php
*@author  (admin)
*@date 24-02-2013 14:06:12
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCulto extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCulto(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_culto_sel';
		$this->transaccion='CCB_CUL_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_culto','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('dia','varchar');
		$this->captura('hora','time');
		$this->captura('tipo_culto','varchar');
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
			
	function insertarCulto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_culto_ime';
		$this->transaccion='CCB_CUL_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('dia','dia','varchar');
		$this->setParametro('hora','hora','time');
		$this->setParametro('tipo_culto','tipo_culto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCulto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_culto_ime';
		$this->transaccion='CCB_CUL_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_culto','id_culto','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('dia','dia','varchar');
		$this->setParametro('hora','hora','time');
		$this->setParametro('tipo_culto','tipo_culto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCulto(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_culto_ime';
		$this->transaccion='CCB_CUL_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_culto','id_culto','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>