CREATE OR REPLACE FUNCTION "ccb"."ft_tipo_cbte_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_tipo_cbte_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.ttipo_cbte'
 AUTOR: 		 (admin)
 FECHA:	        28-02-2016 13:24:23
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

	v_nombre_funcion = 'ccb.ft_tipo_cbte_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TCB_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:23
	***********************************/

	if(p_transaccion='CCB_TCB_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tcb.id_tipo_cbte,
						tcb.descripcion,
						tcb.estado_reg,
						tcb.codigo,
						tcb.id_usuario_ai,
						tcb.id_usuario_reg,
						tcb.usuario_ai,
						tcb.fecha_reg,
						tcb.id_usuario_mod,
						tcb.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.ttipo_cbte tcb
						inner join segu.tusuario usu1 on usu1.id_usuario = tcb.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tcb.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TCB_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:23
	***********************************/

	elsif(p_transaccion='CCB_TCB_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_cbte)
					    from ccb.ttipo_cbte tcb
					    inner join segu.tusuario usu1 on usu1.id_usuario = tcb.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tcb.id_usuario_mod
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
ALTER FUNCTION "ccb"."ft_tipo_cbte_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
