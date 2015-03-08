<?php
/**
*@package pXP
*@file gen-ACTObrero.php
*@author  (admin)
*@date 13-01-2013 12:24:54
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTObrero extends ACTbase{    
			
	function listarObrero(){
		
		$this->objParam->defecto('ordenacion','id_obrero');

		 if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("obr.id_region = ".$this->objParam->getParametro('id_region'));	
				}
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODObrero','listarObrero');
		} else{
			$this->objFunc=$this->create('MODObrero');
			
			$this->res=$this->objFunc->listarObrero($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarObrero(){
		$this->objFunc=$this->create('MODObrero');	
		if($this->objParam->insertar('id_obrero')){
			$this->res=$this->objFunc->insertarObrero($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarObrero($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function modificarObreroMobile(){
		$this->objFunc=$this->create('MODObrero');	
		$this->res=$this->objFunc->modificarObreroMobile($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarObrero(){
		$this->objFunc=$this->create('MODObrero');	
	    $this->res=$this->objFunc->eliminarObrero($this->objParam);
	    $this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>