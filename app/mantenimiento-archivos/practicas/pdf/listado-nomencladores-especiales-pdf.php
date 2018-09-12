<?php
	session_start();	
	

	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}

	$apikey = $_SESSION['ApiKey'];

	$ch = curl_init();
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/nomencladoresespeciales/',
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
			    $this->SetTitle('listado-nomencladores-especiales-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
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
			    $this->Cell(0,-12,'Listado Normal de Nomencladores Especiales');
			}

			function DibujarNomencladoresEspeciales($nomencladoresEspeciales)
			{
				if (count($nomencladoresEspeciales) > 0) 
				{	
					$this->AddFont('LucidaConsole','','lucida-console.php');
					$this->Ln(2);
					foreach ($nomencladoresEspeciales as $nomencladorEspecial) 
					{	//primer renglón
						$this->SetFont('Arial','B',10);
						$this->Cell(15,10,iconv('UTF-8', 'windows-1252', 'Código: ')); 
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30, 10, $nomencladorEspecial['Codigo']);

						$this->SetFont('Arial','B',10);
						$this->Cell(16,10,iconv('UTF-8', 'windows-1252', 'Nombre: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(74,10,iconv('UTF-8', 'windows-1252', $nomencladorEspecial['Nombre']));

						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'U. Gastos: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(25,10,$nomencladorEspecial['UnidadGasto']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'U. Honorarios: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(19,10,$nomencladorEspecial['UnidadHonorario']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(11,10,iconv('UTF-8', 'windows-1252', 'Nivel: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(34,10,iconv('UTF-8', 'windows-1252', $nomencladorEspecial['Nivel']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(23,10,iconv('UTF-8', 'windows-1252', 'Cód. Mutual: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(22,10,iconv('UTF-8', 'windows-1252', $nomencladorEspecial['CodMutual']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Nombre Mutual: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(20,10, iconv('UTF-8', 'windows-1252', $nomencladorEspecial['NombreMutual']));
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
		$pdf->DibujarNomencladoresEspeciales($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>