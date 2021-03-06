<?php
/**
*@package pXP
*@file    SolModPresupuesto.php
*@author  Rensi Arteaga Copari 
*@date    30-01-2014
*@description permites subir archivos a la tabla de documento_sol
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.RepSaldos=Ext.extend(Phx.frmInterfaz,{
	autoScroll: true,
    constructor:function(config)
    {   
    	this.panelResumen = new Ext.Panel({  
    		    padding: '0 0 0 20',
    		    html: 'Hola Prueba',
    		    split: true, 
    		    layout:  'fit' });
    		    
    	this.Grupos = [{

	                    xtype: 'fieldset',
	                        border: false,
	                        layout: 'column',
	                        region: 'north',
	                        collapseFirst : false,
	                        width: '100%',
	                    items: [
			                    {
		
			                    xtype: 'fieldset',
			                    border: false,
			                    collapsible: true,
			                    autoScroll: true,
			                    layout: 'form',
			                    padding: '0 20 0 10',
			                    split: true,
			                    items: [],
			                    id_grupo: 0
						      },
						      this.panelResumen
	                    
	                    ]
				               
				    }
				    ];
				    
        Phx.vista.RepSaldos.superclass.constructor.call(this,config);
        this.init(); 
        this.iniciarEventos();   
       
        
        
    },
    
    Atributos:[
           
		{
				config:{
					name: 'fecha',
					fieldLabel: 'A la fecha',
					allowBlank: false,
					format: 'd/m/Y',
					width: 150
				},
				type: 'DateField',
				id_grupo: 0,
				form: true
		},
		{
			config:{
				name: 'id_lugar',
				fieldLabel: 'Lugar',
				allowBlank: true,
				forceSelection : true,
				emptyText:'Lugar...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_parametros/control/Lugar/listarLugar',
					id: 'id_lugar',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_lugar','id_lugar_fk','codigo','nombre','tipo','sw_municipio','sw_impuesto','codigo_largo'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre'}
				}),
				valueField: 'id_lugar',
				displayField: 'nombre',
				gdisplayField:'desc_lugar',
				hiddenName: 'id_lugar',
    			triggerAction: 'all',
    			lazyRender:true,
				mode:'remote',
				pageSize:50,
				queryDelay:500,
				listWidth:'280',
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_lugar']);}
			},
			type:'ComboBox',
			filters:{pfiltro:'lug.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config:{
				name: 'id_region',
				fieldLabel: 'Region',
				allowBlank: true,
				forceSelection : true,
				emptyText:'Region...',
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
			id_grupo:1,
			grid:true,
			form:true
		},
		{
			config: {
				name: 'id_casa_oracion',
                fieldLabel: 'Casa de Oración',
                allowBlank: true,
                forceSelection : true,
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
			
		},{
            config:{
                name: 'id_tipo_movimiento',
                fieldLabel: 'Colecta de',
                allowBlank: true,
                forceSelection : true,
                emptyText:'Tipo de colecta...',
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
                width:200,
                gwidth:120,
                minChars:2
            },
            type:'ComboBox',
            filters:{pfiltro:'mov.desc_tipo_movimiento',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                name: 'id_obrero',
                fieldLabel: 'Obrero',
                qtip: 'Hermano que lleva la colecta (cuando la entregue al tesorero el estado debe cambiar a entregado)',
                allowBlank: true,
                forceSelection : true,
                emptyText:'Obrero...',
                store:new Ext.data.JsonStore(
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
                    baseParams:{par_filtro:'per.nombre_completo1'}
                }),
                valueField: 'id_obrero',
                tpl:'<tpl for="."><div class="x-combo-list-item"><p>{desc_persona}</p><p>{desc_tipo_ministerio}</p><p>{desc_casa_oracion}</p> </div></tpl>',
				
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
            filters:{pfiltro:'mov.desc_obrero',type:'string'},
            id_grupo:1,
            grid:true,
            form:true
        },
        {
            config:{
                    name:'id_ot',
                    fieldLabel: 'Objetivo (OT)',
                    qtip: 'Si las colecta tiene un objetivo es especifico',
                    sysorigen:'sis_contabilidad',
	       		    origen:'OT',
                    allowBlank:true,
                    gwidth:200,
                     width:210,
   				    listWidth: 350,
                    renderer:function(value, p, record){return String.format('{0}', record.data['desc_orden']);}
            
            },
            type:'ComboRec',
            id_grupo:0,
            filters:{pfiltro:'mov.desc_orden',type:'string'},
            grid:true,
            form:true
        },
		  

    ],
    labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
    
    title: 'Filtro de mayores',
    // Funcion guardar del formulario
    onSubmit: function(o) {
    	var me = this;
    	if (me.form.getForm().isValid()) {

             var parametros = me.getValForm()
             
             console.log('parametros ....', parametros);
             Phx.CP.loadingShow(); 
			 Ext.Ajax.request({
				
				url:'../../sis_admin/control/Movimiento/calcularSaldos',
				params: parametros,
				success:this.successSinc,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
             
                    
        }

    },
    successSinc :function(resp){
       Phx.CP.loadingHide();
       var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        if (reg.ROOT.error) {
            alert('error al procesar');
            return
       } 
       console.log(reg);
       var deco = reg.ROOT.datos,
       	   plantilla = "<div style='overflow-y: initial;'><br><b>CUENTA DEL PRIMER DIA DEL AÑO  A LA FECHA SEÑALADA</b><br><p> \
       					Ingreso  Inicial  considera:  el saldo en adminsitración + saldo por rendir,  al 31 de diciembre de la gestion anterior </br>\
       					Ingreso  Inicial: {0} </br>\
						<b>Ingreso por Colectas: {1}</b></br>\
						Ingreso por Devolucion: {2}</br>\
						Ingreso por Traspasos: {3}</br>\
						Ingreso Total =  (Ingreso por Traspasos) + (Ingreso por colectas) + (Ingreso  Inicial)</br>\
						Ingreso Total: {4}</br></br>\
						Egresos por operación: {5}</br>\
						Egresos inicial por rendir: {6}</br>\
						Egresos contra rendición: {7}</br>\
						Rendiciones: {8}</br>\
						Egresos por Traspaso: {9}</br></br>\
						Egreso Efectivo = (Egresos por operación) + (Rendiciones)</br>\
						<b>Egreso Efectivo: {10}</br></b></br>\
						Saldo en efectivo =  (Ingreso Total) - (Egreso Efectivo) - (Egresos por Traspaso)</br>\
						Saldo en efectivo: {11}</br></br>\
						Saldo en la administración =  (Ingreso Total)  + (Ingreso por Devolución) - (Egresos por Traspaso) - (Egresos por operación) - (Egresos contra rendición)- (Egresos inicial por rendir)</br>\
						<b>Saldo en la administración: {12}</b></br></br>\
						Saldo por Rendir =  (Egresos inicial por rendir) + (Egresos contra rendición)  - (Rendiciones) - (devoluciones)</br>\
						Saldo por Rendir: {13}</br></br></div>";
       
	   this.panelResumen.update( String.format(plantilla,
	                                           deco.v_ingreso_inicial, 
	                                           deco.v_ingreso_colectas,
	                                           deco.v_ingreso_devolucion,
	                                           deco.v_ingreso_traspasos,
	                                           deco.v_ingreso_total,
	                                           deco.v_egreso_operacion ,
	                                           deco.v_egreso_inicial_por_rendir,
	                                           deco.v_egresos_contra_rendicion,
	                                           deco.v_egresos_rendidos,
	                                           deco.v_egreso_traspaso,
	                                           deco.v_egreso_efectivo,
	                                           deco.v_saldo_efectivo,
	                                           deco.v_saldo_adm,
	                                           deco.v_sado_x_rendir
	                                           
	                                           ));
	},
    iniciarEventos: function(){
    	
    }
    
    
})    
</script>