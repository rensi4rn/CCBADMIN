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
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
		
			
}
?>