<?php
/**
*@package pXP
*@file gen-CbtePeriodo.php
*@author  (admin)
*@date 28-02-2016 13:24:52
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CbtePeriodo=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CbtePeriodo.superclass.constructor.call(this,config);
		this.init();	
		this.bloquearMenus();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_cbte_periodo'
			},
			type:'Field',
			form:true 
		},
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
			config: {
				name: 'id_tipo_cbte',
				fieldLabel: 'Tipo Cbte',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_admin/control/TipoCbte/listarTipoCbte',
					id: 'id_',
					root: 'datos',
					sortInfo: {
						field: 'descripcion',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: [
						{name:'id_tipo_cbte', type: 'numeric'},
						{name:'descripcion', type: 'string'},
						{name:'estado_reg', type: 'string'},
						{name:'codigo', type: 'string'},
						{name:'id_usuario_ai', type: 'numeric'},
						{name:'id_usuario_reg', type: 'numeric'},
						{name:'usuario_ai', type: 'string'},
						{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
						{name:'id_usuario_mod', type: 'numeric'},
						{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
						{name:'usr_reg', type: 'string'},
						{name:'usr_mod', type: 'string'}
						
					],
					remoteSort: true,
					baseParams: {par_filtro: 'descripcion#codigo'}
				}),
				valueField: 'id_tipo_cbte',
				displayField: 'descripcion',
				gdisplayField: 'desc_tipo_cbte',
				hiddenName: 'id_tipo_cbte',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_tipo_cbte']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'descripcion',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'id_int_comprobante',
				fieldLabel: 'CBTE',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
			type:'TextField',
			filters:{pfiltro:'cbp.estado_reg',type:'string'},
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
				filters:{pfiltro:'cbp.estado_reg',type:'string'},
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
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
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
				filters:{pfiltro:'cbp.fecha_reg',type:'date'},
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
				filters:{pfiltro:'cbp.fecha_mod',type:'date'},
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
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'cbp.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'cbp.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'CBTE',
	ActSave:'../../sis_admin/control/CbtePeriodo/insertarCbtePeriodo',
	ActDel:'../../sis_admin/control/CbtePeriodo/eliminarCbtePeriodo',
	ActList:'../../sis_admin/control/CbtePeriodo/listarCbtePeriodo',
	id_store:'id_cbte_periodo',
	fields: [
		{name:'id_cbte_periodo', type: 'numeric'},
		{name:'id_estado_periodo', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_tipo_cbte', type: 'numeric'},
		{name:'id_int_comprobante', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_tipo_cbte','nro_cbte'
		
	],
	sortInfo:{
		field: 'id_cbte_periodo',
		direction: 'ASC'
	},
	
	onReloadPage:function(m){
		this.maestro=m;
		this.store.baseParams={id_estado_periodo:this.maestro.id_estado_periodo};
		this.load({params:{start:0, limit:50}})
		
	},
	loadValoresIniciales:function(){
		Phx.vista.CbtePeriodo.superclass.loadValoresIniciales.call(this);
		this.Cmp.id_estado_periodo.setValue(this.maestro.id_estado_periodo);		
	},
	
	bedit: false,
	bdel:false,
	bsave:true
	}
)
</script>
		
		