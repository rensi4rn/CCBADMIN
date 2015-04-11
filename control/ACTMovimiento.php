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

    function listarMovimientoIngreso(){
		

        if($this->objParam->getParametro('tipolist')=='mobile'){
           $this->objParam->defecto('ordenacion','mov.fecha');
           $this->objParam->defecto('dir_ordenacion','desc');
        }	
		else{
		   $this->objParam->defecto('ordenacion','id_movimiento');
           $this->objParam->defecto('dir_ordenacion','asc');	
		}
		
		
		
		 if($this->objParam->getParametro('tipo')!=''){
                    $this->objParam->addFiltro("mov.tipo = ''".$this->objParam->getParametro('tipo')."''");   
          }
          
         if($this->objParam->getParametro('id_estado_periodo')!=''){
                $this->objParam->addFiltro("mov.id_estado_periodo = ".$this->objParam->getParametro('id_estado_periodo'));   
         }
         
         if($this->objParam->getParametro('id_casa_oracion')!=''){
                $this->objParam->addFiltro("mov.id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));   
         }
		 
		 if($this->objParam->getParametro('id_gestion')!=''){
                $this->objParam->addFiltro("mov.id_gestion = ".$this->objParam->getParametro('id_gestion'));   
         }
        
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimientoIngreso');
		} else{
			$this->objFunc=$this->create('MODMovimiento');
			
			$this->res=$this->objFunc->listarMovimientoIngreso($this->objParam);
		}


		
		if($this->objParam->getParametro('tipolist')!='mobile'){
	         //adicionar una fila al resultado con el summario
			$temp = Array();
			$temp['total_construccion'] = $this->res->extraData['total_construccion'];
			$temp['total_viaje'] = $this->res->extraData['total_viaje'];
			$temp['total_especial'] = $this->res->extraData['total_especial'];
			$temp['total_piedad'] = $this->res->extraData['total_piedad'];
			$temp['total_mantenimiento'] = $this->res->extraData['total_mantenimiento'];
			$temp['total_dia'] = $this->res->extraData['total_dia'];
			$temp['tipo_reg'] = 'summary';
			$temp['id_movimiento'] = 0;
			
			$this->res->total++;
			
			$this->res->addLastRecDatos($temp);       
         }
        

		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	
	
	
	
	
	function listarMovimientoEgreso(){
		
		
		 if($this->objParam->getParametro('tipolist')=='mobile'){
            $this->objParam->defecto('ordenacion','mov.fecha');
            $this->objParam->defecto('dir_ordenacion','desc');
         }	
		 else{
		    $this->objParam->defecto('ordenacion','id_movimiento');
            $this->objParam->defecto('dir_ordenacion','asc');	
		 }
		
		 if($this->objParam->getParametro('tipo')!=''){
                    $this->objParam->addFiltro("mov.tipo = ''".$this->objParam->getParametro('tipo')."''");   
          }
          
         if($this->objParam->getParametro('id_estado_periodo')!=''){
                $this->objParam->addFiltro("mov.id_estado_periodo = ".$this->objParam->getParametro('id_estado_periodo'));   
         }
         
         if($this->objParam->getParametro('id_casa_oracion')!=''){
                $this->objParam->addFiltro("mov.id_casa_oracion = ".$this->objParam->getParametro('id_casa_oracion'));   
         }
		 
		 if($this->objParam->getParametro('id_gestion')!=''){
                $this->objParam->addFiltro("mov.id_gestion = ".$this->objParam->getParametro('id_gestion'));   
         }
        
		
		if($this->objParam->getParametro('tipo_concepto')=='egreso'){
                $this->objParam->addFiltro("mov.concepto  in (''operacion'',''egreso_traspaso'',''contra_rendicion'')");   
        }
		else{
			    $this->objParam->addFiltro("mov.concepto  in (''rendicion'')");
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimientoEgreso');
		} else{
			$this->objFunc=$this->create('MODMovimiento');
			
			$this->res=$this->objFunc->listarMovimientoEgreso($this->objParam);
		}
		
		if($this->objParam->getParametro('tipolist')!='mobile'){
	            //adicionar una fila al resultado con el summario
				$temp = Array();
				$temp['total_monto'] = $this->res->extraData['total_monto'];
				$temp['tipo_reg'] = 'summary';
				$temp['id_movimiento'] = 0;				
				$this->res->total++;				
				$this->res->addLastRecDatos($temp);		
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

		
	function insertarMovimientoIngreso(){
		$this->objFunc=$this->create('MODMovimiento');	
		if($this->objParam->insertar('id_movimiento')){
			$this->res=$this->objFunc->insertarMovimientoIngreso($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMovimientoIngreso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarMovimientoEgreso(){
		$this->objFunc=$this->create('MODMovimiento');	
		if($this->objParam->insertar('id_movimiento')){
			$this->res=$this->objFunc->insertarMovimientoEgreso($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMovimientoEgreso($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function calcularSaldos(){
		$this->objFunc=$this->create('MODMovimiento');	
		$this->res=$this->objFunc->calcularSaldos($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
			
}

?>