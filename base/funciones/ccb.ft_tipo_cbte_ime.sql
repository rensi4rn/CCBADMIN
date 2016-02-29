CREATE OR REPLACE FUNCTION "ccb"."ft_tipo_cbte_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_tipo_cbte_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.ttipo_cbte'
 AUTOR: 		 (admin)
 FECHA:	        28-02-2016 13:24:23
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
	v_id_tipo_cbte	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.ft_tipo_cbte_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TCB_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:23
	***********************************/

	if(p_transaccion='CCB_TCB_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.ttipo_cbte(
			descripcion,
			estado_reg,
			codigo,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.descripcion,
			'activo',
			v_parametros.codigo,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null
							
			
			
			)RETURNING id_tipo_cbte into v_id_tipo_cbte;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo CBTE almacenado(a) con exito (id_tipo_cbte'||v_id_tipo_cbte||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_cbte',v_id_tipo_cbte::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TCB_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:23
	***********************************/

	elsif(p_transaccion='CCB_TCB_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.ttipo_cbte set
			descripcion = v_parametros.descripcion,
			codigo = v_parametros.codigo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_cbte=v_parametros.id_tipo_cbte;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo CBTE modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_cbte',v_parametros.id_tipo_cbte::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TCB_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:23
	***********************************/

	elsif(p_transaccion='CCB_TCB_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.ttipo_cbte
            where id_tipo_cbte=v_parametros.id_tipo_cbte;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo CBTE eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_cbte',v_parametros.id_tipo_cbte::varchar);
              
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
ALTER FUNCTION "ccb"."ft_tipo_cbte_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
