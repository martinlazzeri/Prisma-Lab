<?php
	session_start();

	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}
	
	$apikey = $_SESSION['ApiKey'];

	$ch = curl_init();	
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/ingresos/',
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
			    $this->Cell(0,-12,'Listado Normal de Ingresos de Pacientes');
			}

			function DibujarIngresos($ingresos)
			{
				if (count($ingresos) > 0) 
				{					
					$this->Ln(2);
					foreach ($ingresos as $ingreso) 
					{
						$paciente = $ingreso['ApellidoNombre'];
						$paciente = iconv('UTF-8', 'windows-1252', $paciente);
						$this->Cell(20,10,$ingreso['NumPaciente']);
						$this->Cell(60,10,$paciente);
						$ingreso['Sexo'] == 0 ? $sexo = 'M' : $sexo = 'F';
						$this->Cell(15,10,'Sexo: '. $sexo);
						$this->Cell(30,10,iconv('UTF-8', 'windows-1252','Matrícula: ').$ingreso['Matricula']);
						$this->Cell(30,10,'Obra 1: '.$ingreso['Mutual1Nombre']);
						$this->Ln(5);
						if ($ingreso['IngresosPractica']) 
						{
							$this->Cell(10,10,iconv('UTF-8', 'windows-1252', 'Prácticas:'));
							$this->Ln(5);
							for ($i = 0; $i < count($ingreso['IngresosPractica']); $i++)
							{
								$this->Cell(10,10,$ingreso['IngresosPractica'][$i]['PracticaCodigo']);
								$this->Cell(45,10,$ingreso['IngresosPractica'][$i]['PracticaNombre']);
								$ingreso['IngresosPractica'][$i]['EsNomencladorTrabajo'] == 0 ? $nomentrabajo = 'Nomenclador Especial' : $nomentrabajo = 'Nomenclador de Trabajo';
								$this->Cell(10,10,$nomentrabajo);
								$this->Ln(5);
							}
						}
						$this->Cell(10,10,'-------------------------------------------------------------------------------------------------------------------------------------------------------------');
						$this->Ln(10);
					}
				}
			}
		} 
		
		// Instanciación de la clase pdf
		$pdf = new PDF();	
		//alias para el número de paginas
		$pdf->AliasNbPages();
		$pdf->AddPage();
		//seteo de la fuente usada y tamaño
		$pdf->SetFont('Times','',10,true);
		//llamada a la funcion Cabecera
		$pdf->Cabecera();
		//llamada a la funcion DibujarIngresos con el respons del cURL
		$pdf->DibujarIngresos($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>