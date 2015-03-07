--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_detalle_evento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_detalle_evento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tdetalle_evento'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 13:45:38
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_detalle_evento		integer;
    v_fecha_programada		date;
    v_regitros_padre      	record;
    v_estado_periodo		varchar;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_detalle_evento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_DEV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 13:45:38
	***********************************/

	if(p_transaccion='CCB_DEV_INS')then
					
        begin
        
           --revisa si el periodo esta abierto
             
            select 
              re.fecha_programada,
              re.id_casa_oracion
            into
              v_regitros_padre
            from ccb.tregion_evento re 
            where re.id_region_evento = v_parametros.id_region_evento;
            
             select 
              ep.estado_periodo
            into
              v_estado_periodo
            from ccb.testado_periodo ep 
            where ep.id_casa_oracion = v_regitros_padre.id_casa_oracion
                 and  v_regitros_padre.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
            IF v_estado_periodo = 'cerrado' THEN
                raise exception 'el periodo correspondiente se encuentra cerrado';
            END IF;
           
        
        	--Sentencia de la insercion
        	insert into ccb.tdetalle_evento(
			estado_reg,
			cantidad,
			id_region_evento,
			id_tipo_ministerio,
			obs,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.cantidad,
			v_parametros.id_region_evento,
			v_parametros.id_tipo_ministerio,
			v_parametros.obs,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_detalle_evento into v_id_detalle_evento;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Evento almacenado(a) con exito (id_detalle_evento'||v_id_detalle_evento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_detalle_evento',v_id_detalle_evento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_DEV_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 13:45:38
	***********************************/

	elsif(p_transaccion='CCB_DEV_MOD')then

		begin
            --revisa si el periodo esta abierto
             
            select 
              re.fecha_programada,
              re.id_casa_oracion
            into
              v_regitros_padre
            from ccb.tregion_evento re 
            where re.id_region_evento = v_parametros.id_region_evento;
            
             select 
              ep.estado_periodo
            into
              v_estado_periodo
            from ccb.testado_periodo ep 
            where ep.id_casa_oracion = v_regitros_padre.id_casa_oracion
                 and  v_regitros_padre.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
            IF v_estado_periodo = 'cerrado' THEN
                raise exception 'el periodo correspondiente se encuentra cerrado';
            END IF;
        
        
			--Sentencia de la modificacion
			update ccb.tdetalle_evento set
			cantidad = v_parametros.cantidad,
			id_region_evento = v_parametros.id_region_evento,
			id_tipo_ministerio = v_parametros.id_tipo_ministerio,
			obs = v_parametros.obs,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_detalle_evento=v_parametros.id_detalle_evento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Evento modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_detalle_evento',v_parametros.id_detalle_evento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_DEV_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 13:45:38
	***********************************/

	elsif(p_transaccion='CCB_DEV_ELI')then

		begin
			
            --revisa si el periodo esta abierto
            select 
              re.fecha_programada,
              re.id_casa_oracion
            into
              v_regitros_padre
            from ccb.tregion_evento re 
            inner join ccb.tdetalle_evento de on de.id_region_evento = re.id_region_evento
            where de.id_detalle_evento  = v_parametros.id_detalle_evento;
            
             select 
              ep.estado_periodo
            into
              v_estado_periodo
            from ccb.testado_periodo ep 
            where ep.id_casa_oracion = v_regitros_padre.id_casa_oracion
                 and  v_regitros_padre.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
            IF v_estado_periodo = 'cerrado' THEN
                raise exception 'el periodo correspondiente se encuentra cerrado';
            END IF;
            
            
            --Sentencia de la eliminacion
			delete from ccb.tdetalle_evento
            where id_detalle_evento=v_parametros.id_detalle_evento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle Evento eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_detalle_evento',v_parametros.id_detalle_evento::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;