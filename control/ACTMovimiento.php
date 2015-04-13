<?php
/**
*@package pXP
*@file gen-ACTMovimiento.php
*@author  (admin)
*@date 16-03-2013 00:22:36
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../../pxp/pxpReport/DataSource.php');
require_once(dirname(__FILE__).'/../../lib/lib_reporte/PlantillasHTML.php');
require_once(dirname(__FILE__).'/../../lib/lib_reporte/smarty/ksmarty.php');
require_once dirname(__FILE__).'/../../pxp/lib/lib_reporte/ReportePDFFormulario.php';
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
	function comprobanteOfrendas(){
		$this->objFunc=$this->create('MODMovimiento');	
		$this->res=$this->objFunc->comprobanteOfrendas($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	
	function recuperarDatosCbteEgresos(){
    	$dataSource = new DataSource();	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->comprobanteOfrendas($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				 	
			$dataSource->putParameter('datos',$cbteHeader->getDatos());
			return $dataSource;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
		}              
		
    }
	
    function reporteCbteEgresos(){
   	    	
   	    $dataSource = $this->recuperarDatosCbteEgresos(); 
   	   	
   	   	//var_dump($dataSource);
		//exit;
   	   	
        
        //$content = 'hola';
   	    
	    try
	    {// get the HTML
	        ob_start();
	        include(dirname(__FILE__).'/../reportes/tpl/cbte_egresos.php');
             $content = ob_get_clean();
	    	
			$pdf = new ReportePDFFormulario($this->objParam);
			
			$pdf->SetDisplayMode('fullpage');
			
            //$pdf->SetCreator(PDF_CREATOR);
			//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// set font
			$pdf->SetFont('helvetica', '', 10);
			// add a page
            $pdf->AddPage();
			$pdf->writeHTML($content, true, false, true, false, '');
			$pdf->AddPage();
			$pdf->writeHTML($content, true, false, true, false, '');
			$pdf->AddPage();
			$pdf->writeHTML($content, true, false, true, false, '');
			$nombreArchivo = 'IntComprobante.pdf';
			$pdf->Output(dirname(__FILE__).'/../../reportes_generados/'.$nombreArchivo, 'F');
			
			$mensajeExito = new Mensaje();
            $mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado', 'Se generó con éxito el reporte: '.$nombreArchivo,'control');
            $mensajeExito->setArchivoGenerado($nombreArchivo);
            $this->res = $mensajeExito;
            $this->res->imprimirRespuesta($this->res->generarJson());
			
		}
	    catch(exception $e) {
	        echo $e;
	        exit;
	    }
    }	
	
			
}

?>