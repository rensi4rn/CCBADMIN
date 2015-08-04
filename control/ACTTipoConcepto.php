<?php
/**
*@package pXP
*@file gen-ACTTipoConcepto.php
*@author  (admin)
*@date 04-08-2015 07:43:42
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoConcepto extends ACTbase{    
			
	function listarTipoConcepto(){
		$this->objParam->defecto('ordenacion','id_tipo_concepto');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoConcepto','listarTipoConcepto');
		} else{
			$this->objFunc=$this->create('MODTipoConcepto');
			
			$this->res=$this->objFunc->listarTipoConcepto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoConcepto(){
		$this->objFunc=$this->create('MODTipoConcepto');	
		if($this->objParam->insertar('id_tipo_concepto')){
			$this->res=$this->objFunc->insertarTipoConcepto($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoConcepto($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoConcepto(){
			$this->objFunc=$this->create('MODTipoConcepto');	
		$this->res=$this->objFunc->eliminarTipoConcepto($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>