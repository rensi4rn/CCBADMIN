<?php
/**
*@package pXP
*@file gen-MODCbtePeriodo.php
*@author  (admin)
*@date 28-02-2016 13:24:52
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCbtePeriodo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCbtePeriodo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.ft_cbte_periodo_sel';
		$this->transaccion='CCB_CBP_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cbte_periodo','int4');
		$this->captura('id_estado_periodo','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_tipo_cbte','int4');
		$this->captura('id_int_comprobante','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nro_cbte','varchar');
		$this->captura('desc_tipo_cbte','varchar');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCbtePeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_cbte_periodo_ime';
		$this->transaccion='CCB_CBP_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_tipo_cbte','id_tipo_cbte','int4');
		$this->setParametro('id_int_comprobante','id_int_comprobante','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCbtePeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_cbte_periodo_ime';
		$this->transaccion='CCB_CBP_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cbte_periodo','id_cbte_periodo','int4');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_tipo_cbte','id_tipo_cbte','int4');
		$this->setParametro('id_int_comprobante','id_int_comprobante','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCbtePeriodo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_cbte_periodo_ime';
		$this->transaccion='CCB_CBP_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_cbte_periodo','id_cbte_periodo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>