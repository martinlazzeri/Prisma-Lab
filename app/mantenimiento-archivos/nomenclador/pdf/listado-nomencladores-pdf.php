<?php
	session_start();	
	

	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}

	$apikey = $_SESSION['ApiKey'];

	$ch = curl_init();
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/nomencladores/',
					 CURLOPT_RETURNTRANSFER => TRUE,
					 CURLOPT_HTTPHEADER => array('Content-Type: application/json',
					 							 'Authorization: '.$apikey));

	curl_setopt_array($ch, $options);

	$response = curl_exec($ch);

	curl_close($ch);

	if ($response == FALSE)
	{
		die(curl_error($ch));
	}

	$responseData = json_decode($response, TRUE);

	if ($responseData["error"] == TRUE) 
	{
		echo "error";
		exit;
	}
	else
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . '/jjlab/pdf/fpdf.php');
		require_once($_SERVER['DOCUMENT_ROOT'] . '/jjlab/pdf/makefont/makefont.php');
		
		class PDF extends FPDF
		{
			//Encabezado de hoja
			function Cabecera()
			{
			    // Logo
			    //$this->Image($_SESSION['UrlParcialLogo'],170,6,30,30);

			    //Nombre doc
			    $this->SetTitle('listado-nomencladores-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
			    // Seteo la fuente para el nombre del laboratorio
			    $this->SetFont('Arial','BI',12);
			    //Nombre Lab
			    $this->Cell(20,-12,$_SESSION['NombreLab'],0,0,'L');
			    // Seteo la fuente para el nombre del laboratorio
			    $this->SetFont('Arial','',10);
			    //Fecha de Pedido
			    $this->Cell(100,-12,'Fecha de Pedido: '.date('d-m-Y'),0,0,'C');
			    //Fecha
			    $this->Cell(30,-12,'Fecha: '.date('d-m-Y'),0,0,'C');
			    //achicha la letra para el número de página
			    $this->SetFont('','',8);
			    //Num pagina	    
			    $this->Cell(70,-12,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
			    //Línea por debajo
			    $this->Line(0,20,250,20);
			    //retoma el tamaño normal luego de imprimir el número de página
			    $this->SetFont('Arial','',10);
			    $this->Ln(10);
			    $this->Cell(0,-12,'Listado Normal de Nomencladores de Trabajo');
			}

			function DibujarNomencladores($nomencladores)
			{
				if (count($nomencladores) > 0) 
				{	
					$this->AddFont('LucidaConsole','','lucida-console.php');
					$this->Ln(2);
					foreach ($nomencladores as $nomenclador) 
					{	//primer renglón
						$this->SetFont('Arial','B',10);
						$this->Cell(15,10,iconv('UTF-8', 'windows-1252', 'Código: ')); 
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30, 10, $nomenclador['Codigo']);

						$this->SetFont('Arial','B',10);
						$this->Cell(16,10,iconv('UTF-8', 'windows-1252', 'Nombre: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(74,10,iconv('UTF-8', 'windows-1252', $nomenclador['Nombre']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(12,10,iconv('UTF-8', 'windows-1252', 'INOS: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(33,10,$nomenclador['INOS']);
						
						$this->Ln(5);//break renglón
						
						$nomenclador['_677'] == 0 ? $_677 = 'No' : $_677 = 'Sí';
						$this->SetFont('Arial','B',10);
						$this->Cell(27,10,iconv('UTF-8', 'windows-1252', 'Reconoce 677: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(18,10,iconv('UTF-8', 'windows-1252', $_677));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'U. Gastos: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(25,10,$nomenclador['UGastos']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'U. Honorarios: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(19,10,$nomenclador['UHonorarios']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(10,10,iconv('UTF-8', 'windows-1252', 'Área: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(7,10, $nomenclador['Area']);
						
						switch ($nomenclador['Complejidad']) 
						{
							case 0:
								$complejidad = 'No considerar';
								break;
							case 1:
								$complejidad = 'Mediana';
								break;
							case 2:
								$complejidad = 'Compuesta';
								break;
							case 3:
								$complejidad = 'Baja';
								break;
							case 4:
								$complejidad = 'Alta';
								break;
							
							default:
								$complejidad = 'Desconocida';
								break;
						}
						$this->SetFont('Arial','B',10);
						$this->Cell(23,10,iconv('UTF-8', 'windows-1252', 'Complejidad: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(22,10,$complejidad);
						
						$this->Ln(5);//break renglón
						
						$nomenclador['INOSReducido'] == 0 ? $inosreducido = 'No' : $inosreducido = 'Sí';
						$this->SetFont('Arial','B',10);
						$this->Cell(29,10,iconv('UTF-8', 'windows-1252', 'INOS Reducido: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(16,10,iconv('UTF-8', 'windows-1252', $inosreducido));
						
						$nomenclador['NoNomenclada'] == 0 ? $nonomenclada = 'No' : $nonomenclada = 'Sí';
						$this->SetFont('Arial','B',10);
						$this->Cell(29,10,iconv('UTF-8', 'windows-1252', 'No Nomenclada: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(16,10,iconv('UTF-8', 'windows-1252', $nonomenclada));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(27,10,iconv('UTF-8', 'windows-1252', 'T. Realización: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(18,10,iconv('UTF-8', 'windows-1252', $nomenclador['TiempoRealizacion'].' día/s'));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(22,10,iconv('UTF-8', 'windows-1252', 'ID Muestra: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(23,10,$nomenclador['IdMuestra']);
						
						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(17,10,iconv('UTF-8', 'windows-1252', 'Proceso: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $nomenclador['Proceso']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(12,10,iconv('UTF-8', 'windows-1252', 'Lista: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(33,10,iconv('UTF-8', 'windows-1252', $nomenclador['Lista']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(25,10,iconv('UTF-8', 'windows-1252', 'Código FABA: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', $nomenclador['CodigoFABA']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(11,10,iconv('UTF-8', 'windows-1252', 'Nivel: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(34,10,iconv('UTF-8', 'windows-1252', $nomenclador['Nivel']));
						$this->SetFont('Arial','B',10);
						
						$this->ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(9,10,iconv('UTF-8', 'windows-1252', 'RIA: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(36,10,iconv('UTF-8', 'windows-1252', $nomenclador['RIA']));
						
						switch ($nomenclador['NBUFrecuencia']) 
						{
							case 0:
								$nbufrecuencia = 'Alta';
								break;
							case 1:
								$nbufrecuencia = 'Baja';
								break;
							case 2:
								$nbufrecuencia = 'PMOE';
								break;
							
							default:
								$nbufrecuencia = 'Descon.';
								break;
						}
						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Frec. NBU: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(25,10,iconv('UTF-8', 'windows-1252', $nbufrecuencia));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(23,10,iconv('UTF-8', 'windows-1252', 'Código NBU: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(22,10,iconv('UTF-8', 'windows-1252', $nomenclador['NBUCodigo']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(18,10,iconv('UTF-8', 'windows-1252', 'Cantidad: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(27,10,iconv('UTF-8', 'windows-1252', $nomenclador['Cantidad']));
						$this->SetFont('Arial','',10);

						$this->Ln(5);
						$this->Cell(0,10,'-------------------------------------------------------------------------------------------------------------------------------------------------------------');
						$this->Ln(5);
					}
				}
			}
		} 
		
		// Instanciación de la clase pdf
		$pdf = new PDF();	
		//alias para el número de páginas
		$pdf->AliasNbPages();
		//agrega la primer página
		$pdf->AddPage();
		//llamada a la funcion Cabecera
		$pdf->Cabecera();
		//llamada a la funcion DibujarIngresos con el respons del cURL
		$pdf->DibujarNomencladores($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>