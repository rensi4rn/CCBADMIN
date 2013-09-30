<?php
/**
*@package pXP
*@file gen-ACTCulto.php
*@author  (admin)
*@date 24-02-2013 14:06:12
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCulto extends ACTbase{    
			
	function listarCulto(){
		$this->objParam->defecto('ordenacion','id_culto');

		$this->objParam->defecto('dir_ordenacion','asc');
		 
		 if($this->objParam->getParametro('id_casa_oracion')!=''){
	    	$this->objParam->addFiltro("id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));	
		}
	   
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCulto','listarCulto');
		} else{
			$this->objFunc=$this->create('MODCulto');
			
			$this->res=$this->objFunc->listarCulto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCulto(){
		$this->objFunc=$this->create('MODCulto');	
		if($this->objParam->insertar('id_culto')){
			$this->res=$this->objFunc->insertarCulto($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCulto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCulto(){
			$this->objFunc=$this->create('MODCulto');	
		$this->res=$this->objFunc->eliminarCulto($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>