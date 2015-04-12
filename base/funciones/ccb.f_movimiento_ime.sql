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
            
            
            
            -- determinar el ingreso por traspasos     (v_ingreso_traspasos)
            v_ingreso_traspasos =  ccb.f_determina_balance('ingreso_traspasos', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
             
            -- determinar el ingreso po colectas       (v_ingreso_colectas)
            v_ingreso_colectas =  ccb.f_determina_balance('ingreso_colectas', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
            
            -- determinar el ingreso por salo inicial  (v_ingreso_inicial)
             v_ingreso_inicial = ccb.f_determina_balance('ingreso_inicial', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
                                                                         
                                                                         
            -- determinar el total ingreso  (v_ingreso_total =  v_ingreso_traspasos + v_ingreso_colectas + v_ingreso_inicial )
            
            v_ingreso_total =  v_ingreso_traspasos + v_ingreso_colectas + v_ingreso_inicial;
            
            
            
            -- deterimnar egresos por operacion  (v_egreso_operacion)
            v_egreso_operacion =  ccb.f_determina_balance('egreso_operacion', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
                                                                         
            -- determina egresos por traspaso     (v_egreso_traspaso)
            v_egreso_traspaso =  ccb.f_determina_balance('egreso_traspaso', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
                                                                         
            -- determinar egresos contra rendicion (v_egresos_contra_rendicion)
            v_egresos_contra_rendicion = ccb.f_determina_balance('egresos_contra_rendicion', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
            
            -- determinar egresos rendidos  (v_egresos_rendidos)
            v_egresos_rendidos =  ccb.f_determina_balance('egresos_rendidos', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
            
            -- determinar egresos por saldo  contra rendicion  (v_egreso_inicial_por_rendir)
            v_egreso_inicial_por_rendir = ccb.f_determina_balance('egreso_inicial_por_rendir', 
                                                                         v_id_gestion, 
                                                                         v_parametros.fecha, 
                                                                         v_parametros.id_lugar, 
                                                                         v_parametros.id_casa_oracion, 
                                                                         v_parametros.id_region, 
                                                                         v_parametros.id_obrero, 
                                                                         v_parametros.id_tipo_movimiento, 
                                                                         v_parametros.id_ot);
            
            
            
            -- determinar total egresos efectivo  (v_egreso_efectivo = v_egreso_operacion + v_egresos_rendidos)
            v_egreso_efectivo = v_egreso_operacion + v_egresos_rendidos;
           
            -- determinar saldo efectivo (v_saldo_efectivo =  v_ingreso_total - v_egreso_efectivo - v_egreso_traspaso)
            v_saldo_efectivo =  v_ingreso_total - v_egreso_efectivo - v_egreso_traspaso;
            
            -- determinar saldo administracion (v_saldo_adm =  v_ingreso_total  - v_egreso_traspaso - v_egreso_operacion - v_egresos_contra_rendicion)
            v_saldo_adm =  v_ingreso_total  - v_egreso_traspaso - v_egreso_operacion - v_egresos_contra_rendicion;
            
            -- determinar saldo que falta por rendir  (v_sado_x_rendir =  v_egreso_inicial_por_rendir + v_egresos_contra_rendicion  - v_egresos_rendidos )
            v_sado_x_rendir =  v_egreso_inicial_por_rendir + v_egresos_contra_rendicion  - v_egresos_rendidos;
            
            
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','saldos calculados'); 
            v_resp = pxp.f_agrega_clave(v_resp,'v_ingreso_colectas',v_ingreso_colectas::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ingreso_traspasos',v_ingreso_traspasos::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ingreso_inicial',v_ingreso_inicial::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_ingreso_total',v_ingreso_total::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_operacion',v_egreso_operacion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_traspaso',v_egreso_traspaso::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egresos_contra_rendicion',v_egresos_contra_rendicion::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egresos_rendidos',v_egresos_rendidos::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_inicial_por_rendir',v_egreso_inicial_por_rendir::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_egreso_efectivo',v_egreso_efectivo::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_efectivo',v_saldo_efectivo::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_saldo_adm',v_saldo_adm::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_sado_x_rendir',v_sado_x_rendir::varchar);
            
            
            
              
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