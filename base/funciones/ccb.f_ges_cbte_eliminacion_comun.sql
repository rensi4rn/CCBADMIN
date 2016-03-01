--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_ges_cbte_eliminacion_comun (
  p_id_usuario integer,
  p_id_usuario_ai integer,
  p_usuario_ai varchar,
  p_id_int_comprobante integer,
  p_conexion varchar = NULL::character varying
)
RETURNS boolean AS
$body$
/*

Autor: RAC KPLIANF
Fecha:   08 agosto  de 2016 
Descripcion  elima la relacion con el cbte periodo, y permite regerar el cbte

*/


DECLARE
  
	v_nombre_funcion   	text;
	v_resp				varchar;   
    v_registros 		record;
    
    
    
BEGIN

	v_nombre_funcion = 'ccb.f_ges_cbte_eliminacion_comun';
    
    DELETE FROM ccb.tcbte_periodo 
    WHERE  id_int_comprobante = p_id_int_comprobante;
             
      
RETURN  TRUE;



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