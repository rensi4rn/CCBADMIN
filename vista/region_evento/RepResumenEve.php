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
Phx.vista.RepResumenEve=Ext.extend(Phx.frmInterfaz,{
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
				    
        Phx.vista.RepResumenEve.superclass.constructor.call(this,config);
        this.init(); 
        
        this.Cmp.tipo_imp.setValue('consolidado');
        
        
    },
    
    Atributos:[
           
		
		{
				config:{
					name: 'hasta',
					fieldLabel: 'Al',
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
                name: 'tipo_evento',
                fieldLabel: 'Tipo',
                allowBlank: false,
                qtip:' Bautismos  o Santas Cenas',
                emptyText:'evento ...',
                store:new Ext.data.ArrayStore({
                            fields: ['variable', 'valor'],
                            data : [  ['bautizo','Bautismos'],
                                      ['santacena','Santas Cenas']]
                                    }),
                valueField: 'variable',
                value:'bautizo',
                displayField: 'valor',
                forceSelection: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                width:210,
            },
            type:'ComboBox',
            valorInicial:'bautizo',
            form:true
        },
        
		{
            config:{
                name: 'tipo_imp',
                fieldLabel: 'Tipo',
                allowBlank: false,
                qtip:' Consolidado o detallado',
                emptyText:'Tipo Obligacion',
                store:new Ext.data.ArrayStore({
                            fields: ['variable', 'valor'],
                            data : [  ['consolidado','Consolidado'],
                                      ['detallado','Detallado']]
                                    }),
                valueField: 'variable',
                value:'consolidado',
                displayField: 'valor',
                forceSelection: true,
                triggerAction: 'all',
                lazyRender: true,
                mode: 'local',
                width:210,
            },
            type:'ComboBox',
            valorInicial:'detallado',
            form:true
        }
		
	],
    labelSubmit: '<i class="fa fa-check"></i> Aplicar Filtro',
    
    title: 'Reporte de Resumen Espiritual',
    // Funcion guardar del formulario
    onSubmit: function(o) {
    	var me = this;
    	if (me.form.getForm().isValid()) {

             var parametros = me.getValForm()
             
             console.log('parametros ....', parametros);
             Phx.CP.loadingShow(); 
			 Ext.Ajax.request({
				
				url: '../../sis_admin/control/RegionEvento/reporteResumen',
				params:  parametros,
				success: this.successSinc,
				failure: this.conexionFailure,
				timeout: this.timeout,
				scope: this
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