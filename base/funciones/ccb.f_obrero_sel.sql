--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_obrero_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_obrero_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tobrero'
 AUTOR: 		 (admin)
 FECHA:	        13-01-2013 12:03:11
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
    v_filtro			varchar;
    v_lugares			varchar;
			    
BEGIN

	v_nombre_funcion = 'ccb.f_obrero_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_OBR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:03:11
	***********************************/

	if(p_transaccion='CCB_OBR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						obr.id_obrero,
						obr.estado_reg,
						obr.id_region,
						obr.fecha_fin,
						obr.fecha_ini,
						obr.obs,
						obr.id_tipo_ministerio,
						obr.id_persona,
						obr.fecha_reg,
						obr.id_usuario_reg,
						obr.fecha_mod,
						obr.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        per.nombre_completo1 as desc_persona,
                        tipmi.nombre as desc_tipo_ministerio,
                        COALESCE(co.nombre,'''') as desc_casa_oracion,
                        obr.id_casa_oracion,
                        reg.nombre as desc_region,
                        per.telefono1,
                        per.telefono2,
                        per.celular1,
                        per.correo,
                        lug.nombre AS desc_lugar
                        from ccb.tobrero obr
                        inner join ccb.ttipo_ministerio tipmi on tipmi.id_tipo_ministerio = obr.id_tipo_ministerio
                        inner join ccb.tregion reg on reg.id_region = obr.id_region
                        inner join segu.vpersona per on per.id_persona = obr.id_persona
						inner join segu.tusuario usu1 on usu1.id_usuario = obr.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = obr.id_usuario_mod
                        left join ccb.tcasa_oracion co on co.id_casa_oracion =  obr.id_casa_oracion
                        left join param.tlugar lug ON lug.id_lugar = co.id_lugar
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;
        
    /*********************************    
 	#TRANSACCION:  'CCB_OBRTO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:03:11
	***********************************/

	elsif(p_transaccion='CCB_OBRTO_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						obr.id_obrero,
						obr.estado_reg,
						obr.id_region,
						obr.fecha_fin,
						obr.fecha_ini,
						obr.obs,
						obr.id_tipo_ministerio,
						obr.id_persona,
						obr.fecha_reg,
						obr.id_usuario_reg,
						obr.fecha_mod,
						obr.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        per.nombre_completo1 as desc_persona,
                        tipmi.nombre as desc_tipo_ministerio,
                        co.nombre as desc_casa_oracion,
                        obr.id_casa_oracion,
                        reg.nombre as desc_region,
                        per.telefono1,
                        per.telefono2,
                        per.celular1,
                        per.correo
                        from ccb.tobrero obr
                        inner join ccb.ttipo_ministerio tipmi on tipmi.id_tipo_ministerio = obr.id_tipo_ministerio
                        inner join ccb.tregion reg on reg.id_region = obr.id_region
                        inner join segu.vpersona per on per.id_persona = obr.id_persona
						inner join segu.tusuario usu1 on usu1.id_usuario = obr.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = obr.id_usuario_mod
                        left join ccb.tcasa_oracion co on co.id_casa_oracion =  obr.id_casa_oracion
				        where  0=0 ';
			
			--Definicion de la respuesta
			
			v_consulta:=v_consulta||' order by desc_persona';
            
			--Devuelve la respuesta
			return v_consulta;
						
		end;



	/*********************************    
 	#TRANSACCION:  'CCB_OBR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:03:11
	***********************************/

	elsif(p_transaccion='CCB_OBR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_obrero)
					    from ccb.tobrero obr
                        inner join ccb.ttipo_ministerio tipmi on tipmi.id_tipo_ministerio = obr.id_tipo_ministerio
                        inner join ccb.tregion reg on reg.id_region = obr.id_region
                        inner join segu.vpersona per on per.id_persona = obr.id_persona
						inner join segu.tusuario usu1 on usu1.id_usuario = obr.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = obr.id_usuario_mod
                        left join ccb.tcasa_oracion co on co.id_casa_oracion =  obr.id_casa_oracion
				        where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
    
    /*********************************    
 	#TRANSACCION:  'CCB_OBRAGD_SEL'
 	#DESCRIPCION:	Lista los obreros para el report ede agenda anua
 	#AUTOR:		rensi	
 	#FECHA:		16-08-2015 12:03:11
	***********************************/

	elsif(p_transaccion='CCB_OBRAGD_SEL')then
     				
    	begin
        
          
            v_lugares = '0';
            v_filtro = ' ';
            
           -- raise exception '%',  pxp.f_existe_parametro(p_tabla,'id_lugar');
            IF  pxp.f_existe_parametro(p_tabla,'id_lugar')  THEN
                 
                 IF v_parametros.id_lugar is not null THEN
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
                      v_filtro = ' id_lugar in ('||v_lugares||') and ';
                END IF;
                
           END IF; 
           
           
      
           
           --filtro de eventos
           IF  pxp.f_existe_parametro(p_tabla,'id_eventos')  THEN
             IF v_parametros.id_eventos is not null and v_parametros.id_eventos != '' THEN
                v_filtro = v_filtro||' id_evento in ('||v_parametros.id_eventos||') and ';
             END IF;
           END IF;
           
                     
           
           --filtro de regiones
           IF  pxp.f_existe_parametro(p_tabla,'id_regiones')  THEN
             IF v_parametros.id_regiones is not null and v_parametros.id_regiones != '' THEN
                v_filtro = v_filtro||' id_region in ('||v_parametros.id_regiones||') and ';
             END IF;
           END IF;
           
    		--Sentencia de la consulta
			v_consulta:='SELECT 
                          id_tipo_ministerio,
                          id_obrero,
                          id_persona,
                          ministerio,
                          nombre_completo1,
                          telefono1,
                          telefono2,
                          celular1,
                          correo,
                          casa_oracion,
                          region,
                          obs,
                          id_lugar,
                          lugar,
                          id_region
                        FROM 
                          ccb.vagenda_telefonica  
                        WHERE '||v_filtro||' 0=0 ' ;
			
			raise notice '%', v_consulta;
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