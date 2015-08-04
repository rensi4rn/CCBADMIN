CREATE OR REPLACE FUNCTION "ccb"."ft_tipo_concepto_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_tipo_concepto_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.ttipo_concepto'
 AUTOR: 		 (admin)
 FECHA:	        04-08-2015 07:43:42
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

	v_nombre_funcion = 'ccb.ft_tipo_concepto_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TCP_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		04-08-2015 07:43:42
	***********************************/

	if(p_transaccion='CCB_TCP_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tcp.id_tipo_concepto,
						tcp.codigo,
						tcp.estado_reg,
						tcp.descripcion,
						tcp.prioridad,
						tcp.id_usuario_reg,
						tcp.usuario_ai,
						tcp.fecha_reg,
						tcp.id_usuario_ai,
						tcp.id_usuario_mod,
						tcp.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.ttipo_concepto tcp
						inner join segu.tusuario usu1 on usu1.id_usuario = tcp.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tcp.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TCP_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		04-08-2015 07:43:42
	***********************************/

	elsif(p_transaccion='CCB_TCP_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_concepto)
					    from ccb.ttipo_concepto tcp
					    inner join segu.tusuario usu1 on usu1.id_usuario = tcp.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tcp.id_usuario_mod
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
ALTER FUNCTION "ccb"."ft_tipo_concepto_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
