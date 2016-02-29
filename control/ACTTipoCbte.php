<?php
/**
*@package pXP
*@file gen-ACTTipoCbte.php
*@author  (admin)
*@date 28-02-2016 13:24:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoCbte extends ACTbase{    
			
	function listarTipoCbte(){
		$this->objParam->defecto('ordenacion','id_tipo_cbte');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoCbte','listarTipoCbte');
		} else{
			$this->objFunc=$this->create('MODTipoCbte');
			
			$this->res=$this->objFunc->listarTipoCbte($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoCbte(){
		$this->objFunc=$this->create('MODTipoCbte');	
		if($this->objParam->insertar('id_tipo_cbte')){
			$this->res=$this->objFunc->insertarTipoCbte($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoCbte($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoCbte(){
			$this->objFunc=$this->create('MODTipoCbte');	
		$this->res=$this->objFunc->eliminarTipoCbte($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>