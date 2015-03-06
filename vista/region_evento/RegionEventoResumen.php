<?php
/**
*@package pXP
*@file gen-SistemaDist.php
*@author  (rarteaga)
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.RegionEventoResumen = {
    require:'../../../sis_admin/vista/region_evento/RegionEvento.php',
    requireclase:'Phx.vista.RegionEvento',
    title:'Detalle de Eventos',
    nombreVista: 'RegionEventoDet',
    
    constructor: function(config) {
        Phx.vista.RegionEventoResumen.superclass.constructor.call(this, config);
        this.init();
        this.store.baseParams = { tipo_registro:'resumen' }; 
        this.load({ params: { start:0, limit: this.tam_pag }});
        this.Cmp.fecha_programada.disable();
        this.Cmp.fecha_programada.hide();
        
        this.addButton('btnGenerar', {
				text : 'Generar resumen',
				iconCls : 'bchecklist',
				disabled: false,
				handler : this.onBtnGenerarResumen,
				tooltip : '<b>Resumen</b><br/>Busca en todo los registros del año y guarda la suma'
		});
        
    },
    
    
    
    onButtonNew:function(){         
            Phx.vista.RegionEventoResumen.superclass.onButtonNew.call(this);
            this.Cmp.tipo_registro.setValue('resumen');
            this.Cmp.id_gestion.enable();
            this.Cmp.id_region.enable();
            this.Cmp.id_casa_oracion.disable();
        
    },
    
    onButtonEdit:function(){ 
    	
    	        
            Phx.vista.RegionEventoResumen.superclass.onButtonEdit.call(this);
            this.Cmp.id_gestion.disable();
            this.Cmp.id_region.disable();
            this.Cmp.id_casa_oracion.disable();
            
            
     
    },
    
    onBtnGenerarResumen:function(){
		var rec=this.sm.getSelected();
		if(rec){
		
			Phx.CP.loadingShow(); 
			Ext.Ajax.request({
				
				url:'../../sis_admin/control/RegionEvento/generarResumen',
				params:{'id_region_evento': rec.data.id_region_evento},
				success:this.successSinc,
				failure: this.conexionFailure,
				timeout:this.timeout,
				scope:this
			});
		}
		else{
			alert('seleccione un periodo primero')
			
		}
	},
	
	preparaMenu:function(n){
      Phx.vista.RegionEventoResumen.superclass.preparaMenu.call(this,n); 
      this.getBoton('btnGenerar').enable();    
      
      return this.tbar;
    },
    
    liberaMenu:function(){
        var tb = Phx.vista.RegionEventoResumen.superclass.liberaMenu.call(this);
        if(tb){
             this.getBoton('btnGenerar').disable();
        }
        return tb
    },
	
	successSinc:function(){
		Phx.CP.loadingHide();
		this.onButtonAct();
	}
    
   
    
    
};
</script>