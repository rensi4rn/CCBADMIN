--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_movimiento_record_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS SETOF record AS
$body$
DECLARE

v_parametros  		record;
v_aux_registros		record;
v_nombre_funcion   	text;
v_resp				varchar;
v_registros  		record;
v_id_gestion		integer;
va_id_regiones     INTEGER[];
v_saldo_adm			numeric;

BEGIN

    v_nombre_funcion = 'ccb.f_movimiento_record_sel';
    v_parametros = pxp.f_get_record(p_tabla);
    
    
    /*********************************    
 	#TRANSACCION:  'CCB_MOVRESUMEN_REP'
 	#DESCRIPCION:	Consulta del diagrama gant del WF
 	#AUTOR:		rac	
 	#FECHA:		16-03-2012 17:06:17
	***********************************/

	IF(p_transaccion='CCB_MOVRESUMEN_REP')then
    
            va_id_regiones = (string_to_array(v_parametros.id_regiones::Text,','))::integer[];
            
            --obtenemos la gestion a partir  de la fecha
            select 
              g.id_gestion
            into
              v_id_gestion
            from ccb.tgestion g  
            where  v_parametros.hasta::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
            IF v_id_gestion is NULL THEN
              raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
            END IF;
   
            
           
            FOR v_registros in (select
                                  co.id_casa_oracion,
                                  co.nombre as nombre_casa_oracion,
             					  re.id_region,
                                  re.nombre as nombre_region,
                                  lu.id_lugar,
                                  lu.nombre as nombre_lugar,
                                  
                                  ccb.f_determina_balance('ingreso_traspasos', 
                                                               v_id_gestion, 
                                                               v_parametros.hasta, 
                                                               null, 
                                                               co.id_casa_oracion, 
                                                               null, 
                                                               null, 
                                                               null, 
                                                               null) as  ingreso_traspasos,

                                  ccb.f_determina_balance('devolucion', 
                                                               v_id_gestion, 
                                                               v_parametros.hasta, 
                                                               null, 
                                                               co.id_casa_oracion, 
                                                               null, 
                                                               null, 
                                                               null, 
                                                               null) as ingreso_devolucion,
                                   ccb.f_determina_balance('ingreso_colectas', 
                                                             v_id_gestion, 
                                   							 v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as ingreso_colectas,
                                  ccb.f_determina_balance('ingreso_inicial', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as ingreso_inicial, 
                                  ccb.f_determina_balance('egreso_operacion', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta,
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as egreso_operacion,
                                  ccb.f_determina_balance('egreso_traspaso', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as egreso_traspaso,
                                   ccb.f_determina_balance('egresos_contra_rendicion', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as egresos_contra_rendicion,
                                  ccb.f_determina_balance('egresos_rendidos', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as egresos_rendidos,
                                  ccb.f_determina_balance('egreso_inicial_por_rendir', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta,
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             null, 
                                                             null) as egreso_inicial_por_rendir


                                  from ccb.tcasa_oracion co
                                  inner join ccb.tregion re on re.id_region = co.id_region
                                  inner join param.tlugar lu on lu.id_lugar = co.id_lugar
                                  where co.id_region = ANY(va_id_regiones)
                                  order by re.nombre ,lu.nombre ) LOOP
              
              RETURN NEXT v_registros;
             
             
             END LOOP;
    
    
     /*********************************    
 	#TRANSACCION:  'CCB_MOVRESDET_REP'
 	#DESCRIPCION:	consulta recursivamente la colectas
 	#AUTOR:		rac	
 	#FECHA:		16-03-2012 17:06:17
	***********************************/

	ELSEIF(p_transaccion='CCB_MOVRESDET_REP')then
    
            va_id_regiones = (string_to_array(v_parametros.id_regiones::Text,','))::integer[];
            
            --obtenemos la gestion a partir  de la fecha
            select 
              g.id_gestion
            into
              v_id_gestion
            from ccb.tgestion g  
            where  v_parametros.hasta::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
            IF v_id_gestion is NULL THEN
              raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
            END IF;
   
            
           
            FOR v_registros in (select
                                  co.id_casa_oracion,
                                  co.nombre as nombre_casa_oracion,
             					  re.id_region,
                                  re.nombre as nombre_region,
                                  lu.id_lugar,
                                  lu.nombre as nombre_lugar,
                                  tm.id_tipo_movimiento,
                                  tm.nombre as nombre_colecta,
                                  tm.codigo as codigo_colecta,
                                  
                                  ccb.f_determina_balance('ingreso_traspasos', 
                                                               v_id_gestion, 
                                                               v_parametros.hasta, 
                                                               null, 
                                                               co.id_casa_oracion, 
                                                               null, 
                                                               null, 
                                                               tm.id_tipo_movimiento, 
                                                               null) as  ingreso_traspasos,

                                  ccb.f_determina_balance('devolucion', 
                                                               v_id_gestion, 
                                                               v_parametros.hasta, 
                                                               null, 
                                                               co.id_casa_oracion, 
                                                               null, 
                                                               null, 
                                                               tm.id_tipo_movimiento, 
                                                               null) as ingreso_devolucion,
                                   ccb.f_determina_balance('ingreso_colectas', 
                                                             v_id_gestion, 
                                   							 v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as ingreso_colectas,
                                  ccb.f_determina_balance('ingreso_inicial', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as ingreso_inicial, 
                                  ccb.f_determina_balance('egreso_operacion', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta,
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as egreso_operacion,
                                  ccb.f_determina_balance('egreso_traspaso', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as egreso_traspaso,
                                   ccb.f_determina_balance('egresos_contra_rendicion', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as egresos_contra_rendicion,
                                  ccb.f_determina_balance('egresos_rendidos', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta, 
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as egresos_rendidos,
                                  ccb.f_determina_balance('egreso_inicial_por_rendir', 
                                                             v_id_gestion, 
                                                             v_parametros.hasta,
                                                             null, 
                                                             co.id_casa_oracion, 
                                                             null, 
                                                             null, 
                                                             tm.id_tipo_movimiento, 
                                                             null) as egreso_inicial_por_rendir


                                  from ccb.tcasa_oracion co, 
                                  ccb.ttipo_movimiento tm,ccb.tregion re,param.tlugar lu 

                                  where  re.id_region = co.id_region and lu.id_lugar = co.id_lugar
                                        and  co.id_region = ANY(va_id_regiones)
                                  order by re.nombre ,lu.nombre, co.nombre,  tm.id_tipo_movimiento ) LOOP
              
              RETURN NEXT v_registros;
             
             
             END LOOP;
   /*********************************    
 	#TRANSACCION:  'CCB_MOVRESCO_REP'
 	#DESCRIPCION:	consulta recursivamente la colectas por mes 
 	#AUTOR:		rac	
 	#FECHA:		16-03-2012 17:06:17
	***********************************/

	 ELSEIF(p_transaccion='CCB_MOVRESCO_REP')then
     
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
        
        
       

        FOR v_registros in (
        					select 
                              ep.mes,
                              ep.num_mes,
                              tm.nombre as nombre_colecta,
                              tm.codigo as codigo_colecta,
                              co.id_casa_oracion,
                              co.nombre as nombre_casa_oracion,
                              re.id_region,
                              re.nombre as nombre_region,
                              lu.id_lugar,
                              lu.nombre as nombre_lugar,
                              tm.id_tipo_movimiento,
                              
                              ccb.f_calculo_saldos_inicial(ep.id_estado_periodo, 
                                                              NULL, 
                                                              NULL, 
                                                              NULL, 
                                                              tm.id_tipo_movimiento, 
                                                              NULL)::numeric as ingreso_inicial,
                              
                              
                              
                              ccb.f_determina_balance_periodo('ingreso_colectas',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as ingreso_colectas,
                                                                                  
                                                                                  
                                ccb.f_determina_balance_periodo('egreso_inicial_por_rendir',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as egreso_inicial_por_rendir,
                                                                                  
                                                                                                                                      
                              ccb.f_determina_balance_periodo('ingreso_traspasos',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as ingreso_traspasos,
                              ccb.f_determina_balance_periodo('devolucion',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as ingreso_devolucion,
                              ccb.f_determina_balance_periodo('egreso_traspaso',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as egreso_traspaso,
                              ccb.f_determina_balance_periodo('egreso_operacion',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as egreso_operacion,
                              ccb.f_determina_balance_periodo('egresos_contra_rendicion',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as egresos_contra_rendicion,
                                                                                  
                             ccb.f_determina_balance_periodo('egresos_rendidos',
                                                                                  ep.id_estado_periodo, 
                                                                                  NULL, --.id_lugar, 
                                                                                  co.id_casa_oracion, 
                                                                                  NULL, --.id_region, 
                                                                                  NULL, --id_obrero, 
                                                                                  tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                                                                  NULL) as egresos_rendidos                                                     
                       from ccb.tcasa_oracion co,
                            ccb.ttipo_movimiento tm,
                            ccb.tregion re,
                            param.tlugar lu
                            ,ccb.testado_periodo ep
                       where 
                                   re.id_region = co.id_region  and
                                   lu.id_lugar = co.id_lugar  and
                                   co.id_casa_oracion =  v_parametros.id_casa_oracion 
                                   and ep.id_gestion = v_id_gestion
                                   and ep.id_casa_oracion = co.id_casa_oracion
                             order by ep.num_mes asc,
                                      re.nombre,
                                      lu.nombre,
                                      co.nombre,
                                      tm.id_tipo_movimiento)LOOP
        
                  RETURN NEXT v_registros;
        
        END LOOP;

    /*********************************    
 	#TRANSACCION:  'CCB_SALDOMEN_REP'
 	#DESCRIPCION:	Consulta recursivamente el saldo mensual 
 	#AUTOR:		rac	
 	#FECHA:		16-03-2012 17:06:17
	***********************************/

	 ELSEIF(p_transaccion='CCB_SALDOMEN_REP')then
     
        -- obtenemos la gestion a partir  de la fecha
       
         
        select 
          g.id_gestion
        into
          v_id_gestion
        from ccb.tgestion g  
        where  v_parametros.fecha::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
        IF v_id_gestion is NULL THEN
          raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
        END IF;
        
        --crear tabla temporal
        CREATE TEMPORARY TABLE resumen (
                                id_casa_oracion INTEGER,
                                id_region INTEGER,
                                region  varchar,
                                id_gestion INTEGER,
                                gestion varchar,
                                casa_oracion VARCHAR,
                                saldo_inicial numeric,
                                nombre_colecta VARCHAR,
                                id_tipo_movimiento INTEGER,
                                mes_1 numeric,
                                mes_2 numeric,
                                mes_3 numeric,
                                mes_4 numeric,
                                mes_5 numeric,
                                mes_6 numeric,
                                mes_7 numeric,
                                mes_8 numeric,
                                mes_9 numeric,
                                mes_10 numeric,
                                mes_11 numeric,
                                mes_12 numeric ) ON COMMIT DROP;
       
    
        FOR v_registros in (
        					select 
                             
                              tm.nombre as nombre_colecta,
                              tm.codigo as codigo_colecta,
                              co.id_casa_oracion,
                              co.nombre as nombre_casa_oracion,
                              re.id_region,
                              re.nombre as nombre_region,
                              tm.nombre as nombre_colecta,
                              tm.id_tipo_movimiento
                             from ccb.tcasa_oracion co,
                                    ccb.ttipo_movimiento tm,
                                    ccb.tregion re
                             where 
                                   re.id_region = co.id_region 
                                   and co.id_casa_oracion::varchar = ANY(string_to_array(v_parametros.id_casa_oracions, ',')) )LOOP
        
                        
                          --  inserta casa de oracion en tabla temporal                          
                          insert into resumen (
                                                id_casa_oracion,
                                                casa_oracion,
                                                id_region,
                                                region,
                                                nombre_colecta,
                                                id_tipo_movimiento
                                              )
                                              values
                                              (
                                                v_registros.id_casa_oracion,
                                                v_registros.nombre_casa_oracion,
                                                v_registros.id_region,
                                                v_registros.nombre_region,
                                                v_registros.nombre_colecta,
                                                v_registros.id_tipo_movimiento
                                              );
      
        END LOOP;
        
        FOR v_registros in (
        					select 
                              ep.mes,
                              ep.num_mes,
                              tm.nombre as nombre_colecta,
                              tm.codigo as codigo_colecta,
                              co.id_casa_oracion,
                              co.nombre as nombre_casa_oracion,
                              re.id_region,
                              re.nombre as nombre_region,
                              lu.id_lugar,
                              lu.nombre as nombre_lugar,
                              tm.id_tipo_movimiento,
                              ep.id_estado_periodo,
                              ep.fecha_ini
                                                                                  
                                                                              
                       from ccb.tcasa_oracion co,
                            ccb.ttipo_movimiento tm,
                            ccb.tregion re,
                            param.tlugar lu,
                            ccb.testado_periodo ep
                       where 
                                   re.id_region = co.id_region  
                                   and lu.id_lugar = co.id_lugar  
                                   and ep.id_gestion = v_id_gestion
                                   and ep.id_casa_oracion = co.id_casa_oracion
                                   and co.id_casa_oracion::varchar = ANY(string_to_array(v_parametros.id_casa_oracions, ',')) )LOOP
        
                                      
                   
                         --si es enero caculmamos el saldo inicial
                        IF v_registros.num_mes = 1 THEN 
                               
                               v_saldo_adm =  ccb.f_calculo_saldos_inicial(v_registros.id_estado_periodo, 
                                                                      NULL, 
                                                                      NULL, 
                                                                      NULL, 
                                                                      v_registros.id_tipo_movimiento, 
                                                                      NULL);                 
                                           
                             
                             
                               update   resumen  r set 
                                   saldo_inicial = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                         
                          END IF;
                         
                         
                          IF  v_registros.fecha_ini <= v_parametros.fecha  THEN
                             
                             v_saldo_adm =  ccb.f_calculo_saldos_inicial(v_registros.id_estado_periodo, 
                                                                          NULL, 
                                                                          NULL, 
                                                                          NULL, 
                                                                          v_registros.id_tipo_movimiento, 
                                                                          NULL,
                                                                          'final'); 
                           ELSE
                             v_saldo_adm = 0; 
                           
                           END IF;
        
                           IF v_registros.num_mes = 1 THEN 
                           
                               update   resumen  r set 
                                   mes_1 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                                   
                           ELSIF v_registros.num_mes = 2 THEN
                           
                               update   resumen  r set 
                                   mes_2 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento; 
                                   
                           ELSIF v_registros.num_mes = 3 THEN 
                           
                               update   resumen  r set 
                                   mes_3 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                                   
                           ELSIF v_registros.num_mes = 4 THEN
                               
                               update   resumen  r set 
                                   mes_4 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                          
                          ELSIF v_registros.num_mes = 5 THEN
                               
                               update   resumen  r set 
                                   mes_5 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           
                           ELSIF v_registros.num_mes = 6 THEN 
                              
                               update   resumen  r set 
                                   mes_6 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           
                           ELSIF v_registros.num_mes = 7 THEN 
                               update   resumen  r set 
                                   mes_7 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           ELSIF v_registros.num_mes = 8 THEN
                               
                               update   resumen  r set 
                                   mes_8 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           
                           ELSIF v_registros.num_mes = 9 THEN
                               
                               update   resumen  r set 
                                   mes_9 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           ELSIF v_registros.num_mes = 10 THEN 
                               
                               update   resumen  r set 
                                   mes_10 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           ELSIF v_registros.num_mes = 11 THEN 
                               
                               update   resumen  r set 
                                   mes_11 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                           ELSIF v_registros.num_mes = 12 THEN
                               
                               update   resumen  r set 
                                   mes_12 = v_saldo_adm
                               where r.id_casa_oracion =  v_registros.id_casa_oracion and
                                   r.id_tipo_movimiento  =  v_registros.id_tipo_movimiento;
                         
                           END IF;
                  
        END LOOP;

        FOR v_registros in (SELECT id_casa_oracion,
                                  id_region,
                                  region as nombre_region,
                                  id_gestion,
                                  gestion,
                                  casa_oracion as nombre_casa_oracion,
                                  saldo_inicial,
                                  nombre_colecta,
                                  id_tipo_movimiento,
                                  mes_1,
                                  mes_2,
                                  mes_3,
                                  mes_4,
                                  mes_5,
                                  mes_6,
                                  mes_7,
                                  mes_8,
                                  mes_9,
                                  mes_10,
                                  mes_11,
                                  mes_12
                              FROM resumen r
                              order by 
                                      id_region,
                                      r.id_casa_oracion,
                                       r.id_tipo_movimiento 
                                  ) LOOP
                    
                    RETURN NEXT v_registros;
         END LOOP;
        
     /*********************************    
 	#TRANSACCION:  'CCB_MOVRESCOXOT_REP'
 	#DESCRIPCION:	consulta recursiva de colecta por mes segun orden de trabajo
 	#AUTOR:		rac	
 	#FECHA:		26-06-2016 17:06:17
	***********************************/

	 ELSEIF(p_transaccion='CCB_MOVRESCOXOT_REP')then
     
     
      
         select 
                ep.estado_periodo,
                ep.id_estado_periodo,
                ep.fecha_ini,
                ges.id_gestion,
                ep.mes,
                ges.gestion,
                ep.fecha_fin
              into
                v_aux_registros
              from ccb.testado_periodo ep 
              inner join ccb.tgestion ges on ges.id_gestion = ep.id_gestion
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;
                   
            IF v_aux_registros.id_estado_periodo is NULL THEN
              raise exception 'No se encontro un periodo para la fecha indicada %',v_parametros.fecha; 
            END IF;
       
     -- raise exception '% -- %', v_aux_registros.id_estado_periodo,v_parametros.id_casa_oracion ;
      
       -- listar las ordenes de trabajo por tipo de colecta
       
         FOR v_registros in (
              select * 
               from (
                select
                ot.id_orden_trabajo,
                ot.desc_orden,
                tm.id_tipo_movimiento,
                tm.nombre as desc_tipo_movimiento,
                ccb.f_determina_balance_periodo('ingreso_colectas',
                                            v_aux_registros.id_estado_periodo, 
                                            NULL, --.id_lugar, 
                                            v_parametros.id_casa_oracion, 
                                            NULL, --.id_region, 
                                            NULL, --id_obrero, 
                                            tm.id_tipo_movimiento, --id_tipo_movimiento, 
                                            ot.id_orden_trabajo)  as importe    
                from  conta.torden_trabajo ot,
                      ccb.ttipo_movimiento tm
                where ot.fecha_final is null or ot.fecha_final <= v_aux_registros.fecha_fin
                order by id_orden_trabajo,id_tipo_movimiento) tab
                where tab.importe > 0 )LOOP
                      
                      
                       RETURN NEXT v_registros;
        
        END LOOP;
         
     END IF;

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
COST 100 ROWS 1000;