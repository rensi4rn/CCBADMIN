--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.ft_tipo_documento_ccb_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_tipo_documento_ccb_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.ttipo_documento_ccb'
 AUTOR: 		 (admin)
 FECHA:	        29-02-2016 09:49:41
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

	v_nombre_funcion = 'ccb.ft_tipo_documento_ccb_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_TID_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		29-02-2016 09:49:41
	***********************************/

	if(p_transaccion='CCB_TID_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
                            tid.id_tipo_documento_ccb,
                            tid.codigo,
                            tid.estado_reg,
                            tid.nombre,
                            tid.id_plantilla,
                            tid.id_usuario_reg,
                            tid.usuario_ai,
                            tid.fecha_reg,
                            tid.id_usuario_ai,
                            tid.fecha_mod,
                            tid.id_usuario_mod,
                            usu1.cuenta as usr_reg,
                            usu2.cuenta as usr_mod,
                            p.desc_plantilla	
                        from ccb.ttipo_documento_ccb tid
                        inner join segu.tusuario usu1 on usu1.id_usuario = tid.id_usuario_reg
                        inner join param.tplantilla p on p.id_plantilla = tid.id_plantilla
                        left join segu.tusuario usu2 on usu2.id_usuario = tid.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_TID_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		29-02-2016 09:49:41
	***********************************/

	elsif(p_transaccion='CCB_TID_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_tipo_documento_ccb)
			            from ccb.ttipo_documento_ccb tid
                        inner join segu.tusuario usu1 on usu1.id_usuario = tid.id_usuario_reg
                        inner join param.tplantilla p on p.id_plantilla = tid.id_plantilla
                        left join segu.tusuario usu2 on usu2.id_usuario = tid.id_usuario_mod
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