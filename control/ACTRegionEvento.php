<?php
/**
*@package pXP
*@file gen-ACTRegionEvento.php
*@author  (admin)
*@date 13-01-2013 14:31:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRegionEvento extends ACTbase{    
			
	function listarRegionEvento(){
		$this->objParam->defecto('ordenacion','id_region_evento');
		

		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("rege.id_region = ".$this->objParam->getParametro('id_region'));	
		}

        if($this->objParam->getParametro('id_gestion')!=''){
			    	$this->objParam->addFiltro("rege.id_gestion = ".$this->objParam->getParametro('id_gestion'));	
		}
		
		if($this->objParam->getParametro('tipo_registro')!=''){
			    	$this->objParam->addFiltro("rege.tipo_registro =''".$this->objParam->getParametro('tipo_registro')."''");	
		}

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegionEvento','listarRegionEvento');
		} else{
			$this->objFunc=$this->create('MODRegionEvento');
			
			$this->res=$this->objFunc->listarRegionEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

   function listarBautizoSantaCena(){
		$this->objParam->defecto('ordenacion','fecha_programada');
		$this->objParam->defecto('dir_ordenacion','DESC');

		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("eveid_region = ".$this->objParam->getParametro('id_region'));	
		}

        if($this->objParam->getParametro('id_gestion')!=''){
			    	$this->objParam->addFiltro("eve.id_gestion = ".$this->objParam->getParametro('id_gestion'));	
		}
		
		if($this->objParam->getParametro('codigo')!=''){
			    	$this->objParam->addFiltro("eve.codigo = ''".$this->objParam->getParametro('codigo'))."''";	
		}
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegionEvento','listarBautizoSantaCena');
		} else{
			$this->objFunc=$this->create('MODRegionEvento');
			
			$this->res=$this->objFunc->listarBautizoSantaCena($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRegionEvento(){
		$this->objFunc=$this->create('MODRegionEvento');	
		if($this->objParam->insertar('id_region_evento')){
			$this->res=$this->objFunc->insertarRegionEvento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRegionEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarBautizoSantaCena(){
		$this->objFunc=$this->create('MODRegionEvento');	
		if($this->objParam->insertar('id_region_evento')){
			$this->res=$this->objFunc->insertarBautizoSantaCena($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarBautizoSantaCena($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRegionEvento(){
			$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->eliminarRegionEvento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function eliminarBautizoSantaCena(){
			$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->eliminarBautizoSantaCena($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function generarResumen(){
		$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->generarResumen($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
		
}
?>