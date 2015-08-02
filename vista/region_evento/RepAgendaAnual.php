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
Phx.vista.RepAgendaAnual=Ext.extend(Phx.frmInterfaz,{
    constructor:function(config)
    {   
    	this.panelResumen = new Ext.Panel({html:'', autoHeight  : true, layout: 'fit'});
    	this.Grupos = [{

	                    xtype: 'fieldset',
	                    border: false,
	                    autoScroll: true,
	                    layout: 'form',
	                    items: [],
	                    id_grupo: 0
				               
				    },
				     this.panelResumen
				    ];
				    
        Phx.vista.RepAgendaAnual.superclass.constructor.call(this,config);
        this.init(); 
        
       
        
    },
    
    Atributos:[
           
		{
				config:{
					name: 'desde',
					fieldLabel: 'Desde',
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
					name: 'hasta',
					fieldLabel: 'Hasta',
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
				name: 'id_regiones',
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
					baseParams:{par_filtro:'nombre',_adicionar:'todos'}
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
				 enableMultiSelect: true,
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_region']);}
			},
			type:'AwesomeCombo',
			filters:{pfiltro:'reg.nombre',type:'string'},
			id_grupo:1,
			grid:true,
			form:true
		},	
		{
			config:{
				name: 'id_eventos',
				fieldLabel: 'Evento',
				allowBlank: true,
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
				enableMultiSelect: true,
				width:210,
				gwidth:220,
				minChars:2,
				renderer:function (value, p, record){return String.format('{0}', record.data['desc_evento']);}
			},
			type:'AwesomeCombo',
			filters:{pfiltro:'eve.nombre',type:'string'},
			bottom_filter: true,
			id_grupo:1,
			grid:true,
			form:true 
		}
		
		
		  

    ],
    labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
    
    title: 'Reporte de Agenda',
    // Funcion guardar del formulario
    onSubmit: function(o) {
    	var me = this;
    	if (me.form.getForm().isValid()) {

             var parametros = me.getValForm()
             
             console.log('parametros ....', parametros);
             Phx.CP.loadingShow(); 
			 Ext.Ajax.request({
				
				url:'../../sis_admin/control/RegionEvento/reporteAgendaAnual',
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
       
       var nomRep = reg.ROOT.detalle.archivo_generado;
        if(Phx.CP.config_ini.x==1){  			
        	nomRep = Phx.CP.CRIPT.Encriptar(nomRep);
        }
        window.open('../../../lib/lib_control/Intermediario.php?r='+nomRep+'&t='+new Date().toLocaleTimeString())
	}
    
    
})    
</script>