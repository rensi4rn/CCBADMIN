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
Phx.vista.MovimientoEgreso=Ext.extend(Phx.gridInterfaz,{
	
	 fheight:'70%',
     fwidth: '70%',

	constructor:function(config){
	    
		this.maestro=config.maestro;
		this.buildGrupos();
		this.initButtons=[this.cmbTipo,this.cmbCasaOracion,this.cmbGestion,this.cmbEstadoPeriodo];
    	//llama al constructor de la clase padre
		Phx.vista.MovimientoEgreso.superclass.constructor.call(this,config);
		
		this.getComponente('concepto').store.loadData(this.dataEgreso);
		this.cmbEstadoPeriodo.disable();
		this.cmbGestion.disable();
	
		this.init();
		//this.load({params:{start:0, limit:0}})
		
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
		
		
		this.cmbCasaOracion.on('select',function(cm,dat,num){
		    this.cmbGestion.enable();
		    this.cmbEstadoPeriodo.reset();
		    this.store.removeAll();
		    this.cmbEstadoPeriodo.store.baseParams.id_casa_oracion=cm.getValue();
		    this.cmbEstadoPeriodo.modificado=true;
		    
		},this);
		
		
		this.cmbGestion.on('select',function(cm,dat,num){
		   this.cmbEstadoPeriodo.reset();
		   this.store.removeAll();
		   this.cmbEstadoPeriodo.store.baseParams.id_gestion=cm.getValue();
		   this.cmbEstadoPeriodo.store.baseParams.id_casa_oracion=this.cmbCasaOracion.getValue();
		   this.cmbEstadoPeriodo.modificado=true;
		   this.cmbEstadoPeriodo.enable() 
		},this);
		
		this.cmbEstadoPeriodo.on('select',function(cm,dat,num){
           this.capturaFiltros();
           this.fecha_min = dat.data.fecha_ini;
           this.fecha_max = dat.data.fecha_fin;
           this.getComponente('fecha').setMinValue(this.fecha_min);
           this.getComponente('fecha').setMaxValue(this.fecha_max);
         },this);
         
         
        
		 this.iniciarEventos();
	},
	dataIngreso : [
                ['colecta_adultos', 'Colecta de Adultos'],
                ['colecta_jovenes', 'Colecta de Jovenes'],
                ['colecta_especial', 'Colecta Especial'],
                ['saldo_inicial', 'Saldo Inicial'],
                ['ingreso_trapaso', 'Ingreso por Trapaso']
        
        ] , 
    dataEgreso : [
                ['operacion', 'Operación '],
                ['egreso_traspaso', 'Egreso por Traspaso'],
                ['contra_rendicion', 'Deposito'],
                //['egreso_inicial_por_rendir', 'Saldo por Rendir (año pasado)']
        
        ],
    
     documentoEgreso: [
                ['factura', 'Factura '],
                ['recibo_bien', 'Recibo con retención de bienes'],
                ['recibo_servicio', 'Recibo con retención de servicios'],
                ['recibo_alquiler', 'Recibo con retención de alquileres'],
                ['recibo_sin_retencion', 'Recibo sin retención']
      ],
	documentoContraRendicion: [
                ['recibo', 'Cbte de Deposito']
      ],
	documentoTrapaso: [
                ['recibo', 'Recibo de trapaso']
     ],
      
      
	validarFiltros:function(){
	    if(this.cmbEstadoPeriodo.isValid()&& this.cmbCasaOracion.isValid()&& this.cmbGestion.isValid() && this.cmbTipo.isValid() ){
	        return true;
	    }
	    else{
	        return false;
	    }
	    
	},
	
	 capturaFiltros:function(combo, record, index){
	    this.store.baseParams.tipo=this.cmbTipo.getValue();
	    this.store.baseParams.id_casa_oracion=this.cmbCasaOracion.getValue();
        this.store.baseParams.id_estado_periodo=this.cmbEstadoPeriodo.getValue();
         this.store.baseParams.tipo_concepto='egreso';
        this.store.load({params:{start:0, limit:this.tam_pag}}); 
            
        
    },
    onButtonAct:function(){
        if(!this.validarFiltros()){
            alert('Especifique los filtros antes')
         }
        else{
            this.store.baseParams.tipo=this.cmbTipo.getValue();
            this.store.baseParams.id_casa_oracion=this.cmbCasaOracion.getValue();
            this.store.baseParams.id_estado_periodo=this.cmbEstadoPeriodo.getValue();
            Phx.vista.MovimientoEgreso.superclass.onButtonAct.call(this);
        }
    },
    
    
	calculaMontos:function(){		
		var tipodoc = this.Cmp.tipo_documento.getValue();
		var monto_doc = this.Cmp.monto_doc.getValue();
		if(tipodoc == 'recibo_bien'){			
			
			var retencion = monto_doc*0.08;
			retencion = Math.round(retencion * 100) / 100;
			this.Cmp.monto_retencion.setValue(retencion);		   	
		   	this.Cmp.monto.setValue(monto_doc - retencion);
		   	
		}
		else{
			if(tipodoc == 'recibo_servicio'){				
				
				var retencion = monto_doc*0.155;
				retencion = Math.round(retencion * 100) / 100;
				this.Cmp.monto_retencion.setValue(retencion);		   	
			   	this.Cmp.monto.setValue(monto_doc - retencion);
			   	
			}
			else{
				
				if(tipodoc == 'recibo_alquiler'){				
				
					var retencion = monto_doc*0.16;
					retencion = Math.round(retencion * 100) / 100;
					this.Cmp.monto_retencion.setValue(retencion);		   	
				   	this.Cmp.monto.setValue(monto_doc - retencion);
				   	
				}
				else{
					this.Cmp.monto.setValue(monto_doc);
		   	        this.Cmp.monto_retencion.setValue(0);
				}
				 
			}
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
                
	cmbCasaOracion:new Ext.form.ComboBox({
                fieldLabel: 'Casa de Oración',
                allowBlank: false,
                forceSelection : true,
                emptyText:'Casa...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/CasaOracion/listarCasaOracion',
                    id: 'id_casa_oracion',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_casa_oracion','codigo','nombre','desc_lugar','desc_region'],
                    // turn on remote sorting
                    remoteSort: true,     
                    baseParams:{par_filtro:'caor.nombre#reg.nombre#reg.nombre'}
                
               
                }),
                valueField: 'id_casa_oracion',
                displayField: 'nombre',
                hiddenName: 'id_casa_oracion',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombre}</p><p>{desc_lugar} - {desc_region}</p> </div></tpl>',
				triggerAction: 'all',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:210,
                minChars:2
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
            
     cmbEstadoPeriodo:new Ext.form.ComboBox({
                fieldLabel: 'Periodo',
                allowBlank: false,
                forceSelection : true,
                emptyText:'Periodo...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/EstadoPeriodo/listarEstadoPeriodo',
                    id: 'id_estado_periodo',
                    root: 'datos',
                    sortInfo:{
                        field: 'num_mes',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_estado_periodo','id_gestion','mes','num_mes','fecha_ini','fecha_fin'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'mes'}
                }),
                valueField: 'id_estado_periodo',
                triggerAction: 'all',
                displayField: 'mes',
                hiddenName: 'id_estado_periodo',
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
			form:true
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
                form:true
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
            form:true
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
            form:true
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
            form:true
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
            form:true
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
			filters:{pfiltro:'mov.tipo_documento',type:'string'},
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
	    'codigo_control','nit', 'razon_social',
	    'id_ot','desc_orden','id_concepto_ingas','desc_ingas','monto_doc','monto_retencion'
		
		
	],
	
	successSave:function(resp){
		this.store.rejectChanges();
		Phx.CP.loadingHide();
		if(resp.argument && resp.argument.news){
			if(resp.argument.def == 'reset'){
			  //this.form.getForm().reset();
			  this.onButtonNew();
			}
			
			this.loadValoresIniciales();			
			this.calcularSaldos();
		}
		else{
			this.window.hide();
		}

		this.reload();
	},
	
	
	
	onButtonNew:function(){        
        
         if(!this.validarFiltros()){
             alert('Especifique los filtros antes');
        }
         else{
              
              Phx.vista.MovimientoEgreso.superclass.onButtonNew.call(this);
              this.getComponente('fecha').setMinValue(this.fecha_min);
              this.getComponente('fecha').setMaxValue(this.fecha_max);
              this.getComponente('fecha').setValue(this.fecha_min);
              this.ocultarComponente(this.Cmp.id_concepto_ingas);              
              this.Cmp.monto_doc.disable();
         }
         
         this.resetPanel();
         
        
    },
    onButtonEdit:function(){
        
        
        if(!this.validarFiltros()){
             alert('Especifique los filtros antes');
        }
        else{
              Phx.vista.MovimientoEgreso.superclass.onButtonEdit.call(this);
              var con = this.Cmp.concepto.getValue();
              
              if(con == 'operacion'){
		   	  	this.mostrarComponente(this.Cmp.id_concepto_ingas)
		   	  	this.Cmp.id_concepto_ingas.allowBlank = false;
		   	  	this.Cmp.tipo_documento.store.loadData(this.documentoEgreso);
		   	  }
		   	  else{
		   	  	 this.ocultarComponente(this.Cmp.id_concepto_ingas)
		   	  	 this.Cmp.id_concepto_ingas.allowBlank = true;
		   	  	 this.Cmp.id_concepto_ingas.reset();
		   	  }
		   	  
		   	  if(con == 'contra_rendicion'){
		   	  	this.mostrarComponente(this.Cmp.id_cuenta_bancaria);
		   	  	this.Cmp.tipo_documento.store.loadData(this.documentoContraRendicion)
		   	  	
		   	  }
		   	  else{
		   	  	this.ocultarComponente(this.Cmp.id_cuenta_bancaria)	
		   	  }
		   	  
		   	 
		     if(con == 'egreso_traspaso'){
		         this.Cmp.tipo_documento.store.loadData(this.documentoTrapaso)
		     }
		     if(con == 'egreso_inicial_por_rendir'){
		         this.Cmp.tipo_documento.store.loadData(this.documentoContraRendicion)
		     }
		     
		     var tipo_documento = this.Cmp.tipo_documento.getValue();
		     if( tipo_documento == 'factura'){                	
                	// ocultar  autorizacion
                	this.mostrarComponente(this.Cmp.nro_autorizacion);
                	this.mostrarComponente(this.Cmp.codigo_control);
             }
             else{
                	this.ocultarComponente(this.Cmp.nro_autorizacion);
                	this.ocultarComponente(this.Cmp.codigo_control);
                	this.ocultarComponente(this.Cmp.codigo_control);
             }
             
             
             var valueNA = this.Cmp.nro_autorizacion.getValue();
             
             if (valueNA[3] == '4' || valueNA[3] == '8'|| valueNA[3] == '6'){
                    this.mostrarComponente(this.Cmp.codigo_control);
                    this.Cmp.codigo_control.allowBlank = false;
             }
             else{
                    this.Cmp.codigo_control.allowBlank = true;
                    this.ocultarComponente(this.Cmp.codigo_control);
             };

            
            this.Cmp.monto_doc.enable();
         }
         this.resetPanel();
        
    },
    
    loadValoresIniciales:function()
    {
        Phx.vista.MovimientoEgreso.superclass.loadValoresIniciales.call(this);
        this.getComponente('tipo').setValue(this.cmbTipo.getValue());
        this.getComponente('id_casa_oracion').setValue(this.cmbCasaOracion.getValue());  
        this.getComponente('id_estado_periodo').setValue(this.cmbEstadoPeriodo.getValue()); 
       
        
    },
	
	
	
	preparaMenu:function(n){
          var data = this.getSelectedData();
          var tb =this.tbar;
          Phx.vista.MovimientoEgreso.superclass.preparaMenu.call(this,n);
          console.log('data....' ,data)
          if(data.tipo_reg=='summary'){
                this.getBoton('del').disable();
                this.getBoton('edit').disable();
          }
          
         return tb 
     }, 
     
      buildGrupos: function(){ 
    	var me = this;
    	this.panelResumen = new Ext.Panel({  
    		    padding: '0 0 0 20',
    		    html: 'Saldos ....',
    		    split: true, 
    		    layout:  'fit' });
    	me.Grupos = [{
                        	xtype: 'fieldset',
	                        border: false,
	                        split: true,
	                        layout: 'column',
	                        autoScroll: true,
	                        autoHeight: true,
	                        collapseFirst : false,
	                        collapsible: true,
	                        collapseMode : 'mini',
	                        width: '100%',
	                        padding: '0 0 0 10',
	    	                items:[
		    	                   {
							        bodyStyle: 'padding-right:5px;',
							        width: '60%',
							        autoHeight: true,
							        border: true,
							        items:[
			    	                   {
			                            xtype: 'fieldset',
			                            frame: true,
			                            border: false,
			                            layout: 'form',	
			                            title: 'Tipo',
			                            width: '100%',
			                            
			                            //margins: '0 0 0 5',
			                            padding: '0 0 0 10',
			                            bodyStyle: 'padding-left:5px;',
			                            id_grupo: 0,
			                            items: [],
			                         }]
			                     },
			                     {
			                      bodyStyle: 'padding-right:5px;',
			                      width: '40%',
			                      border: true,
			                      autoHeight: true,
							      items: [me.panelResumen]
		                         }
    	                      ]
    	                  }];	
    	     
                  
	},
    		
     
     	
     validarParamSaldos:function(){
	    if( this.Cmp.fecha.isValid()&& this.Cmp.id_tipo_movimiento.isValid()){
	        return true;
	    }
	    else{
	        return false;
	    }
	    

     },
     
     
     resetCuentaBancaria: function(){
		
		this.Cmp.id_cuenta_bancaria.reset();
 	  	this.Cmp.id_cuenta_bancaria.store.baseParams.id_casa_oracion = this.cmbCasaOracion.getValue();
 	  	this.Cmp.id_cuenta_bancaria.store.baseParams.id_tipo_movimiento = this.Cmp.id_tipo_movimiento.getValue();
 	  	this.Cmp.id_cuenta_bancaria.modificado = true;
	     	  	
	},
     calcularSaldos(){
     	var me = this;
     	if (me.validarParamSaldos()) {
     		
     		
     	     var parametros = {
	     	  	fecha: this.fecha_max,
	     	  	id_lugar: undefined,
	     	  	id_region: undefined,
	     	  	id_obrero: undefined,
	     	  	id_ot: undefined,
	     	  	id_casa_oracion: this.cmbCasaOracion.getValue(),
	     	  	id_tipo_movimiento: this.Cmp.id_tipo_movimiento.getValue()
     	  	 };   	 

             console.log('parametros ....', parametros);
             Phx.CP.loadingShow(); 
			 Ext.Ajax.request({
				
				url:'../../sis_admin/control/Movimiento/calcularSaldos',
				params: parametros,
				success:this.successSinc,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});    
        }
     },
     
     resetPanel:function(){
     	this.panelResumen.update("");
     	
     },
     successSinc :function(resp){
		       Phx.CP.loadingHide();
		       var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
		        if (reg.ROOT.error) {
		            alert('error al procesar');
		            return
		       } 
		       console.log(reg);
		       var deco = reg.ROOT.datos,
		       	   plantilla = "<div style='overflow-y: initial;'><br><b>CUENTA DEL PRIMER DIA DEL AÑO  A LA FECHA SEÑALADA</b><br><p> \
		       					Ingreso  Inicial  considera:  el saldo en adminsitración + saldo por rendir,  al 31 de diciembre de la gestion anterior </br>\
		       					Ingreso  Inicial: {0} </br>\
								<b>Ingreso por Colectas: {1}</b></br>\
								Ingreso por Devolucion: {2}</br>\
								Ingreso por Traspasos: {3}</br>\
								Ingreso Total =  (Ingreso por Traspasos) + (Ingreso por colectas) + (Ingreso  Inicial)</br>\
								Ingreso Total: {4}</br></br>\
								Egresos por operación: {5}</br>\
								Egresos inicial por rendir: {6}</br>\
								Egresos contra rendición: {7}</br>\
								Rendiciones: {8}</br>\
								Egresos por Traspaso: {9}</br></br>\
								Egreso Efectivo = (Egresos por operación) + (Rendiciones)</br>\
								<b>Egreso Efectivo: {10}</br></b></br>\
								Saldo en efectivo =  (Ingreso Total) - (Egreso Efectivo) - (Egresos por Traspaso)</br>\
								<b>Saldo en efectivo: {11}</font></b></br></br>\
								Saldo en la administración =  (Ingreso Total)  + (Ingreso por Devolución) - (Egresos por Traspaso) - (Egresos por operación) - (Egresos contra rendición)- (Egresos inicial por rendir)</br>\
								<b><font color='red'>Saldo en la administración: {12}</font></b></br></br>\
								Saldo por Rendir =  (Egresos inicial por rendir) + (Egresos contra rendición)  - (Rendiciones) - (devoluciones)</br>\
								Saldo por Rendir: {13}</br></br></div>";
		       
			   this.panelResumen.update( String.format(plantilla,
			                                           deco.v_ingreso_inicial, 
			                                           deco.v_ingreso_colectas,
			                                           deco.v_ingreso_devolucion,
			                                           deco.v_ingreso_traspasos,
			                                           deco.v_ingreso_total,
			                                           deco.v_egreso_operacion ,
			                                           deco.v_egreso_inicial_por_rendir,
			                                           deco.v_egresos_contra_rendicion,
			                                           deco.v_egresos_rendidos,
			                                           deco.v_egreso_traspaso,
			                                           deco.v_egreso_efectivo,
			                                           deco.v_saldo_efectivo,
			                                           deco.v_saldo_adm,
			                                           deco.v_sado_x_rendir
			                                           
			                                           ));
	},
     
    
     iniciarEventos:function(){
		
		//Eventos
		
		this.Cmp.concepto.on('select', 
		   function(cmb, dat){
		   	
		   	
		   	this.Cmp.tipo_documento.reset();
         	
		    if(dat.data.variable == 'contra_rendicion'){
		      this.Cmp.tipo_documento.store.loadData(this.documentoContraRendicion)
		    }
		    if(dat.data.variable == 'egreso_traspaso'){
		        
		        this.Cmp.tipo_documento.store.loadData(this.documentoTrapaso)
		    }
		    if(dat.data.variable == 'operacion'){
		        
		        this.Cmp.tipo_documento.store.loadData(this.documentoEgreso)
		    }
		    if(dat.data.variable == 'egreso_inicial_por_rendir'){
		        
		        this.Cmp.tipo_documento.store.loadData(this.documentoContraRendicion)
		    }
		    
		   	
		  
		   	  if(cmb.getValue() == 'operacion'){
		   	  	this.mostrarComponente(this.Cmp.id_concepto_ingas)
		   	  	this.Cmp.id_concepto_ingas.allowBlank = false;
		   	  }
		   	  else{
		   	  	this.ocultarComponente(this.Cmp.id_concepto_ingas)
		   	  	this.Cmp.id_concepto_ingas.allowBlank = true;
		   	  	this.Cmp.id_concepto_ingas.reset();
		   	  }
		   	  
		   	   if(cmb.getValue() == 'contra_rendicion'){
		   	  	this.mostrarComponente(this.Cmp.id_cuenta_bancaria)
		   	  	
		   	  }
		   	  else{
		   	  	this.ocultarComponente(this.Cmp.id_cuenta_bancaria)	
		   	  }
		   	  
		   	  this.resetCuentaBancaria();
		   	  
		   	  
		   	
		   },this);	
		   
		this.Cmp.tipo_documento.on('select', 
		   function(cmb){
		   	     console.log('valor ..', cmb.getValue())
		   	     this.Cmp.monto_doc.enable();
		   	     this.Cmp.monto_doc.setValue(0);
		   	     this.Cmp.monto.setValue(0);
		   	     this.Cmp.monto_retencion.setValue(0);
		   	  
		   },this);	
		   
		this.Cmp.monto_doc.on('change', 
		   function(cmb){		   	    
		   	  this.calculaMontos()
		   },this);
		   
		   	
		 this.Cmp.fecha.on('change', 
		   function(cmb){		   	    
		   	 this.calcularSaldos()
		   	
		   },this);
		   
		  this.Cmp.id_tipo_movimiento.on('select', 
		   function(cmb){		   	    
		   	 this.calcularSaldos();
		   	 this.resetCuentaBancaria();
		   },this); 
		   
		   
		  this.Cmp.codigo_control.on('keyup',function(cmp, e){
                //inserta guiones en codigo de contorl
                var value = cmp.getValue(), tmp='',tmp2='',sw = 0;
                tmp = value.replace(/-/g, '');
                for(var i = 0; i< tmp.length; i++){
                    tmp2 = tmp2 + tmp[i];
                    if( (i+1)%2 == 0 && i!= tmp.length-1){
                        tmp2 = tmp2 + '-';
                    }
                }
                cmp.setValue(tmp2.toUpperCase());
            },this); 
            
            
              	     
		   this.Cmp.nro_autorizacion.on('change',function(fild, newValue, oldValue){
                if (newValue[3] == '4' || newValue[3] == '8'|| newValue[3] == '6'){
                    this.mostrarComponente(this.Cmp.codigo_control);
                    this.Cmp.codigo_control.allowBlank = false;
                }
                else{
                    this.Cmp.codigo_control.allowBlank = true;
                    this.Cmp.codigo_control.setValue('0');
                    this.ocultarComponente(this.Cmp.codigo_control);

                };

            },this);
            
            this.Cmp.nro_autorizacion.on('select', function(cmb,rec,i){
                this.Cmp.nit.setValue(rec.data.nit);
                this.Cmp.razon_social.setValue(rec.data.razon_social);
            } ,this);
            
             this.Cmp.nro_autorizacion.on('change', function(cmb,newval,oldval){
                var rec = cmb.getStore().getById(newval)
                if(!rec){
                    //si el combo no tiene resultado
                    if(cmb.lastQuery){
                        //y se tiene una consulta anterior( cuando editemos no abra cnsulta anterior)
                        this.Cmp.nit.reset();
                        this.Cmp.razon_social.reset();
                    }
                }

            } ,this);
            
            this.Cmp.nit.on('select', function(cmb,rec,i){
                this.Cmp.razon_social.setValue(rec.data.razon_social);
            } ,this);
            
             this.Cmp.nit.on('change', function(cmb,newval,oldval){
                var rec = cmb.getStore().getById(newval);
                if(!rec){
                    //si el combo no tiene resultado
                    if(cmb.lastQuery){
                        //y se tiene una consulta anterior( cuando editemos no abra cnsulta anterior)
                        this.Cmp.razon_social.reset();
                    }
                }

            } ,this);
            
            
            
           this.Cmp.tipo_documento.on('select',function(cmp){
               
                if( cmp.getValue() == 'factura'){                	
                	// ocultar  autorizacion
                	this.mostrarComponente(this.Cmp.nro_autorizacion);
                	this.mostrarComponente(this.Cmp.codigo_control);
                	
                }else{
                	this.ocultarComponente(this.Cmp.nro_autorizacion);
                	this.ocultarComponente(this.Cmp.codigo_control);                	
                	this.ocultarComponente(this.Cmp.codigo_control);
                }
                
                this.Cmp.monto.setValue(0);                
                this.Cmp.monto_retencion.setValue(0);
                this.Cmp.monto_doc.setValue(0);

            },this); 
            
            
            
	},
	
	
	
	arrayDefaultColumHidden:['fecha_reg','fecha_mod','usr_reg','estado_reg'],

	
	sortInfo:{
		field: 'id_movimiento',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	
	
	}
)
</script>
		
		