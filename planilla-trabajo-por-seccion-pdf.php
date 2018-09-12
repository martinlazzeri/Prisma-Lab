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

	switch ($_POST['pendientes']) 
	{
		case 0: //pendientes
				$params = array('NumDesde' => $_POST['desdePaciente'],
								'NumHasta' => $_POST['hastaPaciente'],
								'SeccionDesde' => $_POST['desdeSeccion'],
								'SeccionHasta' => $_POST['hastaSeccion'],
								'Origen' => $_POST['origen']);

				$ch = curl_init();
				//setup cURL
				$options = array(CURLOPT_URL => 'http://www.entity-studio.com/jjlab/api/planillas/ingresospendientes',
								 CURLOPT_POST => TRUE,
								 CURLOPT_RETURNTRANSFER => TRUE,
								 CURLOPT_HTTPHEADER => array('Content-Type: application/json',
								 							 'Authorization: '.$apikey),
								 CURLOPT_POSTFIELDS => json_encode($params));

				curl_setopt_array($ch, $options);

				$response = curl_exec($ch);

				curl_close($ch);

				if ($response == FALSE)
				{
					die(curl_error($ch));
				}
			break;
		case 1: //normales
				$params = array('NumDesde' => $_POST['desdePaciente'],
								'NumHasta' => $_POST['hastaPaciente'],
								'SeccionDesde' => $_POST['desdeSeccion'],
								'SeccionHasta' => $_POST['hastaSeccion'],
								'Origen' => $_POST['origen']);
			break;
	}

	$responseData = json_decode($response, TRUE);	

	if ($responseData["error"] == TRUE) 
	{
		echo "error";
		exit;
	}
	else
	{
		echo "<pre>";
		echo print_r($responseData, true);
		/*require_once('pdf/fpdf.php');
		
		class PDF extends FPDF
		{
			//Encabezado de hoja
			function Cabecera()
			{
			    // Logo
			    //$this->Image($_SESSION['UrlParcialLogo'],170,6,30,30);

			    //Nombre doc
			    $this->SetTitle('planilla-trabajo-por-seccion-'.$_SESSION['NombreUsuario'].date('Y-m-d-H:i:s'));
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
			    $this->Cell(0,-12,iconv('UTF-8', 'windows-1252', 'Planilla de Trabajo por Sección'));
			}

			function DibujarIngresos($data)
			{
				if (count($data) > 0) 
				{
					$j = 0;
					foreach ($data['secciones'] as $seccion) 
					{
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(-10,10,iconv('UTF-8', 'windows-1252', 'Sección: ' . $seccion['Codigo'] . '  *  Nombre: ' . $seccion['Nombre']));
						$this->Ln(5);
						$this->Cell(-10,10,iconv('UTF-8', 'windows-1252', '***** INICIO DE SECCIÓN *****'));
						$this->Ln(5);

						$this->Cell(0,10,iconv('UTF-8', 'windows-1252', '----------------------------------------------------------------------------------------------------------------------------------------------------------------'));

						$this->Ln(4);

						$this->Cell(65,10,iconv('UTF-8', 'windows-1252', 'Procesó'));
						$this->Cell(65,10,iconv('UTF-8', 'windows-1252', 'Validó'));
						$this->Cell(65,10,iconv('UTF-8', 'windows-1252', 'Informó'));

						$this->Ln(3);

						$this->Cell(0,10,iconv('UTF-8', 'windows-1252', '----------------------------------------------------------------------------------------------------------------------------------------------------------------'));

						$this->Ln(5);

						$this->SetFont('Arial', '', 8);
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion1']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion2']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion3']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion4']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion5']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion6']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion7']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion8']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion9']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion10']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion11']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion12']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion13']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion14']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion15']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion16']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion17']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion18']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion19']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion20']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion21']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion22']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion23']));
						$this->Cell(7,10,iconv('UTF-8', 'windows-1252', $seccion['Determinacion24']));

						$this->Ln(5);

						foreach ($data['ingresos'] as $ingreso) 
						{
							
						}

						$this->SetFont('Arial', 'B', 10);
						$this->Cell(-10,10,iconv('UTF-8', 'windows-1252', 'Planilla de trabajo Pendiente desde la sección '.$_POST['desdeSeccion'].' hasta la sección '.$_POST['hastaSeccion']. ' y desde el paciente '.$_POST['desdePaciente']));
						$this->Ln(5);
						$this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'hasta el paciente '. $_POST['hastaPaciente']));
						$this->Ln(5);
						$this->Cell(0,10,iconv('UTF-8', 'windows-1252', '################################################################################################'));

						if ($j !== (count($data['secciones']) - 1)) 
						{
							$this->AddPage();
							$this->Cabecera();	
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
		$pdf->DibujarIngresos($responseData);
		//Mostrar pdf generado	
		$pdf->Output();*/
	}
?>