CREATE OR REPLACE FUNCTION "ccb"."ft_casa_banco_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_casa_banco_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tcasa_banco'
 AUTOR: 		 (admin)
 FECHA:	        02-03-2016 01:06:45
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
	v_id_casa_banco	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.ft_casa_banco_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_COB_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		02-03-2016 01:06:45
	***********************************/

	if(p_transaccion='CCB_COB_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tcasa_banco(
			estado_reg,
			id_casa_oracion,
			id_tipo_movimiento,
			obs,
			id_cuenta_bancaria,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.id_casa_oracion,
			v_parametros.id_tipo_movimiento,
			v_parametros.obs,
			v_parametros.id_cuenta_bancaria,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_casa_banco into v_id_casa_banco;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas Bancarias almacenado(a) con exito (id_casa_banco'||v_id_casa_banco||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_banco',v_id_casa_banco::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_COB_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		02-03-2016 01:06:45
	***********************************/

	elsif(p_transaccion='CCB_COB_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tcasa_banco set
			id_casa_oracion = v_parametros.id_casa_oracion,
			id_tipo_movimiento = v_parametros.id_tipo_movimiento,
			obs = v_parametros.obs,
			id_cuenta_bancaria = v_parametros.id_cuenta_bancaria,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_casa_banco=v_parametros.id_casa_banco;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas Bancarias modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_banco',v_parametros.id_casa_banco::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_COB_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		02-03-2016 01:06:45
	***********************************/

	elsif(p_transaccion='CCB_COB_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tcasa_banco
            where id_casa_banco=v_parametros.id_casa_banco;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cuentas Bancarias eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_banco',v_parametros.id_casa_banco::varchar);
              
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
ALTER FUNCTION "ccb"."ft_casa_banco_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
