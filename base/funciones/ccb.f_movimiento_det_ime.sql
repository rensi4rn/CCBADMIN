--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_movimiento_det_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_movimiento_det_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tmovimiento_det'
 AUTOR: 		 (admin)
 FECHA:	        25-03-2013 02:03:18
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
	v_id_movimiento_det	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_movimiento_det_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_MOVD_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-03-2013 02:03:18
	***********************************/

	if(p_transaccion='CCB_MOVD_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tmovimiento_det(
			estado_reg,
			id_movimiento,
			monto,
			id_tipo_movimiento,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.id_movimiento,
			v_parametros.monto,
			v_parametros.id_tipo_movimiento,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_movimiento_det into v_id_movimiento_det;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle de Movimiento almacenado(a) con exito (id_movimiento_det'||v_id_movimiento_det||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento_det',v_id_movimiento_det::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOVD_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-03-2013 02:03:18
	***********************************/

	elsif(p_transaccion='CCB_MOVD_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tmovimiento_det set
			id_movimiento = v_parametros.id_movimiento,
			monto = v_parametros.monto,
			id_tipo_movimiento = v_parametros.id_tipo_movimiento,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle de Movimiento modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento_det',v_parametros.id_movimiento_det::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOVD_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		25-03-2013 02:03:18
	***********************************/

	elsif(p_transaccion='CCB_MOVD_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tmovimiento_det
            where id_movimiento_det=v_parametros.id_movimiento_det;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Detalle de Movimiento eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento_det',v_parametros.id_movimiento_det::varchar);
              
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