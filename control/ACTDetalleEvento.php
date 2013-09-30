<?php
/**
*@package pXP
*@file gen-ACTDetalleEvento.php
*@author  (admin)
*@date 24-02-2013 13:45:38
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTDetalleEvento extends ACTbase{    
			
	function listarDetalleEvento(){
		$this->objParam->defecto('ordenacion','id_detalle_evento');
 
       
	    if($this->objParam->getParametro('id_region_evento')!=''){
	    	$this->objParam->addFiltro("dev.id_region_evento = ".$this->objParam->getParametro('id_region_evento'));	
		}
	   

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODDetalleEvento','listarDetalleEvento');
		} else{
			$this->objFunc=$this->create('MODDetalleEvento');
			
			$this->res=$this->objFunc->listarDetalleEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarDetalleEvento(){
		$this->objFunc=$this->create('MODDetalleEvento');	
		if($this->objParam->insertar('id_detalle_evento')){
			$this->res=$this->objFunc->insertarDetalleEvento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarDetalleEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarDetalleEvento(){
			$this->objFunc=$this->create('MODDetalleEvento');	
		$this->res=$this->objFunc->eliminarDetalleEvento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>