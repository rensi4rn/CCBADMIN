<?php
/**
*@package pXP
*@file gen-MODMovimiento.php
*@author  (admin)
*@date 16-03-2013 00:22:36
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/
class MODMovimiento extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarMovimiento(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MOV_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
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
	
	function listarMovimientoIngreso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MOVING_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		//captura parametros adicionales para el count
		$this->capturaCount('total_construccion','numeric');
		$this->capturaCount('total_viaje','numeric');
		$this->capturaCount('total_especial','numeric');
		$this->capturaCount('total_piedad','numeric');
		$this->capturaCount('total_mantenimiento','numeric');
		$this->capturaCount('total_dia','numeric');
		
				
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento_mantenimiento','int4');
		$this->captura('id_movimiento_det_mantenimiento','int4');
		$this->captura('monto_mantenimiento','numeric');		
		$this->captura('id_tipo_movimiento_especial','int4');
		$this->captura('id_movimiento_det_especial','int4');
		$this->captura('monto_especial','numeric');		
		$this->captura('id_tipo_movimiento_piedad','int4');
		$this->captura('id_movimiento_det_piedad','int4');
		$this->captura('monto_piedad','numeric');		
		$this->captura('id_tipo_movimiento_construccion','int4');
		$this->captura('id_movimiento_det_construccion','int4');
		$this->captura('monto_construccion','numeric');		
		$this->captura('id_tipo_movimiento_viaje','int4');
		$this->captura('id_movimiento_det_viaje','int4');
		$this->captura('monto_viaje','numeric');
		$this->captura('monto_dia','numeric');		
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');		
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_tipo_movimiento_ot','integer');
		$this->captura('nombre_tipo_mov_ot','varchar');
		$this->captura('migrado','varchar');
		$this->captura('desc_region','varchar');
		
		
				

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarMovimientoEgreso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MOVEGRE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto_doc','numeric');
		$this->capturaCount('total_monto','numeric');		
		$this->capturaCount('total_monto_retencion','numeric');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_concepto_ingas','integer');
		$this->captura('desc_ingas','varchar');
		$this->captura('monto_doc','numeric');
		$this->captura('monto_retencion','numeric');
		$this->captura('id_movimiento_traspaso','integer');
		
		$this->captura('id_cuenta_bancaria','integer');
		$this->captura('desc_cuenta_bancaria','text');
		
		
		$this->captura('nit','varchar');
		$this->captura('razon_social','varchar');
		$this->captura('nro_autorizacion','varchar');
		$this->captura('codigo_control','varchar');
		
		
		 
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarMovimientoEgresoTraspaso(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MOVEGT_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_concepto_ingas','integer');
		$this->captura('desc_ingas','varchar');
		$this->captura('monto_doc','numeric');
		$this->captura('monto_retencion','numeric');
		$this->captura('id_movimiento_traspaso','integer');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}





    function listarMovimientoOtrosIngresos(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MOVOTIN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('desc_movimiento_traspaso','text');
		$this->captura('id_movimiento_traspaso','integer');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	
	
	function listarMovimientoDinamico(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='ccb.f_movimiento_sel';
        $this->transaccion='CCB_MOVDIN_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $datos = $this->objParam->getParametro('datos');
        $parametros= explode('@',$datos);
        
        $tamaño = sizeof($parametros);
        
        $this->setParametro('id_casa_oracion','id_casa_oracion','integer'); 
        $this->setParametro('id_gestion','id_gestion','integer');    
        $this->setParametro('tipo','tipo','varchar');    
        
		$this->captura('prioridad','integer');
        for($i=0;$i<$tamaño;$i++){
             $parametros_tipo=explode('#',$parametros[$i]);
            
            $this->captura($parametros_tipo[0],$parametros_tipo[1]);
            
        }
        //Definicion de la lista del resultado del query
        
        //Ejecuta la instruccion
        $this->armarConsulta();
        //echo $this->consulta;exit;
        $this->ejecutarConsulta();
        
        //Devuelve la respuesta
        return $this->respuesta;
    }
			
	function insertarMovimiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOV_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMovimiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOV_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarMovimiento(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOV_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento','id_movimiento','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function insertarMovimientoIngreso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVING_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');		
		$this->setParametro('monto_mantenimiento','monto_mantenimiento','numeric');
		$this->setParametro('monto_piedad','monto_piedad','numeric');
		$this->setParametro('monto_construccion','monto_construccion','numeric');
		$this->setParametro('monto_viaje','monto_viaje','numeric');
		$this->setParametro('monto_especial','monto_especial','numeric');		
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_tipo_movimiento_ot','id_tipo_movimiento_ot','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMovimientoIngreso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVING_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');		
		$this->setParametro('id_movimiento_det_mantenimiento','id_movimiento_det_mantenimiento','int4');
		$this->setParametro('monto_mantenimiento','monto_mantenimiento','numeric');
		$this->setParametro('id_movimiento_det_piedad','id_movimiento_det_piedad','int4');
		$this->setParametro('monto_piedad','monto_piedad','numeric');
		$this->setParametro('id_movimiento_det_construccion','id_movimiento_det_construccion','int4');
		$this->setParametro('monto_construccion','monto_construccion','numeric');
		$this->setParametro('id_movimiento_det_viaje','id_movimiento_det_viaje','int4');
		$this->setParametro('monto_viaje','monto_viaje','numeric');
		$this->setParametro('id_movimiento_det_especial','id_movimiento_det_especial','int4');
		$this->setParametro('monto_especial','monto_especial','numeric');		
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_tipo_movimiento_ot','id_tipo_movimiento_ot','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


    function insertarMovimientoEgreso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVEGRE_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('tipo_documento','tipo_documento','varchar');
		$this->setParametro('num_documento','num_documento','varchar');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('monto_doc','monto_doc','numeric');
		$this->setParametro('monto_retencion','monto_retencion','numeric');		
		$this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');		
		$this->setParametro('nro_autorizacion','nro_autorizacion','varchar');
		$this->setParametro('codigo_control','codigo_control','varchar');
		$this->setParametro('nit','nit','varchar');
		$this->setParametro('razon_social','razon_social','varchar');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMovimientoEgreso(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVEGRE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('id_movimiento_det','id_movimiento_det','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('tipo_documento','tipo_documento','varchar');
		$this->setParametro('num_documento','num_documento','varchar');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('monto_doc','monto_doc','numeric');
		$this->setParametro('monto_retencion','monto_retencion','numeric');
		$this->setParametro('id_cuenta_bancaria','id_cuenta_bancaria','int4');
		$this->setParametro('nro_autorizacion','nro_autorizacion','varchar');
		$this->setParametro('codigo_control','codigo_control','varchar');
		$this->setParametro('nit','nit','varchar');
		$this->setParametro('razon_social','razon_social','varchar');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function insertarMovimientoOtrosIngresos(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVOTRING_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		
		
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('tipo_documento','tipo_documento','varchar');
		$this->setParametro('num_documento','num_documento','varchar');
		
		
		
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('id_movimiento_traspaso','id_movimiento_traspaso','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
    function modificarMovimientoOtrosIngresos(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_MOVOINGRE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_movimiento','id_movimiento','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('tipo','tipo','varchar');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('concepto','concepto','varchar');
		$this->setParametro('obs','obs','text');
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		$this->setParametro('id_movimiento_det','id_movimiento_det','int4');
		$this->setParametro('monto','monto','numeric');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('tipo_documento','tipo_documento','varchar');
		$this->setParametro('num_documento','num_documento','varchar');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('id_ot','id_ot','int4');
		$this->setParametro('id_concepto_ingas','id_concepto_ingas','int4');
		$this->setParametro('id_movimiento_traspaso','id_movimiento_traspaso','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function calcularSaldos(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_CALSALDO_IME';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_obrero','id_obrero','int4');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_tipo_movimiento','id_tipo_movimiento','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_lugar','id_lugar','int4');
		$this->setParametro('id_ot','id_ot','int4');
		
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	
	
	
	 function reporteResumen(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_record_sel';
		$this->transaccion='CCB_MOVRESUMEN_REP';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setTipoRetorno('record');
		
		//Define los parametros para la funcion
		$this->setParametro('hasta','hasta','date');
		$this->setParametro('id_regiones','id_regiones','varchar');
		$this->setParametro('colectas','colectas','varchar');
		
		$this->captura('id_casa_oracion','int4');		
		$this->captura('nombre_casa_oracion','varchar');
		$this->captura('id_region','int4');
		$this->captura('nombre_region','varchar');		
		$this->captura('id_lugar','int4');
		$this->captura('nombre_lugar','varchar');		
		$this->captura('ingreso_traspasos','numeric');
		$this->captura('devolucion','numeric');
		$this->captura('ingreso_colectas','numeric');
		$this->captura('ingreso_inicial','numeric');
		$this->captura('egreso_operacion','numeric');
		$this->captura('egreso_traspaso','numeric');
		$this->captura('egresos_contra_rendicion','numeric');
		$this->captura('egresos_rendidos','numeric');
		$this->captura('egreso_inicial_por_rendir','numeric');	
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

     function reporteResumenDetallado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_record_sel';
		$this->transaccion='CCB_MOVRESDET_REP';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setTipoRetorno('record');
		
		//Define los parametros para la funcion
		$this->setParametro('hasta','hasta','date');
		$this->setParametro('id_regiones','id_regiones','varchar');
		$this->setParametro('colectas','colectas','varchar');
		
		$this->captura('id_casa_oracion','int4');		
		$this->captura('nombre_casa_oracion','varchar');
		$this->captura('id_region','int4');
		$this->captura('nombre_region','varchar');		
		$this->captura('id_lugar','int4');
		$this->captura('nombre_lugar','varchar');
		$this->captura('id_tipo_movimiento','int4');
        $this->captura('nombre_colecta','varchar');
        $this->captura('codigo_colecta','varchar');		
		$this->captura('ingreso_traspasos','numeric');
		$this->captura('devolucion','numeric');
		$this->captura('ingreso_colectas','numeric');
		$this->captura('ingreso_inicial','numeric');
		$this->captura('egreso_operacion','numeric');
		$this->captura('egreso_traspaso','numeric');
		$this->captura('egresos_contra_rendicion','numeric');
		$this->captura('egresos_rendidos','numeric');
		$this->captura('egreso_inicial_por_rendir','numeric');	
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	 }

	
	 function comprobanteOfrendas(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_CBTEOFRE_IME';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_region','id_region','int4');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	 
	 function listarEgresosMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_EGEMES_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_concepto_ingas','integer');
		$this->captura('desc_ingas','varchar');
		$this->captura('desc_concepto','varchar');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


    function listarColectasMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_INFCOLMES_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		
		//Definicion de la lista del resultado del query
		
		
		  $this->captura('id_movimiento','INTEGER');
		  $this->captura('estado_reg','VARCHAR(10)');
		  $this->captura('tipo','VARCHAR');
		  $this->captura('id_casa_oracion','INTEGER');
		  $this->captura('concepto','VARCHAR');
		  $this->captura('obs','TEXT');
		  $this->captura('fecha','DATE');
		  $this->captura('id_estado_periodo','INTEGER');
		  $this->captura('fecha_reg','TIMESTAMP');
		  $this->captura('id_usuario_reg','INTEGER');
		  $this->captura('fecha_mod','TIMESTAMP');
		  $this->captura('id_usuario_mod','INTEGER');
		  $this->captura('usr_reg','VARCHAR');
		  $this->captura('usr_mod','VARCHAR');
		  $this->captura('id_tipo_movimiento_mantenimiento','INTEGER');
		  $this->captura('id_movimiento_det_mantenimiento','INTEGER');
		  $this->captura('monto_mantenimiento','NUMERIC');
		  $this->captura('id_tipo_movimiento_especial','INTEGER');
		  $this->captura('id_movimiento_det_especial','INTEGER');
		  $this->captura('monto_especial','NUMERIC');
		  $this->captura('id_tipo_movimiento_piedad','INTEGER');
		  $this->captura('id_movimiento_det_piedad','INTEGER');
		  $this->captura('monto_piedad','NUMERIC');
		  $this->captura('id_tipo_movimiento_construccion','INTEGER');
		  $this->captura('id_movimiento_det_construccion','INTEGER');
		  $this->captura('monto_construccion','NUMERIC');
		  $this->captura('id_tipo_movimiento_viaje','INTEGER');
		  $this->captura('id_movimiento_det_viaje','INTEGER');
		  $this->captura('monto_viaje','NUMERIC');
		  $this->captura('monto_dia','NUMERIC');
		  $this->captura('id_obrero','INTEGER');
		  $this->captura('desc_obrero','TEXT');
		  $this->captura('estado','VARCHAR');
		  $this->captura('desc_casa_oracion','VARCHAR');
		  $this->captura('mes','VARCHAR');
		  $this->captura('estado_periodo','VARCHAR');
		  $this->captura('id_gestion','INTEGER');
		  $this->captura('gestion','VARCHAR');
		  $this->captura('id_ot','INTEGER');
		  $this->captura('id_tipo_movimiento_ot','INTEGER');
		  $this->captura('nombre_tipo_mov_ot','VARCHAR');
		  $this->captura('desc_orden','VARCHAR');
		  $this->captura('desc_concepto','VARCHAR');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarOtrosIngresosMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_OINGMES_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		
	
  
  
 

		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_region','integer');
		$this->captura('id_lugar','integer');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('desc_concepto','varchar');
		
	
	
	
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function listarRendicionesObreroMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_REDREPO_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_obrero','id_obrero','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_concepto_ingas','integer');
		$this->captura('desc_ingas','varchar');
		$this->captura('desc_concepto','varchar');
		$this->captura('retenciones','numeric');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function listarDevolucionesObreroMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_DEVREPO_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_obrero','id_obrero','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		

		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_region','integer');
		$this->captura('id_lugar','integer');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('desc_concepto','varchar');
		
	

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function saldosPorRendirObreroMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_CSALXREND_IME';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_obrero','id_obrero','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
   
   function listarEgresosContraRendicionMes(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_EGECRMES_SEL';
		$this->tipo_procedimiento='SEL';
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_obrero','id_obrero','int4');
		//captura parametros adicionales para el count
		$this->capturaCount('total_monto','numeric');
		$this->capturaCount('mes','varchar');
		$this->capturaCount('gestion','varchar');
		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento','int4');
		$this->captura('id_movimiento_det','int4');
		$this->captura('monto','numeric');	
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		$this->captura('tipo_documento','varchar');
		$this->captura('num_documento','varchar');
		$this->captura('desc_tipo_movimiento','varchar');
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_concepto_ingas','integer');
		$this->captura('desc_ingas','varchar');
		$this->captura('desc_concepto','varchar');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

  function reporteResumenCO(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_record_sel';
		$this->transaccion='CCB_MOVRESCO_REP';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setTipoRetorno('record');
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','integer');
		
		
		
		
		$this->captura('mes','VARCHAR');
        $this->captura('num_mes','INTEGER');
        $this->captura('nombre_colecta','VARCHAR');
        $this->captura('codigo_colecta','VARCHAR');
        $this->captura('id_casa_oracion','INTEGER');
        $this->captura('nombre_casa_oracion','VARCHAR');
        $this->captura('id_region','INTEGER');
        $this->captura('nombre_region','VARCHAR');
        $this->captura('id_lugar','INTEGER');
        $this->captura('nombre_lugar','VARCHAR');
        $this->captura('id_tipo_movimiento','INTEGER');
		
		$this->captura('ingreso_inicial','numeric');
		$this->captura('ingreso_colectas','numeric');
		$this->captura('egreso_inicial_por_rendir','numeric');
		$this->captura('ingreso_traspasos','numeric');
		$this->captura('ingreso_devolucion','numeric');
		$this->captura('egreso_traspaso','numeric');
		$this->captura('egreso_operacion','numeric');
		$this->captura('egresos_contra_rendicion','numeric');
		$this->captura('egresos_rendidos','numeric');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

    function reporteResumenSaldosMensual(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_record_sel';
		$this->transaccion='CCB_SALDOMEN_REP';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setTipoRetorno('record');
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracions','id_casa_oracions','varchar');
			
		$this->captura('id_casa_oracion','INTEGER');
        $this->captura('id_region','INTEGER');
        $this->captura('nombre_region','varchar');
        $this->captura('id_gestion','INTEGER');
        $this->captura('gestion','varchar');
        $this->captura('nombre_casa_oracion','VARCHAR');
        $this->captura('saldo_inicial','numeric');
        $this->captura('nombre_colecta','VARCHAR');
        $this->captura('id_tipo_movimiento','INTEGER');
        $this->captura('mes_1','numeric');
        $this->captura('mes_2','numeric');
        $this->captura('mes_3','numeric');
        $this->captura('mes_4','numeric');
        $this->captura('mes_5','numeric');
        $this->captura('mes_6','numeric');
        $this->captura('mes_7','numeric');
        $this->captura('mes_8','numeric');
        $this->captura('mes_9','numeric');
        $this->captura('mes_10','numeric');
        $this->captura('mes_11','numeric');
        $this->captura('mes_12','numeric');
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function reporteColectaMensualXOT(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_record_sel';
		$this->transaccion='CCB_MOVRESCOXOT_REP';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this->setCount(false);	
		$this->setTipoRetorno('record');
		
		//Define los parametros para la funcion
		$this->setParametro('fecha','fecha','date');
		$this->setParametro('id_casa_oracion','id_casa_oracion','INTEGER');
			
		$this->captura('id_orden_trabajo','INTEGER');
        $this->captura('desc_orden','varchar');
        $this->captura('id_tipo_movimiento','INTEGER');
        $this->captura('desc_tipo_movimiento','varchar');
        $this->captura('importe','numeric'); 
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
   
   function validarDatosSiga(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_VALSIGA_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

   function actualizarMovMigSiga($id_movimiento){
   	
		$this->resetParametros();
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='ccb.f_movimiento_ime';
		$this->transaccion='CCB_ACTMOVMIG_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		
		$this->arreglo['id_movimiento'] = $id_movimiento;
		$this->setParametro('id_movimiento','id_movimiento','int4');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}



     function listarMovimientoIngresoMigracion(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='ccb.f_movimiento_sel';
		$this->transaccion='CCB_MIGCOLSIGA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		
		$this->setCount(false);
		
		$this->setParametro('id_casa_oracion','id_casa_oracion','int4');
		$this->setParametro('id_estado_periodo','id_estado_periodo','int4');		
		//Definicion de la lista del resultado del query
		$this->captura('id_movimiento','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('tipo','varchar');
		$this->captura('id_casa_oracion','int4');
		$this->captura('concepto','varchar');
		$this->captura('obs','text');
		$this->captura('fecha','date');
		$this->captura('id_estado_periodo','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');		
		$this->captura('id_tipo_movimiento_mantenimiento','int4');
		$this->captura('id_movimiento_det_mantenimiento','int4');
		$this->captura('monto_mantenimiento','numeric');		
		$this->captura('id_tipo_movimiento_especial','int4');
		$this->captura('id_movimiento_det_especial','int4');
		$this->captura('monto_especial','numeric');		
		$this->captura('id_tipo_movimiento_piedad','int4');
		$this->captura('id_movimiento_det_piedad','int4');
		$this->captura('monto_piedad','numeric');		
		$this->captura('id_tipo_movimiento_construccion','int4');
		$this->captura('id_movimiento_det_construccion','int4');
		$this->captura('monto_construccion','numeric');		
		$this->captura('id_tipo_movimiento_viaje','int4');
		$this->captura('id_movimiento_det_viaje','int4');
		$this->captura('monto_viaje','numeric');
		$this->captura('monto_dia','numeric');
		
		$this->captura('id_obrero','int4');
		$this->captura('desc_obrero','text');
		$this->captura('estado','varchar');
		
		$this->captura('desc_casa_oracion','varchar');
		$this->captura('mes','varchar');
		$this->captura('estado_periodo','varchar');
		$this->captura('id_gestion','int4');
		$this->captura('gestion','varchar');
		$this->captura('id_ot','integer');
		$this->captura('desc_orden','varchar');
		$this->captura('id_tipo_movimiento_ot','integer');
		$this->captura('nombre_tipo_mov_ot','varchar');
		
		$this->captura('migrado','varchar');
		$this->captura('fecha_migracion','timestamp');
		$this->captura('codigo_siga_periodo','varchar');
		$this->captura('codigo_siga_colecta','varchar');
		$this->captura('codigo_siga_casa','varchar');
		$this->captura('codigo_siga_region','varchar');
		
		
				

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	 
	 
	 
	 
		
			
}
?>