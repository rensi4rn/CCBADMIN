<?php
/**
*@package pXP
*@file gen-ACTMovimientoDet.php
*@author  (admin)
*@date 25-03-2013 02:03:18
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTMovimientoDet extends ACTbase{    
			
	function listarMovimientoDet(){
		$this->objParam->defecto('ordenacion','id_movimiento_det');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		
		if($this->objParam->getParametro('id_movimiento')!=''){
            $this->objParam->addFiltro("movd.id_movimiento = ".$this->objParam->getParametro('id_movimiento'));    
        }
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimientoDet','listarMovimientoDet');
		} else{
			$this->objFunc=$this->create('MODMovimientoDet');
			
			$this->res=$this->objFunc->listarMovimientoDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarMovimientoDet(){
		$this->objFunc=$this->create('MODMovimientoDet');	
		if($this->objParam->insertar('id_movimiento_det')){
			$this->res=$this->objFunc->insertarMovimientoDet($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMovimientoDet($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarMovimientoDet(){
			$this->objFunc=$this->create('MODMovimientoDet');	
		$this->res=$this->objFunc->eliminarMovimientoDet($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>