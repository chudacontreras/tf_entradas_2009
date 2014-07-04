<?php
session_start();

include("util.php");
if ($_SESSION["sesion"] != "TRUE" || $_SESSION["nivel"] != 2) {
	js_redireccion("index.php");
	exit; 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
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

-->
</style>
</head>

<body>

<table width="650" height="434" border="1" align="center">
  <tr>
    <td width="222" rowspan="3" align="center">
	<img src="imagenes/gobernacion.png" width="130" height="80" />
	<img src="imagenes/topfestival.png" width="213" height="225" />
	<img src="imagenes/cortulara.jpg" />
    </td>    <td height="390" colspan="2" align="center">
        <font color="#CD3232" size="4" face="Arial, Helvetica, sans-serif">Sistema de Venta Anticipada<br />
Boleter&iacute;a-Abonos<br />Usuario Liquidador<br /></font>
	</td>
  </tr>
  <tr>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><!--a href="./edo_vent.php"-->Estado de Ventas</a></font></td>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><a href="./reimprime1.php">Reimprimir</a></font></td>
  </tr>  
  <tr>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif"><a href="./password.php">Cambiar Password</a></font></td>
    <td width="203" align="center"><font color="#CD3232" size="2" face="Arial, Helvetica, sans-serif">Liquidar</font></td>
  </tr>

</table>

</body>
</html>
