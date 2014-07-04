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
$_SESSION["codigo"] = $_POST[busca];

		
		$resultF= $con->ejecutar("SELECT * FROM cab_ventas where codigo='".$_SESSION["codigo"]."'",$idcon);
if (mysql_num_rows($resultF)<=0){
    echo "EL c&oacute;digo que introdujo es incorrecto o no se encuentra registrado"; exit;
}

		$filaF = mysql_fetch_array($resultF);


$_SESSION["cedula"] = $filaF["cedula"];

		$result_V= $con->ejecutar("SELECT * FROM login where login='".$filaF["vendedor"]."'",$idcon);
		$fila_V = mysql_fetch_array($result_V);

		$result2= $con->ejecutar("SELECT * FROM clientes where cedula='".$_SESSION["cedula"]."'",$idcon);
		$fila2 = mysql_fetch_array($result2);

		$resultF= $con->ejecutar("SELECT * FROM cen_com where id=".$filaF["centro_com"]."",$idcon);
		$filaC = mysql_fetch_array($resultF);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo de Pago</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo8 {font-family: Arial, Helvetica, sans-serif; font-size: 8; }
.Estilo9 {font-size: 9}
.Estilo12 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
-->
</style>
</head>

<body>

<table width="89%" height="0" border="1" align="center">
  <tr>
    <td>
    <table width="100%" border="0">
      <tr>
        <td width="11%" align="center" valign="middle"><a href="ppal.php"><img src="imagenes/cortulara.jpg" border="0" /></a></td>
        <td width="44%" align="center" valign="middle">
			<span class="Estilo1">Corporaci&oacute;n de Turismo del Estado Lara<br>
			<strong>CORTULARA</strong><br>
			Carrera 19 esquina calle 25. Palacio de Gobierno<br>
			Tel&eacute;fonos: 0251-2338239 <br>
		  R.I.F.: G20003863-2          </span></td>
        <td width="13%" align="center" valign="middle"><a href="ppal.php"><img src="imagenes/cortulara.jpg" border="0" /></a></td>
        <td width="32%" align="center" valign="middle"><span class="Estilo8"><?php echo $filaC["nombre"] ?><br><?php echo $_SESSION["codigo"] ?><br>
                  <?php  echo $filaF['fecha'];  ?><br>Re-Impresi&oacute;n de Recibo</span></td>
      </tr>
    </table>

      <table width="100%" border="0">
        <tr>
          <td width="14%" align="left" class="Estilo1"><span class="Estilo8">Cliente:</span></td>
          <td width="33%" class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["apellidos"]." ".$fila2 ["nombres"]; ?></span></td>
          <td width="6%" class="Estilo1"><span class="Estilo8">Direcci&oacute;n:</span></td>
          <td width="47%" class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["direccion"]; ?></span></td>
        </tr>
        <tr>
          <td align="left" class="Estilo1"><span class="Estilo8">C&eacute;dula / R.I.F.: </span></td>
          <td class="Estilo1"><span class="Estilo8"><?php echo $_SESSION["cedula"]; ?></span></td>
          <td class="Estilo1"><span class="Estilo8">Tel&eacute;fono:</span></td>
          <td class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["telefono"]; ?></span></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td width="62%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Descripci&oacute;n</span></td>
          <td width="10%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Cantidad</span></td>
          <td width="15%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Precio Unitario</span></td>
          <td width="13%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Neto</span></td>
        </tr>
