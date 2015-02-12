<?php
/**
*@package pXP
*@file gen-EstadoPeriodo.php
*@author  (admin)
*@date 24-02-2013 14:35:36
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.EstadoPeriodo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
		this.initButtons=[this.cmbGestion];
    	//llama al constructor de la clase padre
		Phx.vista.EstadoPeriodo.superclass.constructor.call(this,config);
		this.init();
		
		
		 //si la interface es pestanha este código es para iniciar 
	      var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData()
	      if(dataPadre){
	         this.onEnablePanel(this, dataPadre);
	      }
	      else
	      {
	         this.bloquearMenus();
	      }
	      
	   this.cmbGestion.on('select',this.capturaFiltros,this); 
	   
	   this.addButton('btnAtrib', {
				text : 'Abrir Gestión',
				iconCls : 'bchecklist',
				disabled : false,
				handler : this.onBtnAbrirGestion,
				tooltip : '<b>Abrir Gestión</b><br/>Al abrir la gestión se crearán todos los periodos'
		});
		  
	      
	},
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
	capturaFiltros:function(combo, record, index){
		this.store.baseParams.id_gestion=this.cmbGestion.getValue();
		this.store.load({params:{start:0, limit:250}});	
			
		
	},
	onButtonAct:function(){
		this.store.baseParams.id_gestion=this.cmbGestion.getValue();
		Phx.vista.EstadoPeriodo.superclass.onButtonAct.call(this);
	},		
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_estado_periodo'
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
				name: 'id_gestion',
				inputType:'hidden'
				
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'estado_periodo',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
			type:'TextField',
			filters:{pfiltro:'per.estado_periodo',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'num_mes',
				fieldLabel: '#num',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
			type:'NumberField',
			filters:{pfiltro:'per.num_mes',type:'numeric'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'mes',
				fieldLabel: 'Mes',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
			type:'TextField',
			filters:{pfiltro:'per.mes',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'fecha_ini',
				fieldLabel: 'Fecha Fin',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'per.fecha_ini',type:'date'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'fecha_fin',
				fieldLabel: 'Fecha Ini',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
						format: 'd/m/Y', 
						renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'per.fecha_fin',type:'date'},
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
			filters:{pfiltro:'per.estado_reg',type:'string'},
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
			filters:{pfiltro:'per.fecha_reg',type:'date'},
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
			filters:{pfiltro:'per.fecha_mod',type:'date'},
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
	
	title:'Periodo',
	ActSave:'../../sis_admin/control/EstadoPeriodo/insertarEstadoPeriodo',
	ActDel:'../../sis_admin/control/EstadoPeriodo/eliminarEstadoPeriodo',
	ActList:'../../sis_admin/control/EstadoPeriodo/listarEstadoPeriodo',
	id_store:'id_estado_periodo',
	fields: [
		{name:'id_estado_periodo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'estado_periodo', type: 'string'},
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'num_mes', type: 'numeric'},
		{name:'id_gestion', type: 'numeric'},
		{name:'fecha_fin', type: 'date',dateFormat:'Y-m-d'},
		{name:'mes', type: 'string'},
		{name:'fecha_ini',type: 'date',dateFormat:'Y-m-d '},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_estado_periodo',
		direction: 'ASC'
	},
	
	onBtnAbrirGestion:function(){
		
		
		var gestion = this.cmbGestion.getValue()
		
		if(gestion){
		
			Phx.CP.loadingShow();
			Ext.Ajax.request({
				
				url:'../../sis_admin/control/EstadoPeriodo/generarGestion',
				params:{'id_gestion': gestion,'id_casa_oracion':this.maestro.id_casa_oracion},
				success:this.successSinc,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
		}
		else{
			alert('seleccione una gestion primero')
			
		}
	},
	
	 successSinc:function(){
		Phx.CP.loadingHide();
		this.onButtonAct();
	}
	,
	onReloadPage:function(m)
	{
		this.maestro=m;						
		this.store.baseParams={id_casa_oracion:this.maestro.id_casa_oracion,id_gestion:this.cmbGestion.getValue()};
		this.load({params:{start:0, limit:50}});			
	},
	loadValoresIniciales:function()
	{
		Phx.vista.EstadoPeriodo.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_casa_oracion').setValue(this.maestro.id_casa_oracion);
		this.getComponente('id_gestion').setValue(this.cmbGestion.getValue());		
	},
	bdel:false,
	bsave:false,
	bnew:false,
	bedit:false
	}
)
</script>
		
		