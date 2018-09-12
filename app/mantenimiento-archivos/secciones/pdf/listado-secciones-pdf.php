<?php
	session_start();	
	

	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}

	$apikey = $_SESSION['ApiKey'];

	$ch = curl_init();
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/secciones/',
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
		
		class PDF extends FPDF
		{
			//Encabezado de hoja
			function Cabecera()
			{
			    // Logo
			    //$this->Image($_SESSION['UrlParcialLogo'],170,6,30,30);

			    //Nombre doc
			    $this->SetTitle('listado-secciones-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
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
			    $this->Cell(0,-12,'Listado Normal de Secciones');
			}

			function DibujarSecciones($secciones)
			{
				if (count($secciones) > 0) 
				{	
					$this->AddFont('LucidaConsole','','lucida-console.php');
					$this->Ln(2);
					foreach ($secciones as $seccion) 
					{	//primer renglón
						$this->SetFont('Arial','B',10);
						$this->Cell(15,10,iconv('UTF-8', 'windows-1252', 'Código: ')); 
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30, 10, $seccion['Codigo']);

						$this->SetFont('Arial','B',10);
						$this->Cell(16,10,iconv('UTF-8', 'windows-1252', 'Nombre: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(74,10,iconv('UTF-8', 'windows-1252', $seccion['Nombre']));

						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 1: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,$seccion['Determinacion1']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 2: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,$seccion['Determinacion2']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 3: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion3']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 4: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion4']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 5: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion5']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 6: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion6']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 7: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion7']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 8: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion8']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Determinación 9: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion9']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 10: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion10']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 11: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion11']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 12: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion12']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 13: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion13']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 14: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion14']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 15: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion15']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 16: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion16']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 17: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion17']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 18: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion18']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 19: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion19']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 20: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion20']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 21: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion21']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 22: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion22']));
						
						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 23: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10, iconv('UTF-8', 'windows-1252', $seccion['Determinacion23']));
						$this->SetFont('Arial','',10);

						$this->SetFont('Arial','B',10);
						$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Determinación 24: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(28,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion24']));
						$this->SetFont('Arial','B',10);

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
		$pdf->DibujarSecciones($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>