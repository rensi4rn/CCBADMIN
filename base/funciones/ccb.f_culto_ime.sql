CREATE OR REPLACE FUNCTION "ccb"."f_culto_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_culto_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tculto'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 14:06:12
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
	v_id_culto	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_culto_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_CUL_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:06:12
	***********************************/

	if(p_transaccion='CCB_CUL_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tculto(
			estado_reg,
			id_casa_oracion,
			dia,
			hora,
			tipo_culto,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.id_casa_oracion,
			v_parametros.dia,
			v_parametros.hora,
			v_parametros.tipo_culto,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_culto into v_id_culto;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cultos almacenado(a) con exito (id_culto'||v_id_culto||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_culto',v_id_culto::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CUL_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:06:12
	***********************************/

	elsif(p_transaccion='CCB_CUL_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tculto set
			id_casa_oracion = v_parametros.id_casa_oracion,
			dia = v_parametros.dia,
			hora = v_parametros.hora,
			tipo_culto = v_parametros.tipo_culto,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_culto=v_parametros.id_culto;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cultos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_culto',v_parametros.id_culto::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CUL_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:06:12
	***********************************/

	elsif(p_transaccion='CCB_CUL_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tculto
            where id_culto=v_parametros.id_culto;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cultos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_culto',v_parametros.id_culto::varchar);
              
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
ALTER FUNCTION "ccb"."f_culto_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
