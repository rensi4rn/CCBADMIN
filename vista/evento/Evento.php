<?php
/**
*@package pXP
*@file gen-Evento.php
*@author  (admin)
*@date 05-01-2013 08:03:46
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Evento=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Evento.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:50}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_evento'
			},
			type:'Field',
			form:true  
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'even.codigo',type:'string'},
			id_grupo:1,
			egrid:true,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'even.nombre',type:'string'},
			id_grupo:1,
			egrid:true,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:400
			},
			type:'TextArea',
			filters:{pfiltro:'even.descripcion',type:'string'},
			id_grupo:1,
			egrid:true,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'prioridad',
				fieldLabel: 'Prioridad',
				allowBlank: false,
				allowNegative: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'even.prioridad',type:'string'},
			id_grupo:1,
			egrid: true,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'nacional',
				fieldLabel: 'Nacional',
				qtip: 'los eventos nacionales tienen la opción de aparecer en reportes que no son de su región',
				allowBlank: false,
				anchor: '40%',
				gwidth: 50,
				maxLength:2,
				emptyText:'si/no...',       			
       			typeAhead: true,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    valueField: 'inicio',       		    
       		    store:['si','no']
			},
			type:'ComboBox',
			id_grupo:1,
			filters:{	
	       		         type: 'list',
	       				 pfiltro:'tipes.inicio',
	       				 options: ['si','no'],	
	       		 	},
			grid:true,
			form:true
		},
		{
			config:{
				name: 'color',
				fieldLabel: 'Color',
				qtip: 'Color apra reportes',
				allowBlank: false,
				anchor: '40%',
				gwidth: 50,				
				emptyText:'si/no...',       			
       			typeAhead: true,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    valueField: 'inicio',       		    
       		    store:['defecto','rojo','azul','verde']
			},
			type:'ComboBox',
			id_grupo:1,
			filters:{	
	       		         type: 'list',
	       				 pfiltro:'tipes.inicio',
	       				 options: ['defecto','rojo','azul','verde'],	
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
			filters:{pfiltro:'even.estado_reg',type:'string'},
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
			filters:{pfiltro:'even.fecha_reg',type:'date'},
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
			filters:{pfiltro:'even.fecha_mod',type:'date'},
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
	title:'Tipo de Eventos',
	ActSave:'../../sis_admin/control/Evento/insertarEvento',
	ActDel:'../../sis_admin/control/Evento/eliminarEvento',
	ActList:'../../sis_admin/control/Evento/listarEvento',
	id_store:'id_evento',
	fields: [
		{name:'id_evento', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'fecha_reg', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'codigo','prioridad','nacional','color'
		
	],
	sortInfo:{
		field: 'id_evento',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		