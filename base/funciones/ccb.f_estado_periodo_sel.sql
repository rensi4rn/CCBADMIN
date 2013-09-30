CREATE OR REPLACE FUNCTION "ccb"."f_estado_periodo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_estado_periodo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.testado_periodo'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 14:35:36
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

	v_nombre_funcion = 'ccb.f_estado_periodo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_PER_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	if(p_transaccion='CCB_PER_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						per.id_estado_periodo,
						per.estado_reg,
						per.estado_periodo,
						per.id_casa_oracion,
						per.num_mes,
						per.id_gestion,
						per.fecha_fin,
						per.mes,
						per.fecha_ini,
						per.fecha_reg,
						per.id_usuario_reg,
						per.fecha_mod,
						per.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.testado_periodo per
						inner join segu.tusuario usu1 on usu1.id_usuario = per.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = per.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_PER_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elsif(p_transaccion='CCB_PER_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_estado_periodo)
					    from ccb.testado_periodo per
					    inner join segu.tusuario usu1 on usu1.id_usuario = per.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = per.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ccb"."f_estado_periodo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
