--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_region_evento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_region_evento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tregion_evento'
 AUTOR: 		 (admin)
 FECHA:	        13-01-2013 14:31:26
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
	v_id_region_evento	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_region_evento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	if(p_transaccion='CCB_REGE_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tregion_evento(
			estado_reg,
			id_gestion,
			fecha_programada,
			id_evento,
			estado,
			id_region,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
            id_casa_oracion,
            tipo_registro
          	) values(
			'activo',
			v_parametros.id_gestion,
			v_parametros.fecha_programada,
			v_parametros.id_evento,
			v_parametros.estado,
			v_parametros.id_region,
			now(),
			p_id_usuario,
			null,
			null,
            v_parametros.id_casa_oracion,
            v_parametros.tipo_registro
            
							
			)RETURNING id_region_evento into v_id_region_evento;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región almacenado(a) con exito (id_region_evento'||v_id_region_evento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_id_region_evento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGE_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tregion_evento set
			id_gestion = v_parametros.id_gestion,
			fecha_programada = v_parametros.fecha_programada,
			id_evento = v_parametros.id_evento,
			estado = v_parametros.estado,
			id_region = v_parametros.id_region,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
            id_casa_oracion =  v_parametros.id_casa_oracion,
            tipo_registro = v_parametros.tipo_registro
			where id_region_evento=v_parametros.id_region_evento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tregion_evento
            where id_region_evento=v_parametros.id_region_evento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
              
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