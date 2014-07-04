<?php
session_start();

include("util.php");
include("ControlaBD.php");
if ($_SESSION["sesion"] != "TRUE" || $_SESSION["nivel"] != 2) {
	js_redireccion("index.php");
	exit; 
}
$con   = new ControlaBD();
$idcon = $con->conectarSBD();
$sel_bd= $con->select_BD("topfestival");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reimprimir Recibos</title>
<style>
<!--
a:link {
	color: #DA251D;
	text-decoration:none;
}
a:visited {
	color: #DA251D;
	text-decoration:none;
}
a:hover {
	color: #DA251D;
	text-decoration:none;
}
a:active {
	color: #DA251D;
	text-decoration:none;
}

.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.Estilo8 {font-family: Arial, Helvetica, sans-serif; font-size: 9; }
.Estilo9 {font-size: 11}
.Estilo12 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; }
-->
</style>
</head>

<body>

<table width="650" height="138" border="1" align="center">
  <tr>
    <td width="75" rowspan="3" align="center"><img src="imagenes/afihe.gif" width="75" height="128" /></td>
    <td height="88" colspan="2" align="center">
        <font color="#CD3232" size="4" face="Arial, Helvetica, sans-serif">Sistema de Pre-venta<br />
Boleter&iacute;a-Abonos<br />Usuario Liquidador<br /></font>
	</td>
  </tr>
  <tr>
    <td width="350" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><!--a href="./edo_vent.php"-->Estado de Ventas<!--/a--></font></td>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><a href="./reimprime1.php">Reimprimir</a></font></td>
  </tr>  
  <tr>
    <td width="350" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><a href="./password.php">Cambiar Password</a></font></td>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><!--a href="./liquidar.php"-->Liquidar<!--/a--></font></td>
  </tr>
</table>
<br>
<div align="center">
	Reimprimir Recibos<br><br>
	<form method="post" target="_blank" action="reimprime2.php">
			C&oacute;digo: <input type="text" name="busca">
			<input type="submit" name="Buscar" value="Buscar">	
	</form>
</div>
<br><br>

</body>
</html>