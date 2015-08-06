--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_movimiento_det_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_movimiento_det_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tmovimiento_det'
 AUTOR: 		 (admin)
 FECHA:	        25-03-2013 02:03:18
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

	v_nombre_funcion = 'ccb.f_movimiento_det_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_MOVD_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		25-03-2013 02:03:18
	***********************************/

	if(p_transaccion='CCB_MOVD_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='(select
						movd.id_movimiento_det,
						movd.estado_reg,
						movd.id_movimiento,
						movd.monto,
						movd.id_tipo_movimiento,
						movd.fecha_reg,
						movd.id_usuario_reg,
						movd.fecha_mod,
						movd.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        tm.nombre as desc_tipo_movimiento	
						from ccb.tmovimiento_det movd
						inner join segu.tusuario usu1 on usu1.id_usuario = movd.id_usuario_reg
                        inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = movd.id_tipo_movimiento 
						left join segu.tusuario usu2 on usu2.id_usuario = movd.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
           
			
             v_consulta=v_consulta||')
                    UNION
                 ( select
                            10000::integer,
                            ''resumen''::varchar,
                            0::integer,
                            COALESCE(sum(movd.monto),0)::numeric,
                            0::integer,
                            now()::timestamp,
                            0::integer,
                            NULL::timestamp,
                            NULL::integer,
                            ''-''::varchar,
                            NULL::varchar,
                           ''Total''::varchar
                           from ccb.tmovimiento_det movd
                          
						inner join segu.tusuario usu1 on usu1.id_usuario = movd.id_usuario_reg
                        inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = movd.id_tipo_movimiento 
						left join segu.tusuario usu2 on usu2.id_usuario = movd.id_usuario_mod
				        where
             ';
              v_consulta:=v_consulta||v_parametros.filtro||')';
               v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

              
              
              raise notice '%',v_consulta;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOVD_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		25-03-2013 02:03:18
	***********************************/

	elsif(p_transaccion='CCB_MOVD_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_movimiento_det)+1
					    from ccb.tmovimiento_det movd
					    inner join segu.tusuario usu1 on usu1.id_usuario = movd.id_usuario_reg
                        inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = movd.id_tipo_movimiento 
						left join segu.tusuario usu2 on usu2.id_usuario = movd.id_usuario_mod
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