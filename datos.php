<?php
session_start();

include("ControlaBD.php");
include("util.php");
/* valida que haya iniciado sesion */
if ($_SESSION["sesion"] != "TRUE") {
	js_redireccion("index.php");
	exit;
}
/* Validacion basica para la cedula de identidad */
$_SESSION["cedula"] = $_POST["cedula"];
if ($_POST["cedula"] == "" || !(is_numeric($_POST["cedula"]))) {
	js_msgbox("Error en el Numero de Cedula, por favor verifique y vuelva a intentar");
	js_redireccion("ppal.php");
}else{
	$con   = new ControlaBD();
	$idcon = $con->conectarSBD();
	$sel_bd= $con->select_BD("topfestival");
	/* Verifica si el numero de cedula existe en la tabla clientes */
	$result= $con->ejecutar("SELECT * FROM clientes where cedula='".$_POST["cedula"]."'",$idcon);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
function validar(formulario) {
  if (formulario.nombres.value.length < 2) {
    alert("El campo \"Nombres\" no puede estar vac�o");
    formulario.nombres.focus();
    return (false);
  }
  if (formulario.apellidos.value.length < 2) {
    alert("El campo \"Apellidos\" no puede estar vac�o");
    formulario.apellidos.focus();
    return (false);
  }
  if (formulario.direccion.value.length < 5) {
    alert("El campo \"Direcci�n\" no puede estar vac�o");
    formulario.direccion.focus();
    return (false);
  }  
  if (isNaN(formulario.telefono.value)) {
    alert("El campo \"telefono\" debe ser num�rico");
    formulario.telefono.focus();
    return (false);
  } 
  
  if (formulario.telefono.value.length < 7) {
    alert("El campo \"telefono\" est� incompleto");
    formulario.telefono.focus();
    return (false);
  }    
    
  return (true);
}
</script>
</head>

<body>
<?php
/* sino existe muestra el fomulario vacío y altera el centinela para guardar (session[guarda]) */
if (mysql_num_rows($result) == 0){
$_SESSION["guarda"]="si";
?>
<table width="650" height="399" border="1" align="center">
  <tr>
    <td width="222" rowspan="2" align="center">
	<img src="imagenes/gobernacion.png" width="130" height="80" />
	<img src="imagenes/topfestival.png" width="213" height="225" />
	<img src="imagenes/cortulara.jpg" />
    </td>
    <td height="393" align="center">
	<form method="post" onSubmit = "return validar(this)" action="entradas.php">
		<table width="90%" border="0">
		  <tr>
			<td colspan="2" align="center" valign="middle">
				<span class="Estilo1">Datos Personales </span></td>
		  </tr>		
		  <tr>
			<td width="14%" bgcolor="#E2AC35">C&eacute;dula:</td>
			<td width="86%" bgcolor="#E2AC35"><input type="text" name="cedula" readonly="yes" value=" <?php echo $_POST["cedula"]; ?>" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#EFE136">Nombres:</td>
			<td bgcolor="#EFE136"><input type="text" name="nombres" size="50" maxlength="50" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#E2AC35">Apellidos:</td>
			<td bgcolor="#E2AC35"><input type="text" name="apellidos" size="50" maxlength="50" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#EFE136">Direcci&oacute;n:</td>
			<td bgcolor="#EFE136"><input type="text" name="direccion" size="75" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#E2AC35">Tel&eacute;fono:</td>
			<td bgcolor="#E2AC35">
				<select name="cod">
					<option>0251</option>
					<option>0412</option>
					<option>0414</option>
					<option>0424</option>
					<option>0416</option>
					<option>0426</option>
			</select>-<input type="text" name="telefono" maxlength="7" />			</td>
		  </tr>
		  <tr>
			<td colspan="2" align="center"><br>
				<input type="submit" name="enviar" value="Enviar">
				<input type="button" name="enviar" value="Cancelar" onClick="javascript:history.back();">
				<br><br>			</td>
		  </tr>
		</table>
	</form>	</td>
  </tr>
</table>
<?php
/* si existe muestra el fomulario lleno y altera el centinela para NO guardar */
}else{
$fila = mysql_fetch_array($result);
$_SESSION["guarda"]="no";
?>
<table width="650" height="400" border="1" align="center">
  <tr>
    <td width="222" rowspan="2" align="center">
	<img src="imagenes/gobernacion.png" width="130" height="80" />
	<img src="imagenes/topfestival.png" width="213" height="225" />
	<img src="imagenes/cortulara.jpg" />
    </td>
    <td align="center">
	<form method="post" action="entradas.php">
		<table width="90%" border="0">
		  <tr>
			<td colspan="2" align="center" valign="middle">
				<span class="Estilo1">Datos Personales </span></td>
		  </tr>			
		  <tr>
			<td width="14%" bgcolor="#E2AC35">C&eacute;dula:</td>
			<td width="86%" bgcolor="#E2AC35"><input type="text" name="cedula" readonly="yes" value=" <?php echo $_POST["cedula"]; ?>" /></td>
		  </tr>
		  <tr>
			<td bgcolor="#EFE136">Nombres:</td>
			<td bgcolor="#EFE136"><input type="text" name="nombres" size="50" maxlength="50" readonly="yes" value=" <?php echo $fila["nombres"]; ?>"  /></td>
		  </tr>
		  <tr>
			<td bgcolor="#E2AC35">Apellidos:</td>
			<td bgcolor="#E2AC35"><input type="text" name="apellidos" size="50" maxlength="50" readonly="yes" value=" <?php echo $fila["apellidos"]; ?>"  /></td>
		  </tr>
		  <tr>
			<td bgcolor="#EFE136">Direcci&oacute;n:</td>
			<td bgcolor="#EFE136"><input type="text" name="direccion" size="75" readonly="yes"  value=" <?php echo $fila["direccion"]; ?>"/></td>
		  </tr>
		  <tr>
			<td bgcolor="#E2AC35">Tel&eacute;fono:</td>
			<td bgcolor="#E2AC35">
				<input type="text" name="telefono" maxlength="12" readonly="yes"  value=" <?php echo $fila["telefono"]; ?>" />			</td>
		  </tr>
		  <tr>
			<td colspan="2" align="center"><br>
				<input type="submit" name="enviar" value="Enviar">
				<input type="button" name="enviar" value="Cancelar" onClick="javascript:history.back();">
				<br><br>			</td>
		  </tr>
		</table>
	</form>	</td>
  </tr>
  <!---tr>
    <td>&nbsp;</td>
    <td width="279"><div align="right"><img src="Imagenes/logos.gif"></div></td>
    <td width="196"><div align="center"><img src="Imagenes/fabiolaI.gif"></div></td>
  </tr--->
</table>
<?php
}
?>
</body>
</html>
