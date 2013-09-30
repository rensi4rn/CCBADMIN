CREATE OR REPLACE FUNCTION "ccb"."f_tipo_ministerio_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_tipo_ministerio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.ttipo_ministerio'
 AUTOR: 		 (admin)
 FECHA:	        05-01-2013 07:25:26
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
	v_id_tipo_ministerio	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_tipo_ministerio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TIPMI_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 07:25:26
	***********************************/

	if(p_transaccion='CCB_TIPMI_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.ttipo_ministerio(
			tipo,
			nombre,
			estado_reg,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.tipo,
			v_parametros.nombre,
			'activo',
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_tipo_ministerio into v_id_tipo_ministerio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ministerio almacenado(a) con exito (id_tipo_ministerio'||v_id_tipo_ministerio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ministerio',v_id_tipo_ministerio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TIPMI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 07:25:26
	***********************************/

	elsif(p_transaccion='CCB_TIPMI_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.ttipo_ministerio set
			tipo = v_parametros.tipo,
			nombre = v_parametros.nombre,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_tipo_ministerio=v_parametros.id_tipo_ministerio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ministerio modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ministerio',v_parametros.id_tipo_ministerio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TIPMI_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 07:25:26
	***********************************/

	elsif(p_transaccion='CCB_TIPMI_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.ttipo_ministerio
            where id_tipo_ministerio=v_parametros.id_tipo_ministerio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ministerio eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ministerio',v_parametros.id_tipo_ministerio::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ccb"."f_tipo_ministerio_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
