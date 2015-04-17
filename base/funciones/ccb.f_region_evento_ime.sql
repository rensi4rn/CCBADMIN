--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_region_evento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_region_evento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tregion_evento'
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

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_region_evento		integer;
    v_registros_evento		record;
    va_tipo					varchar[];
    v_registros  			record;
    v_estado_periodo		varchar;
    v_resgistros_detalle    record;
    v_id_detalle_evento     integer;
    v_cantidad              integer;
    v_id_region				integer;
    v_id_gestion			integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_region_evento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	if(p_transaccion='CCB_REGE_INS')then
					
        begin
        	
            -- si es del tipo resumen validamos que no se duplique 
           if  v_parametros.tipo_registro = 'detalle' then
           
              select 
                ep.estado_periodo
              into
                v_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
           
           else 
           
               --validamos que no exista un resumen lara la misma gestion y misma casa de oracion   
               IF EXISTS( 
                         select
                         1
                         from ccb.tregion_evento re 
                         where re.id_gestion = v_parametros.id_gestion 
                               and  re.id_casa_oracion = v_parametros.id_casa_oracion
                               and re.id_region = v_parametros.id_region 
                               and re.id_evento = v_parametros.id_evento 
                               and re.tipo_registro = 'resumen'
                               and re.estado_reg = 'activo') THEN
                        
                        raise exception 'Ya existe un registro del tipo resumen para esta casa de oracion';       
               END IF;
           end if;
        
            
            --Sentencia de la insercion
        	insert into ccb.tregion_evento(
              estado_reg,
              id_gestion,
              fecha_programada,
              id_evento,
              estado,
              id_region,
              fecha_reg,
              id_usuario_reg,
              fecha_mod,
              id_usuario_mod,
              id_casa_oracion,
              tipo_registro,
              hora,
              id_obrero,
              obs,
              obs2
          	) values(
              'activo',
              v_parametros.id_gestion,
              v_parametros.fecha_programada,
              v_parametros.id_evento,
              v_parametros.estado,
              v_parametros.id_region,
              now(),
              p_id_usuario,
              now(),
              p_id_usuario,
              v_parametros.id_casa_oracion,
              v_parametros.tipo_registro,
              v_parametros.hora ,
              v_parametros.id_obrero,
              v_parametros.obs,
              v_parametros.obs2  
							
			)RETURNING id_region_evento into v_id_region_evento;
            
            --recuperar el tip de evento
            
            select e.nombre, e.codigo
            into
             v_registros_evento
            from  ccb.tevento e
            where e.id_evento = v_parametros.id_evento;
            
            --insertar detalle de evento en numero cero segun el tipo ...
            
           
            IF v_registros_evento.codigo in ('bautizo','santacena') THEN
               va_tipo = '{"hermana","hermano"}'; 
            ELSIF v_registros_evento.codigo in ('reuniondejuventud','santacena')  THEN
              va_tipo = '{"anciano","diacono","cooperador","cooperadordejovenes","violinista","organista","tronpetista","clarinetista"}';
            END IF;
            
           
            
            FOR v_registros  in (select
                                   tm.id_tipo_ministerio,
                                   0 as defecto
                                 from ccb.ttipo_ministerio tm 
                                 where tm.codigo =ANY(va_tipo))  LOOP
                                 
                      INSERT INTO 
                          ccb.tdetalle_evento
                        (
                          id_usuario_reg,
                          fecha_reg,
                          estado_reg,
                          id_region_evento,
                          id_tipo_ministerio,
                          cantidad
                        )
                        VALUES (
                          p_id_usuario,
                          now(),
                          'activo',
                          v_id_region_evento,
                          v_registros.id_tipo_ministerio,
                          0
                        );           
            
            END LOOP;
                
            
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','insercion de registros exitosa'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_id_region_evento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGE_MOD')then

		begin
        
              select 
                ep.estado_periodo
              into
                v_estado_periodo
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
        
			--Sentencia de la modificacion
			update ccb.tregion_evento set
			id_gestion = v_parametros.id_gestion,
			fecha_programada = v_parametros.fecha_programada,
			id_evento = v_parametros.id_evento,
			estado = v_parametros.estado,
			id_region = v_parametros.id_region,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
            id_casa_oracion =  v_parametros.id_casa_oracion,
            tipo_registro = v_parametros.tipo_registro,
            hora = v_parametros.hora,
            id_obrero =  v_parametros.id_obrero,
            obs = v_parametros.obs,
            obs2 = v_parametros.obs2 
			where id_region_evento=v_parametros.id_region_evento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

        
    /*********************************    
 	#TRANSACCION:  'CCB_REGE_ELI'
 	#DESCRIPCION:	Eliminacion de eventoscon su detalle
 	#AUTOR:		admin	
 	#FECHA:		13-01-2015 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_REGE_ELI')then

		begin
			--Sentencia que elimina el detalle
            delete from ccb.tdetalle_evento
            where id_region_evento=v_parametros.id_region_evento;
            
            
			delete from ccb.tregion_evento
            where id_region_evento=v_parametros.id_region_evento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;    
     
       
    
    /*********************************    
 	#TRANSACCION:  'CCB_GENRESU_INS'
 	#DESCRIPCION:	genera resumen
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_GENRESU_INS')then

		begin
			
            --obtiene configuracion basica
            select
              re.id_gestion,
              re.id_casa_oracion,
              re.id_evento
            into
             v_registros
            from ccb.tregion_evento re
            where re.id_region_evento = v_parametros.id_region_evento;
			
            
            --validar que la gestion noeste cerrada
            
           --seleciona los datos del tipo detalle evento
           
           FOR v_resgistros_detalle in (
                                     select
                                       sum(de.cantidad) as cantidad,
                                       de.id_tipo_ministerio
                                     
                                     from ccb.tregion_evento re
                                     inner join ccb.tdetalle_evento de on de.id_region_evento = re.id_region_evento
                                     where re.id_gestion = v_registros.id_gestion 
                                           and re.id_casa_oracion = v_registros.id_casa_oracion
                                           and re.id_evento = v_registros.id_evento
                                           and re.tipo_registro = 'detalle'
                                           and re.estado_reg = 'activo'
                                     group by 
                                       de.id_tipo_ministerio) LOOP
    		
                 v_id_detalle_evento = NULL;
                 
                 select 
                  de.id_detalle_evento
                 into
                  v_id_detalle_evento 
                 from  ccb.tdetalle_evento de 
                 where de.id_region_evento = v_parametros.id_region_evento 
                       and de.id_tipo_ministerio = v_resgistros_detalle.id_tipo_ministerio
                       and de.estado_reg = 'activo';
           
                -- si el registros exis lo modifica
                IF  v_id_detalle_evento is not NULL THEN
                
                      UPDATE 
                        ccb.tdetalle_evento 
                      SET 
                        id_usuario_mod = p_id_usuario,
                        fecha_mod = now(),
                        cantidad = v_resgistros_detalle.cantidad
                      WHERE 
                        id_detalle_evento = v_id_detalle_evento;
                
                ELSE
             
                -- si no existe lo inserta
             			INSERT INTO 
                        ccb.tdetalle_evento
                      (
                        id_usuario_reg,
                        fecha_reg,
                        estado_reg,
                        id_region_evento,
                        id_tipo_ministerio,
                        cantidad,
                        obs
                      )
                      VALUES (
                        p_id_usuario,
                        now(),
                        'activo',
                        v_parametros.id_region_evento,
                        v_resgistros_detalle.id_tipo_ministerio,
                        v_resgistros_detalle.cantidad,
                        'insertado al generar resumen'
                      );
                END IF;
           
           END LOOP;
            
            
            
            
            
            
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Resumen de eventos registrado exitosamente'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
        
   /*********************************    
 	#TRANSACCION:  'CCB_RNSC_INS'
 	#DESCRIPCION:	Insercion de registros de santa cena y bautizo
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:31:26
	***********************************/

	elseif(p_transaccion='CCB_RNSC_INS')then
					
        begin
        	  
        -- a partir de la fecha conseguimos la gestion
          
           
              select 
                ep.estado_periodo,
                ep.id_gestion
              into
                v_estado_periodo,
                v_id_gestion
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
              
              IF  v_id_gestion is null THEN              
                raise exception 'La casa de oración no tienen una gestión abierta';
              END IF;
           
      --  raise exception '...%',v_id_gestion;
            --desde la casa de oracion conseguimos la region
           select 
            co.id_region
            into
            v_id_region
           from ccb.tcasa_oracion co 
           where co.id_casa_oracion =  v_parametros.id_casa_oracion;
            
            --Sentencia de la insercion
        	insert into ccb.tregion_evento(
              estado_reg,
              id_gestion,
              fecha_programada,
              id_evento,
              estado,
              id_region,
              fecha_reg,
              id_usuario_reg,
              fecha_mod,
              id_usuario_mod,
              id_casa_oracion,
              tipo_registro,
              hora,
              id_obrero
          	) values(
              'activo',
              v_id_gestion,
              v_parametros.fecha_programada,
              v_parametros.id_evento,
              v_parametros.estado,
              v_id_region,
              now(),
              p_id_usuario,
              now(),
              p_id_usuario,
              v_parametros.id_casa_oracion,
             'detalle' ,
             v_parametros.hora,
             v_parametros.id_obrero  
							
			)RETURNING id_region_evento into v_id_region_evento;
            
            
           
            va_tipo = '{"hermana","hermano"}'; 
            
            
           
            
            FOR v_registros  in (select
                                   tm.id_tipo_ministerio,
                                   tm.codigo
                                 from ccb.ttipo_ministerio tm 
                                 where tm.codigo =ANY(va_tipo))  LOOP
                                 
                      IF v_registros.codigo = 'hermano' THEN
                        v_cantidad  =  v_parametros.cantidad_hermano;
                      ELSE
                       v_cantidad  =  v_parametros.cantidad_hermana;
                      END IF;
                      
                      INSERT INTO 
                          ccb.tdetalle_evento
                        (
                          id_usuario_reg,
                          fecha_reg,
                          estado_reg,
                          id_region_evento,
                          id_tipo_ministerio,
                          cantidad
                        )
                        VALUES (
                          p_id_usuario,
                          now(),
                          'activo',
                          v_id_region_evento,
                          v_registros.id_tipo_ministerio,
                          COALESCE(v_cantidad,0)
                        );           
            
            END LOOP;
                
            
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','insercion de registros exitosa'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_id_region_evento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
    
    /*********************************    
 	#TRANSACCION:  'CCB_RNSC_MOD'
 	#DESCRIPCION:	Modificacion de registros de santa cenas y bautizos
 	#AUTOR:		admin	
 	#FECHA:		14-03-2015 14:31:26
	***********************************/

	elsif(p_transaccion='CCB_RNSC_MOD')then

		begin
        
              select 
                ep.estado_periodo,
                ep.id_gestion
              into
                v_estado_periodo,
                v_id_gestion
              from ccb.testado_periodo ep 
              where ep.id_casa_oracion = v_parametros.id_casa_oracion
                   and  v_parametros.fecha_programada::date BETWEEN  ep.fecha_ini::date and ep.fecha_fin::dATE;  
              
              IF v_estado_periodo is null THEN              
                 raise exception 'Verifique si la casa de oración tiene periodos activos (comuniquese con un administradorde sistema)';   
              END IF;
              
              IF v_estado_periodo = 'cerrado' THEN
                  raise exception 'el periodo correspondiente se encuentra cerrado';
              END IF;
              
            --desde la casa de oracion conseguimos la region
           select 
            co.id_region
            into
            v_id_region
           from ccb.tcasa_oracion co 
           where co.id_casa_oracion =  v_parametros.id_casa_oracion;
              
               
            
              
              
			--Sentencia de la modificacion
			update ccb.tregion_evento set
              id_gestion = v_id_gestion,
              fecha_programada = v_parametros.fecha_programada,
              id_evento = v_parametros.id_evento,
              estado = v_parametros.estado,
              id_region = v_id_region,
              fecha_mod = now(),
              id_usuario_mod = p_id_usuario,
              id_casa_oracion =  v_parametros.id_casa_oracion,
              hora = v_parametros.hora,
              id_obrero =  v_parametros.id_obrero
			where id_region_evento=v_parametros.id_region_evento;
            
            
            --Sentencia de la modificacion
			update ccb.tdetalle_evento set
			cantidad = v_parametros.cantidad_hermano,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_detalle_evento=v_parametros.id_detalle_evento_hermano;
            
            
            --Sentencia de la modificacion
			update ccb.tdetalle_evento set
			cantidad = v_parametros.cantidad_hermana,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_detalle_evento=v_parametros.id_detalle_evento_hermana;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Eventos por Región modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region_evento',v_parametros.id_region_evento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

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