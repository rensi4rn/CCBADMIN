<?php
/**
*@package pXP
*@file gen-ACTTipoMinisterio.php
*@author  (admin)
*@date 05-01-2013 07:25:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoMinisterio extends ACTbase{    
			
	function listarTipoMinisterio(){
		$this->objParam->defecto('ordenacion','id_tipo_ministerio');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoMinisterio','listarTipoMinisterio');
		} else{
		
			$this->objFunc=$this->create('MODTipoMinisterio');
			
			$this->res=$this->objFunc->listarTipoMinisterio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoMinisterio(){
		$this->objFunc=$this->create('MODTipoMinisterio');	
		if($this->objParam->insertar('id_tipo_ministerio')){
			$this->res=$this->objFunc->insertarTipoMinisterio($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoMinisterio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoMinisterio(){
		
		$this->objFunc=$this->create('MODTipoMinisterio');	
		$this->res=$this->objFunc->eliminarTipoMinisterio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>