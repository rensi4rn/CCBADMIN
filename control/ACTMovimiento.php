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
require_once(dirname(__FILE__).'/../reportes/REgresos.php');
require_once(dirname(__FILE__).'/../reportes/RIngresos.php');
require_once(dirname(__FILE__).'/../reportes/RColectas.php');
require_once(dirname(__FILE__).'/../reportes/RCbteRendicion.php');
require_once(dirname(__FILE__).'/../reportes/RResumen.php');
require_once(dirname(__FILE__).'/../reportes/RResumenDet.php');
require_once(dirname(__FILE__).'/../reportes/RResumenDetXColecta.php');
require_once(dirname(__FILE__).'/../reportes/RResumenXColecta.php');
require_once(dirname(__FILE__).'/../reportes/RResumenCODet.php');
require_once(dirname(__FILE__).'/../reportes/RResumenSaldosMensual.php');
require_once(dirname(__FILE__).'/../../lib/rest/ClientSiga.php');



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
		
		
		 $this->objParam->addFiltro("mov.concepto  not in (''devolucion'',''ingreso_traspaso'')"); 
		
		  
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
                $this->objParam->addFiltro("mov.concepto  in (''operacion'',''egreso_traspaso'',''contra_rendicion'',''egreso_inicial_por_rendir'')");   
        }
		elseif($this->objParam->getParametro('tipo_concepto')=='egreso_traspaso'){
                $this->objParam->addFiltro("mov.concepto  in (''egreso_traspaso'') and id_movimiento_traspaso is null");   
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
				$temp['total_monto_doc'] = $this->res->extraData['total_monto_doc'];
				$temp['total_monto_retencion'] = $this->res->extraData['total_monto_retencion'];
				$temp['tipo_reg'] = 'summary';
				$temp['id_movimiento'] = 0;				
				$this->res->total++;				
				$this->res->addLastRecDatos($temp);		
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

    function listarMovimientoEgresoTraspaso(){
		
		
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
		 /*
		 if($this->objParam->getParametro('id_region')!=''){
                $this->objParam->addFiltro("mov.id_region = ".$this->objParam->getParametro('id_region'));   
         }*/
		 
		 if($this->objParam->getParametro('fecha')!=''){
                $this->objParam->addFiltro("''".$this->objParam->getParametro('fecha')."''::Date BETWEEN mov.fecha_ini::Date and mov.fecha_fin::Date");   
         }
         
         
		
		if($this->objParam->getParametro('tipo_concepto')=='egreso_traspaso'){
                $this->objParam->addFiltro("mov.concepto  in (''egreso_traspaso'') and id_movimiento_traspaso is null");   
        }
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimientoEgresoTraspaso');
		} else{
			$this->objFunc=$this->create('MODMovimiento');
			
			$this->res=$this->objFunc->listarMovimientoEgresoTraspaso($this->objParam);
		}
		
		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}



	function listarMovimientoOtrosIngresos(){
		
		
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
        
		
		if($this->objParam->getParametro('tipo_concepto')=='ingreso'){
                $this->objParam->addFiltro("mov.concepto  in (''devolucion'',''ingreso_traspaso'')");   
        }
		
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODMovimiento','listarMovimientoEgreso');
		} else{
			$this->objFunc=$this->create('MODMovimiento');
			
			$this->res=$this->objFunc->listarMovimientoOtrosIngresos($this->objParam);
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
	
	function insertarMovimientoOtrosIngresos(){
		$this->objFunc=$this->create('MODMovimiento');	
		if($this->objParam->insertar('id_movimiento')){
			$this->res=$this->objFunc->insertarMovimientoOtrosIngresos($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarMovimientoOtrosIngresos($this->objParam);
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

    function recuperarDatosEgresos(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarEgresosMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
	function reporteEgresos(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarDatosEgresos();	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';
		$titulo = 'Egresos';
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new REgresos($this->objParam);
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}
	
	


	 
   function recuperarDatosColectas(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarColectasMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }

    function recuperarDatosColectasXOT(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->reporteColectaMensualXOT($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }

    function reporteColectas(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarDatosColectas();	
		$dataSourceXOT = $this->recuperarDatosColectasXOT();	
		
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';
		$titulo = 'Colectas';
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RColectas($this->objParam);
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData, $dataSourceXOT->getDatos());
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

   function recuperarDatosOtrosIngresos(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarOtrosIngresosMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
	function reporteOtrosIngresos(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarDatosOtrosIngresos();	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';
		$titulo = 'Egresos';
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RIngresos($this->objParam);
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}


   function recuperarSaldosPorRendir(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->saldosPorRendirObreroMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }

  function recuperarRendiciones(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarRendicionesObreroMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
  
   function listarDevolucionesObreroMes(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarDevolucionesObreroMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }


    function listarEgresosContraRendicionMes(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarEgresosContraRendicionMes($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }



	
	function reporteCbteRendicion(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSourceSaldos = $this->recuperarSaldosPorRendir();	
		$dataSourceRendiciones = $this->recuperarRendiciones();	
		$dataSourceDevoluciones = $this->listarDevolucionesObreroMes();	
		$dataSourceEgresos = $this->listarEgresosContraRendicionMes();	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';
		$titulo = 'Egresos';
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RCbteRendicion($this->objParam);
		//$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		$reporte->datosHeader($dataSourceSaldos,  $dataSourceRendiciones, $dataSourceDevoluciones,$dataSourceRendiciones->extraData, $dataSourceEgresos);
		
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

    function recuperarDatosResumen($colectas){
    	
		$this->objFunc = $this->create('MODMovimiento');
		
		if($colectas == 'consolidado'){
			$cbteHeader = $this->objFunc->reporteResumen($this->objParam);
		}
		else{
			$cbteHeader = $this->objFunc->reporteResumenDetallado($this->objParam);
		}
		
		
		
		if($cbteHeader->getTipo() == 'EXITO'){				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
	
	
	function reporteResumen(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarDatosResumen($this->objParam->getParametro('colectas'));	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'L';
		$titulo = 'Consolidado';
		if($this->objParam->getParametro('tipo_imp')=='consolidado'){			
		    $orientacion = 'P';		
		}
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		if($this->objParam->getParametro('tipo_imp')=='consolidado'){
             
			   if($this->objParam->getParametro('colectas')=='consolidado'){	
                 $reporte = new RResumen($this->objParam); 
			   }
			   else{
			   	  $reporte = new RResumenXColecta($this->objParam); 
			   }   
         }
		else{
               	
               if($this->objParam->getParametro('colectas')=='consolidado'){	
                 $reporte = new RResumenDet($this->objParam); 
			   }
			   else{
			   	  $reporte = new RResumenDetXColecta($this->objParam); 
			   }  
         
		}
		
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}


function recuperarDatosResumenCO(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->reporteResumenCO($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
   function reporteResumenCO(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarDatosResumenCO();	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'L';
		$titulo = 'Consolidado';
		if($this->objParam->getParametro('tipo_imp')=='consolidado'){			
		    $orientacion = 'P';		
		}
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RResumenCODet($this->objParam); 
			  
		
		
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

  function recuperarResumenSaldosMensual(){
    	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->reporteResumenSaldosMensual($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	

   function reporteResumenSaldosMensual(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		$dataSource = $this->recuperarResumenSaldosMensual();	
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'L';
		$titulo = 'Consolidado';
		if($this->objParam->getParametro('tipo_imp')=='consolidado'){			
		    $orientacion = 'P';		
		}
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		
		$reporte = new RResumenSaldosMensual($this->objParam); 
			  
		
		
		$reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

    function validarDatosSiga(){
		$this->objFunc=$this->create('MODMovimiento');	
		$this->res=$this->objFunc->validarDatosSiga($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	
	private function recuperarDatosMigracion(){
		$dataSource = new DataSource();	
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->listarMovimientoIngresoMigracion($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
		}  
	}
	
	private function actualizarMovMigSiga($id_movimiento){
		
		$this->objFunc = $this->create('MODMovimiento');
		$cbteHeader = $this->objFunc->actualizarMovMigSiga($id_movimiento);
		if($cbteHeader->getTipo() == 'EXITO'){
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
		}
	} 
	
	
	function migrarDatosSiga(){
			
		
		//listar datos a migrar	
		$datos = $this->recuperarDatosMigracion();
		$this->ClienteSiga = ClienteSiga::connect($_SESSION['_DIRECCION_SIGA'], '');
		
		//////////////////////
		//hacer login
		////////////////////
		
		$respuesta =  $this->ClienteSiga->doGet('index.aspx',
			    array(
			        "f_login"=>"S", 
			        "f_usuario"=>$_SESSION['_USER_LOGIN_SIGA'], 
			        "f_senha"=>$_SESSION['_SENHA_SIGA']  
			
			    ));
		
		
		
		if (strpos($respuesta, '/SIS/SIS99908.aspx') !== false) {
			   	
				//////////////////////////////////////////////////////////
			   //definir casa se oracion y periodo de trabajo en SIGA
		      /////////////////////////////////////////////////////////////
			    $this->ClienteSiga->clearHeader();
			    $this->ClienteSiga->addHeader('Accept:  */*');
				$this->ClienteSiga->addHeader('Connection: keep-alive');
				$this->ClienteSiga->addHeader('Host:	'.$_SESSION['_DIRECCION_SIGA']);
				$this->ClienteSiga->addHeader('Referer: https://siga.congregacao.org.br/SIS/SIS99908.aspx?f_inicio=S');
				$this->ClienteSiga->addHeader('X-Requested-With:	XMLHttpRequest');
				$this->ClienteSiga->addHeader('User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');
			  
			    $respuesta =  $this->ClienteSiga->doPost('SIS/SIS99906.aspx', 
				    array(
				        "gravar"=>"S", 
				        "f_usuario"=>$_SESSION['_USUARIO_SIGA'], 
				        "f_empresa"=>$this->objParam->getParametro('codigo_siga_region'),  
				        "f_estabelecimento"=>$this->objParam->getParametro('codigo_siga_co'),  //casa de oracion
				        "f_competencia"=>$this->objParam->getParametro('codigo_siga_periodo'), //mes de trabajo 
				        "__jqSubmit__"=>"S"
				
				    ),'multipart');
					
				///////////////////////////////////	
				//recorrer datos  que seran migrados
				//////////////////////////////////////
				foreach($datos as $key=>$val){
					//insertar colecta en SIGA	
					//var_dump($val);
					//exit;
									
					$respuesta =$this->insertarColectaSiga($val);	
					
					if (strpos($respuesta, 'Informaciones+guardadas') == false) {
						throw new Exception("Error insertar colecta... ".$respuesta);
						exit;
					}
					
					//actulizar datos migrados	
					$this->actualizarMovMigSiga($val['id_movimiento']);		
				
				}
				
				
				//////////////////////////////////////////
				//Consular colectas registradas en SIGA
				/////////////////////////////////////////
				
				
				
				header("HTTP/1.1 200 ok");	
				echo '{"ROOT":{"error":false,"detalle":{"mensaje":"La transacci\u00f3n se ha ejecutado con \u00e9xito","mensaje_tec":"La transacci\u00f3n se ha ejecutado con \u00e9xito"}}}';
				exit;
				
		    
		}
		else{
			throw new Exception("Error al hacer login. ");
			
		}
		
	}

	

    private function insertarColectaSiga( $val){
     		
     	$this->ClienteSiga->clearHeader();
		$this->ClienteSiga->addHeader('Accept:  */*');
		$this->ClienteSiga->addHeader('Connection: keep-alive');
		$this->ClienteSiga->addHeader('Host:	'.$_SESSION['_DIRECCION_SIGA']);
		$this->ClienteSiga->addHeader('Referer: https://siga.congregacao.org.br/TES/TES00402.aspx');
		$this->ClienteSiga->addHeader('X-Requested-With:	XMLHttpRequest');
		$this->ClienteSiga->addHeader('User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');
		
		
		
		$boundary = md5(time());
		
		
		//number_format($val['importe_debe'], 2, '.', ',')
		if($val["concepto"] == 'colecta_jovenes'){
			$f_tipoculto = 2;
		}
		else{
			$f_tipoculto = 1;
		}
		
		if($val['desc_orden'] ==''){
			$f_valor_3667 = $val['monto_especial'];
			$f_valor_7  = 0;    // brasil
			$f_valor_8  = 0;     //musica
			$f_valor_5  = 0;     //reuniones
		}
		else{
			
			if($val['desc_orden'] =='Colecta Nacional para calamidades'){
				$f_valor_3667 = 0;
				$f_valor_7  = 0;    // brasil
				$f_valor_8  = $val['monto_especial'];     //musica
				$f_valor_5  = 0;     //reuniones
			}
			else{
				if($val['desc_orden'] =='Reuniones'){
					$f_valor_3667 = 0;
					$f_valor_7  = 0;    // brasil
					$f_valor_8  = 0;     //musica
					$f_valor_5  = $val['monto_especial'];     //reuniones
				}	
				else{
					if($val['desc_orden'] =='Musica'){
						$f_valor_3667 = 0;
						$f_valor_7  = $val['monto_especial'];    // brasil
						$f_valor_8  = 0;     //musica
						$f_valor_5  = 0;     //reuniones
					}
					else{
						$f_valor_3667 = $val['monto_especial'];
						$f_valor_7  = 0;    // brasil
						$f_valor_8  = 0;     //musica
						$f_valor_5  = 0; 
					}
				}
			}
		}
		
		  
		$this->ClienteSiga->clearRetval();
		$this->ClienteSiga->addParamMultipart($boundary,"f_codigo",""); 
		$this->ClienteSiga->addParamMultipart($boundary,"tarefa",""); 
		$this->ClienteSiga->addParamMultipart($boundary,"gravar","S");  
		$this->ClienteSiga->addParamMultipart($boundary,"f_data",date_format(new DateTime($val["fecha"]), 'd/m/Y'));  
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipoculto",$f_tipoculto);   
		$this->ClienteSiga->addParamMultipart($boundary,"f_valortotal",number_format($val['monto_dia'], 2,",",""));   //casa de oracion
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",1); //mes de trabajo
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_1",number_format($val['monto_construccion'], 2,",",""));  //construccion
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",2);
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_2",number_format($val['monto_piedad'], 2,",",""));  //piedad
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",3); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_3",number_format($val['monto_viaje'], 2,",",""));   //viage
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",4); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_4",number_format($val['monto_mantenimiento'], 2,",",""));   //mantenimiento
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",5); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_5",number_format($f_valor_5, 2,",","")); //reuniones
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",8); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_8",number_format($f_valor_8, 2,",","")); //musica
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",7); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_7",number_format($f_valor_7, 2,",",""));  //brasil
		$this->ClienteSiga->addParamMultipart($boundary,"f_tipos",3667); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_valor_3667",number_format($f_valor_3667, 2,",","")); //especial
		$this->ClienteSiga->addParamMultipart($boundary,"f_restante",number_format(0.00, 2,",","")); 
		$this->ClienteSiga->addParamMultipart($boundary,"f_comando","F"); 
		$this->ClienteSiga->addParamMultipart($boundary,"__initPage__","S"); 
		$this->ClienteSiga->addParamMultipart($boundary,"__jqSubmit__","S"); 
		
		  
		
		return  $this->ClienteSiga->doPostMultipart('TES/TES00402.aspx', $boundary);
		 
     }
	
		
	
			
}

?>