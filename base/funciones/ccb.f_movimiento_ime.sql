--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_movimiento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_movimiento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tmovimiento'
 AUTOR: 		 (admin)
 FECHA:	        16-03-2013 00:22:36
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
	v_id_movimiento	integer;
    
    v_registros record;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_movimiento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_MOV_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	if(p_transaccion='CCB_MOV_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tmovimiento(
			estado_reg,
			tipo,
			id_casa_oracion,
			concepto,
			obs,
			fecha,
			id_estado_periodo,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.tipo,
			v_parametros.id_casa_oracion,
			v_parametros.concepto,
			v_parametros.obs,
			v_parametros.fecha,
			v_parametros.id_estado_periodo,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_movimiento into v_id_movimiento;
            
            
            IF v_parametros.concepto='colecta_adultos' or v_parametros.concepto='colecta_jovenes'THEN
            --introducir el detalle de movimiento con todos los tipo de movimiento con valor 0
            
            
                FOR v_registros in (
                             select
                              tm.id_tipo_movimiento
                             from ccb.ttipo_movimiento tm where tm.estado_reg='activo' ) LOOP
             
                
                              INSERT INTO 
                                ccb.tmovimiento_det
                              (
                                id_usuario_reg,
                                fecha_reg,
                                estado_reg,
                              
                                id_tipo_movimiento,
                                id_movimiento,
                                monto
                              ) 
                              VALUES (
                                p_id_usuario,
                                now(),
                                'activo',
                                v_registros.id_tipo_movimiento,
                                v_id_movimiento,
                                0
                				);
                
                
                END LOOP;
            
            
            END IF;
            
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos almacenado(a) con exito (id_movimiento'||v_id_movimiento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento',v_id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOV_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOV_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tmovimiento set
			tipo = v_parametros.tipo,
			id_casa_oracion = v_parametros.id_casa_oracion,
			concepto = v_parametros.concepto,
			obs = v_parametros.obs,
			fecha = v_parametros.fecha,
			id_estado_periodo = v_parametros.id_estado_periodo,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_movimiento=v_parametros.id_movimiento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento',v_parametros.id_movimiento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOV_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOV_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tmovimiento
            where id_movimiento=v_parametros.id_movimiento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento',v_parametros.id_movimiento::varchar);
              
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