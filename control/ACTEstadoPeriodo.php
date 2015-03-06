<?php
/**
*@package pXP
*@file gen-ACTEstadoPeriodo.php
*@author  (admin)
*@date 24-02-2013 14:35:36
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEstadoPeriodo extends ACTbase{    
			
	function listarEstadoPeriodo(){
		$this->objParam->defecto('ordenacion','id_estado_periodo');

        if($this->objParam->getParametro('id_casa_oracion')!=''){
	    	$this->objParam->addFiltro("id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));	
		}
		
		if($this->objParam->getParametro('id_gestion')!=''){
	    	$this->objParam->addFiltro("id_gestion = ".$this->objParam->getParametro('id_gestion'));	
		}
		

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEstadoPeriodo','listarEstadoPeriodo');
		} else{
			$this->objFunc=$this->create('MODEstadoPeriodo');
			
			$this->res=$this->objFunc->listarEstadoPeriodo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEstadoPeriodo(){
		$this->objFunc=$this->create('MODEstadoPeriodo');	
		if($this->objParam->insertar('id_estado_periodo')){
			$this->res=$this->objFunc->insertarEstadoPeriodo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEstadoPeriodo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function generarGestion(){
		$this->objFunc=$this->create('MODEstadoPeriodo');	
		$this->res=$this->objFunc->generarGestion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function abrirCerrarPeriodo(){
		$this->objFunc=$this->create('MODEstadoPeriodo');	
		$this->res=$this->objFunc->abrirCerrarPeriodo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	
						
	function eliminarEstadoPeriodo(){
			$this->objFunc=$this->create('MODEstadoPeriodo');	
		$this->res=$this->objFunc->eliminarEstadoPeriodo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>