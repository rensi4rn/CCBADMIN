<?php
/**
*@package pXP
*@file gen-MODCasaBanco.php
*@author  (admin)
*@date 02-03-2016 01:06:45
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCasaBanco extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCasaBanco(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.ft_casa_banco_sel';
		$this->transaccion='CCB_COB_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_casa_banco','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('obs','varchar');
		$this->captura('id_cuenta_bancaria','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_cuenta_bancaria','text');
		$this->captura('desc_tipo_movimiento','text');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

      function listarCuentaBancaria(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.ft_casa_banco_sel';
		$this->transaccion='CCB_CBCTABAN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_cuenta_bancaria','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_baja','date');
		$this->captura('nro_cuenta','varchar');
		$this->captura('fecha_alta','date');
		$this->captura('id_institucion','int4');
		$this->captura('nombre_institucion','varchar');
		$this->captura('doc_id','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('id_moneda','integer');
		$this->captura('codigo_moneda','varchar');
		$this->captura('denominacion','varchar');
		$this->captura('centro','varchar');
		
	
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCasaBanco(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_casa_banco_ime';
		$this->transaccion='CCB_COB_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('obs','obs','varchar');
		$this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCasaBanco(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_casa_banco_ime';
		$this->transaccion='CCB_COB_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_casa_banco','id_casa_banco','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('obs','obs','varchar');
		$this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCasaBanco(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.ft_casa_banco_ime';
		$this->transaccion='CCB_COB_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_casa_banco','id_casa_banco','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>