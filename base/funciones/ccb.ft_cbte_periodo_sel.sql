CREATE OR REPLACE FUNCTION "ccb"."ft_cbte_periodo_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_cbte_periodo_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tcbte_periodo'
 AUTOR: 		 (admin)
 FECHA:	        28-02-2016 13:24:52
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

	v_nombre_funcion = 'ccb.ft_cbte_periodo_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_CBP_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:52
	***********************************/

	if(p_transaccion='CCB_CBP_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						cbp.id_cbte_periodo,
						cbp.id_estado_periodo,
						cbp.estado_reg,
						cbp.id_tipo_cbte,
						cbp.id_int_comprobante,
						cbp.id_usuario_reg,
						cbp.usuario_ai,
						cbp.fecha_reg,
						cbp.id_usuario_ai,
						cbp.fecha_mod,
						cbp.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.tcbte_periodo cbp
						inner join segu.tusuario usu1 on usu1.id_usuario = cbp.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cbp.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CBP_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:52
	***********************************/

	elsif(p_transaccion='CCB_CBP_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_cbte_periodo)
					    from ccb.tcbte_periodo cbp
					    inner join segu.tusuario usu1 on usu1.id_usuario = cbp.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = cbp.id_usuario_mod
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
ALTER FUNCTION "ccb"."ft_cbte_periodo_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
