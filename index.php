<?php
session_start();
include("ControlaBD.php");
include("util.php");

$con   = new ControlaBD();
$idcon = $con->conectarSBD();
$sel_bd= $con->select_BD("topfestival");

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gobernaci&oacute;n del Estado Lara</title>
</head>
<body>
<table width="650" height="400" border="0" align="center">
  <tr>
    <td rowspan='2'><img src="imagenes/topfestival.png"></td>
  </tr>
  <!--tr>
    <td width="213" align="center"><img src="imagenes/gobernacion.jpg"></td>
  </tr-->
  <tr> 
    <td width="421" align="center"><font color="#CD3232" size="4" face="Arial, Helvetica, sans-serif">Sistema de Venta<br />
Boleter&iacute;a y Abonos </font><br>
<br>
<form method="post" action="sesion.php">
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Nombre de Usuario:</strong></font><br>
			<input type="text" name="usuario"><br><br>
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Contrase&ntilde;a:</strong></font><br>
			<input type="password" name="password"><br><br>
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Centro Comercial:</strong></font><br>


			<select name="centro" id="centro">
			<?php
			$result3= $con->ejecutar("SELECT * FROM cen_com",$idcon);
			while ($combo = mysql_fetch_array($result3)){
				echo "<option value=".$combo[id].">".$combo[nombre]."</option>";
			}
			?>
			</select>
			<br><br>
			<input type="submit" name="enviar" value="Aceptar">
	  </form>	</td>
  </tr>

</table>
</body>
</html>
