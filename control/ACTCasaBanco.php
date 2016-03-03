<?php
/**
*@package pXP
*@file gen-ACTCasaBanco.php
*@author  (admin)
*@date 02-03-2016 01:06:45
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCasaBanco extends ACTbase{    
			
	function listarCasaBanco(){
		$this->objParam->defecto('ordenacion','id_casa_banco');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		
        if($this->objParam->getParametro('id_casa_oracion')!=''){
	    	$this->objParam->addFiltro("id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));	
		}
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCasaBanco','listarCasaBanco');
		} else{
			$this->objFunc=$this->create('MODCasaBanco');
			
			$this->res=$this->objFunc->listarCasaBanco($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	
	function listarCuentaBancaria(){
		$this->objParam->defecto('ordenacion','id_casa_banco');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		
        $this->objParam->addFiltro("cb.id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));	
		$this->objParam->addFiltro("cb.id_tipo_movimiento = ".$this->objParam->getParametro('id_tipo_movimiento'));	
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCasaBanco','listarCuentaBancaria');
		} else{
			$this->objFunc=$this->create('MODCasaBanco');
			
			$this->res=$this->objFunc->listarCuentaBancaria($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCasaBanco(){
		$this->objFunc=$this->create('MODCasaBanco');	
		if($this->objParam->insertar('id_casa_banco')){
			$this->res=$this->objFunc->insertarCasaBanco($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCasaBanco($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCasaBanco(){
			$this->objFunc=$this->create('MODCasaBanco');	
		$this->res=$this->objFunc->eliminarCasaBanco($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>