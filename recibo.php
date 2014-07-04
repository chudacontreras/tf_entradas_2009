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
/********************************************
*************** VALIDACION ******************
********************************************/
for ($i=1; $i <= $_SESSION[cont]; $i++){
	if ($_POST["grama".$i] > 0){
		$validaMax= $con->ejecutar("SELECT sum(contador) FROM reservacion where id_cart=".$_POST["cart".$i]." and id_ent=1",$idcon);
		$fila_Max = mysql_fetch_array($validaMax);
		if ($fila_Max["sum(contador)"] >= 1000){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Las Entradas de Grama para el ".cambiaf_a_normal($fila_c['dia'])." se han agotado...!!!");
				pagina_atras(1);
				exit;
		}

		$valida= $con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1",$idcon);
		if (mysql_num_rows($valida) > 0){
		
			$fila_v = mysql_fetch_array($valida);
			if (($_POST["grama".$i]+$fila_v[contador]) > 5){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Ha excedido el numero de entradas de Grama para el ".cambiaf_a_normal($fila_c['dia']));
				pagina_atras(1);
				exit;
			}
		}
	}
	if ($_POST["pref".$i] > 0){
		$validaMax= $con->ejecutar("SELECT sum(contador) FROM reservacion where id_cart=".$_POST["cart".$i]." and id_ent=2",$idcon);
		$fila_Max = mysql_fetch_array($validaMax);
		if ($fila_Max["sum(contador)"] >= 9720){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Las Entradas Preferenciales para el ".cambiaf_a_normal($fila_c['dia'])." se han agotado...!!!");
				pagina_atras(1);
				exit;
		}

		$valida= $con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=2",$idcon);
		if (mysql_num_rows($valida) > 0){
			$fila_v = mysql_fetch_array($valida);
			if (($_POST["pref".$i]+$fila_v[contador]) > 5){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Ha excedido el numero de entradas Preferenciales para el ".cambiaf_a_normal($fila_c['dia']));
				pagina_atras(1);
				exit;
			}
		}
	}
	if ($_POST["gral".$i] > 0){
		$validaMax= $con->ejecutar("SELECT sum(contador) FROM reservacion where id_cart=".$_POST["cart".$i]." and id_ent=3",$idcon);
		$fila_Max = mysql_fetch_array($validaMax);
		if ($fila_Max["sum(contador)"] >= 17863){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Las Entradas Generales para el ".cambiaf_a_normal($fila_c['dia'])." se han agotado...!!!");
				pagina_atras(1);
				exit;
		}

		$valida= $con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=3",$idcon);
		if (mysql_num_rows($valida) > 0){
			$fila_v = mysql_fetch_array($valida);
			if (($_POST["gral".$i]+$fila_v[contador]) > 5){
				$c= $con->ejecutar("SELECT * FROM cartelera where id=".$_POST["cart".$i],$idcon);
				$fila_c = mysql_fetch_array($c);
				echo js_msgbox("Ha excedido el numero de entradas Generales para el ".cambiaf_a_normal($fila_c['dia']));
				pagina_atras(1);
				exit;
			}
		}
	}
	
}




		$result= $con->ejecutar("SELECT * FROM control where id = 1",$idcon);
		$fila = mysql_fetch_array($result);
		$nro =  $fila["contador"];
		if (strlen($nro) < 6){
			for ($i=strlen($nro); $i < 6; $i++)
			$nro = "0".$nro;
		}
		$result= $con->ejecutar("UPDATE control set contador = contador+1 where id =1",$idcon);
		$codigo = $fila ["item"].$nro;	
$_SESSION['fecha'] = date('Y-m-d G:i:s');
//echo "INSERT INTO cab_ventas values ('".$codigo."',".$_SESSION["cedula"].",".$_POST["total"].",'".$_SESSION["login"]."', NOW(),'H','".$_POST["pago"]."')"; exit;
$guarda= $con->ejecutar("INSERT INTO cab_ventas values ('".$codigo."',".$_SESSION["cedula"].",".$_POST["total"].",'".$_SESSION["login"]."', NOW(),'H','".$_POST["pago"]."',".$_SESSION["centro"].")",$idcon);


for ($i=1; $i <= $_SESSION[cont]; $i++){
	if ($_POST["grama".$i] > 0){
		//echo "INSERT INTO det_ventas values ('".$codigo."',1,".$_POST["dia".$i].",".$_POST["grama".$i].",".$_POST["sub".$i].")";
		$guarda2= $con->ejecutar("INSERT INTO det_ventas values ('".$codigo."',1,".$_POST["cart".$i].",".$_POST["grama".$i].",".$_POST["sub".$i].")",$idcon);
		//echo "SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1";
		$result3= $con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1",$idcon);
		if (mysql_num_rows($result3) <= 0){
			$guarda3= $con->ejecutar("INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",1,".$_POST["grama".$i].")",$idcon);
			//echo "INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",1,".$_POST["grama".$i].")";
		}else{
			$guarda3= $con->ejecutar("UPDATE reservacion SET contador = contador +".$_POST["grama".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1",$idcon);
			//echo "UPDATE reservacion SET contador = contador +".$_POST["grama".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1";
		}
	}
	if ($_POST["pref".$i] > 0){
		//echo "INSERT INTO det_ventas values ('".$codigo."',2,".$_POST["dia".$i].",".$_POST["pref".$i].",".$_POST["sub".$i].")";
		$guarda2= $con->ejecutar("INSERT INTO det_ventas values ('".$codigo."',2,".$_POST["cart".$i].",".$_POST["pref".$i].",".$_POST["sub".$i].")",$idcon);
		$result3= $con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=2",$idcon);
		if (mysql_num_rows($result3) <= 0){
			$guarda3= $con->ejecutar("INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",2,".$_POST["pref".$i].")",$idcon);
			//echo "INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",1,".$_POST["grama".$i].")";
		}else{
			$guarda3= $con->ejecutar("UPDATE reservacion SET contador = contador +".$_POST["pref".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=2",$idcon);
			//echo "UPDATE reservacion SET contador = contador +".$_POST["grama".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1";
		}
	}
	if ($_POST["gral".$i] > 0){
		//echo "INSERT INTO det_ventas values ('".$codigo."',3,".$_POST["dia".$i].",".$_POST["gral".$i].",".$_POST["sub".$i].")";
		$guarda2= $con->ejecutar("INSERT INTO det_ventas values ('".$codigo."',3,".$_POST["cart".$i].",".$_POST["gral".$i].",".$_POST["sub".$i].")",$idcon);
		$result3=$con->ejecutar("SELECT * FROM reservacion where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=3",$idcon);
		if (mysql_num_rows($result3) <= 0){
			$guarda3= $con->ejecutar("INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",3,".$_POST["gral".$i].")",$idcon);
			//echo "INSERT INTO reservacion VALUES (".$_SESSION["cedula"].",".$_POST["cart".$i].",1,".$_POST["grama".$i].")";
		}else{
			$guarda3= $con->ejecutar("UPDATE reservacion SET contador = contador +".$_POST["gral".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=3",$idcon);
			//echo "UPDATE reservacion SET contador = contador +".$_POST["grama".$i]." where cedula=".$_SESSION["cedula"]." and id_cart=".$_POST["cart".$i]." and id_ent=1";
		}
	}
	
}
$_SESSION["codigo"] = $codigo;
js_redireccion("recibo2.php");
?>
