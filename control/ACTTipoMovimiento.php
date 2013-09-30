<?php
/**
*@package pXP
*@file gen-ACTTipoMovimiento.php
*@author  (admin)
*@date 15-03-2013 23:21:53
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoMovimiento extends ACTbase{    
			
	function listarTipoMovimiento(){
		$this->objParam->defecto('ordenacion','id_tipo_movimiento');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoMovimiento','listarTipoMovimiento');
		} else{
			$this->objFunc=$this->create('MODTipoMovimiento');
			
			$this->res=$this->objFunc->listarTipoMovimiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoMovimiento(){
		$this->objFunc=$this->create('MODTipoMovimiento');	
		if($this->objParam->insertar('id_tipo_movimiento')){
			$this->res=$this->objFunc->insertarTipoMovimiento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoMovimiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoMovimiento(){
			$this->objFunc=$this->create('MODTipoMovimiento');	
		$this->res=$this->objFunc->eliminarTipoMovimiento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>