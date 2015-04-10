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
	v_id_movimiento			integer;
    
    v_registros 			record;
    v_monto 				numeric;
    v_id_estado_periodo		integer;
    v_estado_periodo        varchar;
			    
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
			now(),
			p_id_usuario
							
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
 	#TRANSACCION:  'CCB_MOVING_INS'
 	#DESCRIPCION:	Insercion de movimientos de ingresos
 	#AUTOR:		admin	
 	#FECHA:		03-04-2015 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOVING_INS')then
					
        begin
        
              select 
                ep.estado_periodo,
                ep.id_estado_periodo
              into
                v_estado_periodo,
                v_id_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
        	
            
            
            
            
            
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
			id_usuario_mod,
            id_obrero,
            estado
          	) values(
			'activo',
			v_parametros.tipo,
			v_parametros.id_casa_oracion,
			v_parametros.concepto,
			v_parametros.obs,
			v_parametros.fecha,
			v_id_estado_periodo,
			now(),
			p_id_usuario,
			now(),
			p_id_usuario,
            v_parametros.id_obrero,
            v_parametros.estado
							
			)RETURNING id_movimiento into v_id_movimiento;
            
            
            
            FOR v_registros in (
                             select
                              tm.id_tipo_movimiento,
                              tm.codigo
                             from ccb.ttipo_movimiento tm where tm.estado_reg='activo' ) LOOP
             
                   v_monto = 0;
                   IF v_registros.codigo = 'mantenimiento' THEN
                      v_monto = v_parametros.monto_mantenimiento;
                   ELSIF  v_registros.codigo = 'piedad' THEN
                      v_monto = v_parametros.monto_piedad;
                   ELSIF  v_registros.codigo = 'especial' THEN
                      v_monto = v_parametros.monto_especial;
                   ELSIF  v_registros.codigo = 'viaje' THEN
                      v_monto = v_parametros.monto_viaje;
                   ELSIF  v_registros.codigo = 'construccion' THEN
                      v_monto = v_parametros.monto_construccion;
                   END IF ; 
                  
                  INSERT INTO 
                    ccb.tmovimiento_det(
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
                      COALESCE(v_monto,0)
                     );
             
            END LOOP;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos almacenado(a) con exito (id_movimiento'||v_id_movimiento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento',v_id_movimiento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
    
    
    /*********************************    
 	#TRANSACCION:  'CCB_MOVEGRE_INS'
 	#DESCRIPCION:	Insercion de movimientos de egresos
 	#AUTOR:		admin	
 	#FECHA:		03-04-2015 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOVEGRE_INS')then
					
        begin
            
               select 
                ep.estado_periodo,
                ep.id_estado_periodo
              into
                v_estado_periodo,
                v_id_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
        
        
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
                id_usuario_mod,
                id_obrero,
                estado,
                tipo_documento,
                num_documento
          	) values(
				'activo',
                v_parametros.tipo,
                v_parametros.id_casa_oracion,
                v_parametros.concepto,
                v_parametros.obs,
                v_parametros.fecha,
                v_id_estado_periodo,
                now(),
                p_id_usuario,
                now(),
                p_id_usuario,
                v_parametros.id_obrero,
                v_parametros.estado,
                v_parametros.tipo_documento,
                v_parametros.num_documento
							
			)RETURNING id_movimiento into v_id_movimiento;
            
            
            INSERT INTO 
              ccb.tmovimiento_det(
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
                v_parametros.id_tipo_movimiento,
                v_id_movimiento,
                COALESCE(v_parametros.monto,0)
               );
             
           
			--raise exception 'ssss  %', v_id_movimiento;
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
 	#TRANSACCION:  'CCB_MOVING_MOD'
 	#DESCRIPCION:	Modificacion de movimientos de ingreso
 	#AUTOR:		admin	
 	#FECHA:		03-04-2015 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOVING_MOD')then

		begin
              select 
                ep.estado_periodo,
                ep.id_estado_periodo
              into
                v_estado_periodo,
                v_id_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
        
        
			--Sentencia de la modificacion
			update ccb.tmovimiento set
              tipo = v_parametros.tipo,
              id_casa_oracion = v_parametros.id_casa_oracion,
              concepto = v_parametros.concepto,
              obs = v_parametros.obs,
              fecha = v_parametros.fecha,
              id_estado_periodo = v_id_estado_periodo,
              fecha_mod = now(),
              id_usuario_mod = p_id_usuario,
             id_obrero = v_parametros.id_obrero,
             estado = v_parametros.estado
			where id_movimiento=v_parametros.id_movimiento;
            
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto_mantenimiento,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det_mantenimiento;
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto_piedad,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det_piedad;
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto_viaje,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det_viaje;
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto_especial,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det_especial;
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto_construccion,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det_construccion;
            
            
            
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_movimiento',v_parametros.id_movimiento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;    
        
    /*********************************    
 	#TRANSACCION:  'CCB_MOVEGRE_MOD'
 	#DESCRIPCION:	Modificacion de movimientos de egreso
 	#AUTOR:		admin	
 	#FECHA:		03-04-2015 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOVEGRE_MOD')then

		begin
              select 
                ep.estado_periodo,
                ep.id_estado_periodo
              into
                v_estado_periodo,
                v_id_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
        
        
        
			--Sentencia de la modificacion
			update ccb.tmovimiento set
              tipo = v_parametros.tipo,
              id_casa_oracion = v_parametros.id_casa_oracion,
              concepto = v_parametros.concepto,
              obs = v_parametros.obs,
              fecha = v_parametros.fecha,
              id_estado_periodo = v_id_estado_periodo,
              fecha_mod = now(),
              id_usuario_mod = p_id_usuario,
             id_obrero = v_parametros.id_obrero,
             estado = v_parametros.estado,
             tipo_documento = v_parametros.tipo_documento,
             num_documento = v_parametros.num_documento
			where id_movimiento=v_parametros.id_movimiento;
            
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario
			where id_movimiento_det=v_parametros.id_movimiento_det;
            
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Movimientos de egreso modificado'); 
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
        
        
              select 
                ep.estado_periodo,
                ep.id_estado_periodo
              into
                v_estado_periodo,
                v_id_estado_periodo
              from ccb.tmovimiento mov
              inner join ccb.testado_periodo ep  on mov.id_estado_periodo = ep.id_estado_periodo
              where mov.id_movimiento = v_parametros.id_movimiento;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'No puede borrar el periodo correspondiente se encuentra cerrado';
              END IF;
        
            delete from ccb.tmovimiento_det
            where id_movimiento=v_parametros.id_movimiento;
            
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