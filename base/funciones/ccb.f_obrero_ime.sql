--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_obrero_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_obrero_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tobrero'
 AUTOR: 		 (admin)
 FECHA:	        13-01-2013 12:24:54
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
	v_id_obrero	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_obrero_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_OBR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:24:54
	***********************************/

	if(p_transaccion='CCB_OBR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tobrero(
                estado_reg,
                id_region,
                fecha_fin,
                fecha_ini,
                obs,
                id_tipo_ministerio,
                id_persona,
                fecha_reg,
                id_usuario_reg,
                fecha_mod,
                id_usuario_mod,
                id_casa_oracion
          	) values(
                'activo',
                v_parametros.id_region,
                v_parametros.fecha_fin,
                v_parametros.fecha_ini,
                v_parametros.obs,
                v_parametros.id_tipo_ministerio,
                v_parametros.id_persona,
                now(),
                p_id_usuario,
                now(),
                p_id_usuario,
                v_parametros.id_casa_oracion
							
			)RETURNING id_obrero into v_id_obrero;
            
            
             --moficiamoslos dato de la persona
            UPDATE segu.tpersona 
                SET 
                  id_usuario_mod = p_id_usuario,                 
                  fecha_mod = now(),
                  correo = v_parametros.correo,
                  celular1 = v_parametros.celular1,
                  telefono1 = v_parametros.telefono1
                WHERE 
                  id_persona = v_parametros.id_persona;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Obrero almacenado(a) con exito (id_obrero'||v_id_obrero||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_obrero',v_id_obrero::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_OBR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:24:54
	***********************************/

	elsif(p_transaccion='CCB_OBR_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tobrero set
                id_region = v_parametros.id_region,
                fecha_fin = v_parametros.fecha_fin,
                fecha_ini = v_parametros.fecha_ini,
                obs = v_parametros.obs,
                id_tipo_ministerio = v_parametros.id_tipo_ministerio,
                id_persona = v_parametros.id_persona,
                fecha_mod = now(),
                id_usuario_mod = p_id_usuario,
                id_casa_oracion = v_parametros.id_casa_oracion
			where id_obrero=v_parametros.id_obrero;
            
            
            --moficiamoslos dato de la persona
            UPDATE segu.tpersona 
                SET 
                  id_usuario_mod = p_id_usuario,                 
                  fecha_mod = now(),
                  correo = v_parametros.correo,
                  celular1 = v_parametros.celular1,
                  telefono1 = v_parametros.telefono1
                WHERE 
                  id_persona = v_parametros.id_persona;
            
                     
            
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Obrero modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_obrero',v_parametros.id_obrero::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
    /*********************************    
 	#TRANSACCION:  'CCB_UPDMOB_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:24:54
	***********************************/

	elsif(p_transaccion='CCB_UPDMOB_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tobrero set			
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_obrero=v_parametros.id_obrero;
            
            
            --moficiamoslos dato de la persona
            UPDATE segu.tpersona 
                SET 
                  id_usuario_mod = p_id_usuario,                 
                  fecha_mod = now(),
                  correo = v_parametros.correo,
                  celular1 = v_parametros.celular1,
                  telefono1 = v_parametros.telefono1
                WHERE 
                  id_persona = v_parametros.id_persona;
            
            
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Obrero modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_obrero',v_parametros.id_obrero::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;
	/*********************************    
 	#TRANSACCION:  'CCB_OBR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 12:24:54
	***********************************/

	elsif(p_transaccion='CCB_OBR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tobrero
            where id_obrero=v_parametros.id_obrero;
            
            -- TODO inactivar obreros eliminados ...
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Obrero eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_obrero',v_parametros.id_obrero::varchar);
              
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