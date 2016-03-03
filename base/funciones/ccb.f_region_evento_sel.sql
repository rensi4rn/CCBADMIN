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
    v_tipolist			varchar;
    v_filtro 			varchar;
    v_order 			varchar;
    v_id_gestion		integer;
    v_filtro_final		varchar;
			    
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
            v_tipolist = 'pc';
            
            
            IF  pxp.f_existe_parametro(p_tabla,'tipolist')  THEN            
               v_tipolist = 'mobile';
            END IF;
            
            IF p_administrador != 1   and v_tipolist = 'pc' THEN
               v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = rege.id_region or  uper.id_casa_oracion = rege.id_casa_oracion) ';
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
                        rege.hora,
                        rege.id_obrero,
                        ob.nombre_completo1	 as desc_obrero,
                        rege.obs,
                        rege.obs2
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
                        left join ccb.vobrero ob on ob.id_obrero = rege.id_obrero
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
            v_tipolist = 'pc';
            
            
            IF  pxp.f_existe_parametro(p_tabla,'tipolist')  THEN            
               v_tipolist = 'mobile';
            END IF;
            
            --filtro de asignaciones
            IF p_administrador != 1   and v_tipolist = 'pc' THEN
             v_inner = ' inner join ccb.tusuario_permiso uper on uper.id_usuario_asignado = '||p_id_usuario||'  and (uper.id_region = rege.id_region or  uper.id_casa_oracion = rege.id_casa_oracion) ';
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
                        left join ccb.vobrero ob on ob.id_obrero = rege.id_obrero
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
            
             IF  pxp.f_existe_parametro(p_tabla,'tipoconsulta')  THEN            
               v_tipolist = v_parametros.tipoconsulta;
             else
               v_tipolist = 'comun';
             END IF;
            
             IF p_administrador != 1  and v_tipolist != 'calendario' THEN
            
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
                            eve.hora,
                            id_obrero,
                            desc_obrero
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
                
                v_filtro_lugares =  v_filtro_lugares||' and  id_lugar in ('||v_lugares||') ';
           END IF; 
           
           IF  pxp.f_existe_parametro(p_tabla,'id_obrero')  THEN
              IF   v_parametros.id_obrero is not null  THEN
                 v_filtro_lugares =  v_filtro_lugares||' and  id_obrero = '||v_parametros.id_obrero::varchar||' ';
              END IF;
           END IF;
            
           IF  pxp.f_existe_parametro(p_tabla,'id_evento')  THEN
              IF   v_parametros.id_evento is not null THEN
                 v_filtro_lugares =  v_filtro_lugares||' and  id_evento = '||v_parametros.id_evento::varchar||' ';
              END IF;
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
                            id_region_evento,
                            id_obrero,
                            COALESCE(desc_obrero,''n/d''),
                            id_casa_oracion,
                            id_region,
                            id_evento,
                            desc_gestion,
                            id_gestion
                          FROM 
                            ccb.vcalendario
                        where   (fecha_programada  BETWEEN  '''||v_fecha_ini::varchar||'''::date and '''||v_fecha_fin::varchar||'''::date)  
                                and '||v_filtro_lugares;
			
			--Definicion de la respuesta
			
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;
    /*********************************    
 	#TRANSACCION:  'CCB_REPAGE_SEL'
 	#DESCRIPCION:	consulta de agenda para reporte impreso
 	#AUTOR:		admin	
 	#FECHA:		16-08-2015 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REPAGE_SEL')then
     				
    	begin
        
            v_inner = '';
            v_lugares = '0';
            v_filtro = '0=0 and';
            
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
                      v_filtro = ' lug.id_lugar in ('||v_lugares||') and ';
                END IF;
                
           END IF; 
           
           
      
           
           --filtro de eventos
           IF  pxp.f_existe_parametro(p_tabla,'id_eventos')  THEN
             IF v_parametros.id_eventos is not null and v_parametros.id_eventos != '' THEN
                v_filtro = v_filtro||' rege.id_evento in ('||v_parametros.id_eventos||') and ';
             END IF;
           END IF;
           
            
           
           --filtro de obreros
           IF  pxp.f_existe_parametro(p_tabla,'id_obrero')  THEN
             IF v_parametros.id_obrero is not null and v_parametros.id_obrero != '' THEN
                v_filtro = v_filtro||' rege.id_obrero in ('||v_parametros.id_obrero||') and ';
             END IF;
           END IF;
           
          
           
           --filtro de regiones
           IF  pxp.f_existe_parametro(p_tabla,'id_regiones')  THEN
             IF v_parametros.id_regiones is not null and v_parametros.id_regiones != '' THEN
                v_filtro = v_filtro||' rege.id_region in ('||v_parametros.id_regiones||') and ';
             END IF;
           END IF;
           
          
           
           --filtro de regiones
           IF  pxp.f_existe_parametro(p_tabla,'id_regiones')  THEN
             IF v_parametros.id_regiones is not null and v_parametros.id_regiones != '' THEN
                v_filtro = v_filtro||' rege.id_region in ('||v_parametros.id_regiones||') and ';
             END IF;
           END IF;
           
           
          --raise exception '  % ', v_parametros.tipo_orden;
           
           IF v_parametros.tipo_orden = 'fecha'  THEN
            v_order = 'ep.num_mes asc , eve.prioridad asc, rege.fecha_programada asc';
           ELSE
             v_order = 'eve.prioridad, rege.fecha_programada asc';
           END IF;
           
           
           IF  pxp.f_existe_parametro(p_tabla,'nacional')  THEN
             
             
             IF v_parametros.nacional is not null and v_parametros.nacional = 'si' THEN
                v_filtro_final =' 0=0)  or  (eve.nacional = ''si'')) and ';
             ELSE
                v_filtro_final =' 0=0)) and ';
             END IF;
           
           
           END IF;
           
           
          
            --Sentencia de la consulta
			v_consulta:='select
                          rege.id_region_evento,
                          rege.estado_reg,
                          rege.id_gestion,
                          (to_char(rege.fecha_programada, ''DD/MM/YY''))::varchar as fecha_programada,
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
                          to_char(rege.hora, ''HH24:MI'')::varchar as hora,
                          rege.id_obrero,
                          ob.nombre_completo1	 as desc_obrero,
                          (extract(dow from  rege.fecha_programada))::varchar as num_dia,
                          reg.obs as obs_region,
                          COALESCE(rege.obs,'''') as obs,
                          rege.obs2
                          from ccb.tregion_evento rege
                          inner join ccb.tgestion ges on ges.id_gestion = rege.id_gestion
                          inner join ccb.tregion reg on reg.id_region = rege.id_region
                          inner join ccb.tevento eve on eve.id_evento = rege.id_evento 
                          inner join ccb.tcasa_oracion co on co.id_casa_oracion = rege.id_casa_oracion
                          inner join segu.tusuario usu1 on usu1.id_usuario = rege.id_usuario_reg
                          inner join param.tlugar lug on lug.id_lugar = co.id_lugar
                          inner join ccb.testado_periodo ep   on  rege.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE  and ep.estado_reg = ''activo'' and ep.id_casa_oracion = co.id_casa_oracion
                          left join segu.tusuario usu2 on usu2.id_usuario = rege.id_usuario_mod
                          left join ccb.vobrero ob on ob.id_obrero = rege.id_obrero
                        where  (('||v_filtro||v_filtro_final||' (rege.fecha_programada  BETWEEN  '''||v_parametros.desde::varchar||'''::date and '''||v_parametros.hasta::varchar||'''::date) ';
			 
			--Definicion de la respuesta
			v_consulta := v_consulta||' order by '||v_order;
			--Devuelve la respuesta
            
            raise notice '---> %' , v_consulta;
			return v_consulta;
						
		end;
     /*********************************    
 	#TRANSACCION:  'CCB_REPAGEANU_SEL'
 	#DESCRIPCION:	consulta de agenda anual para reporte impreso
 	#AUTOR:		admin	
 	#FECHA:		16-08-2015 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REPAGEANU_SEL')then
     				
    	begin
        
            
    		
            v_inner = '';
            v_lugares = '0';
            v_filtro = '0=0 and';
            
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
                      v_filtro = ' re.id_lugar in ('||v_lugares||') and ';
                END IF;
                
           END IF; 
           
           
      
           
           --filtro de eventos
           IF  pxp.f_existe_parametro(p_tabla,'id_eventos')  THEN
             IF v_parametros.id_eventos is not null and v_parametros.id_eventos != '' THEN
                v_filtro = v_filtro||' re.id_evento in ('||v_parametros.id_eventos||') and ';
             END IF;
           END IF;
           
                     
           
           --filtro de regiones
           IF  pxp.f_existe_parametro(p_tabla,'id_regiones')  THEN
             IF v_parametros.id_regiones is not null and v_parametros.id_regiones != '' THEN
                v_filtro = v_filtro||' re.id_region in ('||v_parametros.id_regiones||') and ';
             END IF;
           END IF;
           
          
            --Sentencia de la consulta
			v_consulta:='SELECT (to_char(d.dia::timestamp with time zone, ''DD''::text))::TEXT  AS num_dia,
                                (to_char(d.dia::timestamp with time zone, ''D''::text))::TEXT AS dia_sem,
                                (to_char(d.dia::timestamp with time zone, ''MONTH''::text))::TEXT  AS mes,
                                 
                                 re.hora::varchar,
                                 re.desc_region_obs,
                                 re.desc_casa_oracion,
                                 re.desc_evento,
                                 re.css,
                                 re.desc_obrero,
                                 re.desc_region,
                                 re.desc_lugar,
                                 re.id_lugar,
                                 re.id_region_evento,
                                 re.id_evento,
                                 re.id_region,
                                 re.id_casa_oracion,
                                 d.dia::Date
                          FROM ccb.vdias d
                               LEFT JOIN ccb.vregion_evento re 
                               
                               ON re.fecha_programada = d.dia and '||v_filtro||' 0=0 
                           WHERE  (dia  BETWEEN  '''||v_parametros.desde::varchar||'''::date and '''||v_parametros.hasta::varchar||'''::date) 
                           ORDER BY d.dia, re.hora';
			 
			
			return v_consulta;
						
		end;
    
    /*********************************    
 	#TRANSACCION:  'CCB_REGESCRES_SEL'
 	#DESCRIPCION:	Consulta de santa cenas y bautizos para resumen
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGESCRES_SEL')then
     				
    	begin
    		
           
            
            --obtenemos la gestion a partir  de la fecha
            select 
              g.id_gestion
            into
              v_id_gestion
            from ccb.tgestion g  
            where  v_parametros.hasta::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
            IF v_id_gestion is NULL THEN
              raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
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
                                eve.cantidad_hermano::int4,
                                eve.cantidad_hermana::int4,
                                eve.id_gestion,
                                eve.gestion,
                                eve.id_detalle_evento_hermano,
                                eve.id_detalle_evento_hermana,
                                eve.id_evento,
                                eve.codigo,
                                eve.nombre,
                                eve.id_usuario_mod,
                                eve.cuenta,
                                eve.hora,
                                id_obrero,
                                desc_obrero,
                                eve.id_lugar,
                                eve.nombre_lugar
                          FROM 
                            ccb.vevento_bautizo_santa_cena eve
                            
                        where     eve.id_region in ('||COALESCE(v_parametros.id_regiones,'0')||')
                             and  eve.id_gestion = '||COALESCE(v_id_gestion,0)::Varchar||'
                             and eve.codigo::text = '''||v_parametros.tipo_evento||''' 
			              order  by eve.nombre_region ,eve.fecha_programada, eve.nombre_co ';
           
			--Devuelve la respuesta
			return v_consulta;
						
		end;
     /*********************************    
 	#TRANSACCION:  'CCB_RECONBSC_SEL'
 	#DESCRIPCION:	Consulta de santa cenas y bautizos para resumen consolidado
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_RECONBSC_SEL')then
     				
    	begin
    		
           
            
            --obtenemos la gestion a partir  de la fecha
            select 
              g.id_gestion
            into
              v_id_gestion
            from ccb.tgestion g  
            where  v_parametros.hasta::date BETWEEN  ('01/01/'||g.gestion)::date and ('31/12/'||g.gestion)::date;
            
            
            IF v_id_gestion is NULL THEN
              raise exception 'No se encontro una gestión registrada para la fecha %',v_parametros.fecha; 
            END IF;
            
            
            
            --Sentencia de la consulta
			v_consulta:='SELECT 
                               
                               
                              
                                eve.id_casa_oracion,
                                eve.id_region,
                                eve.nombre_region,
                                eve.nombre_co,
                                sum(eve.cantidad_hermano)::int4,
                                sum(eve.cantidad_hermana)::int4,
                                eve.id_gestion,
                                eve.gestion,
                                eve.codigo,
                                eve.nombre
                          FROM 
                            ccb.vevento_bautizo_santa_cena eve
                            
                           
                            
                        where     eve.id_region in ('||COALESCE(v_parametros.id_regiones,'0')||')
                             and  eve.id_gestion = '||COALESCE(v_id_gestion,0)::Varchar||'
                             and eve.codigo::text = '''||v_parametros.tipo_evento||''' 
			            group by
                                eve.id_casa_oracion,
                                eve.id_region,
                                eve.nombre_region,
                                eve.nombre_co,
                                eve.id_gestion,
                                eve.gestion,
                                eve.codigo,
                                eve.nombre
                        order  by eve.nombre_region , eve.nombre_co ';
           
			--Devuelve la respuesta
            raise notice '%',v_consulta;
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