<?php
/**
*@package pXP
*@file gen-Movimiento.php
*@author  (admin)
*@date 16-03-2013 00:22:36
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.MovimientoEgresoGeneral=Ext.extend(Phx.gridInterfaz,{
	

	constructor:function(config){
	    
		this.maestro=config.maestro;
		this.initButtons=[this.cmbTipo,this.cmbGestion];
    	//llama al constructor de la clase padre
		Phx.vista.MovimientoEgresoGeneral.superclass.constructor.call(this,config);
		
	
		this.init();
		
		this.cmbTipo.on('select',function(cm,dat,num){
		    if(dat.data.field1=='ingreso'){
		       this.getComponente('concepto').store.loadData(this.dataIngreso)
		    }
		    else{
		       this.getComponente('concepto').store.loadData(this.dataEgreso)
		    }
		    
		   if(this.validarFiltros()){
		          this.capturaFiltros();
		   }
		},this);
		
		
		
		this.cmbGestion.on('select',function(cm,dat,num){
		   
		   this.store.removeAll();
		   this.capturaFiltros();
		 
		},this);
		
		
	},
	
   
      
	validarFiltros:function(){
	    if(this.cmbGestion.isValid() && this.cmbTipo.isValid() ){
	        return true;
	    }
	    else{
	        return false;
	    }
	    
	},
	
	 capturaFiltros:function(combo, record, index){
	    this.store.baseParams.tipo=this.cmbTipo.getValue();
	    this.store.baseParams.id_gestion = this.cmbGestion.getValue();
        this.store.baseParams.tipo_concepto='egreso';
        this.store.load({params:{start:0, limit:this.tam_pag}}); 
            
        
    },
    onButtonAct:function(){
        if(!this.validarFiltros()){
            alert('Especifique los filtros antes')
         }
        else{
            this.store.baseParams.tipo=this.cmbTipo.getValue();
            this.store.baseParams.id_gestion=this.cmbGestion.getValue();
            Phx.vista.MovimientoEgresoGeneral.superclass.onButtonAct.call(this);
        }
    },
    
    
    
	cmbTipo: new Ext.form.ComboBox({
                    name: 'tipo',
                    fieldLabel: 'Tipo',
                    allowBlank: false,
                    emptyText:'Tipo...',
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender: true,
                    value:'ingreso',
                    mode: 'local',
                    width: 70,
                    store: ['ingreso','egreso'],
                    value: 'egreso',
                    disabled: true,
                }),
                
	
                
     cmbGestion:new Ext.form.ComboBox({
                fieldLabel: 'Gestion',
                allowBlank: false,
                forceSelection : true,
                emptyText:'Gestion...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/Gestion/listarGestion',
                    id: 'id_gestion',
                    root: 'datos',
                    sortInfo:{
                        field: 'gestion',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_gestion','gestion'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'gestion'}
                }),
                valueField: 'id_gestion',
                triggerAction: 'all',
                displayField: 'gestion',
                hiddenName: 'id_gestion',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:80
            }),
     
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_movimiento'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'tipo',
				inputType:'hidden',
				fieldLabel: 'tipo'
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'id_casa_oracion',
				inputType:'hidden',
				fieldLabel: 'id_casa_oracion'
			},
			type:'Field',
			form:true
		},
        {
            config:{
                name: 'id_estado_periodo',
                inputType:'hidden',
                fieldLabel: 'id_estado_periodo',
                allowBlank: false
            },
            type:'Field',
            form:true
        },
        
         {
			config:{
				name: 'desc_casa_oracion',
				fieldLabel: 'Casa',
				allowBlank: false,
				anchor: '80%',
				gwidth: 230,
				maxLength:500
			},
			type:'TextArea',
			filters:{pfiltro:'mov.desc_casa_oracion',type:'string'},
			bottom_filter: true,
			id_grupo:0,
			grid:true,
			form:false
		},
        
        
        
        
        {
			config:{
				name: 'fecha',
				fieldLabel: 'fecha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'mov.fecha',type:'date'},
			bottom_filter: true,
			id_grupo:0,
			grid:true,
			form:false
		},
        {
                config:{
                    name:'concepto',
                    fieldLabel:'Concepto',
                    allowBlank:false,
                    emptyText:'Tipo...',
                    forceSelection : true,
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    displayField:'valor',
                    valueField:'variable',
                    mode: 'local',
                    anchor: '80%',
                    gwidth: 130,
                    renderer:function (value, p, record){
                        var dato='';
                        dato = (dato==''&&value=='colecta_adultos')?'Colecta de Adultos':dato;
                        dato = (dato==''&&value=='contra_rendicion')?'Deposito':dato;
                        dato = (dato==''&&value=='colecta_jovenes')?'Colecta de Jovenes':dato;
                        dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                        dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                        dato = (dato==''&&value=='saldo_inicial')?'Saldo Inicial':dato;
                        dato = (dato==''&&value=='ingreso_trapaso')?'Ingreso por Trapaso':dato;
                        dato = (dato==''&&value=='operacion')?'Operacion':dato;
                        
                        
                        if(dato==''&&value=='egreso_traspaso'){
                        	dato='Egreso por Trapaso';
                        	console.log('sssss', record.data.id_movimiento_traspaso )
                        	if(!record.data.id_movimiento_traspaso){
                        		return String.format('<div title="No tiene traspaso de Ingreso"><font color=red><b>{0}</b></font></div>', dato);
                        	}
                        	else{
                        		return String.format('<div title="traspaso completo"><font color=green>{0}</b></font>', dato);
                        	}
                        	
                        }
                        
                        return String.format('{0}', dato);
                        
                        
                        
                        
                    },
            
                    store:new Ext.data.ArrayStore({
                            fields: ['variable', 'valor'],
                            data : []})
                },
                type:'ComboBox',
                bottom_filter: true,
                id_grupo:0,
                filters:{   
                         type: 'string',
                         pfiltro:'mov.concepto' 
                    },
                grid:true,
                form:false
        },{
            config:{
                name: 'id_tipo_movimiento',
                fieldLabel: 'Colecta de',
                allowBlank: false,
                forceSelection : true,
                emptyText:'Colecta de ...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/TipoMovimiento/listarTipoMovimiento',
                    id: 'id_tipo_movimiento',
                    root: 'datos',
                    sortInfo:{
                        field: 'codigo',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_tipo_movimiento','codigo','nombre'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'nombre'}
                }),
                valueField: 'id_tipo_movimiento',
                displayField: 'nombre',
                gdisplayField:'desc_tipo_movimiento',
                hiddenName: 'id_tipo_movimiento',
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                anchor: '80%',
                width:200,
                gwidth:120,
                minChars:2
            },
            type:'ComboBox',
            bottom_filter: true,
            filters:{pfiltro:'mov.desc_tipo_movimiento',type:'string'},
            id_grupo:0,
            grid:true,
            form:false
        },
		{
            config:{
                name: 'id_cuenta_bancaria',
                fieldLabel: 'Cuenta Bancaria Pago',
                allowBlank: false,
                emptyText:'Elija una Cuenta...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/CasaBanco/listarCuentaBancaria',
                    id: 'id_cuenta_bancaria',
                    root:'datos',
                    sortInfo:{
                        field:'id_cuenta_bancaria',
                        direction:'ASC'
                    },
                    totalProperty:'total',
                    fields: ['id_cuenta_bancaria','nro_cuenta','nombre_institucion','codigo_moneda','centro','denominacion'],
                    remoteSort: true,
                    baseParams : {
						par_filtro :'nro_cuenta'
					}
                }),
                tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{nro_cuenta}</b></p><p>Moneda: {codigo_moneda}, {nombre_institucion}</p><p>{denominacion}, Centro: {centro}</p></div></tpl>',
                valueField: 'id_cuenta_bancaria',
                hiddenValue: 'id_cuenta_bancaria',
                displayField: 'nro_cuenta',
                gdisplayField:'desc_cuenta_bancaria',
                listWidth:'280',
                forceSelection:true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:20,
                queryDelay:500,
                gwidth: 250,
                anchor: '80%',
                minChars:2,
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
             },
            type:'ComboBox',
            filters:{pfiltro:'cb.nro_cuenta',type:'string'},
            id_grupo:1,
            grid:true,
            form:false
        },
        
        
        
        {
            config:{
                name: 'id_obrero',
                fieldLabel: 'Obrero',
                forceSelection : true,
                qtip: 'Hermano responsable, (caso de egresos la persona que pago y recibio la factura o la que firma el recibo)',
                allowBlank: false,
                emptyText:'Obrero...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/Obrero/listarObrero',
                    id: 'id_obrero',
                    root: 'datos',
                    sortInfo:{
                        field: 'desc_persona',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_obrero','desc_persona','desc_tipo_ministerio',
							'desc_casa_oracion','id_casa_oracion','desc_region',
							'telefono1','telefono2','celular1','correo'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'per.nombre_completo1'}
                }),
                valueField: 'id_obrero',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{desc_persona}</p><p>{desc_tipo_ministerio}</p><p>{desc_casa_oracion}</p> </div></tpl>',
				
                displayField: 'desc_persona',
                gdisplayField:'desc_obrero',
                hiddenName: 'id_obrero',
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                anchor: '80%',
                width:210,
                gwidth:160,
                minChars:2
            },
            type:'ComboBox',
            bottom_filter: true,
            filters:{pfiltro:'mov.desc_obrero',type:'string'},
            id_grupo:0,
            grid:true,
            form:false
        },                    
        {
            config:{
                name: 'id_concepto_ingas',
                fieldLabel: 'Concepto Gasto',
                allowBlank: true,
                emptyText: 'Concepto Ingreso Gasto...',
                store: new Ext.data.JsonStore({
                         url: '../../sis_parametros/control/ConceptoIngas/listarConceptoIngas',
                         id: 'id_concepto_ingas',
                         root: 'datos',
                         sortInfo:{
                            field: 'desc_ingas',
                            direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_concepto_ingas','tipo','desc_ingas','movimiento','desc_partida','id_grupo_ots','filtro_ot','requiere_ot'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'desc_ingas',movimiento:'gasto'}
                    }),
                valueField: 'id_concepto_ingas',
                displayField: 'desc_ingas',
                gdisplayField:'desc_ingas',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{desc_ingas}</b></p><p>TIPO: {tipo}</p></div></tpl>',
                hiddenName: 'id_concepto_ingas',
                forceSelection:true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize: 20,
                queryDelay:1000,
                listWidth:600,
                resizable:true,
                anchor:'80%', 
                gwidth: 200,      
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_ingas']);}
            },
            type:'ComboBox',
            id_grupo:0,
            filters:{   
                        pfiltro:'desc_ingas',
                        type:'string'
                    },
            grid:true,
            form:false
        },
        {
			config:{
				name: 'obs',
				qtip: 'observaciones de la transacción , por EJM. que estamos  comprando ',
				fieldLabel: 'obs',
				allowBlank: false,
				anchor: '80%',
				gwidth: 230,
				maxLength:500
			},
			type:'TextArea',
			filters:{pfiltro:'mov.obs',type:'string'},
			bottom_filter: true,
			id_grupo:0,
			grid:true,
			form:true
		},
		
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_movimiento_det'
			},
			type:'Field',
			form:true 
		},
		
		{
			config:{
				name: 'tipo_documento',
				fieldLabel: 'Tipo Documento',
				qtip: 'Documento de respaldo,  factura o recibo',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				store:new Ext.data.ArrayStore({
                            fields: ['variable', 'valor'],
                            data : []}),
				
				maxLength:500,	
							
				typeAhead: true,
                triggerAction: 'all',
                lazyRender:true,
                displayField:'valor',
                valueField:'variable',
                mode: 'local'
			},
			type:'ComboBox',
			filters:{
				pfiltro:'mov.tipo_documento',
			    type:'list',  
			    options: ['factura', 
			             'recibo_bien', 
			             'recibo_servicio', 
			             'recibo_alquiler', 
			             'recibo_sin_retencion']
			
			},
			bottom_filter: true,
			id_grupo:0,
			grid:true,
			form:true
		},
		
		{
                    config:{
                        name: 'nro_autorizacion',
                        fieldLabel: 'Autorización',
                        allowBlank: false,
                        emptyText:'autorización ...',
                        store:new Ext.data.JsonStore(
                            {
                                url: '../../sis_contabilidad/control/DocCompraVenta/listarNroAutorizacion',
                                id: 'nro_autorizacion',
                                root:'datos',
                                sortInfo:{
                                    field:'nro_autorizacion',
                                    direction:'ASC'
                                },
                                totalProperty:'total',
                                fields: ['nro_autorizacion','nit','razon_social'],
                                remoteSort: true
                            }),
                        valueField: 'nro_autorizacion',
                        hiddenValue: 'nro_autorizacion',
                        displayField: 'nro_autorizacion',
                        queryParam: 'nro_autorizacion',
                        listWidth:'280',
                        forceSelection:false,
                        autoSelect: false,
                        hideTrigger:true,
                        typeAhead: false,
                        typeAheadDelay: 75,
                        lazyRender:false,
                        mode:'remote',
                        pageSize:20,
                        width: 200,
                        boxMinWidth: 200,
                        queryDelay:500,
                        minChars:1,
                        maskRe: /[0-9/-]+/i,
                        regex: /[0-9/-]+/i
                    },
                    type:'ComboBox',
                    id_grupo: 0,
                    grid:true,
			        form:true
         },
		
		 {
                    config:{
                        name: 'nit',
                        fieldLabel: 'NIT/CI',
                        qtip: 'Número de indentificación del proveedor',
                        allowBlank: false,
                        emptyText:'nit ...',
                        store:new Ext.data.JsonStore(
                            {
                                url: '../../sis_contabilidad/control/DocCompraVenta/listarNroNit',
                                id: 'nit',
                                root:'datos',
                                sortInfo:{
                                    field:'nit',
                                    direction:'ASC'
                                },
                                totalProperty:'total',
                                fields: ['nit','razon_social'],
                                remoteSort: true
                            }),
                        valueField: 'nit',
                        hiddenValue: 'nit',
                        displayField: 'nit',
                        gdisplayField:'nit',
                        queryParam: 'nit',
                        listWidth:'280',
                        forceSelection:false,
                        autoSelect: false,
                        typeAhead: false,
                        typeAheadDelay: 75,
                        hideTrigger:true,
                        triggerAction: 'query',
                        lazyRender:false,
                        mode:'remote',
                        pageSize:20,
                        queryDelay:500,
                        anchor: '80%',
                        minChars:1
                    },
                    type:'ComboBox',
                    id_grupo: 0,
                    grid:true,
                    form: true
        },
        
        {
                    config:{
                        name: 'razon_social',
                        fieldLabel: 'Razón Social / Nombre',
                        allowBlank: false,
                        maskRe: /[A-Za-z0-9 &-. ñ Ñ]/,
                        fieldStyle: 'text-transform:uppercase',
                        listeners:{
                            'change': function(field, newValue, oldValue){

                                field.suspendEvents(true);
                                field.setValue(newValue.toUpperCase());
                                field.resumeEvents(true);
                            }
                        },
                        anchor: '80%',
                        maxLength:180
                    },
                    type:'TextField',
                    id_grupo:0,
                    grid:true,
                    form:true
        },

		{
                    config:{
                        name: 'codigo_control',
                        fieldLabel: 'Código de Control',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        enableKeyEvents: true,
                        fieldStyle : 'text-transform: uppercase',
                        maxLength:200,
                        validator: function(v) {
                            return /^0|^([A-Fa-f0-9]{2,2}\-)*[A-Fa-f0-9]{2,2}$/i.test(v)? true : 'Introducir texto de la forma xx-xx, donde x representa dígitos  hexadecimales  [0-9]ABCDEF.';
                        },
                        maskRe: /[0-9ABCDEF/-]+/i,
                        regex: /[0-9ABCDEF/-]+/i
                    },
                    type:'TextField',
                    id_grupo:1,
                    grid:true,
                    form:true
        },
		
		
		{
			config:{
				name: 'monto_doc',
				fieldLabel: 'Monto',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				minValue :0,
				maxLength:1245186,
				renderer:function (value, p, record){
                            if(record.data.tipo_reg=='summary'){
                                 return String.format('<b><font color="green">{0}</font></b>', record.data.total_monto_doc);
                            }
                            else{
                                return String.format('{0}', value);
                            }
                        
                        }
				
			},
			type:'NumberField',
			valorInicial: 0,
			bottom_filter: true,
			filters:{pfiltro:'mov.monto',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'monto',
				fieldLabel: 'Monto Liquido',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				minValue :0,
				readOnly: true,
				maxLength:1245186,
				renderer:function (value, p, record){
                            if(record.data.tipo_reg=='summary'){
                                 return String.format('<b><font color="green">{0}</font></b>', record.data.total_monto);
                            }
                            else{
                                return String.format('{0}', value);
                            }
                        
                        }
				
			},
			type:'NumberField',
			valorInicial: 0,
			bottom_filter: true,
			filters:{pfiltro:'mov.monto',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'monto_retencion',
				fieldLabel: 'Retenciones',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				minValue :0,
				readOnly: true,
				maxLength:1245186,
				renderer:function (value, p, record){
                            if(record.data.tipo_reg=='summary'){
                                 return String.format('<b><font color="green">{0}</font></b>', record.data.total_monto_retencion);
                            }
                            else{
                                return String.format('{0}', value);
                            }
                        
                        }
				
			},
			type:'NumberField',
			valorInicial: 0,
			bottom_filter: true,
			filters:{pfiltro:'mov.monto_retencion',type:'numeric'},
			id_grupo:0,
			grid:true,
			form:true
		},
		
		
        
		{
			config:{
				name: 'num_documento',
				fieldLabel: 'Número Doc',
				qtip: 'número del documento de respaldo o número de factura',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:500
			},
			type:'TextField',
			filters:{pfiltro:'mov.num_documento',type:'string'},
			bottom_filter: true,
			id_grupo:0,
			grid:true,
			form:true
		},
        
       
        {
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				qtip: 'Pendiente si todavia no fue entregado el recibo o factura al terorero, os egresos solamente validaods cuando se entrega la factura o recibo originales',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				store: ['pendiente','entregado'],
				allowBlank: false,
				typeAhead: true,
	       		triggerAction: 'all',
	       		lazyRender:true,
	       		forceSelection : true,
				mode: 'local',
				anchor: '80%',
				maxLength:500
			},
			type:'ComboBox',
			filters:{pfiltro:'mov.estado',type:'string'},
			bottom_filter: true,
			valorInicial: 'pendiente',
			id_grupo:0,
			grid:true,
			form:true
		},
        {
            config:{
                    name:'id_ot',
                    fieldLabel: 'Objetivo (OT)',
                    qtip: 'Si las colecta tiene un objetivo es especifico',
                    sysorigen:'sis_contabilidad',
	       		    origen:'OT',
                    allowBlank:true,
                    gwidth:200,
                    anchor: '80%',
   				    listWidth: 350,
                    renderer:function(value, p, record){return String.format('{0}', record.data['desc_orden']);}
            
            },
            type:'ComboRec',
            id_grupo:0,
            filters:{pfiltro:'mov.desc_orden',type:'string'},
            grid:true,
            form:true
        },
        
		
		
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'mov.fecha_reg',type:'date'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'usu1.cuenta',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		},
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'mov.estado_reg',type:'string'},
            id_grupo:0,
            grid:true,
            form:false
        },
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'mov.fecha_mod',type:'date'},
			id_grupo:0,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'usu2.cuenta',type:'string'},
			id_grupo:0,
			grid:true,
			form:false
		}
	],
	
	title:'Movimientos',
	ActSave:'../../sis_admin/control/Movimiento/insertarMovimientoEgreso',
	ActDel:'../../sis_admin/control/Movimiento/eliminarMovimiento',
	ActList:'../../sis_admin/control/Movimiento/listarMovimientoEgreso',
	id_store:'id_movimiento',
	fields: [
		{name:'id_movimiento', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'tipo', type: 'string'},
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'concepto', type: 'string'},
		{name:'obs', type: 'string'},
		{name:'fecha', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_estado_periodo', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		'id_tipo_movimiento' ,
        'id_movimiento_det','id_cuenta_bancaria','desc_cuenta_bancaria',
        'monto',
        'total_monto_doc','total_monto_retencion',
        'total_monto','tipo_reg','tipo_documento','num_documento',
        'id_obrero',
	    'desc_obrero','id_movimiento_traspaso',
	    'estado',
	    'desc_tipo_movimiento','nro_autorizacion',
	    'codigo_control','nit', 'razon_social','desc_casa_oracion',
	    'id_ot','desc_orden','id_concepto_ingas','desc_ingas','monto_doc','monto_retencion'
		
		
	],
	
	
	sortInfo:{
		field: 'id_movimiento',
		direction: 'ASC'
	},
	bdel:false,
	bsave:false,
	bnew : false,
	bedit: false
	
	
	}
)
</script>
		
		