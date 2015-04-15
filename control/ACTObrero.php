<?php
/**
*@package pXP
*@file gen-ACTObrero.php
*@author  (admin)
*@date 13-01-2013 12:24:54
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../reportes/RObrero.php');
require_once(dirname(__FILE__).'/../../pxp/pxpReport/DataSource.php');
require_once dirname(__FILE__).'/../../pxp/lib/lib_reporte/ReportePDFFormulario.php';
class ACTObrero extends ACTbase{    
			
	function listarObrero(){
		
		$this->objParam->defecto('ordenacion','id_obrero');

		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("obr.id_region = ".$this->objParam->getParametro('id_region'));	
		}
		
		if($this->objParam->getParametro('codigo_ministerio')!=''){
			    	$this->objParam->addFiltro("tipmi.codigo in (".$this->objParam->getParametro('codigo_ministerio').")");	
		}
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODObrero','listarObrero');
		} else{
			$this->objFunc=$this->create('MODObrero');
			
			$this->res=$this->objFunc->listarObrero($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarObrero(){
		$this->objFunc=$this->create('MODObrero');	
		if($this->objParam->insertar('id_obrero')){
			$this->res=$this->objFunc->insertarObrero($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarObrero($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function modificarObreroMobile(){
		$this->objFunc=$this->create('MODObrero');	
		$this->res=$this->objFunc->modificarObreroMobile($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarObrero(){
		$this->objFunc=$this->create('MODObrero');	
	    $this->res=$this->objFunc->eliminarObrero($this->objParam);
	    $this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function recuperarDatosObreros(){
    	
		$this->objFunc = $this->create('MODObrero');
		$cbteHeader = $this->objFunc->listarObreroTodos($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
	function reporteObreros_bk(){
			
		$nombreArchivo = uniqid(md5(session_id()).'PlanCuentas') . '.pdf'; 
		$dataSource = $this->recuperarDatosObreros();	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';
		$titulo = '';
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RObrero($this->objParam);
		$reporte->datosHeader($dataSource);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

   function reporteObreros(){
   	    	
   	    $dataSource = $this->recuperarDatosObreros(); 
   	   	$datos = $dataSource;
   	    
	    try
	    {// get the HTML
	        
			
	    	
			$pdf = new ReportePDFFormulario($this->objParam);
			
			$pdf->SetDisplayMode('fullpage');
			
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			// set font
			$pdf->SetFont('helvetica', '', 8);
			// add a page
            
            //suponemos que entran en 20 en una pagina
            $tam_pagina = 24;
            $total = sizeof($datos);
			$num_pagina = $total/($tam_pagina*2);
            $fin = $tam_pagina*2;
			$inicio = 0;
			
			for($i = 0; $i<$num_pagina;$i++){
			//var_dump($datos[$inicio]);
			   ob_start();
	           include(dirname(__FILE__).'/../reportes/tpl/obrero.php');
               $content = ob_get_clean();
			   
			   $pdf->AddPage();
			   $pdf->writeHTML($content, true, false, true, false, '');
			   $inicio = $inicio + $tam_pagina*2;
			   $fin = $fin + $tam_pagina*2;
			   
			   
			   
			   
			}
            
           
			
			
			
			$nombreArchivo = uniqid(md5(session_id()).'Obreros') . '.pdf'; 
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