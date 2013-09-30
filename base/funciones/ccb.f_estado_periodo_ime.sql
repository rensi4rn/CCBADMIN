--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_estado_periodo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_estado_periodo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.testado_periodo'
 AUTOR: 		 (admin)
 FECHA:	        24-02-2013 14:35:36
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
	v_id_estado_periodo	integer;
    
    v_fecha_ini date;
    v_fecha_fin date;
    
    
    v_cont integer;
    v_mes varchar;
    v_gestion integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_estado_periodo_ime';
    v_parametros = pxp.f_get_record(p_tabla);
    
    
    
    
/*********************************    
 	#TRANSACCION:  'CCB_GENGES_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	if(p_transaccion='CCB_GENGES_INS')then
					
        begin
        
           --preguntamos is ya existes registros para esta gestion
           
           
           IF exists (select 1 
                      from ccb.testado_periodo e 
                      where e.id_gestion = v_parametros.id_gestion 
                      and e.id_casa_oracion= v_parametros.id_casa_oracion and e.estado_reg = 'activo') THEN
                      
             raise exception 'Esta gestion ya fue abierta';
                  
               
           END IF;
        
           
        
           --inserta en la tabla periodo
            
            v_cont =1;
            
            
            select g.gestion into v_gestion from ccb.tgestion g where g.id_gestion = v_parametros.id_gestion; 
            
            
            WHILE v_cont <= 12 LOOP
            
             -- obtiene primer del mes correspondiente a la fecha_ini
                        
             v_fecha_ini= ('01-'||v_cont||'-'||v_gestion)::date;
             -- obtiene el ultimo dia del mes correspondiente a la fecha_fin
           
             v_fecha_fin=(date_trunc('MONTH', v_fecha_ini) + INTERVAL '1 MONTH - 1 day')::date;
             
             
             IF(v_cont =1 ) THEN
              v_mes = 'Enero';
             END IF;
             
             IF(v_cont =2 ) THEN
              v_mes = 'Febrero';
             END IF;
             
             IF(v_cont =3 ) THEN
              v_mes = 'Marzo';
             END IF;
             
             IF(v_cont =4 ) THEN
              v_mes = 'Abril';
             END IF;
             
             IF(v_cont =5 ) THEN
              v_mes = 'Mayo';
             END IF;
             
             IF(v_cont =6 ) THEN
              v_mes = 'Junio';
             END IF;
             
             IF(v_cont =7 ) THEN
              v_mes = 'Julio';
             END IF;
             
             IF(v_cont =8 ) THEN
              v_mes = 'Agosto';
             END IF;
             
             IF(v_cont =9 ) THEN
              v_mes = 'Septiembre';
             END IF;
             
             IF(v_cont =10 ) THEN
              v_mes = 'Octubre';
             END IF;
             
             IF(v_cont =11 ) THEN
              v_mes = 'Noviembre';
             END IF;
             
             IF(v_cont =12 ) THEN
              v_mes = 'Diciembre';
             END IF;
             
            
             INSERT INTO ccb.testado_periodo(
                estado_reg,
                estado_periodo,
                id_casa_oracion,
                num_mes,
                id_gestion,
                fecha_fin,
                mes,
                fecha_ini,
                fecha_reg,
                id_usuario_reg,
                fecha_mod,
                id_usuario_mod
                ) values(
                'activo',
                'abierto',
                v_parametros.id_casa_oracion,
                v_cont,
                v_parametros.id_gestion,
                v_fecha_fin,
                v_mes,
                v_fecha_ini,
                now(),
                p_id_usuario,
                null,
                null
    							
                )RETURNING id_estado_periodo into v_id_estado_periodo;
                
               v_cont=v_cont+1;
            
            END LOOP;
        
        
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Se abrio la gestion ='|| v_parametros.id_gestion ||' para la casar de oracion ='|| v_parametros.id_casa_oracion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_id_estado_periodo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
	/*********************************    
 	#TRANSACCION:  'CCB_PER_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elseif(p_transaccion='CCB_PER_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.testado_periodo(
			estado_reg,
			estado_periodo,
			id_casa_oracion,
			num_mes,
			id_gestion,
			fecha_fin,
			mes,
			fecha_ini,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.estado_periodo,
			v_parametros.id_casa_oracion,
			v_parametros.num_mes,
			v_parametros.id_gestion,
			v_parametros.fecha_fin,
			v_parametros.mes,
			v_parametros.fecha_ini,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_estado_periodo into v_id_estado_periodo;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo almacenado(a) con exito (id_estado_periodo'||v_id_estado_periodo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_id_estado_periodo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_PER_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elsif(p_transaccion='CCB_PER_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.testado_periodo set
			estado_periodo = v_parametros.estado_periodo,
			id_casa_oracion = v_parametros.id_casa_oracion,
			num_mes = v_parametros.num_mes,
			id_gestion = v_parametros.id_gestion,
			fecha_fin = v_parametros.fecha_fin,
			mes = v_parametros.mes,
			fecha_ini = v_parametros.fecha_ini,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_estado_periodo=v_parametros.id_estado_periodo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_parametros.id_estado_periodo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_PER_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		24-02-2013 14:35:36
	***********************************/

	elsif(p_transaccion='CCB_PER_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.testado_periodo
            where id_estado_periodo=v_parametros.id_estado_periodo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Periodo eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_estado_periodo',v_parametros.id_estado_periodo::varchar);
              
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