<?php
/**
*@package pXP
*@file gen-Culto.php
*@author  (admin)
*@date 24-02-2013 14:06:12
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Culto=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Culto.superclass.constructor.call(this,config);
		this.init();
		this.bloquearMenus();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_culto'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'id_casa_oracion',
				inputType:'hidden'
			},
			type:'Field',
			form:true 
		},
		{
	       		config:{
	       			name:'tipo_culto',
	       			fieldLabel:'Tipo Culto',
	       			allowBlank:false,
	       			emptyText:'Tipo...',
	       			typeAhead: true,
	       		    triggerAction: 'all',
	       		    lazyRender:true,
	       		    mode: 'local',
	       		    store:['Jovenes','Mayores','Mixto']
	       		},
	       		type:'ComboBox',
	       		id_grupo:0,
	       		filters:{	
	       		         type: 'list',
	       				 options: ['Jovenes','Mayores','Mixto']
	       		 	},
	       		grid:true,
	       		form:true
	       	},
		{
	       		config:{
	       			name:'dia',
	       			fieldLabel:'DIa',
	       			allowBlank:false,
	       			emptyText:'Dia...',
	       			typeAhead: true,
	       		    triggerAction: 'all',
	       		    lazyRender:true,
	       		    mode: 'local',
	       		    store:['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo']
	       		},
	       		type:'ComboBox',
	       		id_grupo:0,
	       		filters:{	
	       		         type: 'list',
	       				 options: ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo']	
	       		 	},
	       		grid:true,
	       		form:true
	       	},
		{
			config:{
				name: 'hora',
				fieldLabel: 'hora',
				allowBlank: true,
				minValue: '8:00 AM',
                maxValue: '11:00 PM',
                increment: 30,
				gwidth: 100,
				format: 'H:i:s'
			},
			type:'TimeField',
			filters:{pfiltro:'cul.hora',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'cul.estado_reg',type:'string'},
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
			filters:{pfiltro:'cul.fecha_reg',type:'date'},
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
			filters:{pfiltro:'cul.fecha_mod',type:'date'},
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
	
	title:'Cultos',
	ActSave:'../../sis_admin/control/Culto/insertarCulto',
	ActDel:'../../sis_admin/control/Culto/eliminarCulto',
	ActList:'../../sis_admin/control/Culto/listarCulto',
	id_store:'id_culto',
	fields: [
		{name:'id_culto', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'dia', type: 'string'},
		{name:'hora', type: 'string'},
		{name:'tipo_culto', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_culto',
		direction: 'ASC'
	},
	
	
	onReloadPage:function(m)
	{
		this.maestro=m;						
		this.store.baseParams={id_casa_oracion:this.maestro.id_casa_oracion};
		this.load({params:{start:0, limit:50}});			
	},
	loadValoresIniciales:function()
	{
		Phx.vista.Culto.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_casa_oracion').setValue(this.maestro.id_casa_oracion);		
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		