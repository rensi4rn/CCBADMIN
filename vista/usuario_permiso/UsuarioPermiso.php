<?php
/**
*@package pXP
*@file gen-UsuarioPermiso.php
*@author  (admin)
*@date 12-02-2015 14:36:49
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.UsuarioPermiso=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.UsuarioPermiso.superclass.constructor.call(this,config);
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
	      
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_usuario_permiso'
			},
			type:'Field',
			form:true 
		},
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
			config: {
				name: 'id_usuario_asignado',
				fieldLabel: 'Usuario',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_seguridad/control/Usuario/listarUsuario',
					id: 'id_usuario',
					root: 'datos',
					sortInfo: {
						field: 'cuenta',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_usuario', 'cuenta', 'desc_person'],
					remoteSort: true,
					baseParams: {par_filtro: 'cuenta'}
				}),
				valueField: 'id_usuario',
				displayField: 'cuenta',
				gdisplayField: 'desc_usuario',
				hiddenName: 'id_usuario_asignado',
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
					return String.format('{0}', record.data['desc_usuario']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'usu.cuenta', type: 'string'},
			grid: true,
			form: true
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
		},{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'usper.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'usper.usuario_ai',type:'string'},
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
				filters:{pfiltro:'usper.fecha_reg',type:'date'},
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
				filters:{pfiltro:'usper.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'usper.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Usuarios autorizados',
	ActSave:'../../sis_admin/control/UsuarioPermiso/insertarUsuarioPermiso',
	ActDel:'../../sis_admin/control/UsuarioPermiso/eliminarUsuarioPermiso',
	ActList:'../../sis_admin/control/UsuarioPermiso/listarUsuarioPermiso',
	id_store:'id_usuario_permiso',
	fields: [
		{name:'id_usuario_permiso', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'id_usuario_asignado', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_usuario'
		
	],
	sortInfo:{
		field: 'id_usuario_permiso',
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
		Phx.vista.UsuarioPermiso.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_casa_oracion').setValue(this.maestro.id_casa_oracion);	
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		