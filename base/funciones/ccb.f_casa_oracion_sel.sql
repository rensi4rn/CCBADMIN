--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_casa_oracion_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_casa_oracion_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tcasa_oracion'
 AUTOR: 		 (admin)
 FECHA:	        05-01-2013 08:52:02
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
    v_inner 			varchar;
    v_filtro_lugares	varchar;
    v_lugares			varchar;
			    
BEGIN

	v_nombre_funcion = 'ccb.f_casa_oracion_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_CAOR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:52:02
	***********************************/

	if(p_transaccion='CCB_CAOR_SEL')then
     				
    	begin
        
            v_inner = '';
            v_filtro_lugares = '0=0 and';
            
            IF p_administrador != 1  THEN
               v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = caor.id_region or  uper.id_casa_oracion = caor.id_casa_oracion) ';
            END IF;
            
            IF  pxp.f_existe_parametro(p_tabla,'id_lugar')  THEN
            
                  WITH RECURSIVE lugar_rec (id_lugar, id_lugar_fk, nombre) AS (
                    SELECT lug.id_lugar, id_lugar_fk, nombre
                    FROM param.tlugar lug
                    WHERE lug.id_lugar = v_parametros.id_lugar and lug.estado_reg = 'activo'
                  UNION ALL
                    SELECT lug2.id_lugar, lug2.id_lugar_fk, lug2.nombre
                    FROM lugar_rec lrec 
                    INNER JOIN param.tlugar lug2 ON lrec.id_lugar = lug2.id_lugar_fk
                    where lug2.estado_reg = 'activo'
                  )
                SELECT  pxp.list(id_lugar::varchar) 
                  into 
                    v_lugares
                FROM lugar_rec;
                
                
                
                v_filtro_lugares = ' lug.id_lugar in ('||v_lugares||') and ';
           END IF;
            
            
            
    		--Sentencia de la consulta
			v_consulta:='select
						caor.id_casa_oracion,
						caor.estado_reg,
						caor.fecha_cierre,
						caor.codigo,
						caor.id_region,
						caor.id_lugar,
						caor.direccion,
						caor.nombre,
						caor.fecha_apertura,
						caor.fecha_reg,
						caor.id_usuario_reg,
						caor.fecha_mod,
						caor.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        reg.nombre as desc_region,
                        lug.nombre as desc_lugar,
                        caor.latitud,
                        caor.longitud,
                        caor.zoom
						from ccb.tcasa_oracion caor
                        inner join ccb.tregion reg on reg.id_region = caor.id_region
                        inner join param.tlugar lug on lug.id_lugar = caor.id_lugar
						inner join segu.tusuario usu1 on usu1.id_usuario = caor.id_usuario_reg
                        '|| v_inner ||'
						left join segu.tusuario usu2 on usu2.id_usuario = caor.id_usuario_mod
				        where  '||v_filtro_lugares;
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CAOR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:52:02
	***********************************/

	elsif(p_transaccion='CCB_CAOR_CONT')then

		begin
            v_inner = '';
            v_filtro_lugares = '0=0 and';
            IF p_administrador != 1  THEN
               v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = caor.id_region or  uper.id_casa_oracion = caor.id_casa_oracion) ';
            END IF;
            
            IF  pxp.f_existe_parametro(p_tabla,'id_lugar')  THEN
            
                  WITH RECURSIVE lugar_rec (id_lugar, id_lugar_fk, nombre) AS (
                    SELECT lug.id_lugar, id_lugar_fk, nombre
                    FROM param.tlugar lug
                    WHERE lug.id_lugar = v_parametros.id_lugar and lug.estado_reg = 'activo'
                  UNION ALL
                    SELECT lug2.id_lugar, lug2.id_lugar_fk, lug2.nombre
                    FROM lugar_rec lrec 
                    INNER JOIN param.tlugar lug2 ON lrec.id_lugar = lug2.id_lugar_fk
                    where lug2.estado_reg = 'activo'
                  )
                SELECT  pxp.list(id_lugar::varchar) 
                  into 
                    v_lugares
                FROM lugar_rec;
                
                
                
                v_filtro_lugares = ' lug.id_lugar in ('||v_lugares||') and ';
           END IF;
           
           
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(caor.id_casa_oracion)
					    from ccb.tcasa_oracion caor
					    inner join ccb.tregion reg on reg.id_region = caor.id_region
                        inner join param.tlugar lug on lug.id_lugar = caor.id_lugar
						inner join segu.tusuario usu1 on usu1.id_usuario = caor.id_usuario_reg
                        '|| v_inner ||'
						left join segu.tusuario usu2 on usu2.id_usuario = caor.id_usuario_mod
					    where '||v_filtro_lugares;
			
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