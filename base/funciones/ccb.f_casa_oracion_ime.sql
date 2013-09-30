--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_casa_oracion_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_casa_oracion_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tcasa_oracion'
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

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_casa_oracion	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_casa_oracion_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_CAOR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:52:02
	***********************************/

	if(p_transaccion='CCB_CAOR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tcasa_oracion(
			estado_reg,
			fecha_cierre,
			codigo,
			id_region,
			id_lugar,
			direccion,
			nombre,
			fecha_apertura,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.fecha_cierre,
			v_parametros.codigo,
			v_parametros.id_region,
			v_parametros.id_lugar,
			v_parametros.direccion,
			v_parametros.nombre,
			v_parametros.fecha_apertura,
			now(),
			p_id_usuario,
			null,
			null
							
			)RETURNING id_casa_oracion into v_id_casa_oracion;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Casas de Oracioón almacenado(a) con exito (id_casa_oracion'||v_id_casa_oracion||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_oracion',v_id_casa_oracion::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CAOR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:52:02
	***********************************/

	elsif(p_transaccion='CCB_CAOR_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tcasa_oracion set
			fecha_cierre = v_parametros.fecha_cierre,
			codigo = v_parametros.codigo,
			id_region = v_parametros.id_region,
			id_lugar = v_parametros.id_lugar,
			direccion = v_parametros.direccion,
			nombre = v_parametros.nombre,
			fecha_apertura = v_parametros.fecha_apertura,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_casa_oracion=v_parametros.id_casa_oracion;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Casas de Oracioón modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_oracion',v_parametros.id_casa_oracion::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CAOR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:52:02
	***********************************/

	elsif(p_transaccion='CCB_CAOR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tcasa_oracion
            where id_casa_oracion=v_parametros.id_casa_oracion;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Casas de Oracioón eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_casa_oracion',v_parametros.id_casa_oracion::varchar);
              
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