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

	constructor:function(config){
	    
		this.maestro=config.maestro;
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
         },this);
         
         
         this.Cmp.concepto.on('select',function(cm,dat,num){
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
		  
		    
		},this);
		
	},
	dataIngreso : [
                ['colecta_adultos', 'Colecta de Adultos'],
                ['colecta_jovenes', 'Colecta de Jovenes'],
                ['colecta_especial', 'Colecta Especial'],
                ['saldo_inicial', 'Saldo Inicial'],
                ['ingreso_trapaso', 'Ingreso por Trapaso']
        
        ] ,
    dataEgreso : [
                ['operacion', 'Operacion '],
                ['egreso_traspaso', 'Egreso por Traspaso'],
                ['contra_rendicion', 'Contra rendición'],
                ['egreso_inicial_por_rendir', 'Saldo por Rendir (año pasado)']
        
        ],
    
     documentoEgreso: [
                ['factura', 'Factura '],
                ['recibo_bien', 'Recibo con retención de bienes'],
                ['recibo_servicio', 'Recibo con retención de servicios'],
                ['recibo_sin_retencion', 'Recibo sin retención']
      ],
	documentoContraRendicion: [
                ['recibo_piedad', 'Recibo de Piedad'],
                ['recibo', 'Recibo Especial']
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
    
    onButtonNew:function(){
        
        
         if(!this.validarFiltros()){
             alert('Especifique los filtros antes');
        }
         else{
              Phx.vista.MovimientoEgreso.superclass.onButtonNew.call(this);
              this.getComponente('fecha').setMinValue(this.fecha_min);
               this.getComponente('fecha').setMaxValue(this.fecha_max);
         }
        
    },
    onButtonEdit:function(){
        
        
         if(!this.validarFiltros()){
             alert('Especifique los filtros antes');
        }
         else{
              Phx.vista.MovimientoEgreso.superclass.onButtonEdit.call(this);
              this.getComponente('fecha').setMinValue(this.fecha_min);
              this.getComponente('fecha').setMaxValue(this.fecha_max);
         }
        
    },
    
     loadValoresIniciales:function()
    {
        Phx.vista.MovimientoEgreso.superclass.loadValoresIniciales.call(this);
        this.getComponente('tipo').setValue(this.cmbTipo.getValue());
        this.getComponente('id_casa_oracion').setValue(this.cmbCasaOracion.getValue());  
        this.getComponente('id_estado_periodo').setValue(this.cmbEstadoPeriodo.getValue());   
        
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
			id_grupo:1,
			grid:true,
			form:true
		},
        {
                config:{
                    name:'concepto',
                    fieldLabel:'Concepto',
                    allowBlank:false,
                    emptyText:'Tipo...',
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    displayField:'valor',
                    valueField:'variable',
                    mode: 'local',
                    gwidth: 100,
                    renderer:function (value, p, record){
                        var dato='';
                        dato = (dato==''&&value=='colecta_adultos')?'Colecta de Adultos':dato;
                        dato = (dato==''&&value=='colecta_jovenes')?'Colecta de Jovenes':dato;
                        dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                        dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                        dato = (dato==''&&value=='saldo_inicial')?'Saldo Inicial':dato;
                        dato = (dato==''&&value=='ingreso_trapaso')?'Ingreso por Trapaso':dato;
                        dato = (dato==''&&value=='operacion')?'Operacion':dato;
                        dato = (dato==''&&value=='egreso_traspaso')?'Egreso por Traspaso':dato;
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
                width:200,
                gwidth:120,
                minChars:2
            },
            type:'ComboBox',
            filters:{pfiltro:'mov.desc_tipo_movimiento',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'id_obrero',
                fieldLabel: 'Obrero',
                forceSelection : true,
                qtip: 'Hermano que lleva la colecta (cuando la entregue al tesorero el estado debe cambiar a entregado)',
                allowBlank: true,
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
                width:210,
                gwidth:160,
                minChars:2
            },
            type:'ComboBox',
            bottom_filter: true,
            filters:{pfiltro:'mov.desc_obrero',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
			config:{
				name: 'obs',
				fieldLabel: 'obs',
				allowBlank: true,
				anchor: '80%',
				gwidth: 230,
				maxLength:500
			},
			type:'TextArea',
			filters:{pfiltro:'mov.obs',type:'string'},
			bottom_filter: true,
			id_grupo:1,
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
				name: 'monto',
				fieldLabel: 'Monto',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				minValue :0,
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
			id_grupo:1,
			grid:true,
			egrid:true,
			form:true
		},
		{
			config:{
				name: 'tipo_documento',
				fieldLabel: 'Documento',
				qtip: 'Documento de respaldo factura o recibo',
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
			id_grupo:1,
			grid:true,
			form:true
		},
        
		{
			config:{
				name: 'num_documento',
				fieldLabel: 'Numero',
				qtip: 'número del documento de respaldo o número de factura',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:500
			},
			type:'TextField',
			filters:{pfiltro:'mov.num_documento',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true
		},
        
       
        {
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				qtip: 'si la colecta fue entregado al tesorero el estado será entregado en caso contrario pendiente',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				store: ['pendiente','entregado'],
				lazyRender: true,
				mode: 'local',
				maxLength:500
			},
			type:'ComboBox',
			filters:{pfiltro:'mov.estado',type:'string'},
			bottom_filter: true,
			valorInicial: 'pendiente',
			id_grupo:1,
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
			id_grupo:1,
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
			id_grupo:1,
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
            id_grupo:1,
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
			id_grupo:1,
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
			id_grupo:1,
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
        'id_movimiento_det',
        'monto',
        'total_monto','tipo_reg','tipo_documento','num_documento',
        'id_obrero',
	    'desc_obrero',
	    'estado','desc_tipo_movimiento'
		
		
	],
	
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
		
		