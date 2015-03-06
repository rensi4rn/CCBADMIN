<?php
/**
*@package pXP
*@file gen-TipoMinisterio.php
*@author  (admin)
*@date 05-01-2013 07:25:26
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.TipoMinisterio=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.TipoMinisterio.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:50}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_tipo_ministerio'
			},
			type:'Field',
			form:true 
		},
		{
	       		config:{
	       			name:'tipo',
	       			fieldLabel:'Tipo',
	       			allowBlank:false,
	       			emptyText:'Tipo...',
	       			
	       			typeAhead: true,
	       		    triggerAction: 'all',
	       		    lazyRender:true,
	       		    mode: 'local',
	       		    //readOnly:true,
	       		   // valueField: 'estilo',
	       		   // displayField: 'descestilo',
	       		    store:['administracion','espiritual','musical','hermandad']
	       		    
	       		},
	       		type:'ComboBox',
	       		id_grupo:1,
	       		filters:{	
	       			 type: 'list',
	       		         pfiltro: 'tipmi.tipo',
	       				 options: ['administracion','espiritual','musical','Hermandad']	
	       		 	},
	       		grid:true,
	       		form:true
	       },
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Código',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				egrid:true,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'tipmi.codigo',type:'string'},
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
			filters:{pfiltro:'tipmi.nombre',type:'string'},
			id_grupo:1,
			egrid:true,
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
			filters:{pfiltro:'tipmi.estado_reg',type:'string'},
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
			filters:{pfiltro:'tipmi.fecha_reg',type:'date'},
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
			filters:{pfiltro:'tipmi.fecha_mod',type:'date'},
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
	title:'Tipos de Ministerio',
	ActSave:'../../sis_admin/control/TipoMinisterio/insertarTipoMinisterio',
	ActDel:'../../sis_admin/control/TipoMinisterio/eliminarTipoMinisterio',
	ActList:'../../sis_admin/control/TipoMinisterio/listarTipoMinisterio',
	id_store:'id_tipo_ministerio',
	fields: [
		{name:'id_tipo_ministerio', type: 'numeric'},
		{name:'tipo', type: 'string'},
		{name:'nombre', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'fecha_reg', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date', dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'codigo'
		
	],
	sortInfo:{
		field: 'id_tipo_ministerio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		