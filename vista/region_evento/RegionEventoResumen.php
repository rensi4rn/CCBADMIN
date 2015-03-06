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
        
        
        Phx.vista.RegionEventoResumen.superclass.constructor.call(this,config);
        this.init();
        this.store.baseParams = { tipo_registro:'resumen' }; 
        this.load({ params: { start:0, limit: this.tam_pag }});
        
        
    },
    
    
    
    onButtonNew:function(){         
            Phx.vista.RegionEventoResumen.superclass.onButtonNew.call(this);
            this.Cmp.tipo_registro.setValue('resumen')
        
    },
    
    onButtonEdit:function(){ 
    	
    	        
            Phx.vista.RegionEventoResumen.superclass.onButtonEdit.call(this);
            
            
            
     
    }
    
   
    
    
};
</script>