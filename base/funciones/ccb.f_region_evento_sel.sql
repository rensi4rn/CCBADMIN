--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_region_evento_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_region_evento_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tregion_evento'
 AUTOR: 		 (admin)
 FECHA:	        13-01-2013 14:31:26
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
    v_inner				varchar;
    v_lugares	        varchar;
    v_filtro_lugares    varchar;
    v_fecha_ini			date;
    v_fecha_fin			date;
			    
BEGIN

	v_nombre_funcion = 'ccb.f_region_evento_sel';
    v_parametros = pxp.f_get_record(p_tabla);
    

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	if(p_transaccion='CCB_REGE_SEL')then
     				
    	begin
    		
            v_inner = '';
            v_lugares = '0';
            v_filtro_lugares = '0=0 and';
            IF p_administrador != 1  THEN
            
             -- v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = rege.id_region or  uper.id_casa_oracion = rege.id_casa_oracion) ';
            
            END IF;
            
           -- raise exception '%',  pxp.f_existe_parametro(p_tabla,'id_lugar');
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
            
           --raise exception 'ssss %', v_parametros;
            --Sentencia de la consulta
			v_consulta:='select
						rege.id_region_evento,
						rege.estado_reg,
						rege.id_gestion,
						rege.fecha_programada,
						rege.id_evento,
						rege.estado,
						rege.id_region,
						rege.fecha_reg,
						rege.id_usuario_reg,
						rege.fecha_mod,
						rege.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        ges.gestion as desc_gestion,
                        eve.nombre as desc_evento,
                        reg.nombre as desc_region,
                        co.id_casa_oracion,
                        co.nombre as desc_casa_oracion,
                        rege.tipo_registro,
                        lug.id_lugar,
                        lug.nombre as  desc_lugar,
                        ep.mes,
                        rege.hora	
						from ccb.tregion_evento rege
                        inner join ccb.tgestion ges on ges.id_gestion = rege.id_gestion
                        inner join ccb.tregion reg on reg.id_region = rege.id_region
                        inner join ccb.tevento eve on eve.id_evento = rege.id_evento 
                        inner join ccb.tcasa_oracion co on co.id_casa_oracion = rege.id_casa_oracion
						inner join segu.tusuario usu1 on usu1.id_usuario = rege.id_usuario_reg
                        inner join param.tlugar lug on lug.id_lugar = co.id_lugar
                        inner join ccb.testado_periodo ep   on  rege.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE  and ep.estado_reg = ''activo'' and ep.id_casa_oracion = co.id_casa_oracion
                        
                        '|| v_inner ||'
                        left join segu.tusuario usu2 on usu2.id_usuario = rege.id_usuario_mod
                        where  '||v_filtro_lugares;
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            raise notice  '.. % ...', v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;
    /*********************************    
 	#TRANSACCION:  'CCB_REGE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGE_CONT')then

		begin
        
            v_inner = '';
            v_lugares = '0';
            v_filtro_lugares = '0=0 and';
            
            IF p_administrador != 1  THEN
            
             -- v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = rege.id_region or  uper.id_casa_oracion = rege.id_casa_oracion) ';
            
            END IF;
             
             -- raise exception '%',  pxp.f_existe_parametro(p_tabla,'id_lugar');
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
			v_consulta:='select count(id_region_evento)
					    from ccb.tregion_evento rege
                        inner join ccb.tgestion ges on ges.id_gestion = rege.id_gestion
                        inner join ccb.tregion reg on reg.id_region = rege.id_region
                        inner join ccb.tevento eve on eve.id_evento = rege.id_evento 
                        inner join ccb.tcasa_oracion co on co.id_casa_oracion = rege.id_casa_oracion
						inner join segu.tusuario usu1 on usu1.id_usuario = rege.id_usuario_reg
                        inner join param.tlugar lug on lug.id_lugar = co.id_lugar
                        inner join ccb.testado_periodo ep   on  rege.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE  and ep.estado_reg = ''activo'' and ep.id_casa_oracion = co.id_casa_oracion
                        '|| v_inner ||'
                        left join segu.tusuario usu2 on usu2.id_usuario = rege.id_usuario_mod
                        where  '||v_filtro_lugares;
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;
            
             
			--Devuelve la respuesta
			return v_consulta;

		end;
	
					
	/*********************************    
 	#TRANSACCION:  'CCB_REGESC_SEL'
 	#DESCRIPCION:	Consulta de santa cenas y bautizos
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGESC_SEL')then
     				
    	begin
    		
            v_inner = '';
            IF p_administrador != 1  THEN
            
              v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = eve.id_region or  uper.id_casa_oracion = eve.id_casa_oracion) ';
            
            END IF;
            
            
            --Sentencia de la consulta
			v_consulta:='SELECT 
                            eve.fecha_programada,
                            eve.estado,
                            eve.id_region_evento,
                            eve.id_casa_oracion,
                            eve.id_region,
                            eve.nombre_region,
                            eve.nombre_co,
                            eve.cantidad_hermano,
                            eve.cantidad_hermana,
                            eve.id_gestion,
                            eve.gestion,
                            eve.id_detalle_evento_hermano,
                            eve.id_detalle_evento_hermana,
                            eve.id_evento,
                            eve.codigo,
                            eve.nombre,
                            eve.id_usuario_mod,
                            eve.cuenta,
                            eve.hora
                          FROM 
                            ccb.vevento_bautizo_santa_cena eve
                        '|| v_inner ||'
                        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            --raise exception 'xxx %',v_consulta ;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGESC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGESC_CONT')then

		begin
        
             v_inner = '';
            IF p_administrador != 1  THEN
            
              v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = eve.id_region or  uper.id_casa_oracion = eve.id_casa_oracion) ';
            
            END IF;
            
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_region_evento)
					    FROM 
                            ccb.vevento_bautizo_santa_cena eve
                        '|| v_inner ||'
                        where   ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;
            
             
			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************    
 	#TRANSACCION:  'CCB_CALEN_SEL'
 	#DESCRIPCION:	consulta de eventos para el calendario
 	#AUTOR:		admin	
 	#FECHA:		06-06-2015 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_CALEN_SEL')then
     				
    	begin
    		
            v_inner = '';
            v_lugares = '0';
            v_filtro_lugares = '0=0 ';
            
           -- raise exception '%',  pxp.f_existe_parametro(p_tabla,'id_lugar');
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
                
                v_filtro_lugares = ' lug.id_lugar in ('||v_lugares||') ';
           END IF; 
           
           v_fecha_ini = now() - interval '1' MONTH;
           v_fecha_fin = now() + interval '2' MONTH;
           
           IF  pxp.f_existe_parametro(p_tabla,'fecha_ini')  THEN
             v_fecha_ini = v_parametros.fecha_ini::date - interval '2' MONTH;
           END IF;
           
           IF  pxp.f_existe_parametro(p_tabla,'fecha_fin')  THEN
             v_fecha_fin = v_parametros.fecha_fin::date + interval '2' MONTH;
           END IF;
           
          
            --Sentencia de la consulta
			v_consulta:='SELECT 
                            "event"::varchar,
                            "title",
                            "start"::TIMESTAMP,
                            "end"::TIMESTAMP,
                            desc_evento,
                            desc_region,
                            desc_casa_oracion,
                            tipo_registro,
                            desc_lugar,
                            hora::varchar as hora,
                            id_lugar,
                            fecha_programada,
                            css,
                            id_region_evento
                          FROM 
                            ccb.vcalendario
                        where   (fecha_programada  BETWEEN  '''||v_fecha_ini::varchar||'''::date and '''||v_fecha_fin::varchar||'''::date)  
                                and '||v_filtro_lugares;
			
			--Definicion de la respuesta
			
			raise notice '%',v_consulta;
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