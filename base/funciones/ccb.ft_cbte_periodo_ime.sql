--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.ft_cbte_periodo_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		ADMCCB
 FUNCION: 		ccb.ft_cbte_periodo_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ccb.tcbte_periodo'
 AUTOR: 		 (admin)
 FECHA:	        28-02-2016 13:24:52
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    		integer;
	v_parametros           		record;
	v_id_requerimiento     		integer;
	v_resp		           	 	varchar;
	v_nombre_funcion        	text;
	v_mensaje_error         	text;
	v_id_cbte_periodo			integer;
    v_reg_estado				record;
    v_reg_tipo_cbte				record;
    v_id_int_comprobante    	integer;
			    
BEGIN

    v_nombre_funcion = 'ccb.ft_cbte_periodo_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CCB_CBP_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:52
	***********************************/

	if(p_transaccion='CCB_CBP_INS')then
					
        begin
        	
            
            
            select  
              *
            into 
              v_reg_estado
            from  ccb.testado_periodo ep
            where ep.id_estado_periodo = v_parametros.id_estado_periodo;
            
            IF v_reg_estado.estado_periodo != 'cerrado' THEN
              raise exception 'Solo peude generar cbte para periodos cerrados';
            END IF;
            
            --revisar que no se dupique el cbte
            
            IF  exists( select 1 
                        from ccb.tcbte_periodo cp 
                        where cp.id_tipo_cbte = v_parametros.id_tipo_cbte 
                            and cp.estado_reg = 'activo' 
                            and cp.id_estado_periodo = v_parametros.id_estado_periodo ) THEN            
               raise exception 'el comprobante a se encuentra registrado';            
            END IF;
            
            
            
            select  *  into v_reg_tipo_cbte
            from ccb.ttipo_cbte tc 
            where tc.id_tipo_cbte = v_parametros.id_tipo_cbte;
            
            
            --Sentencia de la insercion
        	insert into ccb.tcbte_periodo(
              id_estado_periodo,
              estado_reg,
              id_tipo_cbte,
              id_usuario_reg,
              usuario_ai,
              fecha_reg,
              id_usuario_ai,
              fecha_mod,
              id_usuario_mod
          	) values(
              v_parametros.id_estado_periodo,
              'activo',
              v_parametros.id_tipo_cbte,
              p_id_usuario,
              v_parametros._nombre_usuario_ai,
              now(),
              v_parametros._id_usuario_ai,
              null,
              null						
			)RETURNING id_cbte_periodo into v_id_cbte_periodo;
            
            --llamar al generador de comprobantes
            
            v_id_int_comprobante = conta.f_gen_comprobante ( 
                                                     v_parametros.id_estado_periodo::integer, 
                                                     v_reg_tipo_cbte.codigo ,
                                                     NULL, -- estado wf                                                     
                                                     p_id_usuario,
                                                     v_parametros._id_usuario_ai, 
                                                     v_parametros._nombre_usuario_ai, 
                                                     NULL);
                                                     
                                                       
                                                     
            update ccb.tcbte_periodo set
               id_int_comprobante = v_id_int_comprobante
            where  id_cbte_periodo  = v_id_cbte_periodo;                                      
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','CBTE almacenado(a) con exito (id_cbte_periodo'||v_id_cbte_periodo||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cbte_periodo',v_id_cbte_periodo::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CBP_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:52
	***********************************/

	elsif(p_transaccion='CCB_CBP_MOD')then

		begin
			--Sentencia de la modificacion
			update ccb.tcbte_periodo set
                id_estado_periodo = v_parametros.id_estado_periodo,
                id_tipo_cbte = v_parametros.id_tipo_cbte,
                id_int_comprobante = v_parametros.id_int_comprobante,
                fecha_mod = now(),
                id_usuario_mod = p_id_usuario,
                id_usuario_ai = v_parametros._id_usuario_ai,
                usuario_ai = v_parametros._nombre_usuario_ai
			where id_cbte_periodo=v_parametros.id_cbte_periodo;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','CBTE modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cbte_periodo',v_parametros.id_cbte_periodo::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'CCB_CBP_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		28-02-2016 13:24:52
	***********************************/

	elsif(p_transaccion='CCB_CBP_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ccb.tcbte_periodo
            where id_cbte_periodo=v_parametros.id_cbte_periodo;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','CBTE eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cbte_periodo',v_parametros.id_cbte_periodo::varchar);
              
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