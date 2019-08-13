<?php
require("../controlador/session.php");
set_time_limit(0);
if (isset ($_REQUEST['txtCodigoCertificado'])){
	//----- Incluye la librería -----//
	require('../includes/fpdf181/fpdf.php');
	//----- Evalúa si el certificado es para un modulo o un curso -----//
	if($_REQUEST['txtTipoCertificado'] == '405'){
		switch ($_REQUEST['txtFormatoCertificado']) {
		    case '1':
		    	class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,57,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(30);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(15);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."del ";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."del curso";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    default:
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."de la capacitación";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						}
						$this->Ln(15);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo1),0,2,'C');
						$this->Ln(6);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo2),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso1),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso2),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],108,133);
						//Salto de línea
						$this->Ln(30);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
				break;
		    case '2':
		    	class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,60,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(32);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."del ";
						        $curso1 = $_REQUEST['txtCurso'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."del curso";
						        $curso1 = $_REQUEST['txtCurso'];
						        break;
						    default:
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo'];
						        $modulo2 = $_REQUEST['txtModulo1']."de la capacitación";
						        $curso1 = $_REQUEST['txtCurso'];
						}
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo1),0,2,'C');
						$this->Ln(6);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo2),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso1),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],108,130);
						//Salto de línea
						$this->Ln(30);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
				break;
		    case '3':
		    	class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,60,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(32);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo']." del ";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo']." del curso";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    default:
						        $modulo1 = "Asistió al módulo ".$_REQUEST['txtModulo']." de la capacitación";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						}
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo1),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso1),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso2),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],108,131);
						//Salto de línea
						$this->Ln(28);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
				break;
		    case '4':
		    	class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,65,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(35);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(19);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo = "Asistió al módulo ".$_REQUEST['txtModulo']." del ";
						        $curso = $_REQUEST['txtCurso'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo = "Asistió al módulo ".$_REQUEST['txtModulo']." del curso";
						        $curso = $_REQUEST['txtCurso'];
						        break;
						    default:
						        $modulo = "Asistió al módulo ".$_REQUEST['txtModulo']." de la capacitación";
						        $curso = $_REQUEST['txtCurso'];
						}
						$this->Ln(18);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],108,130);
						//Salto de línea
						$this->Ln(30);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
		}
	}else{
		switch ($_REQUEST['txtFormatoCertificado']) {
		    case '5':
				class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,60,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(32);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo = "Asistió al";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo = "Asistió al curso";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						        break;
						    default:
						        $modulo = "Asistió a la capacitación";
						        $curso1 = $_REQUEST['txtCurso'];
						        $curso2 = $_REQUEST['txtCurso1'];
						}
						$this->Ln(17);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso1),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso2),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],115,130);
						//Salto de línea
						$this->Ln(28);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
				break;
			case '6':
				class PDF extends FPDF{
					//echo Cabecera de página
					function Header(){
						//---- HORIZONTAL -------
						//Marca de agua
						$this->Image('../vista/images/marcadeagua.png',20,65,240);
						//Logo
						$this->Image('../vista/images/logo-colsubsidio.png',20,9,64);
						//Arial bold 15
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-cet.png',104,12,90);
						//Movernos a la derecha
						$this->Cell(80);
						//Título
						//$this->Cell(30,10,'Title',1,0,'C');
						$this->Image('../vista/images/logo-airbus.png',217,12,42);
						//Salto de línea
						$this->Ln(35);
						
						//parte media
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("CORPORACIÓN DE EDUCACIÓN TECNOLÓGICA COLSUBSIDIO - AIRBUS GROUP"),0,2,'C');
						//this->Ln(20);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Ln(6);
						$this->Cell(260,0,utf8_decode("Autorización oficial según Resolución No. 9150 del 22 de octubre de 2010 del Ministerio de Educación Nacional"),0,2,'C');
						//this->Ln(20);
						
						$this->Ln(19);
						$this->SetFont('Arial','B',15);
						//Movernos a la derecha
						$this->Cell(260,0,utf8_decode("HACE CONSTAR QUE:"),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($_REQUEST['txtEstudiante']),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',12);
						$this->Cell(260,0,utf8_decode("Identificado(a) con ".$_REQUEST['txtTipoIdentificacion']." ".$_REQUEST['txtNumeroIdentificacion']." expedida en ".$_REQUEST['txtLugarExpedicion']),0,2,'C');
						//Para colocar la leyenda de los módulos y cursos a los que asistió
						switch ($_REQUEST['txtRuta']) {
						    case '100':
						        $modulo = "Asistió al";
						        $curso1 = $_REQUEST['txtCurso'];
						        break;
						    case '4':
						    case '5':
						    case '7':
						        $modulo = "Asistió al curso";
						        $curso1 = $_REQUEST['txtCurso'];
						        break;
						    default:
						        $modulo = "Asistió a la capacitación";
						        $curso1 = $_REQUEST['txtCurso'];
						}
						$this->Ln(18);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode($modulo),0,2,'C');
						$this->Ln(9);
						$this->SetFont('Arial','B',25);
						$this->Cell(260,0,utf8_decode($curso1),0,2,'C');
						$this->Ln(8);
						$this->SetFont('Arial','B',15);
						$this->Cell(260,0,utf8_decode("Con una duración total de ".$_REQUEST['txtDuracion']),0,2,'C');
						
						//Firma
						$this->Image($_REQUEST['txtRutaFirma'],115,130);
						//Salto de línea
						$this->Ln(30);
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,"_____________________________________________",0,2,'C');
						
						$this->SetFont('Arial','B',12);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode($_REQUEST['txtNombreSecretaria']),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						//Movernos a la derecha
						$this->Cell(260,5,utf8_decode("Secretaría Académica"),0,2,'C');
						
						$this->SetFont('Arial','B',10);
						$fecha = explode("-",$_REQUEST['txtFechaCertificado']);
						$dia = $fecha[2];
						$mes = $fecha[1];
						switch ($mes) {
							case "01":
								$mes="Enero";
								break;
							case "02":
								$mes="Febrero";
								break;
							case "03":
								$mes="Marzo";
								break;
							case "04":
								$mes="Abril";
								break;
							case "05":
								$mes="Mayo";
								break;
							case "06":
								$mes="Junio";
								break;
							case "07":
								$mes="Julio";
								break;
							case "08":
								$mes="Agosto";
								break;
							case "09":
								$mes="Septiembre";
								break;
							case "10":
								$mes="Octubre";
								break;
							case "11":
								$mes="Noviembre";
								break;
							case "12":
								$mes="Diciembre";
								break;
						}
						$anio = $fecha[0];
						//Movernos a la derecha
						$this->Ln(10);
						$this->Cell(260,0,utf8_decode("Dado en Bogotá D.C., a los ".$dia." días del mes de ".$mes." de ".$anio),0,2,'C');
						$this->Ln(5);
						$this->SetFont('Arial','B',10);
						$this->Cell(260,0,utf8_decode("Personería jurídica Nº. 9150 de oct. 22 de 2010"),0,2,'C');
						$this->Ln(5);
						$this->Cell(260,0,utf8_decode("VIGILADA MINEDUCACIÓN"),0,2,'C');
						//Codigo QR
						$this->Image('../vista/images/qr_certificados.png',55,185,25);
						$this->Ln(9);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("La autenticidad de este documento puede ser verificada en el registro que se encuentra en"),0,2,'C');
						$this->Ln(3);
						$this->SetFont('Arial','',8);
						$this->Cell(260,0,utf8_decode("la página web https://certificados.cetcolsubsidio.edu.co bajo el código ".$_REQUEST['txtCodigoCertificado']),0,2,'C');
						//---- FIN HORIZONTAL -------
					}
				}
				break;	
		}
	}
	//Creación del objeto de la clase heredada
	$pdf=new PDF('L','mm','Letter');
	$pdf->Output($_REQUEST['txtCodigoCertificado'].'.pdf','I');
}else{
	echo "No llegan los datos";
}
?>