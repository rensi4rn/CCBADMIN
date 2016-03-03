--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.ft_casa_banco_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_casa_banco_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tcasa_banco'
 AUTOR: 		 (admin)
 FECHA:	        02-03-2016 01:06:45
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

	v_nombre_funcion = 'ccb.ft_casa_banco_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_COB_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		02-03-2016 01:06:45
	***********************************/

	if(p_transaccion='CCB_COB_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
                            cob.id_casa_banco,
                            cob.estado_reg,
                            cob.id_casa_oracion,
                            cob.id_tipo_movimiento,
                            cob.obs,
                            cob.id_cuenta_bancaria,
                            cob.id_usuario_reg,
                            cob.fecha_reg,
                            cob.usuario_ai,
                            cob.id_usuario_ai,
                            cob.id_usuario_mod,
                            cob.fecha_mod,
                            usu1.cuenta as usr_reg,
                            usu2.cuenta as usr_mod,
                            cb.nro_cuenta||'' (''||cb.denominacion||'')''  as desc_cuenta_bancaria,
                            tm.nombre::text  as desc_tipo_movimiento	
                          from ccb.tcasa_banco cob
                            inner join tes.tcuenta_bancaria cb on cb.id_cuenta_bancaria = cob.id_cuenta_bancaria
                            inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = cob.id_tipo_movimiento
                            inner join segu.tusuario usu1 on usu1.id_usuario = cob.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = cob.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_COB_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		02-03-2016 01:06:45
	***********************************/

	elsif(p_transaccion='CCB_COB_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_casa_banco)
					    from ccb.tcasa_banco cob
                            inner join tes.tcuenta_bancaria cb on cb.id_cuenta_bancaria = cob.id_cuenta_bancaria
                            inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = cob.id_tipo_movimiento
                            inner join segu.tusuario usu1 on usu1.id_usuario = cob.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = cob.id_usuario_mod
				        where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
   /*********************************    
 	#TRANSACCION:  'CCB_CBCTABAN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		Gonzalo Sarmiento Sejas	
 	#FECHA:		24-04-2013 15:19:30
	***********************************/

	elseif(p_transaccion='CCB_CBCTABAN_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select DISTINCT
                            ctaban.id_cuenta_bancaria,
                            ctaban.estado_reg,
                            ctaban.fecha_baja,
                            ctaban.nro_cuenta,
                            ctaban.fecha_alta,
                            ctaban.id_institucion,
                            inst.nombre as nombre_institucion,
                            inst.doc_id,
                            ctaban.fecha_reg,
                            ctaban.id_usuario_reg,
                            ctaban.fecha_mod,
                            ctaban.id_usuario_mod,
                            usu1.cuenta as usr_reg,
                            usu2.cuenta as usr_mod,
                            mon.id_moneda,	
                            mon.codigo as codigo_moneda,
                            ctaban.denominacion,
                            ctaban.centro
						from tes.tcuenta_bancaria ctaban
                        inner join param.tinstitucion inst on inst.id_institucion = ctaban.id_institucion
                        inner join ccb.tcasa_banco cb on cb.id_cuenta_bancaria = ctaban.id_cuenta_bancaria
                        left join param.tmoneda mon on mon.id_moneda =  ctaban.id_moneda
						inner join segu.tusuario usu1 on usu1.id_usuario = ctaban.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ctaban.id_usuario_mod  
                        where  ';
			  
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CBCTABAN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		Gonzalo Sarmiento Sejas	
 	#FECHA:		24-04-2013 15:19:30
	***********************************/

	elsif(p_transaccion='CCB_CBCTABAN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(DISTINCT ctaban.id_cuenta_bancaria)
					    from tes.tcuenta_bancaria ctaban
                        inner join param.tinstitucion inst on inst.id_institucion = ctaban.id_institucion
                        inner join ccb.tcasa_banco cb on cb.id_cuenta_bancaria = ctaban.id_cuenta_bancaria
                        left join param.tmoneda mon on mon.id_moneda =  ctaban.id_moneda
						inner join segu.tusuario usu1 on usu1.id_usuario = ctaban.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ctaban.id_usuario_mod  
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