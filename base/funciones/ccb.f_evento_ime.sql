--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_evento_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.f_evento_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tevento'
 AUTOR: 		 (admin)
 FECHA:	        05-01-2013 08:03:46
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
	v_id_evento	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.f_evento_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_EVEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:03:46
	***********************************/

	if(p_transaccion='CCB_EVEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ccb.tevento(
			estado_reg,
			nombre,
			descripcion,
			fecha_reg,
			id_usuario_reg,
			fecha_mod,
			id_usuario_mod,
            codigo
          	) values(
			'activo',
			v_parametros.nombre,
			v_parametros.descripcion,
			now(),
			p_id_usuario,
			null,
			null,
            lower(v_parametros.codigo)
							
			)RETURNING id_evento into v_id_evento;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Eventos almacenado(a) con exito (id_evento'||v_id_evento||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_evento',v_id_evento::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_EVEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:03:46
	***********************************/

	elsif(p_transaccion='CCB_EVEN_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tevento set
			nombre = v_parametros.nombre,
			descripcion = v_parametros.descripcion,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
            codigo = lower(v_parametros.codigo)
			where id_evento=v_parametros.id_evento;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Eventos modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_evento',v_parametros.id_evento::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_EVEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-01-2013 08:03:46
	***********************************/

	elsif(p_transaccion='CCB_EVEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tevento
            where id_evento=v_parametros.id_evento;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipo de Eventos eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_evento',v_parametros.id_evento::varchar);
              
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