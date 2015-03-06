<?php
/**
*@package pXP
*@file gen-Obrero.php
*@author  (admin)
*@date 13-01-2013 12:24:54
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Obrero=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Obrero.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();
		this.load({params:{start:0, limit:50}});	
		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_obrero'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				labelSeparator:'',
					inputType:'hidden',
					name: 'id_region'
					},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'id_tipo_ministerio',
				fieldLabel: 'Ministerio',
				allowBlank: false,
				emptyText:'Ministerio...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_admin/control/TipoMinisterio/listarTipoMinisterio',
					id: 'id_tipo_ministerio',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_ministerio','nombre','tipo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_tipo_ministerio',
				displayField: 'nombre',
				gdisplayField:'desc_tipo_ministerio',
				hiddenName: 'id_tipo_ministerio',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_tipo_ministerio']);}
			},
			type:'ComboBox',
			bottom_filter: true,
			filters:{pfiltro:'tipmi.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'id_region',
				fieldLabel: 'Región',
				allowBlank: false,
				emptyText:'Región...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_admin/control/Region/listarRegion',
					id: 'id_region',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_region','nombre'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_region',
				displayField: 'nombre',
				gdisplayField:'desc_region',
				hiddenName: 'id_region',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_region']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'reg.nombre',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true
		},
		
		{
			config: {
				name: 'id_casa_oracion',
                fieldLabel: 'Casa de Oración',
                allowBlank: false,
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
                    fields: ['id_casa_oracion','codigo','nombre'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'nombre'}
                }),
                valueField: 'id_casa_oracion',
                displayField: 'nombre',
                gdisplayField:'desc_casa_oracion',
                hiddenName: 'id_casa_oracion',
                triggerAction: 'all',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:210,
                minChars:2
            },
			type:'ComboBox',
			filters:{pfiltro:'co.nombre',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true
			
		},
		{
   			config:{
       		    name:'id_persona',
   				origen:'PERSONA',
   				tinit:true,
   				fieldLabel:'Persona',
   				allowBlank:false,
                gwidth:200,
   				valueField: 'id_persona',
   			    gdisplayField: 'desc_persona',
      			renderer:function(value, p, record){return String.format('{0}', record.data['desc_persona']);}
       	     },
   			type:'ComboRec',//ComboRec
   			id_grupo:0,
   			filters:{pfiltro:'per.nombre_completo1',type:'string'},
   			bottom_filter: true,
   		    grid:true,
   			form:true
		 },
		{
			config:{
				name: 'fecha_ini',
				fieldLabel: 'Fecha Nom',
				qtip:'Fecha de nombramiento',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'obr.fecha_ini',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'fecha_fin',
				fieldLabel: 'fecha_fin',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'obr.fecha_fin',type:'date'},
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
				gwidth: 100,
				maxLength:800
			},
			type:'TextArea',
			filters:{pfiltro:'obr.obs',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'telefono1',
				fieldLabel: 'Telefono',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'per.telefono1',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'celular1',
				fieldLabel: 'Celular',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'per.celuar1',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'correo',
				fieldLabel: 'Correo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'per.correo',type:'string'},
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
			filters:{pfiltro:'obr.estado_reg',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
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
			filters:{pfiltro:'obr.fecha_reg',type:'date'},
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'obr.fecha_mod',type:'date'},
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
	
	title:'Obrero',
	ActSave:'../../sis_admin/control/Obrero/insertarObrero',
	ActDel:'../../sis_admin/control/Obrero/eliminarObrero',
	ActList:'../../sis_admin/control/Obrero/listarObrero',
	id_store:'id_obrero',
	fields: [
		{name:'id_obrero', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_region', type: 'numeric'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'fecha_ini', type: 'date',dateFormat:'Y-m-d'},
		{name:'obs', type: 'string'},
		{name:'id_tipo_ministerio', type: 'numeric'},
		{name:'id_persona', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_persona','desc_tipo_ministerio',
		'desc_casa_oracion','id_casa_oracion','desc_region',
		'telefono1','telefono2','celular1','correo'
	],
	
	iniciarEventos:function(){
	     this.Cmp.id_region.on('select', function(combo, record, index){ 
            	this.Cmp.id_casa_oracion.reset();
            	this.Cmp.id_casa_oracion.store.baseParams.id_region = this.Cmp.id_region.getValue();
            	this.Cmp.id_casa_oracion.modificado = true;
            	this.Cmp.id_casa_oracion.enable();
            }, this);
    },	
	
	sortInfo:{
		field: 'id_obrero',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
})
</script>