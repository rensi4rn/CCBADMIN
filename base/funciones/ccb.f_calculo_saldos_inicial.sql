--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_calculo_saldos_inicial (
  p_id_estado_periodo integer,
  p_id_lugar integer,
  p_id_region integer,
  p_id_obrero integer,
  p_id_tipo_movimiento integer,
  p_id_ot integer,
  p_tipo_saldo varchar = 'inicial'::character varying
)
RETURNS varchar AS
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
    v_ingreso_devolucion			numeric;
    v_saldo_adm_inicial				numeric;
    
     p_id_gestion					integer;
     p_id_casa_oracion 				integer;
     p_fecha						date;
     v_mes							varchar;
  
BEGIN

    v_nombre_funcion:='ccb.f_calculo_saldos_inicial';
       
            
    select 
      ep.id_gestion,
      ep.id_casa_oracion,
      ep.fecha_fin,
      ep.fecha_ini,
      ep.mes
    into 
      p_id_gestion,
      p_id_casa_oracion,
      p_fecha,
      v_fecha_ini,
      v_mes
    from ccb.testado_periodo ep
    where ep.id_estado_periodo = p_id_estado_periodo;
    
    IF p_tipo_saldo  = 'inicial' THEN
     	v_fecha_ultimo_anterior =  v_fecha_ini - interval '1 day'; 
    ELSE
       v_fecha_ultimo_anterior = p_fecha;
    END IF;
     
     -- determinar el ingreso por salo inicial  (v_ingreso_inicial)
     -- raise exception '-- % --', p_id_estado_periodo;
         
     IF lower(trim(v_mes)) = 'enero' and   p_tipo_saldo  = 'inicial'  THEN
     
          ---------------------------------------------------
          --  USAMOS la fecha del periodo actual
          --------------------------------------------------
     
          v_ingreso_inicial = ccb.f_determina_balance('ingreso_inicial', 
                                                                         p_id_gestion, 
                                                                         p_fecha, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
         
          return  v_ingreso_inicial;
     ELSE 
     
          ---------------------------------------------------
          --  USAMOS la fecha del periodo ANTERIOR
          --------------------------------------------------
          
          v_ingreso_traspasos =  ccb.f_determina_balance('ingreso_traspasos', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
                                                                         
                                                                         
            -- determinar el ingreso po colectas       (v_ingreso_colectas)
            v_ingreso_colectas =  ccb.f_determina_balance('ingreso_colectas', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
                                                                         
             v_ingreso_inicial = ccb.f_determina_balance('ingreso_inicial', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
                                                                         
            -- deterimnar egresos por operacion  (v_egreso_operacion)
            v_egreso_operacion =  ccb.f_determina_balance('egreso_operacion', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot); 
                                                                         
            
               -- determinar egresos rendidos  (v_egresos_rendidos)
            v_egresos_rendidos =  ccb.f_determina_balance('egresos_rendidos', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
                                                                                                                                     
              v_egreso_traspaso =  ccb.f_determina_balance('egreso_traspaso', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot); 
            
             -- determinar el ingreso por devolucion     (v_ingreso_devolucion)
            v_ingreso_devolucion =  ccb.f_determina_balance('devolucion', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);  
                                                                         
             -- determinar egresos contra rendicion (v_egresos_contra_rendicion)
            v_egresos_contra_rendicion = ccb.f_determina_balance('egresos_contra_rendicion', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);
                                                                         
            
            -- determinar egresos por saldo  contra rendicion  (v_egreso_inicial_por_rendir)
            v_egreso_inicial_por_rendir = ccb.f_determina_balance('egreso_inicial_por_rendir', 
                                                                         p_id_gestion, 
                                                                         v_fecha_ultimo_anterior, 
                                                                         p_id_lugar, 
                                                                         p_id_casa_oracion, 
                                                                         p_id_region, 
                                                                         p_id_obrero, 
                                                                         p_id_tipo_movimiento, 
                                                                         p_id_ot);                                                                                                                                                                                                                                                                                                             
     
        -- si no es enero calcula el saldo en efectivo del periodo anteriort
        v_ingreso_total =  v_ingreso_traspasos + v_ingreso_colectas + v_ingreso_inicial;
        v_egreso_efectivo = v_egreso_operacion + v_egresos_rendidos;
        v_saldo_efectivo =  v_ingreso_total - v_egreso_efectivo - v_egreso_traspaso;
         -- determinar saldo administracion (v_saldo_adm =  v_ingreso_total  - v_egreso_traspaso - v_egreso_operacion - v_egresos_contra_rendicion)
        v_saldo_adm =  v_ingreso_total + v_ingreso_devolucion  - v_egreso_traspaso - v_egreso_operacion - v_egresos_contra_rendicion - v_egreso_inicial_por_rendir;
           
        
        
        return v_saldo_adm;
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
COST 100;