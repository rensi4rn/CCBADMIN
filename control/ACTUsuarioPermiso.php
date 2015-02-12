<?php
/**
*@package pXP
*@file gen-ACTUsuarioPermiso.php
*@author  (admin)
*@date 12-02-2015 14:36:49
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTUsuarioPermiso extends ACTbase{    
			
	function listarUsuarioPermiso(){
		$this->objParam->defecto('ordenacion','id_usuario_permiso');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('id_casa_oracion')!=''){
	    	$this->objParam->addFiltro("id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));	
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODUsuarioPermiso','listarUsuarioPermiso');
		} else{
			$this->objFunc=$this->create('MODUsuarioPermiso');
			
			$this->res=$this->objFunc->listarUsuarioPermiso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarUsuarioPermiso(){
		$this->objFunc=$this->create('MODUsuarioPermiso');	
		if($this->objParam->insertar('id_usuario_permiso')){
			$this->res=$this->objFunc->insertarUsuarioPermiso($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarUsuarioPermiso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarUsuarioPermiso(){
			$this->objFunc=$this->create('MODUsuarioPermiso');	
		$this->res=$this->objFunc->eliminarUsuarioPermiso($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>