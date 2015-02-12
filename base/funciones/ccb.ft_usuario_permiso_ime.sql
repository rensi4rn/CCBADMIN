CREATE OR REPLACE FUNCTION "ccb"."ft_usuario_permiso_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_usuario_permiso_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tusuario_permiso'
 AUTOR: 		 (admin)
 FECHA:	        12-02-2015 14:36:49
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
	v_id_usuario_permiso	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.ft_usuario_permiso_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_usper_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		12-02-2015 14:36:49
	***********************************/

	if(p_transaccion='CCB_usper_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tusuario_permiso(
			estado_reg,
			id_casa_oracion,
			id_usuario_asignado,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.id_casa_oracion,
			v_parametros.id_usuario_asignado,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_usuario_permiso into v_id_usuario_permiso;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuarios autorizados almacenado(a) con exito (id_usuario_permiso'||v_id_usuario_permiso||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_permiso',v_id_usuario_permiso::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_usper_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		12-02-2015 14:36:49
	***********************************/

	elsif(p_transaccion='CCB_usper_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tusuario_permiso set
			id_casa_oracion = v_parametros.id_casa_oracion,
			id_usuario_asignado = v_parametros.id_usuario_asignado,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_usuario_permiso=v_parametros.id_usuario_permiso;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuarios autorizados modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_permiso',v_parametros.id_usuario_permiso::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_usper_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		12-02-2015 14:36:49
	***********************************/

	elsif(p_transaccion='CCB_usper_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tusuario_permiso
            where id_usuario_permiso=v_parametros.id_usuario_permiso;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuarios autorizados eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_permiso',v_parametros.id_usuario_permiso::varchar);
              
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
ALTER FUNCTION "ccb"."ft_usuario_permiso_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
