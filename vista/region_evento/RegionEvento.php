<?php
/**
*@package pXP
*@file gen-RegionEvento.php
*@author  (admin)
*@date 13-01-2013 14:31:26
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.RegionEvento=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
		this.initButtons=[this.cmbGestion,this.cmbRegion];
    	//llama al constructor de la clase padre
		Phx.vista.RegionEvento.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:50}})
		
		
		this.cmbRegion.on('select',this.capturaFiltros,this);
		this.cmbGestion.on('select',this.capturaFiltros,this);
		
	},
	capturaFiltros:function(combo, record, index){
		this.store.baseParams.id_gestion=this.cmbGestion.getValue();
		this.store.baseParams.id_region=this.cmbRegion.getValue();
		this.store.load({params:{start:0, limit:250}});	
			
		
	},
	onButtonAct:function(){
		this.store.baseParams.id_gestion=this.cmbGestion.getValue();
		this.store.baseParams.id_region=this.cmbRegion.getValue();
		Phx.vista.RegionEvento.superclass.onButtonAct.call(this);
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_region_evento'
			},
			type:'Field',
			form:true 
		},
				
		{
			config:{
				name: 'id_gestion',
				fieldLabel: 'Gestion',
				allowBlank: false,
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
				displayField: 'gestion',
				gdisplayField:'desc_gestion',
				hiddenName: 'id_gestion',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:200,
				gwidth:100,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_gestion']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'ges.gestion',type:'string'},
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
			id_grupo:1,
			grid:true,
			form:true
		},
	
		{
			config:{
				name: 'id_evento',
				fieldLabel: 'Evento',
				allowBlank: false,
				emptyText:'Evento...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_admin/control/Evento/listarEvento',
					id: 'id_evento',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_evento','nombre'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_evento',
				displayField: 'nombre',
				gdisplayField:'desc_evento',
				hiddenName: 'id_evento',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_evento']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'eve.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		
		{
			config:{
				name: 'fecha_programada',
				fieldLabel: 'Fecha',
				allowBlank: false,
				//anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'rege.fecha_programada',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
	       		config:{
	       			name:'estado',
	       			fieldLabel:'Estado',
	       			allowBlank:false,
	       			emptyText:'Estado...',
	       			
	       			typeAhead: true,
	       		    triggerAction: 'all',
	       		    lazyRender:true,
	       		    mode: 'local',
	       		    store:['pendiente','ejecutado','cancelado']
	       		    
	       		},
	       		type:'ComboBox',
	       		id_grupo:1,
	       		filters:{	
	       			 type: 'list',
	       		         pfiltro: 'estado',
	       				 options: ['pendiente','estado','cancelado']	
	       		 	},
	       		grid:true,
	       		form:true
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
			filters:{pfiltro:'rege.estado_reg',type:'string'},
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
			filters:{pfiltro:'rege.fecha_reg',type:'date'},
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
			filters:{pfiltro:'rege.fecha_mod',type:'date'},
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
	
	title:'Eventos por Región',
	ActSave:'../../sis_admin/control/RegionEvento/insertarRegionEvento',
	ActDel:'../../sis_admin/control/RegionEvento/eliminarRegionEvento',
	ActList:'../../sis_admin/control/RegionEvento/listarRegionEvento',
	id_store:'id_region_evento',
	fields: [
		{name:'id_region_evento', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_gestion', type: 'numeric'},
		{name:'fecha_programada', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_evento', type: 'numeric'},
		{name:'estado', type: 'string'},
		{name:'id_region', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		'desc_gestion','desc_evento','desc_region'		
	],
	
	cmbGestion:new Ext.form.ComboBox({
				fieldLabel: 'Gestion',
				allowBlank: true,
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
			
			
			
		cmbRegion:new Ext.form.ComboBox({
				fieldLabel: 'Región',
				allowBlank: true,
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
				hiddenName: 'id_region',
    			triggerAction: 'all',
    			mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:210,
				minChars:2
				}),
	sortInfo:{
		field: 'id_region_evento',
		direction: 'ASC'
	},
	south:{
		  url:'../../../sis_admin/vista/detalle_evento/DetalleEvento.php',
		  title:'Detalle', 
		  height:'50%',
		  cls:'DetalleEvento'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		