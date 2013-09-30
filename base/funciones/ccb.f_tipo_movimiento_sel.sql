--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_tipo_movimiento_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_tipo_movimiento_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.ttipo_movimiento'
 AUTOR: 		 (admin)
 FECHA:	        15-03-2013 23:21:53
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

	v_nombre_funcion = 'ccb.f_tipo_movimiento_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TMOV_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-03-2013 23:21:53
	***********************************/

	if(p_transaccion='CCB_TMOV_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tmov.id_tipo_movimiento,
						tmov.estado_reg,
						
						tmov.codigo,
						tmov.nombre,
						tmov.fecha_reg,
						tmov.id_usuario_reg,
						tmov.fecha_mod,
						tmov.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.ttipo_movimiento tmov
						inner join segu.tusuario usu1 on usu1.id_usuario = tmov.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tmov.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TMOV_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-03-2013 23:21:53
	***********************************/

	elsif(p_transaccion='CCB_TMOV_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_movimiento)
					    from ccb.ttipo_movimiento tmov
					    inner join segu.tusuario usu1 on usu1.id_usuario = tmov.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tmov.id_usuario_mod
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