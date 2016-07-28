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
Phx.vista.RegionEvento=Ext.extend(Phx.gridInterfaz,{
	constructor:function(config){
		this.maestro=config.maestro;
		//llama al constructor de la clase padre
		Phx.vista.RegionEvento.superclass.constructor.call(this,config);
		this.store.load({params:{start:0, limit:250}});
		this.iniciarEventos();
		
	},
	
	iniciarEventos:function(){
	     this.Cmp.id_region.on('select', function(combo, record, index){ 
            	
            	this.Cmp.id_casa_oracion.reset();
            	this.Cmp.id_casa_oracion.store.baseParams.id_region = this.Cmp.id_region.getValue();
            	this.Cmp.id_casa_oracion.modificado = true;
            	this.Cmp.id_casa_oracion.enable();
            	
            	
            }, this);
            
          this.Cmp.id_gestion.on('select', function(combo, record, index){ 
            	this.Cmp.fecha_programada.reset();
            	
                this.Cmp.fecha_programada.setMaxValue('31/12/' + record.data.gestion);
                this.Cmp.fecha_programada.setMinValue('01/01/' + record.data.gestion);
                console.log('setea datos..... ', record.data.gestion)
             }, this);  
            
            
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
					name: 'tipo_registro'
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
				gdisplayField:'desc_gestion',
				hiddenName: 'id_gestion',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:200,
				gwidth:100,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_gestion']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'ges.gestion',type:'string'},
			id_grupo:1,
			bottom_filter: true,
			grid:true,
			form:true
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
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true
		},
		
		{
	       		config:{
	       			name:'desc_lugar',
	       			fieldLabel:'Municipio'
	       		},
	       		type:'Field',
	       		bottom_filter: true,
	       		filters:{pfiltro:'lug.nombre',type:'string'},
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
                gdisplayField:'desc_casa_oracion',
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
			filters:{pfiltro:'co.nombre',type:'string'},
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
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_evento',
				displayField: 'nombre',
				gdisplayField:'desc_evento',
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
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_evento']);}
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
				gwidth: 180,
				format: 'd/m/Y', 
				renderer:function (value,p,record){
					 var days = ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
					     sday = days[value.getDay()],
					     sdate = value?value.dateFormat('d/m/Y'):'';
					 
   
                     return String.format('{0}  ({1})', sdate,  sday);
 					
					}
			},
			type:'DateField',
			filters:{pfiltro:'rege.fecha_programada',type:'date'},
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
                name: 'id_obrero',
                fieldLabel: 'Atiende',
                qtip: 'Obrero que atiende el evento',
                allowBlank: true,
                forceSelection : true,
                emptyText:'Atiende ...',
                store: new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/Obrero/listarObrero',
                    id: 'id_obrero',
                    root: 'datos',
                    sortInfo:{
                        field: 'desc_persona',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_obrero','desc_persona','desc_tipo_ministerio',
							'desc_casa_oracion','id_casa_oracion','desc_region',
							'telefono1','telefono2','celular1','correo'],
                    // turn on remote sorting
                    remoteSort: true,
                   // baseParams:{par_filtro:'per.nombre_completo1',codigo_ministerio:"''anciano'',''cooperador'',''diacono''"}
                    baseParams:{par_filtro:'per.nombre_completo1'}
                }),
                valueField: 'id_obrero',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{desc_persona}</b></p><p>{desc_tipo_ministerio}</p><p>{desc_casa_oracion}</p> </div></tpl>',
				displayField: 'desc_persona',
                gdisplayField:'desc_obrero',
                hiddenName: 'id_obrero',
                triggerAction: 'all',
                lazyRender:true,
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:210,
                gwidth:220,
                minChars:2
            },
            type:'ComboBox',
            bottom_filter: true,
            filters:{pfiltro:'ob.nombre_completo1',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
			config:{
				name: 'obs',
				fieldLabel: 'Obs',
				anchor: '100%',
				qtip: 'si existen figuran en el reporte',
				allowBlank: true,
				gwidth: 100
			},
			type: 'TextArea',
			filters: { pfiltro:'rege.obs', type:'string' },
			id_grupo: 1,
			grid: true,
			form: true
		},
        {
			config:{
				name: 'obs2',
				fieldLabel: 'Obs2',
				anchor: '100%',
				qtip: 'no entran en reportes, solo a modo de recordatorio',
				allowBlank: true,
				increment: 30,
				gwidth: 100
			},
			type: 'TextArea',
			filters: { pfiltro:'rege.obs2', type:'string' },
			id_grupo: 1,
			grid: true,
			form: true
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
			filters:{pfiltro:'rege.estado_reg',type:'string'},
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
			filters:{pfiltro:'rege.fecha_reg',type:'date'},
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
			filters:{pfiltro:'rege.fecha_mod',type:'date'},
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
	
	title:'Eventos por Región',
	ActSave:'../../sis_admin/control/RegionEvento/insertarRegionEvento',
	ActDel:'../../sis_admin/control/RegionEvento/eliminarRegionEvento',
	ActList:'../../sis_admin/control/RegionEvento/listarRegionEvento',
	id_store:'id_region_evento',
	fields: [
		{name:'id_region_evento', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_gestion', type: 'numeric'},
		{name:'fecha_programada', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_evento', type: 'numeric'},
		{name:'estado', type: 'string'},
		{name:'id_region', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},'tipo_registro',
		'hora','desc_gestion','desc_evento','desc_region','desc_casa_oracion',
		'id_casa_oracion','id_obrero','desc_obrero','obs','obs2','desc_lugar'
	],
	
	sortInfo:{
		field: 'id_region_evento',
		direction: 'ASC'
	},
	south:{
		  url:'../../../sis_admin/vista/detalle_evento/DetalleEvento.php',
		  title:'Detalle', 
		  height:'50%',
		  cls:'DetalleEvento'
	},
	bdel:true,
	bsave:true
	}
)
</script>	