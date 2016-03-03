<?php
/**
*@package pXP
*@file gen-CasaBanco.php
*@author  (admin)
*@date 02-03-2016 01:06:45
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CasaBanco=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.CasaBanco.superclass.constructor.call(this,config);
		this.init();
		
		
		
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
					name: 'id_casa_banco'
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
                anchor: '80%',
                width:200,
                gwidth:120,
                minChars:2
            },
            type:'ComboBox',
            bottom_filter: true,
            filters:{pfiltro:'tm.desc_tipo_movimiento',type:'string'},
            id_grupo:0,
            grid:true,
            form:true
        },
		{
            config:{
                name: 'id_cuenta_bancaria',
                fieldLabel: 'Cuenta Bancaria Pago',
                allowBlank: false,
                emptyText:'Elija una Cuenta...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_tesoreria/control/CuentaBancaria/listarCuentaBancaria',
                    id: 'id_cuenta_bancaria',
                    root:'datos',
                    sortInfo:{
                        field:'id_cuenta_bancaria',
                        direction:'ASC'
                    },
                    totalProperty:'total',
                    fields: ['id_cuenta_bancaria','nro_cuenta','nombre_institucion','codigo_moneda','centro','denominacion'],
                    remoteSort: true,
                    baseParams : {
						par_filtro :'nro_cuenta'
					}
                }),
                tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{nro_cuenta}</b></p><p>Moneda: {codigo_moneda}, {nombre_institucion}</p><p>{denominacion}, Centro: {centro}</p></div></tpl>',
                valueField: 'id_cuenta_bancaria',
                hiddenValue: 'id_cuenta_bancaria',
                displayField: 'nro_cuenta',
                gdisplayField:'desc_cuenta_bancaria',
                listWidth:'280',
                forceSelection:true,
                typeAhead: false,
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:20,
                queryDelay:500,
                gwidth: 250,
                anchor: '80%',
                minChars:2,
                renderer:function(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
             },
            type:'ComboBox',
            filters:{pfiltro:'cb.nro_cuenta',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		
		{
			config:{
				name: 'obs',
				fieldLabel: 'Observaciones',
				allowBlank: true,
				anchor: '80%',
				gwidth: 250
			},
				type:'TextArea',
				filters:{pfiltro:'cob.obs',type:'string'},
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
				filters:{pfiltro:'cob.estado_reg',type:'string'},
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
				filters:{pfiltro:'cob.fecha_reg',type:'date'},
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
				filters:{pfiltro:'cob.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'cob.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'cob.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Cuentas Bancarias',
	ActSave:'../../sis_admin/control/CasaBanco/insertarCasaBanco',
	ActDel:'../../sis_admin/control/CasaBanco/eliminarCasaBanco',
	ActList:'../../sis_admin/control/CasaBanco/listarCasaBanco',
	id_store:'id_casa_banco',
	fields: [
		{name:'id_casa_banco', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_casa_oracion', type: 'numeric'},
		{name:'id_tipo_movimiento', type: 'numeric'},
		{name:'obs', type: 'string'},
		{name:'id_cuenta_bancaria', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		'desc_cuenta_bancaria','desc_tipo_movimiento'
		
	],
	sortInfo:{
		field: 'id_casa_banco',
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
		Phx.vista.CasaBanco.superclass.loadValoresIniciales.call(this);
		this.getComponente('id_casa_oracion').setValue(this.maestro.id_casa_oracion);	
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		