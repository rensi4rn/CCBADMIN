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
    v_registros_2			record;
    v_monto 				numeric;
    v_id_estado_periodo		integer;
    v_estado_periodo        varchar;
    v_id_gestion			integer;
    v_ingreso_colectas     			numeric;
    v_ingreso_traspasos    			numeric;
    v_ingreso_inicial    			numeric;
    v_ingreso_total    				numeric;
    v_egreso_operacion    			numeric;
    v_egreso_traspaso    			numeric;
    v_egresos_contra_rendicion   	numeric;
    v_egresos_rendidos    			numeric;
    v_egreso_inicial_por_rendir   	numeric;
    v_egreso_efectivo    			numeric;
    v_saldo_efectivo    			numeric;
    v_saldo_adm    					numeric;
    v_sado_x_rendir    				numeric;
    v_fecha_ini						date;
    v_fecha_ultimo_anterior			date;
    v_estado_periodo_ant			varchar;
    v_id_estado_periodo_ant			integer;    
    
    
    v_id_tm_mantenimiento   		integer;        
    v_saldo_adm_mantenimiento		numeric;
    v_id_tm_piedad					integer;
    v_saldo_adm_piedad				numeric;
    v_id_tm_especial				integer;
    v_saldo_adm_especial			numeric;
    v_id_tm_viaje					integer;
    v_saldo_adm_viaje				numeric;
    v_id_tm_construccion			integer;
    v_saldo_adm_construccion		numeric;
    v_cadena						varchar;
    v_id_gestion_ant				integer;    
    v_total_colecta 				numeric;
    v_colecta_contruccion 			numeric;
    v_colecta_piedad 				numeric; 
    v_colecta_viaje 				numeric; 
    v_colecta_especial 				numeric; 
    v_colecta_mantenimiento			numeric;
    
    v_total_ing_traspasos 			numeric;
    v_ing_traspasos_contruccion 	numeric; 
    v_ing_traspasos_piedad  		numeric; 
    v_ing_traspasos_viaje 			numeric; 
    v_ing_traspasos_especial 		numeric; 
    v_ing_traspasos_mantenimiento	numeric;
    
    v_total_egre_traspasos 			numeric; 
    v_egre_traspasos_contruccion 	numeric; 
    v_egre_traspasos_piedad  		numeric; 
    v_egre_traspasos_viaje 			numeric; 
    v_egre_traspasos_especial 		numeric; 
    v_egre_traspasos_mantenimiento	numeric;
    
    v_total_egreso_operacion 	numeric; 
    v_egreso_operacion_contruccion 	numeric; 
    v_egreso_operacion_piedad  		numeric; 
    v_egreso_operacion_viaje 		numeric; 
    v_egreso_operacion_especial 	numeric; 
    v_egreso_operacion_mantenimiento	numeric;
    v_total_egreso_contra_rendicion 	numeric;    
    v_egreso_contra_rendicion_contruccion 	numeric;
    v_egreso_contra_rendicion_piedad  	numeric;
    v_egreso_contra_rendicion_viaje 	numeric; 
    v_egreso_contra_rendicion_especial 	numeric;
    v_egreso_contra_rendicion_mantenimiento	numeric;
    
    v_total_egresos_adm 				numeric;           
    v_total_egresos_adm_contruccion 	numeric;
    v_total_egresos_adm_piedad			numeric;
    v_total_egresos_adm_viaje			numeric;
    v_total_egresos_adm_especial		numeric;     
    v_total_egresos_adm_mantenimiento 	numeric;
    
    v_total_egresos_adm_tmp 				numeric;           
    v_total_egresos_adm_contruccion_tmp 	numeric;
    v_total_egresos_adm_piedad_tmp			numeric;
    v_total_egresos_adm_viaje_tmp			numeric;
    v_total_egresos_adm_especial_tmp		numeric;     
    v_total_egresos_adm_mantenimiento_tmp 	numeric;
    
    
    
    v_total_saldo_mes 					numeric;
    v_saldo_mes_mantenimiento 			numeric; 
    v_saldo_mes_piedad 					numeric;
    v_saldo_mes_construccion 			numeric; 
    v_saldo_mes_especial 				numeric; 
    v_saldo_mes_viaje					numeric;
    
    v_total_saldo_adm					numeric;
    v_mes 								varchar;
    v_gestion 							varchar;
            
           
            
            
            
			    
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
              
            -- obtiene datos de la casa de oración 
              
              
        	
            
            --TODO si el concepto es saldo inicial verifica que solo exista uno por gestion para la casa de oración
            
            
            
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
            id_ot,
            id_tipo_movimiento_ot
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
            v_parametros.id_ot,
            v_parametros.id_tipo_movimiento_ot
							
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
              --TODO si el concepto es egreso_inicial_por_rendir   verificar que solo exista uno por gestion para la casa de oración
            
            
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
                num_documento,
                id_ot
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
                v_parametros.num_documento,
                v_parametros.id_ot
							
			)RETURNING id_movimiento into v_id_movimiento;
            
            
            INSERT INTO 
              ccb.tmovimiento_det(
                id_usuario_reg,
                fecha_reg,
                estado_reg,
                id_tipo_movimiento,
                id_movimiento,
                monto,
                id_concepto_ingas
              ) 
              VALUES (
                p_id_usuario,
                now(),
                'activo',
                v_parametros.id_tipo_movimiento,
                v_id_movimiento,
                COALESCE(v_parametros.monto,0),
                v_parametros.id_concepto_ingas
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
             estado = v_parametros.estado,
             id_ot = v_parametros.id_ot,
             id_tipo_movimiento_ot = v_parametros.id_tipo_movimiento_ot
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
             num_documento = v_parametros.num_documento,
             id_ot = v_parametros.id_ot
			where id_movimiento=v_parametros.id_movimiento;
            
            
            update ccb.tmovimiento_det set
			 monto = COALESCE(v_parametros.monto,0),
			 fecha_mod = now(),
			 id_usuario_mod = p_id_usuario,
             id_tipo_movimiento = v_parametros.id_tipo_movimiento,
             id_concepto_ingas = v_parametros.id_concepto_ingas
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
    /*********************************    
 	#TRANSACCION:  'CCB_CALSALDO_IME'
 	#DESCRIPCION:	Calcular saldo a la fecha indicada
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_CALSALDO_IME')then

		begin
            
        
            --obtenemos la gestion a partir  de la fecha
            select 
              g.id_gestion
            into
              v_id_gestion
            from ccb.tgestion g  
            where  v_parametros.fecha::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
            IF v_id_gestion is NULL THEN
              raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
            END IF;
            
            
            --Definicion de la respuesta
            v_resp = ccb.f_calculo_saldos(v_id_gestion, 
                                         v_parametros.fecha, 
                                         v_parametros.id_lugar, 
                                         v_parametros.id_casa_oracion, 
                                         v_parametros.id_region, 
                                         v_parametros.id_obrero, 
                                         v_parametros.id_tipo_movimiento, 
                                         v_parametros.id_ot);
            
            
            
              
            --Devuelve la respuesta
            return v_resp;

		end;     
	/*********************************    
 	#TRANSACCION:  'CCB_CBTEOFRE_IME'
 	#DESCRIPCION:	comprobante de ofrendeas, colectas y transferencias ocurridas
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_CBTEOFRE_IME')then

		begin
        
        
        
             /*
                 I)   determinar SALDOS
                 II)  determinar INGESOS
                 III) determinar ingreso por trapasos
                 IV)  determinar egresos por trapasos
                 V)   determinar egresos de la adminsitracion 
                 VI)  determinar saldos del mes en la administracion
             */
            
            --determinar el mes del reporte
            
           
            select 
                ep.estado_periodo,
                ep.id_estado_periodo,
                ep.fecha_ini,
                ges.id_gestion,
                ep.mes,
                ges.gestion
              into
                v_estado_periodo,
                v_id_estado_periodo,
                v_fecha_ini,
                v_id_gestion,
                v_mes,
                v_gestion
              from ccb.testado_periodo ep 
              inner join ccb.tgestion ges on ges.id_gestion = ep.id_gestion
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;
                   
            IF v_estado_periodo is NULL THEN
              raise exception 'No se encontro un periodo para la fecha indicada %',v_parametros.fecha; 
            END IF;
            
            
            SELECT 
              co.nombre,
              co.codigo,
              reg.nombre as region
            into
             v_registros_2
            FROM ccb.tcasa_oracion co 
            inner join ccb.tregion reg on reg.id_region = co.id_region
            where  co.id_casa_oracion =   v_parametros.id_casa_oracion;
            
            --determinar el mes anterior para calcula el saldo del mes
            
            v_fecha_ultimo_anterior =  v_fecha_ini - interval '1 day';      
            
            --determinar gestion del la ultima fecha (podra ser enero de 2015 y la fecha ulitma seria 31 de diciembre de 2014)
            
            select 
                ep.estado_periodo,
                ep.id_estado_periodo,
                ges.id_gestion
              into
                v_estado_periodo_ant,
                v_id_estado_periodo_ant,
                v_id_gestion_ant
              from ccb.testado_periodo ep 
              inner join ccb.tgestion ges on ges.id_gestion = ep.id_gestion
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_fecha_ultimo_anterior::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;
                   
                   
            
            IF v_estado_periodo_ant is NULL THEN
              raise exception 'No se encontro periodo precedente para la fecha: %',v_fecha_ultimo_anterior; 
            END IF;
            
            IF v_id_gestion_ant is NULL THEN
              raise exception 'No se encontro gestion de la fecha anterior %',v_fecha_ultimo_anterior; 
            END IF;
           
            
            /********************************************           
            --  I)  DETERMINAR SALDO DEL PERIODO ANTERIOR
            *********************************************/
            
           
            --determinar id de los tipos de movimientos ...
           
            v_saldo_adm_mantenimiento = 0;         
            v_saldo_adm_piedad = 0;          
            v_saldo_adm_especial = 0;           
            v_saldo_adm_viaje = 0;           
            v_saldo_adm_construccion = 0;
            
             FOR v_registros in (
                             select
                              tm.id_tipo_movimiento,
                              tm.codigo
                             from ccb.ttipo_movimiento tm where tm.estado_reg='activo' ) LOOP
             
                   v_monto = 0;
                   
                   -- raise exception 'yyyyyyyyyyyy % - %  - % - %',v_id_gestion_ant, v_fecha_ultimo_anterior , v_parametros.id_casa_oracion, v_registros.id_tipo_movimiento   ;
                   
                   -- determinar administrativo del mes anterior anterior
                    v_cadena = ccb.f_calculo_saldos(v_id_gestion_ant, 
                                                     v_fecha_ultimo_anterior, 
                                                     NULL, --.id_lugar, 
                                                     v_parametros.id_casa_oracion, 
                                                     NULL, --.id_region, 
                                                     NULL, --id_obrero, 
                                                     v_registros.id_tipo_movimiento, --id_tipo_movimiento, 
                                                     NULL);
                   
                   IF v_registros.codigo = 'mantenimiento' THEN
                     v_id_tm_mantenimiento =  v_registros.id_tipo_movimiento;
                     v_saldo_adm_mantenimiento = COALESCE(((pxp.f_recupera_clave(v_cadena, 'v_saldo_adm'))[1])::numeric,0);
                     
                   ELSIF  v_registros.codigo = 'piedad' THEN
                     v_id_tm_piedad =  v_registros.id_tipo_movimiento;
                     v_saldo_adm_piedad =  COALESCE(((pxp.f_recupera_clave(v_cadena, 'v_saldo_adm'))[1])::numeric,0);
                     
                   ELSIF  v_registros.codigo = 'especial' THEN
                     v_id_tm_especial =  v_registros.id_tipo_movimiento;
                     v_saldo_adm_especial =  COALESCE(((pxp.f_recupera_clave(v_cadena, 'v_saldo_adm'))[1])::numeric,0);
                     
                   ELSIF  v_registros.codigo = 'viaje' THEN
                     v_id_tm_viaje =  v_registros.id_tipo_movimiento;
                     v_saldo_adm_viaje =  COALESCE(((pxp.f_recupera_clave(v_cadena, 'v_saldo_adm'))[1])::numeric,0);
                   ELSIF  v_registros.codigo = 'construccion' THEN
                     v_id_tm_construccion =  v_registros.id_tipo_movimiento;
                     v_saldo_adm_construccion =  COALESCE(((pxp.f_recupera_clave(v_cadena, 'v_saldo_adm'))[1])::numeric,0);
                   END IF ;
             
            
            
            END LOOP;
            
            
             
            v_total_saldo_adm = v_saldo_adm_construccion + v_saldo_adm_viaje +  v_saldo_adm_especial + v_saldo_adm_piedad + v_saldo_adm_mantenimiento;
            
            
           -- raise exception 'ssss';
            /********************************************           
            --  II)  DETERMINAR INGRESOS DEL PERIODO
            *********************************************/
            
            
            -- determinar colecta de contruccion v_colecta_contruccion
            v_colecta_contruccion = ccb.f_determina_balance_periodo('ingreso_colectas',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_construccion, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            -- determinar colecta de piedad v_colecta_piedad 
            v_colecta_piedad = ccb.f_determina_balance_periodo('ingreso_colectas',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_piedad, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de viajes v_colecta_viaje
            v_colecta_viaje = ccb.f_determina_balance_periodo('ingreso_colectas',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_viaje, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta especiales v_colecta_especial
             v_colecta_especial = ccb.f_determina_balance_periodo('ingreso_colectas',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_especial, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de mantenimiento v_colecta_mantenimiento
            v_colecta_mantenimiento = ccb.f_determina_balance_periodo('ingreso_colectas',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_mantenimiento, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar el total de colectas   v_total_colecta
            -- v_total_colecta = v_colecta_contruccion + v_colecta_piedad + v_colecta_piedad_juvenud_piedad + v_colecta_viaje + v_colecta_especial + v_colecta_mantenimiento
            v_total_colecta = v_colecta_contruccion + v_colecta_piedad  + v_colecta_viaje + v_colecta_especial + v_colecta_mantenimiento;
            
            
            /********************************************           
            --  III)  DETERMINAR INGRESOS POR TRASPASO
            *********************************************/
            
             -- determinar raspasos de contruccion v_colecta_contruccion
            v_ing_traspasos_contruccion = ccb.f_determina_balance_periodo('ingreso_traspasos',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_construccion, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            -- determinar colecta de piedad v_colecta_piedad 
            v_ing_traspasos_piedad = ccb.f_determina_balance_periodo('ingreso_traspasos',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_piedad, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de viajes v_colecta_viaje
            v_ing_traspasos_viaje = ccb.f_determina_balance_periodo('ingreso_traspasos',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_viaje, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta especiales v_colecta_especial
             v_ing_traspasos_especial = ccb.f_determina_balance_periodo('ingreso_traspasos',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_especial, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de mantenimiento v_colecta_mantenimiento
            v_ing_traspasos_mantenimiento = ccb.f_determina_balance_periodo('ingreso_traspasos',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_mantenimiento, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar el total de colectas   v_total_colecta
           v_total_ing_traspasos = v_ing_traspasos_contruccion + v_ing_traspasos_piedad  + v_ing_traspasos_viaje + v_ing_traspasos_especial + v_ing_traspasos_mantenimiento;
            
            
            
            /********************************************           
            --  IV)  DETERMINAR EGRESOS POR TRASPASO
            *********************************************/
            
             -- determinar raspasos de contruccion v_colecta_contruccion
            v_egre_traspasos_contruccion = ccb.f_determina_balance_periodo('egreso_traspaso',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_construccion, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            -- determinar colecta de piedad v_colecta_piedad 
            v_egre_traspasos_piedad = ccb.f_determina_balance_periodo('egreso_traspaso',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_piedad, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de viajes v_colecta_viaje
            v_egre_traspasos_viaje = ccb.f_determina_balance_periodo('egreso_traspaso',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_viaje, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta especiales v_colecta_especial
             v_egre_traspasos_especial = ccb.f_determina_balance_periodo('egreso_traspaso',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_especial, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de mantenimiento v_colecta_mantenimiento
            v_egre_traspasos_mantenimiento = ccb.f_determina_balance_periodo('egreso_traspaso',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_mantenimiento, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar el total de colectas   v_total_colecta
           v_total_egre_traspasos = v_egre_traspasos_contruccion + v_egre_traspasos_piedad  + v_egre_traspasos_viaje + v_egre_traspasos_especial + v_egre_traspasos_mantenimiento;
            
           
            /********************************************           
            --  IV)  DETERMIANR EGESOS DE LA ADMINISTRACION
            *********************************************/
            
             --DETERMINAR LOS EGESOS POR OPERACION
            
             -- determinar raspasos de contruccion v_colecta_contruccion
            v_egreso_operacion_contruccion = ccb.f_determina_balance_periodo('egreso_operacion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_construccion, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            -- determinar colecta de piedad v_colecta_piedad 
            v_egreso_operacion_piedad = ccb.f_determina_balance_periodo('egreso_operacion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_piedad, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de viajes v_colecta_viaje
            v_egreso_operacion_viaje = ccb.f_determina_balance_periodo('egreso_operacion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_viaje, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta especiales v_colecta_especial
             v_egreso_operacion_especial = ccb.f_determina_balance_periodo('egreso_operacion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_especial, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de mantenimiento v_colecta_mantenimiento
            v_egreso_operacion_mantenimiento = ccb.f_determina_balance_periodo('egreso_operacion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_mantenimiento, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar el total de egresos por operacion
           v_total_egreso_operacion = v_egreso_operacion_contruccion + v_egreso_operacion_piedad  + v_egreso_operacion_viaje + v_egreso_operacion_especial + v_egreso_operacion_mantenimiento;
            
            
           -- DETERMINAR LOS EGRESOS CONTRA RENDICION
            
             -- determinar raspasos de contruccion v_colecta_contruccion
            v_egreso_contra_rendicion_contruccion = ccb.f_determina_balance_periodo('egresos_contra_rendicion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_construccion, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            -- determinar colecta de piedad v_colecta_piedad 
            v_egreso_contra_rendicion_piedad = ccb.f_determina_balance_periodo('egresos_contra_rendicion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_piedad, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de viajes v_colecta_viaje
            v_egreso_contra_rendicion_viaje = ccb.f_determina_balance_periodo('egresos_contra_rendicion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_viaje, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta especiales v_colecta_especial
             v_egreso_contra_rendicion_especial = ccb.f_determina_balance_periodo('egresos_contra_rendicion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_especial, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar colecta de mantenimiento v_colecta_mantenimiento
            v_egreso_contra_rendicion_mantenimiento = ccb.f_determina_balance_periodo('egresos_contra_rendicion',
            												v_id_estado_periodo, 
                                                            NULL, --.id_lugar, 
                                                            v_parametros.id_casa_oracion, 
                                                            NULL, --.id_region, 
                                                            NULL, --id_obrero, 
                                                            v_id_tm_mantenimiento, --id_tipo_movimiento, 
                                                            NULL);   --p_id_ot
            
            -- determinar el total de egresos por operacion
           v_total_egreso_contra_rendicion = v_egreso_contra_rendicion_contruccion + v_egreso_contra_rendicion_piedad  + v_egreso_contra_rendicion_viaje + v_egreso_contra_rendicion_especial + v_egreso_contra_rendicion_mantenimiento;
            
            
            --total egresos de la administracion
           v_total_egresos_adm =  v_total_egreso_contra_rendicion + v_total_egreso_operacion + v_total_egre_traspasos;
           
            
           
           --total egresos de la adminsitracion por colecta ( egresospor operacion + egresos contra rendicion + egresos por traspasos)
           
           v_total_egresos_adm_contruccion = v_egreso_contra_rendicion_contruccion + v_egreso_operacion_contruccion + v_egre_traspasos_contruccion;
           v_total_egresos_adm_piedad = v_egreso_contra_rendicion_piedad  + v_egreso_operacion_piedad + v_egre_traspasos_piedad;
           v_total_egresos_adm_viaje = v_egreso_contra_rendicion_viaje + v_egreso_operacion_viaje + v_egre_traspasos_viaje;
           v_total_egresos_adm_especial = v_egreso_contra_rendicion_especial +     v_egreso_operacion_especial + v_egre_traspasos_especial;      
           v_total_egresos_adm_mantenimiento = v_egreso_contra_rendicion_mantenimiento + v_egreso_operacion_mantenimiento + v_egre_traspasos_mantenimiento;
           
             
           v_total_egresos_adm_contruccion_tmp = v_egreso_contra_rendicion_contruccion + v_egreso_operacion_contruccion ;
           v_total_egresos_adm_piedad_tmp = v_egreso_contra_rendicion_piedad  + v_egreso_operacion_piedad ;
           v_total_egresos_adm_viaje_tmp = v_egreso_contra_rendicion_viaje + v_egreso_operacion_viaje ;
           v_total_egresos_adm_especial_tmp  = v_egreso_contra_rendicion_especial +     v_egreso_operacion_especial ;      
           v_total_egresos_adm_mantenimiento_tmp = v_egreso_contra_rendicion_mantenimiento + v_egreso_operacion_mantenimiento ;
           
           v_total_egresos_adm_tmp =  v_total_egreso_contra_rendicion + v_total_egreso_operacion;
           
             
         
            /******************************************************           
            --  IV)  DETERMINAR SALDO DEL MES EN LA ADMINISTRACION
            *******************************************************/
            
            
            
            --v_ingreso_total  - v_egreso_traspaso - v_egreso_operacion - v_egresos_contra_rendicion;
            
            v_saldo_mes_mantenimiento = v_saldo_adm_mantenimiento + v_colecta_mantenimiento + v_ing_traspasos_mantenimiento  - v_total_egresos_adm_mantenimiento; 
            v_saldo_mes_piedad	 =      v_saldo_adm_piedad +        v_colecta_piedad +        v_ing_traspasos_piedad -         v_total_egresos_adm_piedad;
            v_saldo_mes_construccion =  v_saldo_adm_construccion +  v_colecta_contruccion  +  v_ing_traspasos_contruccion -    v_total_egresos_adm_contruccion;
            v_saldo_mes_especial =      v_saldo_adm_especial +      v_colecta_especial +      v_ing_traspasos_especial -       v_total_egresos_adm_especial;
            v_saldo_mes_viaje =         v_saldo_adm_viaje +         v_colecta_viaje +         v_ing_traspasos_viaje -          v_total_egresos_adm_viaje;
            
            v_total_saldo_mes = v_saldo_mes_mantenimiento + v_saldo_mes_piedad + v_saldo_mes_construccion + v_saldo_mes_especial + v_saldo_mes_viaje;
           
            
            -- determnar el total general v_total_general = v_total_colecta + v_saldo_mantenimiento
            
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','saldos del mes');
            
            v_resp = pxp.f_agrega_clave(v_resp,'v_mes',v_mes);
            v_resp = pxp.f_agrega_clave(v_resp,'v_gestion',v_gestion);
            
            
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_saldo_adm',v_total_saldo_adm::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm_construccion',v_saldo_adm_construccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm_viaje',v_saldo_adm_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm_especial',v_saldo_adm_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm_piedad',v_saldo_adm_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm_mantenimiento',v_saldo_adm_mantenimiento::varchar);
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_colecta',v_total_colecta::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_colecta_construccion',v_colecta_contruccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_colecta_piedad',v_colecta_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_colecta_viaje',v_colecta_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_colecta_especial',v_colecta_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_colecta_mantenimiento',v_colecta_mantenimiento::varchar);
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_ing_traspasos',v_total_ing_traspasos::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ing_traspasos_construccion',v_ing_traspasos_contruccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ing_traspasos_piedad',v_ing_traspasos_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ing_traspasos_viaje',v_ing_traspasos_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ing_traspasos_especial',v_ing_traspasos_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ing_traspasos_mantenimiento',v_ing_traspasos_mantenimiento::varchar);
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_egre_traspasos_construccion',v_egre_traspasos_contruccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egre_traspasos_piedad',v_egre_traspasos_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egre_traspasos_viaje',v_egre_traspasos_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egre_traspasos_especial',v_egre_traspasos_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egre_traspasos_mantenimiento',v_egre_traspasos_mantenimiento::varchar);        
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion_construccion',v_egreso_operacion_contruccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion_piedad',v_egreso_operacion_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion_viaje',v_egreso_operacion_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion_especial',v_egreso_operacion_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion_mantenimiento',v_egreso_operacion_mantenimiento::varchar);
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_contra_rendicion_construccion',v_egreso_contra_rendicion_contruccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_contra_rendicion_piedad',v_egreso_contra_rendicion_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_contra_rendicion_viaje',v_egreso_contra_rendicion_viaje::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_contra_rendicion_especial',v_egreso_contra_rendicion_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_contra_rendicion_mantenimiento',v_egreso_contra_rendicion_mantenimiento::varchar);
           
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_tmp',v_total_egresos_adm_tmp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_construccion_tmp',v_total_egresos_adm_contruccion_tmp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_piedad_tmp',v_total_egresos_adm_piedad_tmp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_viaje_tmp',v_total_egresos_adm_viaje_tmp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_especial_tmp',v_total_egresos_adm_especial_tmp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm_mantenimiento_tmp',v_total_egresos_adm_mantenimiento_tmp::varchar);
           
           
           
           
           
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egresos_adm',v_total_egresos_adm::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egreso_contra_rendicion',v_total_egreso_contra_rendicion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egreso_operacion',v_total_egreso_operacion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_egre_traspasos',v_total_egre_traspasos::varchar);
            
            v_resp = pxp.f_agrega_clave(v_resp,'v_total_saldo_mes',v_total_saldo_mes::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_mes_mantenimiento',v_saldo_mes_mantenimiento::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_mes_piedad',v_saldo_mes_piedad::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_mes_construccion',v_saldo_mes_construccion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_mes_especial',v_saldo_mes_especial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_mes_viaje',v_saldo_mes_viaje::varchar);
            
            
            v_resp = pxp.f_agrega_clave(v_resp,'v_casa_oracion',v_registros_2.nombre::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_codigo',v_registros_2.codigo::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_region',v_registros_2.region::varchar);
            
            
            
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