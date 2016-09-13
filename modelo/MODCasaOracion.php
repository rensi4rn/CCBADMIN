<?php
/**
*@package pXP
*@file gen-MODCasaOracion.php
*@author  (admin)
*@date 05-01-2013 08:52:02
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODCasaOracion extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarCasaOracion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_casa_oracion_sel';
		$this->transaccion='CCB_CAOR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('verificar','verificar','varchar');				
				
		//Definicion de la lista del resultado del query
		$this->captura('id_casa_oracion','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('fecha_cierre','date');
		$this->captura('codigo','varchar');
		$this->captura('id_region','int4');
		$this->captura('id_lugar','int4');
		$this->captura('direccion','text');
		$this->captura('nombre','varchar');
		$this->captura('fecha_apertura','date');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_region','varchar');
		$this->captura('desc_lugar','varchar');
		
		$this->captura('latitud','varchar');
		$this->captura('longitud','varchar');
		$this->captura('zoom','varchar');
		$this->captura('id_uo','int4');
		$this->captura('desc_uo','varchar');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarCasaOracion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_casa_oracion_ime';
		$this->transaccion='CCB_CAOR_INS';
		$this->tipo_procedimiento='IME';
			
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_cierre','fecha_cierre','date');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('direccion','direccion','text');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('fecha_apertura','fecha_apertura','date');		
		$this->setParametro('latitud','latitud','varchar');
		$this->setParametro('longitud','longitud','varchar');
		$this->setParametro('zoom','zoom','varchar');
		$this->setParametro('id_uo','id_uo','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarCasaOracion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_casa_oracion_ime';
		$this->transaccion='CCB_CAOR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('fecha_cierre','fecha_cierre','date');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('direccion','direccion','text');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('fecha_apertura','fecha_apertura','date');
		$this->setParametro('latitud','latitud','varchar');
		$this->setParametro('longitud','longitud','varchar');
		$this->setParametro('zoom','zoom','varchar');
		$this->setParametro('id_uo','id_uo','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarCasaOracion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_casa_oracion_ime';
		$this->transaccion='CCB_CAOR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function listarCasaOracionAgenda(){
		  //Definicion de variables para ejecucion del procedimientp
		  $this->procedimiento='ccb.f_casa_oracion_sel';
		  $this->transaccion='CCB_CAORAGD_SEL';
		  $this->tipo_procedimiento='SEL';//tipo de transaccion
		  $this->setCount(false);
		  
		  $this->setParametro('id_lugar','id_lugar','int4');
		  $this->setParametro('id_eventos','id_eventos','varchar');
		  $this->setParametro('id_regiones','id_regiones','varchar');		
		  $this->captura('id_casa_oracion','INTEGER');
          $this->captura('obs','varchar');
          $this->captura('region','varchar');
          $this->captura('casa_oracion','varchar');
          $this->captura('direccion','TEXT');
          $this->captura('id_region','INTEGER');
          $this->captura('id_lugar','INTEGER');
          $this->captura('lugar','varchar');
          $this->captura('latitud','varchar');
          $this->captura('longitud','varchar');
          $this->captura('horarios','text');
		  
		 
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>