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
v_nombre_funcion   	text;
v_resp				varchar;
v_registros  		record;
v_id_gestion		integer;
va_id_regiones     INTEGER[];



 

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