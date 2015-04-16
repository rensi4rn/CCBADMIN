<?php
/**
*@package pXP
*@file gen-MODRegionEvento.php
*@author  (admin)
*@date 13-01-2013 14:31:26
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODRegionEvento extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarRegionEvento(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_region_evento_sel';
		$this->transaccion='CCB_REGE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('tipolist','tipolist','varchar');			
		//Definicion de la lista del resultado del query
		$this->captura('id_region_evento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('fecha_programada','date');
		$this->captura('id_evento','int4');
		$this->captura('estado','varchar');
		$this->captura('id_region','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_gestion','varchar');
		$this->captura('desc_evento','varchar');
		$this->captura('desc_region','varchar');
		$this->captura('id_casa_oracion','integer');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('tipo_registro','varchar');
		$this->captura('id_lugar','integer');
		$this->captura('desc_lugar','varchar');
		$this->captura('mes','varchar');
		$this->captura('hora','time');
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//echo $this->getConsulta();
		//exit;
		//Devuelve la respuesta
		return $this->respuesta;
	}

    
			
	function insertarRegionEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_REGE_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_programada','fecha_programada','date');
		$this->setParametro('id_evento','id_evento','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','integer');
		$this->setParametro('tipo_registro','tipo_registro','varchar');
		$this->setParametro('hora','hora','time');
		$this->setParametro('id_obrero','id_obrero','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarRegionEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_REGE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_region_evento','id_region_evento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_programada','fecha_programada','date');
		$this->setParametro('id_evento','id_evento','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','integer');
		$this->setParametro('tipo_registro','tipo_registro','varchar');
		$this->setParametro('hora','hora','time');
		$this->setParametro('id_obrero','id_obrero','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarRegionEvento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_REGE_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_region_evento','id_region_evento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}



   function eliminarBautizoSantaCena(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_REGE_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_region_evento','id_region_evento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function generarResumen(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_GENRESU_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_region_evento','id_region_evento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function listarBautizoSantaCena(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_region_evento_sel';
		$this->transaccion='CCB_REGESC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('fecha_programada','date');
		$this->captura('estado','varchar');
		$this->captura('id_region_evento','int4');
		$this->captura('id_casa_oracion','integer');
		$this->captura('id_region','int4');
		$this->captura('nombre_region','varchar');
		$this->captura('nombre_co','varchar');
		$this->captura('cantidad_hermano','int4');		
		$this->captura('cantidad_hermana','int4');		
		$this->captura('id_gestion','int4');		
		$this->captura('gestion','varchar');
		$this->captura('id_detalle_evento_hermano','int4');
		$this->captura('id_detalle_evento_hermana','int4');
		$this->captura('id_evento','INTEGER');
		$this->captura('codigo','varchar');
		$this->captura('nombre','varchar');
		$this->captura('id_usuario_mod','integer');
		$this->captura('cuenta','varchar');
		$this->captura('hora','time');
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		
		
		
  
  
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function insertarBautizoSantaCena(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_RNSC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_programada','fecha_programada','date');
		$this->setParametro('id_evento','id_evento','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','integer');		
		$this->setParametro('cantidad_hermano','cantidad_hermano','int4');
		$this->setParametro('cantidad_hermana','cantidad_hermana','int4');
		$this->setParametro('id_detalle_evento_hermano','id_detalle_evento_hermano','int4');
		$this->setParametro('id_detalle_evento_hermana','id_detalle_evento_hermana','int4');
		$this->setParametro('hora','hora','time');
		$this->setParametro('id_obrero','id_obrero','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarBautizoSantaCena(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_region_evento_ime';
		$this->transaccion='CCB_RNSC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_region_evento','id_region_evento','int4');
		$this->setParametro('id_gestion','id_gestion','int4');
		$this->setParametro('fecha_programada','fecha_programada','date');
		$this->setParametro('id_evento','id_evento','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','integer');		
		$this->setParametro('cantidad_hermano','cantidad_hermano','int4');
		$this->setParametro('cantidad_hermana','cantidad_hermana','int4');
		$this->setParametro('id_detalle_evento_hermano','id_detalle_evento_hermano','int4');
		$this->setParametro('id_detalle_evento_hermana','id_detalle_evento_hermana','int4');
		$this->setParametro('hora','hora','time');
		$this->setParametro('id_obrero','id_obrero','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function listarCalendario(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_region_evento_sel';
		$this->transaccion='CCB_CALEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('id_evento','id_evento','int4');
		$this->setParametro('fecha_ini','fecha_ini','date');	
		$this->setParametro('fecha_fin','fecha_fin','date');			
			
		//Definicion de la lista del resultado del query
		$this->captura('event','VARCHAR');
		$this->captura('title','text');
		$this->captura('start','TIMESTAMP');
		$this->captura('"end"','TIMESTAMP');
		$this->captura('desc_evento','varchar');
		$this->captura('desc_region','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('tipo_registro','varchar');
		$this->captura('desc_lugar','varchar');
		$this->captura('hora','varchar');
		$this->captura('id_lugar','int4');
		$this->captura('fecha_programada','date');
		$this->captura('css','text');
		$this->captura('id_region_evento','int4');
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		
		
		
		
	//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//echo $this->getConsulta();
		//exit;
		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarReporteAgenda(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_region_evento_sel';
		$this->transaccion='CCB_REPAGE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('tipo_orden','tipo_orden','varchar');
		$this->setParametro('id_eventos','id_eventos','varchar');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('id_regiones','id_regiones','varchar');
		$this->setParametro('hasta','hasta','date');
		$this->setParametro('desde','desde','date');				
		//Definicion de la lista del resultado del query
		$this->captura('id_region_evento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('fecha_programada','date');
		$this->captura('id_evento','int4');
		$this->captura('estado','varchar');
		$this->captura('id_region','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_gestion','varchar');
		$this->captura('desc_evento','varchar');
		$this->captura('desc_region','varchar');
		$this->captura('id_casa_oracion','integer');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('tipo_registro','varchar');
		$this->captura('id_lugar','integer');
		$this->captura('desc_lugar','varchar');
		$this->captura('mes','varchar');
		$this->captura('hora','time');
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		//echo $this->getConsulta();
		//exit;
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>