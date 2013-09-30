<?php
/**
*@package pXP
*@file gen-ACTRegion.php
*@author  (admin)
*@date 04-01-2013 18:05:10
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRegion extends ACTbase{    
			
	function listarRegion(){
		$this->objParam->defecto('ordenacion','id_region');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegion','listarRegion');
		} else{
		
			$this->objFunc=$this->create('MODRegion');
			
			$this->res=$this->objFunc->listarRegion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRegion(){
	
		$this->objFunc=$this->create('MODRegion');	
		if($this->objParam->insertar('id_region')){
			$this->res=$this->objFunc->insertarRegion($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRegion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRegion(){
		
			$this->objFunc=$this->create('MODRegion');	
		$this->res=$this->objFunc->eliminarRegion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>