CREATE OR REPLACE FUNCTION "ccb"."ft_tipo_documento_ccb_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_tipo_documento_ccb_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.ttipo_documento_ccb'
 AUTOR: 		 (admin)
 FECHA:	        29-02-2016 09:49:41
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
	v_id_tipo_documento_ccb	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.ft_tipo_documento_ccb_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TID_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-02-2016 09:49:41
	***********************************/

	if(p_transaccion='CCB_TID_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.ttipo_documento_ccb(
			codigo,
			estado_reg,
			nombre,
			id_plantilla,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.codigo,
			'activo',
			v_parametros.nombre,
			v_parametros.id_plantilla,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_tipo_documento_ccb into v_id_tipo_documento_ccb;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Documento almacenado(a) con exito (id_tipo_documento_ccb'||v_id_tipo_documento_ccb||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_documento_ccb',v_id_tipo_documento_ccb::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TID_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-02-2016 09:49:41
	***********************************/

	elsif(p_transaccion='CCB_TID_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.ttipo_documento_ccb set
			codigo = v_parametros.codigo,
			nombre = v_parametros.nombre,
			id_plantilla = v_parametros.id_plantilla,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_documento_ccb=v_parametros.id_tipo_documento_ccb;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Documento modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_documento_ccb',v_parametros.id_tipo_documento_ccb::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TID_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-02-2016 09:49:41
	***********************************/

	elsif(p_transaccion='CCB_TID_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.ttipo_documento_ccb
            where id_tipo_documento_ccb=v_parametros.id_tipo_documento_ccb;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo Documento eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_documento_ccb',v_parametros.id_tipo_documento_ccb::varchar);
              
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
ALTER FUNCTION "ccb"."ft_tipo_documento_ccb_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
