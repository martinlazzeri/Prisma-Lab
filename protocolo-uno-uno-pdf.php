<?php
	session_start();	
	
	if (!isset($_SESSION['Id'])) 
	{
		header('Location: logout.php');
	}

	$apikey = $_SESSION['ApiKey'];

	if (!isset($_POST)) 
	{
		header('Location: index.php');
	}
	else
	{
		$params = array('IngresoId' => $_POST['ingresoId']);
	}


	$ch = curl_init();
	//setup cURL
	$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/planillas/protocoloUnoUno',
					 CURLOPT_POST => TRUE,
					 CURLOPT_RETURNTRANSFER => TRUE,
					 CURLOPT_HTTPHEADER => array('Content-Type: application/json',
					 							 'Authorization: '. $apikey),
					 CURLOPT_POSTFIELDS => json_encode($params));

	curl_setopt_array($ch, $options);

	$response = curl_exec($ch);

	curl_close($ch);

	//echo $response;

	if ($response == FALSE)
	{
		die(curl_error($ch));
	}	

	$responseData = json_decode($response, TRUE);	

	if ($responseData["error"] == TRUE) 
	{
		echo "Ocurrió un error al intentar generar el PDF. Por favor intentenlo nuevamente o pruebe más tarde.";
		exit;
	}
	else
	{
		require_once('pdf/fpdf.php');
		
		class PDF extends FPDF
		{
			//Encabezado de hoja
			function Cabecera()
			{
			    // Logo
			    //$this->Image($_SESSION['UrlParcialLogo'],170,6,30,30);

			    //Nombre doc
			    //$this->SetTitle('protocolo-uno-a-uno-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
			    
			    // Seteo la fuente para el nombre del laboratorio
			    $this->SetFont('Arial','BI',12);
			   
			    //Nombre Lab
			    //$this->Cell(20,-12,$_SESSION['NombreLab'],0,0,'L');
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
			    $this->Cell(0,-12,iconv('UTF-8', 'windows-1252', 'Protocolo Uno a Uno'));
			}

			function DibujarPacientes($pacientes)
			{
				$this->Ln(5);
				if (count($pacientes) > 0) 
				{	
					$j = 0;
					foreach ($pacientes as $paciente) 
					{
						$this->SetFont('Arial','B',10);
						$this->Cell(19,10,iconv('UTF-8', 'windows-1252', $paciente['NumPaciente']));

						$this->SetFont('Arial','B',10);
						$this->Cell(60,10,iconv('UTF-8', 'windows-1252', $paciente['ApellidoNombre']));

						$now = time();
						$your_date = strtotime($paciente['FechaNacimiento']);
						$datediff = $now - $your_date;
						$edad = floor($datediff / (60 * 60 * 24 * 365));

						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Edad: '.$edad));

						$paciente['Sexo'] == 0 ? $sexo = 'M' : $sexo = 'F';
						$paciente['Sexo'] == null ? $sexo = 'NE' : '';
						$this->SetFont('Arial','B',10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Sexo: '.$sexo));

						$paciente['ApellidoMed'] == null ? $medico = 'No especifica' : $medico =$paciente['ApellidoMed'].', '.$paciente['NombreMed'];
						$this->SetFont('Arial','B',10);
						$this->Cell(40,10,iconv('UTF-8', 'windows-1252', 'Dr./Dra.: '.$medico));

						$this->Ln(10);
						$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Prácticas:'));
						$this->Ln(5);
						
						foreach ($paciente['IngresosPractica'] as $ingresoP) 
						{
							$this->Cell(10,10,$ingresoP['Codigo']);
						}
						$this->Ln(10);

						foreach ($paciente['IngresosPractica'] as $ingresoP) 
						{
							$this->Cell(10,10,iconv('UTF-8', 'windows-1252', $ingresoP['Codigo']));
							$this->Cell(45,10,iconv('UTF-8', 'windows-1252', '_____'));							
							$this->Ln(5);
						}


						if ($_POST['fichas-individuales'] == 1) 
						{
							if ((count($pacientes) - 1) !== $j) //ultimo ingreso, no necesita otra pagina porque no hay siguiente
							{
								$this->AddPage();
								$this->Cabecera();
								$this->Ln(10);
							}
						}
						else
						{
							if ((count($pacientes) - 1) !== $j) //ultimo ingreso, no necesita otra linea porque no hay siguiente
							{
								$this->Ln(5);
								$this->Cell(0,10,'-------------------------------------------------------------------------------------------------------------------------------------------------------------');
								$this->Ln(5);
							}
						}
						$j++;
					}
				}
			}
		} 
		
		// Instanciación de la clase pdf
		$pdf = new PDF();

		//alias para el número de páginas
		$pdf->AliasNbPages();

		//agrego la primer pagina
		$pdf->AddPage();

		//llamada a la funcion Cabecera
		$pdf->Cabecera();

		//llamada a la funcion DibujarIngresos con el respons del cURL
		//$pdf->DibujarPacientes($responseData['data']);

		//Mostrar pdf generado	
		$pdf->Output();
	}
?>