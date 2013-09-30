--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_movimiento_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_movimiento_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ccb.tmovimiento'
 AUTOR: 		 (admin)
 FECHA:	        16-03-2013 00:22:36
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
    
    g_registros record;
    g_registros2  record;
    
    v_cod varchar;
    v_consulta2 varchar;
    v_consulta1  varchar;
    v_total_fila numeric;
    
    v_consulta_sum varchar;
	v_consulta_tem varchar;
    v_insert_sum varchar;		    
BEGIN

	v_nombre_funcion = 'ccb.f_movimiento_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_MOV_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	if(p_transaccion='CCB_MOV_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						mov.id_movimiento,
						mov.estado_reg,
						mov.tipo,
						mov.id_casa_oracion,
						mov.concepto,
						mov.obs,
						mov.fecha,
						mov.id_estado_periodo,
						mov.fecha_reg,
						mov.id_usuario_reg,
						mov.fecha_mod,
						mov.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ccb.tmovimiento mov
						inner join segu.tusuario usu1 on usu1.id_usuario = mov.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = mov.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_MOV_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		16-03-2013 00:22:36
	***********************************/

	elsif(p_transaccion='CCB_MOV_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_movimiento)
					    from ccb.tmovimiento mov
					    inner join segu.tusuario usu1 on usu1.id_usuario = mov.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = mov.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	  /*********************************
      #TRANSACCION: 'CCB_MOVDIN_SEL'
      #DESCRIPCION: coonsulta dinamica delos movimientos economicos
      #AUTOR: rac
      #FECHA: 25/03/2013
      ***********************************/

      elseif(p_transaccion = 'CCB_MOVDIN_SEL')then

      begin
              
      --1) crear tabla temporal segun la fecha inicio y ficha final indicada
              
      v_consulta = 'create temp table tt_movimiento_'||p_id_usuario||'(
      id_movimieno_din serial,
      id_movimiento integer,
      desc_casa_oracion varchar,
      desc_gestion integer,
      desc_estado_periodo varchar,
      concepto varchar,
      tipo varchar,
      fecha date
      ';
      
      --prepara consulta de sum
      v_consulta_tem =' select
                        id_movimieno_din,
                        id_movimiento,
                        desc_casa_oracion,
                        desc_gestion,
                        desc_estado_periodo,
                        concepto,
                        tipo,
                        fecha';
      
      v_consulta_sum = 'select
                        0,
                        0,
                        ''Total''::varchar,
                        max(desc_gestion),
                        ''Total''::varchar,
                        ''Total''::varchar,
                        ''resumen''::varchar,
                        max(fecha)'; 
    
              
               
     FOR g_registros in (
                          select
                           tm.id_tipo_movimiento,
                           tm.codigo
                          from ccb.ttipo_movimiento tm
                          where tm.estado_reg='activo'
     
                        ) LOOP
                  
                  v_cod= 'col_'||lower(g_registros.codigo);
         
                 
                  v_consulta =v_consulta||','||v_cod||' numeric';
                  
                  v_consulta_sum=v_consulta_sum||',sum(COALESCE('||v_cod||',0)) as '||v_cod;
                  v_consulta_tem =v_consulta_tem||',COALESCE('||v_cod||',0) as '||v_cod;
                  
                  v_consulta =v_consulta||','||v_cod||'_key integer';
                  
                  v_consulta_sum=v_consulta_sum||',0 as '||v_cod||'_key';
                  v_consulta_tem =v_consulta_tem||','||v_cod||'_key';
               
              
                 
                 
                 end loop;
                 
               -- raise exception '%', v_consulta;
                
                --concatena el finald e la creacion
                 v_consulta =v_consulta||',total numeric) on commit drop';
                 
                 v_consulta_sum=v_consulta_sum||', sum(total)';
                 v_consulta_tem =v_consulta_tem||', total';
                 
                
                --crea tabla
                
                 raise notice 'CREA TABLA TEMPORAL,%',v_consulta;
                 execute(v_consulta);
                
             
               -- LLenamos la tabla temporal
                             
                -- 2) FOR consulta las fechas de la tabla equipo medicion filtrados por uni_cons,
                -- raise exception 'paciencia';
                     
                     FOR g_registros in (
                           
                             select
                             m.id_movimiento,
                             m.id_casa_oracion,
                             co.nombre as desc_casa_oracion,
                             ep.mes as desc_estado_periodo,
                             m.concepto,
                             m.tipo,
                             m.fecha,
                             ep.mes,
                             ges.gestion::integer as desc_gestion
                             
                             from ccb.tmovimiento m
                             inner join ccb.testado_periodo ep on m.id_estado_periodo = ep.id_estado_periodo  
                             inner join ccb.tcasa_oracion co on co.id_casa_oracion = m.id_casa_oracion
                             inner join ccb.tgestion ges on ges.id_gestion =ep.id_gestion
                              where
                              m.id_casa_oracion = v_parametros.id_casa_oracion
                              and ep.id_gestion= v_parametros.id_gestion
                              and m.tipo= v_parametros.tipo) LOOP
      
                            --2.0) (atributos) arma primera parte de la cadena de insercion con datos del equipo y del mantenimiento
           
                     
                  v_consulta1= 'INSERT into tt_movimiento_'||p_id_usuario||' (
                                   
                                  id_movimiento ,
                                  desc_casa_oracion ,
                                  desc_gestion ,
                                  desc_estado_periodo ,
                                  concepto ,
                                  tipo, 
                                  fecha  ';
                                                             
                -- (valores) arma la cadena de insercion de valores
               

                   v_consulta2= ',total) values('||g_registros.id_movimiento||','''||g_registros.desc_casa_oracion||''','||g_registros.desc_gestion||','''||g_registros.desc_estado_periodo||''','''||g_registros.concepto||''','''||g_registros.tipo||''','''||g_registros.fecha||'''';
                                  
                           v_total_fila =0;
                          
                           --2.1) FOR consulta los registros de la movimiento detalle agrupados por id_movimiento
                            FOR g_registros2 in (select 
                                                md.id_movimiento_det,
                                                md.monto,
                                                md.id_tipo_movimiento,
                                                tm.codigo,
                                                tm.nombre
                                                from ccb.tmovimiento_det md
                                                inner join ccb.ttipo_movimiento tm on tm.id_tipo_movimiento = md.id_tipo_movimiento
                                                where md.id_movimiento = g_registros.id_movimiento
                                                  ) LOOP
                  
                             -- 2.1.1) arma consulta de insercion
                              v_cod = 'col_'||lower(g_registros2.codigo);
                              v_consulta1=v_consulta1||','||v_cod||','||v_cod||'_key';
                              v_consulta2=v_consulta2||','||COALESCE(g_registros2.monto,0)::varchar||','||g_registros2.id_movimiento_det;
                            
                            
                            v_total_fila=v_total_fila+g_registros2.monto;
                            
                            END LOOP;
                            
                             -- 2.2) finaliza la cadena de insercion
                            
                             v_consulta1 = v_consulta1||v_consulta2|| ','|| v_total_fila::varchar||') ';
               
                            
                            -- 2.3) inserta los datos en la tabla temporal
                            
                            raise notice 'INSERCION %',v_consulta1;
         
           execute(v_consulta1);
              
                   END LOOP;
                
               -- 3) consulta de la tabla temporal
               
               
               
       v_consulta:='('||v_consulta_tem||' from tt_movimiento_'||p_id_usuario||' where '||v_parametros.filtro||'  ';
      
     
       v_consulta:= v_consulta||') UNION ('||v_consulta_sum||' from tt_movimiento_'||p_id_usuario||' where '||v_parametros.filtro||')';
      
      
      v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

               
      --Devuelve la respuesta
      return v_consulta;
               
             
      end;
          /*********************************
      #TRANSACCION: 'CCB_MOVDIN_CONT'
      #DESCRIPCION: Conteo de registros de la consulta dinamica de mediciones por quipo
      #AUTOR: rac
      #FECHA: 22/09/2012 22:09
      ***********************************/

      elsif(p_transaccion='CCB_MOVDIN_CONT')then

      begin
      --Sentencia de la consulta de conteo de registros
      v_consulta:='select
                             count(m.id_movimiento) + 1
                             from ccb.tmovimiento m
                             inner join ccb.testado_periodo ep on m.id_estado_periodo = ep.id_estado_periodo  
                             inner join ccb.tcasa_oracion co on co.id_casa_oracion = m.id_casa_oracion
                             inner join ccb.tgestion ges on ges.id_gestion =ep.id_gestion
                              where
                              m.id_casa_oracion = '||v_parametros.id_casa_oracion||'
                              and ep.id_gestion= '||v_parametros.id_gestion||'
                              and m.tipo='''||v_parametros.tipo||'''';


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