--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_detalle_evento_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_detalle_evento_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tdetalle_evento'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 13:45:38
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ccb.f_detalle_evento_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_DEV_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 13:45:38
	***********************************/

	if(p_transaccion='CCB_DEV_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						dev.id_detalle_evento,
						dev.estado_reg,
						dev.cantidad,
						dev.id_region_evento,
						dev.id_tipo_ministerio,
						dev.obs,
						dev.fecha_reg,
						dev.id_usuario_reg,
						dev.fecha_mod,
						dev.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        tipmin.nombre as desc_tipo_ministerio
						from ccb.tdetalle_evento dev
						inner join segu.tusuario usu1 on usu1.id_usuario = dev.id_usuario_reg
                        inner join ccb.ttipo_ministerio tipmin on tipmin.id_tipo_ministerio = dev.id_tipo_ministerio
						left join segu.tusuario usu2 on usu2.id_usuario = dev.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_DEV_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 13:45:38
	***********************************/

	elsif(p_transaccion='CCB_DEV_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_detalle_evento)
					      from ccb.tdetalle_evento dev
						  inner join segu.tusuario usu1 on usu1.id_usuario = dev.id_usuario_reg
                          inner join ccb.ttipo_ministerio tipmin on tipmin.id_tipo_ministerio = dev.id_tipo_ministerio
						  left join segu.tusuario usu2 on usu2.id_usuario = dev.id_usuario_mod
				         where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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