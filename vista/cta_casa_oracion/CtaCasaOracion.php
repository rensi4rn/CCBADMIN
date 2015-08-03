<?php
/**
*@package pXP
*@file gen-SistemaDist.php
*@author  (fprudencio)
*@date 20-09-2011 10:22:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.CtaCasaOracion = {
    require: '../../../sis_admin/vista/casa_oracion/CasaOracion.php',
    requireclase: 'Phx.vista.CasaOracion',
    title: 'Casa Oracion',
    constructor: function(config) {
        Phx.vista.CtaCasaOracion.superclass.constructor.call(this,config);     
    },    
  
   east: undefined,
   tabeast:[
	     { 
          url:'../../../sis_contabilidad/vista/relacion_contable/RelacionContableTabla.php',
          title:'Relacion Contable', 
          width:'50%',
          cls:'RelacionContableTabla',
          params:{nombre_tabla:'ccb.tcasa_oracion',tabla_id:'id_casa_oracion'}
         },
	     {
		  url:'../../../sis_admin/vista/casa_oracion/mapaLocalizacion.php',
		  title:'Ubicación', 
		  width:'50%',
		  cls:'mapaLocalizacion'
		 }
	
	   ],
	   
   bedit: false,
   bnew: false,
   bdel: false,
   bsave: false,
   EnableSelect : function (n, extra) {
        var miExtra = {codigos_tipo_relacion:''};
        if (extra != null && typeof extra === 'object') {
            miExtra = Ext.apply(extra, miExtra) 
        }
      Phx.vista.CtaCasaOracion.superclass.EnableSelect.call(this,n,miExtra);  
   }
};
</script>