<?php
		$result3= $con->ejecutar("SELECT * FROM det_ventas where codigo='".$_SESSION["codigo"]."'",$idcon);
		while ($fila3 = mysql_fetch_array($result3)) {
			//echo "SELECT * FROM cartelera where dia=".$fila3["dia"];
			$result4= $con->ejecutar("SELECT * FROM cartelera where dia=".$fila3["dia"],$idcon);
			$fila4 = mysql_fetch_array($result4);
			echo "<tr>";
			//Consulta para conocer el tipo de entrada
			$result5= $con->ejecutar("SELECT * FROM tip_ent where id=".$fila3["tipo"],$idcon);
			$fila5 = mysql_fetch_array($result5);

			//Consulta para saber los datos de la cartelera
			$result6= $con->ejecutar("SELECT * FROM cartelera where id=".$fila3["dia"],$idcon);
			$fila6 = mysql_fetch_array($result6);
			
			echo "<td align='left' height='16' valign='middle'><span class='Estilo1'>".$fila5["tipo"].": ".$fila6["cartelera"]." (".cambiaf_a_normal($fila6[dia]).")</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila3["cantidad"]."</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila5["costo"]."</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila3["cantidad"]*$fila5["costo"]."</span></td>";
			echo "</tr>";					
		}
			echo "<tr>";
			echo "<td align='left' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "</tr>";
			$result7= $con->ejecutar("SELECT * FROM cab_ventas where codigo='".$_SESSION["codigo"]."'",$idcon);
			$fila7 = mysql_fetch_array($result7);
			echo "<tr>";
			echo "<td align='left' valign='middle'></td>";
			echo "<td align='right' valign='middle'></td>";
			echo "<td align='right' valign='middle'><span class='Estilo12'>TOTAL Bs.</span></td>";
			echo "<td align='right' valign='middle'><span class='Estilo12'>".$fila7["total"]."</span></td>";
			echo "</tr>";
			
			if ($fila7["pago"] == 'E'){
				$pago = 'EFECTIVO';
			}else{
				$pago = 'TARJETA';
			}						
?>	
      </table>

		<table width="100%" border="0">
		  <tr>
			<td width="28%" height="2" align="center" valign="middle">___________________</td>
			<td width="3%" align="center" valign="middle">&nbsp;</td>
			<td width="29%" align="center" valign="middle">__________________</td>
		    <td width="40%" rowspan="2" align="center" valign="middle" class="Estilo1">Forma de Pago: <?php echo $pago ?></td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="Estilo1">Recibido </td>
			<td align="center" valign="middle">&nbsp;</td>
			<td align="center" valign="middle" class="Estilo1">Reimpresi&oacute;n: <?php echo $_SESSION["usuario"] ?><br>
				Vendedor: <?php echo $fila_V["nombre"]." ".$fila_V["apellido"]; ?>
			</td>
	      </tr>
	      <tr>
		<td colspan="4" align="center" class="Estilo1"><strong>Nota:</strong>  Las entradas ser&aacute;n canjeadas previa  presentaci&oacute;n de la  C&eacute;dula  de  Identidad  laminada <br />
		  los d&iacute;as  23, 24 y 25 de Octubre de 2009 en la Carr. 19 esquina calle 25 , Palacio de Gobierno</td>
	      </tr>

	  </table>	  
	  
    </td>
  </td>
