<?php
/**
*@package pXP
*@file gen-CasaOracion.php
*@author  (admin)
*@date 05-01-2013 08:52:02
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CasaOracion=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CasaOracion.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:50}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_casa_oracion'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'id_region',
				fieldLabel: 'Region',
				allowBlank: false,
				emptyText:'Lugar...',
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
		}
		,
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'caor.codigo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		
		{
			config:{
				name: 'nombre',
				fieldLabel: 'Nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'caor.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'direccion',
				fieldLabel: 'Direecón',
				allowBlank: true,
				anchor: '80%',
				gwidth: 250,
				maxLength:500
			},
			type:'TextArea',
			filters:{pfiltro:'caor.direccion',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'id_lugar',
				fieldLabel: 'Lugar',
				allowBlank: false,
				emptyText:'Lugar...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_parametros/control/Lugar/listarLugar',
					id: 'id_lugar',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_lugar','id_lugar_fk','codigo','nombre','tipo','sw_municipio','sw_impuesto','codigo_largo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_lugar',
				displayField: 'nombre',
				gdisplayField:'desc_lugar',
				hiddenName: 'id_lugar',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_lugar']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'lug.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'fecha_apertura',
				fieldLabel: 'Fecha Apertura',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				format:'Y-m-d',
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'caor.fecha_apertura',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'fecha_cierre',
				fieldLabel: 'Fecha Cierre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				 format:'d-m-Y',
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'caor.fecha_cierre',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'latitud',
				fieldLabel: 'LAtitud',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
			type:'TextField',
			filters:{pfiltro:'caor.latitud',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'longitud',
				fieldLabel: 'Longitud',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
			type:'TextField',
			filters:{pfiltro:'caor.longitud',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'zoom',
				fieldLabel: 'Zoom',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:200
			},
			type:'NumberField',
			filters:{pfiltro:'caor.zoom',type:'string'},
			id_grupo:1,
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
			filters:{pfiltro:'caor.estado_reg',type:'string'},
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
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y h:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'caor.fecha_reg',type:'date'},
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
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y h:i:s'):''}
			},
			type:'DateField',
			filters:{pfiltro:'caor.fecha_mod',type:'date'},
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
	title:'Casas de Oración',
	ActSave:'../../sis_admin/control/CasaOracion/insertarCasaOracion',
	ActDel:'../../sis_admin/control/CasaOracion/eliminarCasaOracion',
	ActList:'../../sis_admin/control/CasaOracion/listarCasaOracion',
	id_store:'id_casa_oracion',
	winmodal:false,
	fields: [
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_cierre', type: 'date', dateFormat:'Y-m-d'},
		{name:'codigo', type: 'string'},
		{name:'id_region', type: 'numeric'},
		{name:'id_lugar', type: 'numeric'},
		{name:'direccion', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'fecha_apertura', type: 'date', dateFormat:'Y-m-d'},
		{name:'fecha_reg', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_region','desc_lugar','latitud','longitud','zoom'
		
	],
	sortInfo:{
		field: 'id_casa_oracion',
		direction: 'ASC'
	},
	east:{
			  url:'../../../sis_admin/vista/casa_oracion/mapaLocalizacion.php',
			  title:'Ubicación', 
			  width:'50%',
			  cls:'mapaLocalizacion'
		 },
	tabsouth:[
	      {
			  url:'../../../sis_admin/vista/culto/Culto.php',		  
			  title:'Cultos', 
			  height:'50%',
			  cls:'Culto'
		 },
	     {
			  url:'../../../sis_admin/vista/estado_periodo/EstadoPeriodo.php',		
			  title:'Periodos', 
			  height:'50%',
			  cls:'EstadoPeriodo'
		 }
	
	   ],
	   
	onButtonNew:function(){
			Phx.vista.CasaOracion.superclass.onButtonNew.call(this);
			Phx.CP.getPagina(this.idContenedor+'-east').setMarkerDragableOn();
	 },
	 
	 onButtonEdit:function(){
			Phx.vista.CasaOracion.superclass.onButtonEdit.call(this);
			Phx.CP.getPagina(this.idContenedor+'-east').setMarkerDragableOn();
	 },
	
	
	cargaMapa: function(){
		var data = this.getSelectedData();
		console.log('data',data)
		if(Phx.CP.getPagina(this.idContenedor+'-east')){	
			 Phx.CP.getPagina(this.idContenedor+'-east').ubicarPos(4,data)
		}
		else{
				    	
			alert("No hay acceso a internet")
		}
	},
	
	EnableSelect:function(n){
		
		
		this.cargaMapa();
		Phx.vista.CasaOracion.superclass.EnableSelect.call(this,n)
	},
	bdel:true,
	bsave:true
	}
)
</script>	
		