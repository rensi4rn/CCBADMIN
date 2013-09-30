<?php
/**
*@package pXP
*@file gen-ACTMovimiento.php
*@author  (admin)
*@date 16-03-2013 00:22:36
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTMovimiento extends ACTbase{    
			
	function listarMovimiento(){
		$this->objParam->defecto('ordenacion','id_movimiento');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		 if($this->objParam->getParametro('tipo')!=''){
                    $this->objParam->addFiltro("mov.tipo = ''".$this->objParam->getParametro('tipo')."''");   
          }
          
         if($this->objParam->getParametro('id_estado_periodo')!=''){
                $this->objParam->addFiltro("mov.id_estado_periodo = ".$this->objParam->getParametro('id_estado_periodo'));   
         }
         
         if($this->objParam->getParametro('id_casa_oracion')!=''){
                $this->objParam->addFiltro("mov.id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));   
         }
        
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimiento');
		} else{
			$this->objFunc=$this->create('MODMovimiento');
			
			$this->res=$this->objFunc->listarMovimiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarMovimientoDinamico(){
        
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam, $this);
            $this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimientoDinamico');
        } else{
            $this->objFunc=$this->create('MODMovimiento');  
            $this->res=$this->objFunc->listarMovimientoDinamico();
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
				
	function insertarMovimiento(){
		$this->objFunc=$this->create('MODMovimiento');	
		if($this->objParam->insertar('id_movimiento')){
			$this->res=$this->objFunc->insertarMovimiento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMovimiento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarMovimiento(){
			$this->objFunc=$this->create('MODMovimiento');	
		$this->res=$this->objFunc->eliminarMovimiento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>