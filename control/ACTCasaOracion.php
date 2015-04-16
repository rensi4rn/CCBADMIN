<?php
/**
*@package pXP
*@file gen-ACTCasaOracion.php
*@author  (admin)
*@date 05-01-2013 08:52:02
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTCasaOracion extends ACTbase{    
			
	function listarCasaOracion(){
		$this->objParam->defecto('ordenacion','id_casa_oracion');
		$this->objParam->defecto('dir_ordenacion','asc');		
		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("caor.id_region = ".$this->objParam->getParametro('id_region'));	
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODCasaOracion','listarCasaOracion');
		} else{
		
			$this->objFunc=$this->create('MODCasaOracion');
			$this->res=$this->objFunc->listarCasaOracion($this->objParam);
		}
		
		if($this->objParam->getParametro('_adicionar')!=''){
		    
			$respuesta = $this->res->getDatos();
			array_unshift ( $respuesta, array(  'id_casa_oracion'=>'0',
		                                'desc_region'=>'Todos',
									    'nombre'=>'Todos',
										'nombre'=>'Todos',
										'desc_lugar'=>'Todos',
										'direccion'=>'Todos',
										'codigo'=>'Todos'));
		    //var_dump($respuesta);
			$this->res->setDatos($respuesta);
		}
		
		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarCasaOracion(){
	    $this->objFunc=$this->create('MODCasaOracion');	
		if($this->objParam->insertar('id_casa_oracion')){
			$this->res=$this->objFunc->insertarCasaOracion($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarCasaOracion($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarCasaOracion(){
		$this->objFunc=$this->create('MODCasaOracion');	
		$this->res=$this->objFunc->eliminarCasaOracion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>