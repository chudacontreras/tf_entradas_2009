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
		$telefono = $_POST[cod].$_POST[telefono];
		if ($_SESSION["guarda"]=="si"){
			$result= $con->ejecutar("INSERT INTO clientes values (".$_POST[cedula].",'".$_POST[nombres]."','".$_POST[apellidos]."','".$_POST[direccion]."','".$telefono."')",$idcon);
			// PENDIENTE if (!$result){ js_redireccion("")}
			//echo "INSERT INTO clientes values (".$_POST[cedula].",'".$_POST[nombres]."','".$_POST[apellidos]."','".$_POST[direccion]."','".$telefono."')";
		}
		
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Venta de Entradas y Abonos</title>
<script language="javascript">
function validar(formulario) {
  if (formulario.total.value.length < 2) {
    alert("Debe Adquirir por lo menos una entrada");
    //formulario.nombres.focus();
    return (false);
  }  
  return (true);
}
</script>

<script>
function calculo(cantidad,grama,g_pref,g_gral,inputtext,totaltext){

    pgrama = document.getElementById("grama"+cantidad).selectedIndex;
    ppref = document.getElementById("pref"+cantidad).selectedIndex;
    pgral = document.getElementById("gral"+cantidad).selectedIndex;

	subtotal = (pgrama*grama)+(ppref*g_pref)+(pgral*g_gral);
	inputtext.value=subtotal;
	//alert (cantidad);
	
	total = eval(document.getElementById('sub1').value) + eval(document.getElementById('sub2').value) + eval(document.getElementById('sub3').value) + eval(document.getElementById('sub4').value) + eval(document.getElementById('sub5').value) + eval(document.getElementById('sub6').value);
	totaltext.value = total;
}
</script>

<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>
<body>

<table width="938" height="400" border="1" align="center">
  <tr>
    <td width="222" rowspan="2" align="center">
	<img src="imagenes/gobernacion.png" width="130" height="80" />
	<img src="imagenes/topfestival.png" width="213" height="225" />
	<img src="imagenes/cortulara.jpg" />
    </td>
    <td width="1486" align="center">
	
		<div align="center">
		<?php
		echo "<br><br>".$_POST[nombres]." ".$_POST[apellidos]."<br>";
		echo $_POST[cedula]."<br><br>";
		?>
		</div>

		<table width="100%" border="0" align="center">
		<form name="frm_venta" onSubmit = "return validar(this)" action="recibo.php" method="post">
		<!-- COSTO DE LAS ENTRADAS - DEBE SER AUTOMATIZADO --->
			<input type="hidden" name="grama" value="70" />
			<input type="hidden" name="g_pref" value="80" />
			<input type="hidden" name="g_gral" value="70" />
			<input type="hidden" name="abono" value="450" />
		  <tr>
			<td align="center" valign="middle" bgcolor="#3A3129" width="15%"><span class="Estilo1">D&iacute;a</span></td>
			<td align="center" valign="middle" bgcolor="#3A3129" width="40%"><span class="Estilo1">Artistas</span></td>
			<td align="center" valign="middle" bgcolor="#3A3129" width="10%"><span class="Estilo1">Grama</span></td>
			<td align="center" valign="middle" bgcolor="#3A3129" width="10%"><span class="Estilo1">Pref.</span></td>
			<td align="center" valign="middle" bgcolor="#3A3129" width="10%"><span class="Estilo1">Gral</span></td>
			<td align="center" valign="middle" bgcolor="#3A3129" width="15%"><span class="Estilo1">Sub-total</span></td>
		  </tr>
		
		<?php
			$result2= $con->ejecutar("SELECT * FROM cartelera",$idcon);
			$cen = 0;
			$_SESSION[cont] = 0;
			while ($fila = mysql_fetch_array($result2)){
				if ($cen == 0){
					$color="#E2AC35";
					$cen = 1;
				}else{ 
					$color="#EFE136";
					$cen = 0;
				}
				echo "<input type='hidden' name='dia".$fila[id]."' value='".substr(cambiaf_a_normal($fila[dia]),0,2)."'>";
				echo "<input type='hidden' name='cart".$fila[id]."' value='".$fila[id]."'>";
				echo "<tr><td align='center' valign='middle' bgcolor='".$color."'>".cambiaf_a_normal($fila[dia])."</td>";
				echo "<td align='center' valign='middle' bgcolor='".$color."'>".$fila[genero]."</td>";
				echo "<td align='center' valign='middle' bgcolor='".$color."'><select name='grama".$fila[id]."' id='grama".$fila[id]."'
					 onChange='calculo(".$fila[id].",grama.value,g_pref.value,g_gral.value,sub".$fila[id].",total);'>
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select></td>";
				echo "<td align='center' valign='middle' bgcolor='".$color."'><select name='pref".$fila[id]."' id='pref".$fila[id]."'
					 onChange='calculo(".$fila[id].",grama.value,g_pref.value,g_gral.value,sub".$fila[id].",total);'>
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select></td>";
				echo "<td align='center' valign='middle' bgcolor='".$color."'><select name='gral".$fila[id]."' id='gral".$fila[id]."'
					 onChange='calculo(".$fila[id].",grama.value,g_pref.value,g_gral.value,sub".$fila[id].",total);'>
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select></td>";
				echo "<td align='center' valign='middle' bgcolor='".$color."'><input name='sub".$fila[id]."' type='text' id='sub".$fila[id]."' value='0' readonly='yes' size='5' />
		    Bs.</td></tr>";
				$_SESSION[cont]++;
			}
		?>

		  <tr>
			<td align="center" valign="middle" colspan="6">&nbsp;</td>
		  </tr>  


		  <tr>
			<td align="right" valign="middle" colspan="5">TOTAL:&nbsp;&nbsp;</td>
			<td align="center"><input name="total" type="text" value="0" readonly="yes" size="5" /> 
			  Bs.</td>
		  </tr> 
		  <tr>
			<td colspan="6" align="center" valign="middle">
				<br>
				<table width="31%" border="0">
				  <tr>
					<td colspan="4" align="center">Forma de Pago</td>
				  </tr>
				  <tr>
					<td width="7%"><input name="pago" type="radio" value="E" checked></td>
					<td width="44%">Efectivo</td>
					<td width="7%"><input name="pago" type="radio" value="T"></td>
					<td width="42%">Tarjeta</td>
				  </tr>
			  </table>
			  <br>
			</td>
		  </tr>		  
		  <tr>
			<td align="center" valign="middle" colspan="6">
				<input type="submit" name="enviar" value="Enviar">
				<input type="button" name="enviar" value="Cancelar" onClick="javascript:history.back();">			</td>
		  </tr>		   
		  </form>
	</table>	</td>
  </tr>
</table>
</body>
</html>
