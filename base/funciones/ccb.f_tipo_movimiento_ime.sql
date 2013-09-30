--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_tipo_movimiento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_tipo_movimiento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.ttipo_movimiento'
 AUTOR: 		 (admin)
 FECHA:	        15-03-2013 23:21:53
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
	v_id_tipo_movimiento	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_tipo_movimiento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TMOV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-03-2013 23:21:53
	***********************************/

	if(p_transaccion='CCB_TMOV_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.ttipo_movimiento(
			estado_reg,
			
			codigo,
			nombre,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			
			v_parametros.codigo,
			v_parametros.nombre,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_tipo_movimiento into v_id_tipo_movimiento;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Movimiento almacenado(a) con exito (id_tipo_movimiento'||v_id_tipo_movimiento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_movimiento',v_id_tipo_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TMOV_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-03-2013 23:21:53
	***********************************/

	elsif(p_transaccion='CCB_TMOV_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.ttipo_movimiento set
			
			codigo = v_parametros.codigo,
			nombre = v_parametros.nombre,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_tipo_movimiento=v_parametros.id_tipo_movimiento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Movimiento modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_movimiento',v_parametros.id_tipo_movimiento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TMOV_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		15-03-2013 23:21:53
	***********************************/

	elsif(p_transaccion='CCB_TMOV_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.ttipo_movimiento
            where id_tipo_movimiento=v_parametros.id_tipo_movimiento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Movimiento eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_movimiento',v_parametros.id_tipo_movimiento::varchar);
              
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