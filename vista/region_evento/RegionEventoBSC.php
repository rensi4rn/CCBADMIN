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
Phx.vista.RegionEventoBSC=Ext.extend(Phx.gridInterfaz,{
	constructor:function(config){
		this.maestro=config.maestro;
		//llama al constructor de la clase padre
		Phx.vista.RegionEventoBSC.superclass.constructor.call(this,config);
		this.init();
        this.store.baseParams={tipo_registro:'detalle'}; 
        this.load({params:{start:0, limit:this.tam_pag}});
		this.iniciarEventos();
	},
	
	iniciarEventos:function(){
	     
            
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
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_detalle_evento_hermano'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_detalle_evento_hermana'
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
				gdisplayField:'gestion',
				hiddenName: 'id_gestion',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:200,
				gwidth:70,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['gestion']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'eve.gestion',type:'string'},
			id_grupo:1,
			bottom_filter: true,
			grid:true,
			form:false
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
				gdisplayField:'nombre_region',
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
				renderer:function (value, p, record){return String.format('{0}', record.data['nombre_region']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'eve.nombre_region',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:false
		},
		
		{
			config: {
				name: 'id_casa_oracion',
                fieldLabel: 'Casa de Oración',
                allowBlank: false,
                emptyText:'Casa...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/CasaOracion/listarCasaOracion',
                    id: 'id_casa_oracion',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_casa_oracion','codigo','nombre','desc_lugar','desc_region'],
                    // turn on remote sorting
                    remoteSort: true,    
                    baseParams:{par_filtro:'caor.nombre#reg.nombre#reg.nombre'}
                
                }),
                valueField: 'id_casa_oracion',
                displayField: 'nombre',
                gdisplayField:'nombre_co',
                hiddenName: 'id_casa_oracion',
                triggerAction: 'all',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{nombre}</p><p>{desc_lugar} - {desc_region}</p> </div></tpl>',
				
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:210,
                minChars:2
            },
			type:'ComboBox',
			filters:{pfiltro:'eve.nombre_co',type:'string'},
			bottom_filter: true,
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
					baseParams:{par_filtro:'nombre',filtro_evento:'bsc'}
				}),
				valueField: 'id_evento',
				displayField: 'nombre',
				gdisplayField:'nombre',
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
				renderer:function (value, p, record){return String.format('{0}', record.data['nombre']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'eve.nombre',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true 
		},
		{
			config:{
				name: 'fecha_programada',
				fieldLabel: 'Fecha',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
			type:'DateField',
			filters:{pfiltro:'eve.fecha_programada',type:'date'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'hora',
				fieldLabel: 'hora',
				allowBlank: false,
				minValue: '8:00 AM',
                maxValue: '11:00 PM',
                increment: 30,
				gwidth: 100,
				format: 'H:i:s'
			},
			type: 'TimeField',
			filters: { pfiltro:'rege.hora', type:'string' },
			id_grupo: 1,
			grid: true,
			form: true
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
	       		bottom_filter: true,
	       		grid:true,
	       		form:true
	     },
		
		{
			config:{
				name: 'cantidad_hermano',
				fieldLabel: 'Hermanos',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:3
			},
			type:'NumberField',
			filters:{pfiltro:'eve.cantidad_hermano',type:'numeric'},
			id_grupo:1,
			grid:true,
			egrid:true,
			form:true
		},
		
		{
			config:{
				name: 'cantidad_hermana',
				fieldLabel: 'Hermanas',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:3
			},
			type:'NumberField',
			filters:{pfiltro:'eve.cantidad_hermana',type:'numeric'},
			id_grupo:1,
			grid:true,
			egrid:true,
			form:true
		},
	],
	
	title:'Eventos por Región',
	ActSave:'../../sis_admin/control/RegionEvento/insertarBautizoSantaCena',
	ActDel:'../../sis_admin/control/RegionEvento/eliminarBautizoSantaCena',
	ActList:'../../sis_admin/control/RegionEvento/listarBautizoSantaCena',
	id_store:'id_region_evento',
	fields: [
				{name:'fecha_programada', type: 'date',dateFormat:'Y-m-d'},
			    'estado',
			    'id_region_evento',
			    'id_casa_oracion',
			    'id_region',
			    'nombre_region',
			    'nombre_co',
			    'cantidad_hermano',
			    'cantidad_hermana',
			    'id_gestion',
			    'gestion',
			    'id_detalle_evento_hermano',
			    'id_detalle_evento_hermana',
			    'id_evento',
			    'codigo',
			    'nombre',
			    'hora'
		
	],
	
	sortInfo:{
		field: 'fecha_programada',
		direction: 'DESC'
	},
	bdel:true,
	bsave:true
	}
)
</script>	