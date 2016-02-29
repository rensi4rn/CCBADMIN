<?php
/**
*@package pXP
*@file gen-ACTTipoDocumentoCcb.php
*@author  (admin)
*@date 29-02-2016 09:49:41
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoDocumentoCcb extends ACTbase{    
			
	function listarTipoDocumentoCcb(){
		$this->objParam->defecto('ordenacion','id_tipo_documento_ccb');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoDocumentoCcb','listarTipoDocumentoCcb');
		} else{
			$this->objFunc=$this->create('MODTipoDocumentoCcb');
			
			$this->res=$this->objFunc->listarTipoDocumentoCcb($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoDocumentoCcb(){
		$this->objFunc=$this->create('MODTipoDocumentoCcb');	
		if($this->objParam->insertar('id_tipo_documento_ccb')){
			$this->res=$this->objFunc->insertarTipoDocumentoCcb($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoDocumentoCcb($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoDocumentoCcb(){
			$this->objFunc=$this->create('MODTipoDocumentoCcb');	
		$this->res=$this->objFunc->eliminarTipoDocumentoCcb($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>