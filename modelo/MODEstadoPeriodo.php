<?php
/**
*@package pXP
*@file gen-MODEstadoPeriodo.php
*@author  (admin)
*@date 24-02-2013 14:35:36
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODEstadoPeriodo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarEstadoPeriodo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_estado_periodo_sel';
		$this->transaccion='CCB_PER_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_estado_periodo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('num_mes','int4');
		$this->captura('id_gestion','int4');
		$this->captura('fecha_fin','date');
		$this->captura('mes','varchar');
		$this->captura('fecha_ini','date');
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
			
	function insertarEstadoPeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_estado_periodo_ime';
		$this->transaccion='CCB_PER_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado_periodo','estado_periodo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('num_mes','num_mes','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('mes','mes','varchar');
		$this->setParametro('fecha_ini','fecha_ini','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarEstadoPeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_estado_periodo_ime';
		$this->transaccion='CCB_PER_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado_periodo','estado_periodo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('num_mes','num_mes','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_fin','fecha_fin','date');
		$this->setParametro('mes','mes','varchar');
		$this->setParametro('fecha_ini','fecha_ini','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarEstadoPeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_estado_periodo_ime';
		$this->transaccion='CCB_PER_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function generarGestion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_estado_periodo_ime';
		$this->transaccion='CCB_GENGES_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_gestion','id_gestion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function abrirCerrarPeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_estado_periodo_ime';
		$this->transaccion='CCB_ABRCERAR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}		
}
?>