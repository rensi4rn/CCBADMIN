--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.ft_usuario_permiso_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_usuario_permiso_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tusuario_permiso'
 AUTOR: 		 (admin)
 FECHA:	        12-02-2015 14:36:49
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

	v_nombre_funcion = 'ccb.ft_usuario_permiso_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_usper_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		12-02-2015 14:36:49
	***********************************/

	if(p_transaccion='CCB_usper_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						usper.id_usuario_permiso,
						usper.estado_reg,
						usper.id_casa_oracion,
						usper.id_usuario_asignado,
						usper.id_usuario_reg,
						usper.usuario_ai,
						usper.fecha_reg,
						usper.id_usuario_ai,
						usper.id_usuario_mod,
						usper.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        usper.id_region,
                        reg.nombre as desc_region,
                        co.nombre as desc_casa_oracion
						from ccb.tusuario_permiso usper
                        inner join segu.tusuario usu1 on usu1.id_usuario = usper.id_usuario_reg
						left join ccb.tregion reg on reg.id_region = usper.id_region
                        left join ccb.tcasa_oracion co on co.id_casa_oracion = usper.id_casa_oracion
                        
                        left join segu.tusuario usu2 on usu2.id_usuario = usper.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_usper_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		12-02-2015 14:36:49
	***********************************/

	elsif(p_transaccion='CCB_usper_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_usuario_permiso)
                         from ccb.tusuario_permiso usper
                        inner join segu.tusuario usu1 on usu1.id_usuario = usper.id_usuario_reg
						left join ccb.tregion reg on reg.id_region = usper.id_region
                        left join ccb.tcasa_oracion co on co.id_casa_oracion = usper.id_casa_oracion
                        
                        left join segu.tusuario usu2 on usu2.id_usuario = usper.id_usuario_mod
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