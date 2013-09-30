CREATE OR REPLACE FUNCTION "ccb"."f_estado_periodo_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_estado_periodo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.testado_periodo'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 14:35:36
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
	v_id_estado_periodo	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_estado_periodo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_PER_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	if(p_transaccion='CCB_PER_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.testado_periodo(
			estado_reg,
			estado_periodo,
			id_casa_oracion,
			num_mes,
			id_gestion,
			fecha_fin,
			mes,
			fecha_ini,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.estado_periodo,
			v_parametros.id_casa_oracion,
			v_parametros.num_mes,
			v_parametros.id_gestion,
			v_parametros.fecha_fin,
			v_parametros.mes,
			v_parametros.fecha_ini,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_estado_periodo into v_id_estado_periodo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo almacenado(a) con exito (id_estado_periodo'||v_id_estado_periodo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_id_estado_periodo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_PER_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elsif(p_transaccion='CCB_PER_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.testado_periodo set
			estado_periodo = v_parametros.estado_periodo,
			id_casa_oracion = v_parametros.id_casa_oracion,
			num_mes = v_parametros.num_mes,
			id_gestion = v_parametros.id_gestion,
			fecha_fin = v_parametros.fecha_fin,
			mes = v_parametros.mes,
			fecha_ini = v_parametros.fecha_ini,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_estado_periodo=v_parametros.id_estado_periodo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_parametros.id_estado_periodo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_PER_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elsif(p_transaccion='CCB_PER_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.testado_periodo
            where id_estado_periodo=v_parametros.id_estado_periodo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_parametros.id_estado_periodo::varchar);
              
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
ALTER FUNCTION "ccb"."f_estado_periodo_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
