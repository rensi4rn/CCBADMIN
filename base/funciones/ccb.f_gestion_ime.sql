--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_gestion_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_gestion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tgestion'
 AUTOR: 		 (admin)
 FECHA:	        13-01-2013 14:01:12
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
	v_id_gestion	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_gestion_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_GES_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:01:12
	***********************************/

	if(p_transaccion='CCB_GES_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tgestion(
			estado_reg,
			gestion,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.gestion,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_gestion into v_id_gestion;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión almacenado(a) con exito (id_gestion'||v_id_gestion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_gestion',v_id_gestion::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_GES_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:01:12
	***********************************/

	elsif(p_transaccion='CCB_GES_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tgestion set
			gestion = v_parametros.gestion,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_gestion=v_parametros.id_gestion;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_gestion',v_parametros.id_gestion::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_GES_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		13-01-2013 14:01:12
	***********************************/

	elsif(p_transaccion='CCB_GES_ELI')then

		begin
			
            --Sentencia de la modificacion
			update ccb.tgestion set
			  estado_reg = 'inactivo'
			where id_gestion=v_parametros.id_gestion;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Gestión eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_gestion',v_parametros.id_gestion::varchar);
              
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
