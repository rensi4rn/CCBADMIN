--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_determina_balance (
  p_codigo_balance varchar,
  p_id_gestion integer,
  p_fecha date,
  p_id_lugar integer,
  p_id_casa_oracion integer,
  p_id_region integer,
  p_id_obrero integer,
  p_id_tipo_movimiento integer,
  p_id_ot integer
)
RETURNS numeric AS
$body$
/*
Autor inicial GAYME RIMERA ROJAS (No sabe porner comentarios)
Fecha 28/06/2013
Descripcion: nose por que el gayme no puso comentarios


Autor:  Rensi Arteaga Copari
Fecha 01/05/2015
Descripcion:   Esta funciona inicia la generacion de comprobantes contables,  
               apartir de una plantilla predefinida





*/


DECLARE
	
    v_nombre_funcion        text;
    v_resp 					varchar;
    v_consulta_ingreso      varchar;
    v_consulta_egreso		varchar;
    v_consulta				VARCHAR;
    v_filtro                varchar;
    v_sw 					boolean;
    v_lugares				varchar;
    v_resultado				numeric;
  
BEGIN

    v_nombre_funcion:='ccb.f_determina_balance';
    v_filtro = ' 0=0';
     v_sw = FALSE;
     
    IF p_id_casa_oracion is not NULL THEN
    
          v_filtro = '  mov.id_casa_oracion = '||p_id_casa_oracion::varchar||' ';
          v_sw = TRUE;
    
    END IF;
    
    IF p_id_tipo_movimiento is not NULL THEN
          
          IF v_sw THEN
             v_filtro = v_filtro||'  AND mov.id_tipo_movimiento = '||p_id_tipo_movimiento::varchar||' ';
          ELSE
             v_filtro = '  mov.id_tipo_movimiento = '||p_id_tipo_movimiento::varchar||' ';
          END IF;
          
           v_sw = TRUE;
    
    END IF;
    
    IF p_id_obrero is not NULL THEN
          
          IF v_sw THEN
             v_filtro = v_filtro||'  AND mov.id_obrero = '||p_id_obrero::varchar||' ';
          ELSE
             v_filtro = '  mov.id_obrero = '||p_id_obrero::varchar||' ';
          END IF;
          
           v_sw = TRUE;
    
    END IF;
    
     IF p_id_ot is not NULL THEN
          
          IF v_sw THEN
             v_filtro = v_filtro||'  AND mov.id_ot = '||p_id_ot::varchar||' ';
          ELSE
             v_filtro = '  mov.id_ot = '||p_id_ot::varchar||' ';
          END IF;
          
           v_sw = TRUE;
    
    END IF;
    
    IF p_id_region is not NULL THEN
          
          IF v_sw THEN
             v_filtro = v_filtro||'  AND mov.id_region = '||p_id_region::varchar||' ';
          ELSE
             v_filtro = '  mov.id_region = '||p_id_region::varchar||' ';
          END IF;
          
           v_sw = TRUE;
    
    END IF;
    
    
    IF p_id_lugar is not NULL THEN
            
                WITH RECURSIVE lugar_rec (id_lugar, id_lugar_fk, nombre) AS (
                    SELECT lug.id_lugar, id_lugar_fk, nombre
                    FROM param.tlugar lug
                    WHERE lug.id_lugar = p_id_lugar and lug.estado_reg = 'activo'
                  UNION ALL
                    SELECT lug2.id_lugar, lug2.id_lugar_fk, lug2.nombre
                    FROM lugar_rec lrec 
                    INNER JOIN param.tlugar lug2 ON lrec.id_lugar = lug2.id_lugar_fk
                    where lug2.estado_reg = 'activo'
                  )
                SELECT  pxp.list(id_lugar::varchar) 
                  into 
                    v_lugares
                FROM lugar_rec;
                
                
                
                IF v_sw THEN
                   v_filtro = v_filtro||'  AND  mov.id_lugar in ('||v_lugares||') ';
                ELSE
                   v_filtro = ' mov.id_lugar in ('||v_lugares||') ';
                END IF;
                
               v_sw = TRUE;
    END IF;
    
    --raise exception 'sss %', p_fecha;
    
    v_consulta_ingreso = 'select
                             sum(mov.monto)
                          from ccb.vmovimiento_ingreso_x_colecta mov
                          where      mov.id_gestion = '||p_id_gestion::varchar||'
                                and  mov.fecha::Date <= '''||p_fecha::Date||''' ';
    
    v_consulta_egreso = 'select
                             sum(mov.monto)
                          from ccb.vmovimiento_egreso mov
                          where      mov.id_gestion = '||p_id_gestion::varchar||'
                                and  mov.fecha::date <= '''||p_fecha::Date||''' ';
    
    
    
    IF p_codigo_balance = 'ingreso_traspasos' then      
          v_consulta = v_consulta_ingreso ||' and ' ||v_filtro||'  and mov.concepto = ''ingreso_traspaso'' ';
    ELSIF p_codigo_balance = 'devolucion' then      
          v_consulta = v_consulta_ingreso ||' and ' ||v_filtro||'  and mov.concepto = ''devolucion'' ';
    ELSIF p_codigo_balance = 'ingreso_colectas' then
          v_consulta = v_consulta_ingreso ||' and ' ||v_filtro||'  and mov.concepto in(''colecta_adultos'',''colecta_jovenes'',''colecta_especial'') ';
    ELSIF p_codigo_balance = 'ingreso_inicial' then
          v_consulta = v_consulta_ingreso ||' and ' ||v_filtro||'  and mov.concepto in(''saldo_inicial'') ';
    ELSIF p_codigo_balance = 'egreso_operacion' then
          v_consulta = v_consulta_egreso ||' and ' ||v_filtro||'  and mov.concepto in(''operacion'') ';
    ELSIF p_codigo_balance = 'egreso_traspaso' then
          v_consulta = v_consulta_egreso ||' and ' ||v_filtro||'  and mov.concepto in(''egreso_traspaso'') ';
    ELSIF p_codigo_balance = 'egresos_contra_rendicion' then
          v_consulta = v_consulta_egreso ||' and ' ||v_filtro||'  and mov.concepto in(''contra_rendicion'') ';
    ELSIF p_codigo_balance = 'egresos_rendidos' then
          v_consulta = v_consulta_egreso ||' and ' ||v_filtro||'  and mov.concepto in(''rendicion'') ';
    ELSIF p_codigo_balance = 'egreso_inicial_por_rendir' then
          v_consulta = v_consulta_egreso ||' and ' ||v_filtro||'  and mov.concepto in(''egreso_inicial_por_rendir'') ';
    END IF;
    
    raise notice '.... % .....', v_consulta;
    
    EXECUTE v_consulta INTO v_resultado;
    return  COALESCE(v_resultado,0);
    
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