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
		
		if ($_POST['pold'] != ''){
			if ($_SESSION["password"] != $_POST['pold']){
				js_redireccion("mensaje.php?msg=El Password Actual es Incorrecto");
				exit;
			}else{
				$result= $con->ejecutar("Update login set pass='".$_POST['pnew']."' where login='".$_SESSION["login"]."'",$idcon);
				$_SESSION["password"] = $_POST['pnew'];
				js_redireccion("mensaje.php?msg=El Password se ha cambiado exitosamente");
				exit;				
			}
		}
		//$result= $con->ejecutar("SELECT * FROM login WHERE login='$login' and pass='$password'",$idcon);
		//echo "INSERT INTO clientes values (".$_POST[cedula].",'".$_POST[nombres]."','".$_POST[apellidos]."','".$_POST[direccion]."','".$telefono."',0,0,0,0,0,0,0,0,0,0)";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cambiar Password</title>
<script language="javascript">
function validar(formulario) {
  if (formulario.pold.value.length < 1) {
    alert("Debe Introducir el Password Actual");
    formulario.pold.focus();
    return (false);
  }
  if (formulario.pnew.value.length < 8) {
    alert("El nuevo password no es valido, debe tener 8 caracteres");
    formulario.pnew.focus();
    return (false);
  }
  if (formulario.pnew.value != formulario.prenew.value) {
    alert("El nuevo Password y la confirmacion no coinciden");
    formulario.pnew.focus();
    return (false);
  }   
  return (true);
}
</script>
</head>

<body>
<table width="650" height="434" border="1" align="center">
  <tr>
    <td width="222" rowspan="3" align="center">
	<img src="imagenes/gobernacion.png" width="130" height="80" />
	<img src="imagenes/topfestival.png" width="213" height="225" />
	<img src="imagenes/cortulara.jpg" />
    </td>
    <td height="390" colspan="2" align="center">
        <font color="#CD3232" size="4" face="Arial, Helvetica, sans-serif">Sistema de Pre-venta<br />
Cambiar Password</font><br /><br />
        <form method="post" onSubmit = "return validar(this)" action="password.php">
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Introduzca el password actual:</strong></font><br>
			<input type="password" name="pold" maxlength="8"><br><br>
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Introduzca el nuevo password:</strong></font><br>
			<input type="password" name="pnew" maxlength="8"><br><br>	
			<font size="2" face="Arial, Helvetica, sans-serif"><strong>Confirme el nuevo password:</strong></font><br>
			<input type="password" name="prenew" maxlength="8"><br><br>						
			<input type="submit" name="enviar" value="Enviar">
			<input type="button" name="cancelar" value="Cancelar" onclick="javascript:history.back()">
	  </form>	</td>
  </tr>
</table>
<?php echo $mensaje; ?>
</body>
</html>
</body>
</html>
