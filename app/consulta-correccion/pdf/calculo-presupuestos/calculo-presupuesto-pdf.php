<?php
	session_start();

	if (!isset($_SESSION['ApiKey'])) 
	{
		header('Location: logout.php');
	}

	if ($_POST)
	{
		$responseData = $_POST;
	}

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
		    $this->Cell(0,-12,iconv('UTF-8', 'windows-1252', 'Comprobante de Cálculo de Presupuesto'));
		}

		function DibujarComprobante($comprobante)
		{
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(39,10,iconv('UTF-8', 'windows-1252', 'Nombre del paciente: '));
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $comprobante['nombre']));
			
			$this->Ln(5);

			$this->SetFont('Arial','B',10);
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'Obra Social N° 1: '));
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(50,10,iconv('UTF-8', 'windows-1252', $comprobante['obra1']));

			$this->Ln(5);

			$this->SetFont('Arial','B',10);
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', 'N° Afiliado N° 1: '));
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(42,10,iconv('UTF-8', 'windows-1252', $comprobante['num-afiliado1']));

			$this->SetFont('Arial','B',10);
			$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Debe orden N° 1? '));
			$this->SetFont('LucidaConsole','',10);
			$comprobante['debe-orden1'] == 0 ? $debeorden1 = 'No' : $debeorden1 = 'Si';
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $debeorden1));

			$this->Ln(5);

			$this->SetFont('Arial','B',10);
			$this->Cell(32,10,iconv('UTF-8', 'windows-1252', 'Tipo Afiliado N° 1: '));
			$this->SetFont('LucidaConsole','',10);
			$comprobante['tipo-afiliado1'] == 0 ? $tipoafiliado1 = 'Obligatorio' : $tipoafiliado1 = 'Voluntario';
			$this->Cell(40,10,iconv('UTF-8', 'windows-1252', $tipoafiliado1));

			$this->SetFont('Arial','B',10);
			$this->Cell(38,10,iconv('UTF-8', 'windows-1252', 'Porc. Cobertura N° 1: '));
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $comprobante['porc-cobertura1'].' %'));

			$this->SetFont('Arial','B',10);
			$this->Cell(25,10,iconv('UTF-8', 'windows-1252', 'Abona APB: '));
			$this->SetFont('LucidaConsole','',10);
			$comprobante['abona-apb1'] == 0 ? $abonaapb1 == 'No' : $abonaapb1 = 'Si';
			$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $abonaapb1));

			$this->Ln(10);

			$this->SetFont('Arial','B',10);
			$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Prácticas'));

			$this->Ln(5);
			
			for($i = 1; $i <= 20; $i++)
			{
				if ($comprobante['p'.$i]) 
				{
					$this->SetFont('Arial','B',10);
					$this->Cell(20,10,iconv('UTF-8', 'windows-1252', 'Código: '));
					$this->SetFont('LucidaConsole','',10);
					$this->Cell(30,10,iconv('UTF-8', 'windows-1252', $comprobante['p'.$i]));
					$this->Ln(5);
				}
			}
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Importe Boleta');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['importe-boleta']);
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Importe Mutual1');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['importe-mutual1']);
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Importe Mutual2');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['importe-mutual2']);
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Importe Paciente');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['importe-paciente']);
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Importe APB');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['importe-apb']);
			
			$this->Ln(5);
			
			$this->SetFont('Arial','B',10);
			$this->Cell(35,10,'Total');
			$this->SetFont('LucidaConsole','',10);
			$this->Cell(20,10,'$ '. $comprobante['total']);
		}
	}

	// Instanciación de la clase pdf
	$pdf = new PDF();	
	$pdf->AddFont('LucidaConsole','','lucida-console.php');
	//alias para el número de páginas
	$pdf->AliasNbPages();
	//agrega la primer página
	$pdf->AddPage();
	//llamada a la funcion Cabecera
	$pdf->Cabecera();
	//llamada a la función para dibujar el comprobante
	$pdf->DibujarComprobante($responseData)	;

	//Mostrar pdf generado	
	$pdf->Output();
?>