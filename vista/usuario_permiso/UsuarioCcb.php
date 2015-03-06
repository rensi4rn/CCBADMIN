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
Phx.vista.UsuarioCcb = {
    require:'../../../sis_seguridad/vista/usuario/Usuario.php',
    requireclase:'Phx.vista.usuario',
    title:'Usuarios Cbb',
    nombreVista: 'UsuarioCcb',
    
    constructor: function(config) {
        
        
        Phx.vista.UsuarioCcb.superclass.constructor.call(this,config);
        this.init();
        this.store.baseParams={tipo_registro:'detalle'}; 
        this.load({params:{start:0, limit:this.tam_pag}});
        
        
    },
    
    
    
    
    tabeast:[
         {
          url:'../../../sis_seguridad/vista/usuario_rol/UsuarioRol.php',
          title:'Roles', 
          width:400,
          cls:'usuario_rol'
         },
		 {
		  url:'../../../sis_admin/vista/usuario_permiso/UsuarioPermiso.php',		
		  title:'Autorizaciones', 
		  height:'50%',
		  cls:'UsuarioPermiso'
		 }
        ],
    
   
    
    
};
</script>