</table>
<?php /*
<div align="center"><br><br>-------------------------------------------------------------------------------------------------------------------<br><br>
</div>
<table width="89%" height="0" border="1" align="center">
  <tr>
    <td>
    <table width="100%" border="0">
      <tr>
        <td width="11%" align="center" valign="middle"><a href="ppal.php"><img src="imagenes/cortulara.jpg" border="0" /></a></td>
        <td width="44%" align="center" valign="middle">
			<span class="Estilo1">Corporaci&oacute;n de Turismo del Estado Lara<br>
			<strong>CORTULARA, C.A.</strong><br>
			Carrera 19 esquina calle 25. Palacio de Gobierno<br>
			Tel&eacute;fonos: 0251-2338239 <br>
		  R.I.F.: G20003863-2          </span></td>
        <td width="13%" align="center" valign="middle"><a href="ppal.php"><img src="imagenes/cortulara.jpg" border="0" /></a></td>
        <td width="32%" align="center" valign="middle"><span class="Estilo8"><?php echo $filaC["nombre"] ?><br><?php echo $_SESSION["codigo"] ?><br>
        </span>          <?php  echo $filaF['fecha'];  ?></td>
      </tr>
    </table>

      <table width="100%" border="0">
        <tr>
          <td width="14%" align="left" class="Estilo1"><span class="Estilo8">Cliente:</span></td>
          <td width="33%" class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["apellidos"]." ".$fila2 ["nombres"]; ?></span></td>
          <td width="6%" class="Estilo1"><span class="Estilo8">Direcci&oacute;n:</span></td>
          <td width="47%" class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["direccion"]; ?></span></td>
        </tr>
        <tr>
          <td align="left" class="Estilo1"><span class="Estilo8">C&eacute;dula / R.I.F.: </span></td>
          <td class="Estilo1"><span class="Estilo8"><?php echo $_SESSION["cedula"]; ?></span></td>
          <td class="Estilo1"><span class="Estilo8">Tel&eacute;fono:</span></td>
          <td class="Estilo1"><span class="Estilo8"><?php echo $fila2 ["telefono"]; ?></span></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td width="62%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Descripci&oacute;n</span></td>
          <td width="10%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Cantidad</span></td>
          <td width="15%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Precio Unitario</span></td>
          <td width="13%" align="center" valign="middle" bgcolor="#CCCCCC"><span class="Estilo12">Neto</span></td>
        </tr>
<?php
		$result3= $con->ejecutar("SELECT * FROM det_ventas where codigo='".$_SESSION["codigo"]."'",$idcon);
		while ($fila3 = mysql_fetch_array($result3)) {
			//echo "SELECT * FROM cartelera where dia=".$fila3["dia"];
			$result4= $con->ejecutar("SELECT * FROM cartelera where dia=".$fila3["dia"],$idcon);
			$fila4 = mysql_fetch_array($result4);
			echo "<tr>";
			//Consulta para conocer el tipo de entrada
			$result5= $con->ejecutar("SELECT * FROM tip_ent where id=".$fila3["tipo"],$idcon);
			$fila5 = mysql_fetch_array($result5);

			//Consulta para saber los datos de la cartelera
			$result6= $con->ejecutar("SELECT * FROM cartelera where id=".$fila3["dia"],$idcon);
			$fila6 = mysql_fetch_array($result6);
			
			echo "<td align='left' height='16' valign='middle'><span class='Estilo1'>".$fila5["tipo"].": ".$fila6["cartelera"]." (".cambiaf_a_normal($fila6[dia]).")</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila3["cantidad"]."</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila5["costo"]."</span></td>";

			echo "<td align='right' valign='middle'><span class='Estilo1'>".$fila3["cantidad"]*$fila5["costo"]."</span></td>";
			echo "</tr>";					
		}
			echo "<tr>";
			echo "<td align='left' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "<td align='right' valign='middle'>&nbsp;</td>";
			echo "</tr>";
			$result7= $con->ejecutar("SELECT * FROM cab_ventas where codigo='".$_SESSION["codigo"]."'",$idcon);
			$fila7 = mysql_fetch_array($result7);
			echo "<tr>";
			echo "<td align='left' valign='middle'></td>";
			echo "<td align='right' valign='middle'></td>";
			echo "<td align='right' valign='middle'><span class='Estilo12'>TOTAL Bs.</span></td>";
			echo "<td align='right' valign='middle'><span class='Estilo12'>".$fila7["total"]."</span></td>";
			echo "</tr>";
			if ($fila7["pago"] == 'E'){
				$pago = 'EFECTIVO';
			}else{
				$pago = 'TARJETA';
			}						
?>	
      </table>

		<table width="100%" border="0">
		  <tr>
			<td width="28%" height="2" align="center" valign="middle">___________________</td>
			<td width="3%" align="center" valign="middle">&nbsp;</td>
			<td width="29%" align="center" valign="middle">__________________</td>
		    <td width="40%" rowspan="2" align="center" valign="middle" class="Estilo1">Forma de Pago: <?php echo $pago ?></td>
		  </tr>
		  <tr>
			<td align="center" valign="middle" class="Estilo1">Recibido </td>
			<td align="center" valign="middle">&nbsp;</td>
			<td align="center" valign="middle" class="Estilo1">Vendedor: <?php echo $_SESSION["usuario"] ?></td>
	      </tr>
	      <tr>
		<td colspan="4" align="center" class="Estilo1"><strong>Nota:</strong>  Las entradas ser&aacute;n canjeadas previa  presentaci&oacute;n de la  C&eacute;dula  de  Identidad  laminada <br />
		  los d&iacute;as  23, 24 y 25 de Octubre de 2009 en la Carr. 19 esquina calle 25 , Palacio de Gobierno</td>
	      </tr>

	  </table>	  
	  
    </td>
  </td>
</table>*/?>
</body>
</html>
