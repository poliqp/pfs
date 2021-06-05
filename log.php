<?php
	session_start();
	if(!isset($_SESSION["id_utente"])&&!isset($_SESSION["id_professore"])){
		header("Location: login.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<?php 
		include("var.php");
		echo "<br>Utenti <br><br>";
		$sql="Select * from utenti";
		querry($link,$sql);
		echo "<br>Studenti <br><br>";
		$sql="Select * from studenti";
		querry($link,$sql);
		echo "<br>Giorni <br><br>";
		$sql="Select * from giorni";
		querry($link,$sql);
		echo "<br>Ore <br><br>";
		$sql="Select * from ore";
		querry($link,$sql);
		echo "<br>Presenze <br><br>";
		$sql="Select * from presenze";
		querry($link,$sql);
		echo "<br>Voti <br><br>";
		$sql="Select * from voti";
		querry($link,$sql);
		echo "<br>Note <br><br>";
		$sql="Select * from note";
		querry($link,$sql);
		echo "<br>Compiti <br><br>";
		$sql="Select * from compiti";
		querry($link,$sql);
	?>


</body>
</html>