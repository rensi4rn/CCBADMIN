--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_region_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_region_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tregion'
 AUTOR: 		 (admin)
 FECHA:	        04-01-2013 18:05:10
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
	v_id_region	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_region_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_REGI_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		04-01-2013 18:05:10
	***********************************/

	if(p_transaccion='CCB_REGI_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tregion(
			estado_reg,
			nombre,
			obs,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
            id_depto_contable
          	) values(
			'activo',
			v_parametros.nombre,
			v_parametros.obs,
			now(),
			p_id_usuario,
			null,
			null,
            v_parametros.id_depto_contable
							
			)RETURNING id_region into v_id_region;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Regiones almacenado(a) con exito (id_region'||v_id_region||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region',v_id_region::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGI_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		04-01-2013 18:05:10
	***********************************/

	elsif(p_transaccion='CCB_REGI_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tregion set
			nombre = v_parametros.nombre,
			obs = v_parametros.obs,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
            id_depto_contable = v_parametros.id_depto_contable
			where id_region=v_parametros.id_region;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Regiones modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region',v_parametros.id_region::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_REGI_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		04-01-2013 18:05:10
	***********************************/

	elsif(p_transaccion='CCB_REGI_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tregion
            where id_region=v_parametros.id_region;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Regiones eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_region',v_parametros.id_region::varchar);
              
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