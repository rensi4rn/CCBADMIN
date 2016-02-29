<?php
/**
*@package pXP
*@file gen-ACTCbtePeriodo.php
*@author  (admin)
*@date 28-02-2016 13:24:52
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCbtePeriodo extends ACTbase{    
			
	function listarCbtePeriodo(){
		$this->objParam->defecto('ordenacion','id_cbte_periodo');
		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('id_estado_periodo')!=''){
	    	$this->objParam->addFiltro("id_estado_periodo = ".$this->objParam->getParametro('id_estado_periodo'));	
		}
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCbtePeriodo','listarCbtePeriodo');
		} else{
			$this->objFunc=$this->create('MODCbtePeriodo');
			
			$this->res=$this->objFunc->listarCbtePeriodo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCbtePeriodo(){
		$this->objFunc=$this->create('MODCbtePeriodo');	
		if($this->objParam->insertar('id_cbte_periodo')){
			$this->res=$this->objFunc->insertarCbtePeriodo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCbtePeriodo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCbtePeriodo(){
			$this->objFunc=$this->create('MODCbtePeriodo');	
		$this->res=$this->objFunc->eliminarCbtePeriodo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>