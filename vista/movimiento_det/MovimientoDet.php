<?php
/**
*@package pXP
*@file gen-MovimientoDet.php
*@author  (admin)
*@date 25-03-2013 02:03:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.MovimientoDet=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.MovimientoDet.superclass.constructor.call(this,config);
		this.init();
		
		
		this.grid.on('beforeedit',
		function(o){
		    if(o.record.data.desc_tipo_movimiento=='Total'){
		        return false;
		    }},this);
		
		
		this.grid.on('afteredit',
           function(o){
           valor = o.value - o.originalValue;
            this.store.getById(10000).set('monto', (this.store.getById(10000).data.monto)*1+valor);
         },this);
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_movimiento_det'
			},
			type:'Field',
			form:true 
		},
        {
            config:{
                name: 'id_movimiento',
                fieldLabel: 'id_movimiento',
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
                emptyText:'Lugar...',
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
                width:210,
                gwidth:220,
                minChars:2,
                renderer:function (value, p, record){
                    
                    if (record.data['desc_tipo_movimiento']=='Total'){
                        
                         return String.format('<b>{0}</b>', record.data['desc_tipo_movimiento']);
                        
                    }
                    else{
                          return String.format('{0}', record.data['desc_tipo_movimiento']);
                        }
                    }
            },
            type:'ComboBox',
            filters:{pfiltro:'tm.nombre',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
		{
			config:{
				name: 'monto',
				fieldLabel: 'Monto',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				minValue :0,
				maxLength:1245186,
				 renderer:function (value, p, record){
                    
                    if (record.data['desc_tipo_movimiento']=='Total'){
                        
                         return String.format('<b>{0}</b>', value);
                        
                    }
                    else{
                          return String.format('{0}', value);
                        }
                    }
			},
			type:'NumberField',
			filters:{pfiltro:'movd.monto',type:'numeric'},
			id_grupo:1,
			grid:true,
			egrid:true,
			form:true
		},
        {
            config:{
                name: 'estado_reg',
                fieldLabel: 'Estado Reg.',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10,
                renderer:function (value, p, record){
                    
                    if (record.data['desc_tipo_movimiento']=='Total'){
                        
                         return String.format('<b>{0}</b>', value);
                        
                    }
                    else{
                          return String.format('{0}', value);
                        }
                    }
            },
            type:'TextField',
            filters:{pfiltro:'movd.estado_reg',type:'string'},
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
			filters:{pfiltro:'movd.fecha_reg',type:'date'},
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
			filters:{pfiltro:'movd.fecha_mod',type:'date'},
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
	
	title:'Detalle de Movimiento',
	ActSave:'../../sis_admin/control/MovimientoDet/insertarMovimientoDet',
	ActDel:'../../sis_admin/control/MovimientoDet/eliminarMovimientoDet',
	ActList:'../../sis_admin/control/MovimientoDet/listarMovimientoDet',
	id_store:'id_movimiento_det',
	fields: [
		{name:'id_movimiento_det', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_movimiento', type: 'numeric'},
		{name:'monto', type: 'numeric'},
		{name:'id_tipo_movimiento', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'desc_tipo_movimiento'
		
	],
	sortInfo:{
		field: 'id_movimiento_det',
		direction: 'ASC'
	},
	loadValoresIniciales:function()
    {
        
        this.getComponente('id_movimiento').setValue(this.maestro.id_movimiento);
        Phx.vista.MovimientoDet.superclass.loadValoresIniciales.call(this);
    },
	
	onReloadPage:function(m){
       this.maestro=m;
       this.store.baseParams={id_movimiento:this.maestro.id_movimiento};
       this.getComponente('id_movimiento').setValue(this.maestro.id_movimiento);
        this.load({params:{start:0, limit:50}});
       
    },
    preparaMenu:function(n){
      var data = this.getSelectedData();
      var tb =this.tbar;
       
        Phx.vista.MovimientoDet.superclass.preparaMenu.call(this,n);
       
        if(data['desc_tipo_movimiento']==  'Total'){
               this.getBoton('edit').disable(); 
        }
        return tb 
     },
    
	
	bdel:true,
	bsave:true
	}
)
</script>
		
		