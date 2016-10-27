--------------- SQL ---------------

CREATE OR REPLACE FUNCTION ccb.f_inserta_lcv (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_id_movimiento integer
)
RETURNS varchar AS
$body$
/*
*
*  Autor:   JRR
*  DESC:    funcion que inserta lcv en el sistema de contabilidad
*  Fecha:   17/10/2014
*
*/

DECLARE

	v_nombre_funcion   	 text;
    v_resp    			 varchar;
    v_mensaje 			 varchar;
    v_id_tipo_estado		 integer;
    v_venta 			 record;
    v_id_funcionario_inicio	 integer;
    v_id_estado_actual		 integer;
    
    v_parametros           	record;
    v_id_tipo_compra_venta	integer;
    v_tabla			varchar;
    v_codigo_tipo_compra_venta	varchar;
    v_descuento			numeric;
    v_descuento_porc	numeric;
    v_iva				numeric;
    v_it				numeric;
    v_ice				numeric;
    v_id_depto_conta	integer;
    v_id_doc_compra_venta	INTEGER;
    v_codigo_trans			varchar;
    v_desc_doc				varchar;
    v_id_moneda_base		INTEGER;
    v_reg_mov_egreso        record;
    v_id_plantilla			integer;
    
BEGIN

	 v_nombre_funcion = 'ccb.f_inserta_lcv';
	 v_parametros = pxp.f_get_record(p_tabla);
	 v_resp	= 'exito';
     v_id_moneda_base = param.f_get_moneda_base();
     
     --datos del mov
     select
        mov.tipo_documento, --  facuta, recibo, etc,
        mov.num_documento,
        mov.nit,
        mov.nro_autorizacion,
        mov.razon_social,
        mov.codigo_control,
        md.monto_doc,
        md.monto,
        md.monto_retencion,
        mov.fecha,
        mov.obs,
        mov.id_casa_oracion,
        mov.id_estado_periodo,
        reg.id_depto_contable,
        reg.nombre as region_nombre
      into
       v_reg_mov_egreso
     from ccb.tmovimiento mov
     inner join ccb.tcasa_oracion co on co.id_casa_oracion = mov.id_casa_oracion
     inner join ccb.tregion reg on reg.id_region = co.id_region
     inner join ccb.tmovimiento_det md on md.id_movimiento = mov.id_movimiento
     inner join ccb.testado_periodo ep on ep.id_estado_periodo = mov.id_estado_periodo
     where mov.id_movimiento = p_id_movimiento;
     
     --identificar plantila
     if v_reg_mov_egreso.tipo_documento = 'factura'  then
            v_desc_doc = 'FACTURA';     
     elseif  v_reg_mov_egreso.tipo_documento = 'recibo_bien'  then
          v_desc_doc = 'RECIBO CON RETENCIONES BIENES'; 
     elseif  v_reg_mov_egreso.tipo_documento = 'recibo_servicio'  then
          v_desc_doc = 'RECIBO CON RETENCIONES SERVICIOS'; 
     elseif  v_reg_mov_egreso.tipo_documento = 'recibo_alquiler'  then
          v_desc_doc = 'RECIBO CON RETENCIONES DE ALQUILER'; 
     elseif  v_reg_mov_egreso.tipo_documento = 'recibo_sin_retencion'  then
          v_desc_doc = 'RECIBO SIN RETENCION';
     else
          raise exception 'Documento no reconocido:  %',v_reg_mov_egreso.tipo_documento;      
     end if;
     
     select 
         p.id_plantilla
     into
        v_id_plantilla
     from param.tplantilla p
     where p.desc_plantilla = v_desc_doc;
     
     if (v_id_plantilla is  null) then
         raise exception 'no fue encontrada un aplantilla para %',v_desc_doc;
     end if;
     
     
     v_id_depto_conta = v_reg_mov_egreso.id_depto_contable;
     
     IF v_id_depto_conta is null THEN
         raise exception 'La región %, no tiene un depto contable configurado',v_reg_mov_egreso.region_nombre;
     END IF;
     
     
     --verificar si existe el documento
     select 
       dcv.id_doc_compra_venta 
     into 
       v_id_doc_compra_venta
     from conta.tdoc_compra_venta dcv
     where     dcv.tabla_origen = 'ccb.tmovimiento' 
           and dcv.id_origen = p_id_movimiento and
     	       dcv.estado_reg = 'activo';
        
       
		
     --el documento entra validado
        
     v_codigo_tipo_compra_venta = '1'; --mercado interno con destino a actividades gravadas
       
    --si no existe el documento se inserta
     if (v_id_doc_compra_venta is null) then
        	
        	v_codigo_trans = 'CONTA_DCV_INS';
        --si existe se modifica
      else        
        	v_codigo_trans = 'CONTA_DCV_MOD';
     end if;
        
	    
	 
	select 
       tcv.id_tipo_doc_compra_venta 
    into 
       v_id_tipo_compra_venta
	from conta.ttipo_doc_compra_venta tcv
	where tcv.codigo = v_codigo_tipo_compra_venta and tcv.estado_reg = 'activo';
    
    
	--solo si tiene plantilla se inserta en el libro de ventas
    if (v_id_plantilla is not null) then
    
        if (v_id_tipo_compra_venta is null) then
            raise exception 'No se encontro el tipo compra venta para insertar al LCV';
        else
        	--obtener descuento porcentaje
        	select  
               ps_descuento_porc,
               ps_descuento
             into
              v_descuento_porc,
              v_descuento
             FROM  conta.f_get_descuento_plantilla_calculo(v_id_plantilla);
            
            --obtener iva
             select  
               ps_monto_porc
             into
              v_iva
             FROM  conta.f_get_detalle_plantilla_calculo(v_id_plantilla, 'IVA');
             
           
            --recupera IT           
            select  
               ps_monto_porc
             into
              v_it
             FROM  conta.f_get_detalle_plantilla_calculo(v_id_plantilla, 'IT');
            
            --recupera ICE            
            select  
               ps_monto_porc
             into
              v_ice
             FROM  conta.f_get_detalle_plantilla_calculo(v_id_plantilla, 'ICE');
          
            --crear tabla 
            v_tabla = pxp.f_crear_parametro(ARRAY[	'_nombre_usuario_ai',
                                '_id_usuario_ai',
                                'revisado',
                                'movil',
                                'tipo',
                                'importe_excento',
                                'id_plantilla',
                                'fecha',
                                'nro_documento',
                                'nit',
                                'importe_ice',
                                'nro_autorizacion',
                                'importe_iva',
                                'importe_descuento',
                                'importe_doc',
                                'sw_contabilizar',
                                'tabla_origen',
                                'estado',
                                'id_depto_conta',
                                'id_origen',
                                'obs',
                                'estado_reg',
                                'codigo_control',
                                'importe_it',
                                'razon_social',
                                'importe_descuento_ley',
                                'importe_pago_liquido',
                                'nro_dui',
                                'id_moneda',							
                                'importe_pendiente',
                                'importe_anticipo',
                                'importe_retgar',
                                'importe_neto',
                                'id_auxiliar',
                                'id_doc_compra_venta',
                                'id_tipo_compra_venta'],
            				ARRAY[	coalesce(v_parametros._nombre_usuario_ai,''),
                                coalesce(v_parametros._id_usuario_ai::varchar,''),
                                'si',--'revisado',
                                'no',--'movil',
                                'compra',--'tipo',
                                '0',--'importe_excento',
                                v_id_plantilla::varchar,--'id_plantilla',
                                to_char(v_reg_mov_egreso.fecha,'DD/MM/YYYY'),--'fecha',
                                v_reg_mov_egreso.num_documento::varchar,--'nro_documento',
                                coalesce(v_reg_mov_egreso.nit,''),--'nit',
                                '0',--'importe_ice',
                                coalesce(v_reg_mov_egreso.nro_autorizacion,''), --'nro_autorizacion',
                                (v_reg_mov_egreso.monto_doc * coalesce(v_iva,0))::varchar,--'importe_iva',
                                '0',--'importe_descuento',
                                (v_reg_mov_egreso.monto_doc )::varchar,--'importe_doc',
                                'no',--'sw_contabilizar',
                                'ccb.tmovimiento',--'tabla_origen',
                                'validado',--'estado',
                                v_id_depto_conta::varchar,--'id_depto_conta',
                                p_id_movimiento::varchar,--'id_origen',
                                coalesce(v_reg_mov_egreso.obs,''),--'obs',
                                'activo',--'estado_reg',
                                coalesce(v_reg_mov_egreso.codigo_control,''),--'codigo_control',
                                (v_reg_mov_egreso.monto_doc *  coalesce(v_it,0))::varchar,--'importe_it',
                                coalesce(v_reg_mov_egreso.razon_social,''),--'razon_social',
                                (v_reg_mov_egreso.monto_doc *  coalesce(v_descuento_porc,0))::varchar,--'importe_descuento_ley',
                                coalesce((v_reg_mov_egreso.monto_doc - (v_reg_mov_egreso.monto_doc * coalesce(v_descuento_porc,0)))::varchar,''),--'importe_pago_liquido',
                                '0',--'nro_dui',
                                v_id_moneda_base::varchar,--'id_moneda',							
                                '0',--'importe_pendiente',
                                '0',--'importe_anticipo',
                                '0',--'importe_retgar',
                                (v_reg_mov_egreso.monto_doc - (v_reg_mov_egreso.monto_doc * coalesce(v_descuento_porc,0)))::varchar,--'importe_neto',--
                                '',--'id_auxiliar',
                                coalesce(v_id_doc_compra_venta::varchar,''),--id_doc_compra_venta
                                v_id_tipo_compra_venta::varchar
                                ],
                            ARRAY['varchar',
                                'integer',	
                            	'varchar',
                                'varchar',
                                'varchar',
                                'numeric',
                                'int4',
                                'date',
                                'varchar',
                                'varchar',
                                'numeric',
                                'varchar',
                                'numeric',
                                'numeric',
                                'numeric',
                                'varchar',
                                'varchar',
                                'varchar',
                                'int4',
                                'int4',
                                'varchar',
                                'varchar',
                                'varchar',
                                'numeric',
                                'varchar',
                                'numeric',
                                'numeric',
                                'varchar',
                                'int4',							
                                'numeric',
                                'numeric',
                                'numeric',
                                'numeric',
                                'integer',
                                'integer',
                                'integer']
                            );
            --inserta o modifica eldoc_compra_venta
            
            v_resp = conta.ft_doc_compra_venta_ime(p_administrador,p_id_usuario,v_tabla,v_codigo_trans);
    		
        end if;
    else
      raise exception 'No fue encontrada un aplantilla para el tipo de documento indicado';
    end if;
	
 
	RETURN   v_resp;

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