<?php
session_start();

include("ControlaBD.php");
include("util.php");
if ($_SESSION["sesion"] != "TRUE") {
	js_redireccion("index.php");
	exit; 
}
		$con   = new ControlaBD();
		$idcon = $con->conectarSBD();
		$sel_bd= $con->select_BD("topfestival");
		
$tarjeta = 0;
$efectivo = 0;
require('fpdf.php');
$fecha = date("d / m / Y")." a las ".(date("h")-1).":".(date("i A"));
$pdf=new FPDF('P','mm','letter');
$pdf->AddPage();

// ENCABEZADO
$pdf->Image ("./imagenes/gobernacion.jpg", 40,17,25,15, "JPG");
$pdf->SetFont ("arial","",8); //Tama�o de la letra
$pdf->SetXY(1,20);
$pdf->Cell (214, 4, "CORTULARA",0,1,"C");
$pdf->SetXY(1,24);
$pdf->Cell (214, 4, "Reporte de Ventas al ".$fecha,0,1,"C");

$pdf->SetXY(1,28);
$pdf->Cell (214, 4, $_SESSION["usuario"],0,1,"C");
$pdf->Image ("./imagenes/cortulara.jpg", 150,17,25,15, "JPG");

//Cabecera
$pdf->SetXY(35,42);
$pdf->SetFillColor(200,220,255);
$pdf->Cell (40, 4, 'Codigo',1,0,"C",1);
$pdf->Cell (45, 4, 'Dia',1,0,"C",1);
$pdf->Cell (20, 4, 'Cant.',1,0,"C",1);
$pdf->Cell (20, 4, 'Sub Total',1,0,"C",1);
$pdf->Cell (25, 4, 'Total',1,1,"C",1);

//Contenido del Reporte
$linea = 46;
$pdf->SetY($linea);
$pdf->SetFont ("arial","",7); //Tamaño de la letra
$result= $con->ejecutar("SELECT * FROM cab_ventas WHERE vendedor='".$_SESSION[login]."' and fecha like '".date("Y-m-d")."%'",$idcon);
$codi = "cualquier cosa";
$codi_ = "cualquier cosa";
$pdf->SetFillColor(179,179,179);
$color=0;
while ($fila = mysql_fetch_array($result)) {
	$result2= $con->ejecutar("SELECT * FROM det_ventas WHERE codigo='".$fila['codigo']."'",$idcon);	
	//$alto = mysql_num_rows($result);
	$alto = 0;
	$nro = mysql_num_rows($result2);
	while ($fila2 = mysql_fetch_array($result2)) {
		if ($fila2['dia'] == 0){
			$dia = "Abono";
		}else{
			$result_3=$con->ejecutar("SELECT * FROM cartelera WHERE id=".$fila2['dia']."",$idcon);
			$fila_3=mysql_fetch_array($result_3);
			$result_4=$con->ejecutar("SELECT * FROM tip_ent WHERE id=".$fila2['tipo']."",$idcon);
			$fila_4=mysql_fetch_array($result_4);
			$dia = $fila_4['tipo'].": ".cambiaf_a_normal($fila_3['dia']);
		}
	$pdf->SetX(35);

	if($codi != $fila['codigo']){
		$pdf->Cell (40, 4,$fila['codigo'],1,0,"C",1);
		$codi = $fila['codigo'];
	}else{
		$pdf->Cell (40, 4,"",1,0,"C",1);
	}

//$pdf->SetX(75);
		$pdf->Cell (45, 4, $dia,1,0,"L",1);
		$pdf->Cell (20, 4, $fila2['cantidad'],1,0,"C",1);
		$pdf->Cell (20, 4, $fila2['bs'],1,0,"R",1);
	//js_msgbox(($nro-1)." < ".$alto);	
	if(($nro-1) == $alto){
		$pdf->Cell (25, 4,$fila['total'],1,1,"R",1);
		//$codi = $fila['codigo'];
	}else{
		$pdf->Cell (25, 4,"",1,1,"R",1);
	}
//$pdf->SetX(160);
	

$alto++;
		
	}

	if ($fila['pago']=="T"){
		$tarjeta = $tarjeta+$fila['total'];
	}else{
		$efectivo = $efectivo+$fila['total'];
	}
	$total = $total + $fila['total'];
if ($color==0){
$pdf->SetFillColor(255,255,255);
$color=1;
}else{
$pdf->SetFillColor(179,179,179);
$color=0;
}
}
$pdf->SetFillColor(179,179,179);
$pdf->SetX(140);
$pdf->Cell (20, 4,"Tarjetas",1,0,"C",1);
$pdf->Cell (25, 4,$tarjeta,1,1,"R",1);

$linea = $linea+4;
//$pdf->SetY($linea);
$pdf->SetX(140);
$pdf->Cell (20, 4,"Efectivo",1,0,"C",1);
$pdf->Cell (25, 4,$efectivo,1,1,"R",1);

$linea = $linea+4;
//$pdf->SetY($linea);
$pdf->SetX(140);
$pdf->Cell (20, 4,"Total",1,0,"C",1);
$pdf->Cell (25, 4,$total,1,1,"R",1);

$pdf->Output('Rep_ven.pdf','I');

?>
