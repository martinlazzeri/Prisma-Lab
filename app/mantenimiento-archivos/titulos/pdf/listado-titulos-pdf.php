<?php
	session_start();	
	

	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}

	$apikey = $_SESSION['ApiKey'];

	$ch = curl_init();
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/titulos/',
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
			    $this->SetTitle('listado-titulos-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
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
			    $this->Cell(0,-12,iconv('UTF-8', 'windows-1252', 'Listado Normal de Títulos'));
			}

			function DibujarTitulos($titulos)
			{
				if (count($titulos) > 0) 
				{	
					$this->AddFont('LucidaConsole','','lucida-console.php');
					$this->Ln(2);
					foreach ($titulos as $titulo) 
					{	//primer renglón
						$this->SetFont('Arial','B',10);
						$this->Cell(15,10,iconv('UTF-8', 'windows-1252', 'Código: ')); 
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30, 10, $titulo['Codigo']);

						$this->SetFont('Arial','B',10);
						$this->Cell(24,10,iconv('UTF-8', 'windows-1252', 'Descripción: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(75,10,iconv('UTF-8', 'windows-1252', $titulo['Descripcion']));

						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(10,10,iconv('UTF-8', 'windows-1252', 'Tipo: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(35,10,$titulo['Tipo']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Unidades: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(50,10,$titulo['Unidades']);
						
						$this->SetFont('Arial','B',10);
						$this->Cell(17,10,iconv('UTF-8', 'windows-1252', 'Rango: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', $titulo['Rango']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'Línea Texto 1: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $titulo['LineaTexto1']));

						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'Línea Texto 2: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10, iconv('UTF-8', 'windows-1252', $titulo['LineaTexto2']));
						$this->SetFont('Arial','',10);

						$this->Ln(5);//break renglón

						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'Línea Texto 3: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $titulo['LineaTexto3']));
						$this->SetFont('Arial','B',10);

						$this->Ln(5);//break renglón
												
						$this->SetFont('Arial','B',10);
						$this->Cell(26,10,iconv('UTF-8', 'windows-1252', 'Resultado : '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $titulo['LineaTexto4']));

						$this->Ln(5);//break renglón
						
						$this->SetFont('Arial','B',10);
						$this->Cell(60,10,iconv('UTF-8', 'windows-1252', 'Valores de Referencia Ampliados: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(100,10, iconv('UTF-8', 'windows-1252', $titulo['ValoresReferenciaAmpliados']));
						$this->SetFont('Arial','',10);

						$this->Ln(5);//break renglón

						$this->SetFont('Arial','B',10);
						$this->Cell(27,10,iconv('UTF-8', 'windows-1252', 'Valor Mínimo: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(50,10,iconv('UTF-8', 'windows-1252', $titulo['ValorMinimo']));
						$this->SetFont('Arial','B',10);
												
						$this->SetFont('Arial','B',10);
						$this->Cell(27,10,iconv('UTF-8', 'windows-1252', 'Valor Máximo: '));
						$this->SetFont('LucidaConsole','',10);
						$this->Cell(50,10,iconv('UTF-8', 'windows-1252', $titulo['ValorMaximo']));
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
		$pdf->DibujarTitulos($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>