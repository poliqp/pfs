<?php 
	session_start();
	if(!isset($_SESSION["id_utente"])&&!isset($_SESSION["id_studente"])){
		header("Location: login.php");
		exit;
	}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title>Home</title>
</head>
<body>
	<div class="container-content">
		<nav>
			<ul>
				<li><a href="studente_presenze.php">PRESENZE</a></li>
				<li><a href="studente_voti.php">VOTI</a></li>
				<li><a href="studente_compiti.php">COMPITI</a></li>
				<li><a href="studente_note.php">NOTE</a></li>
				<li><a href="studente_logout.php">LOGOUT</a></li>
			</ul>
		</nav>
		<?php
			include "var.php";
			$params[0]=$_SESSION["id_studente"];
			$template="Select giorni.id,ore.ora from studenti inner join presenze on studenti.id=presenze.id_studente inner join ore on presenze.id_ora=ore.id inner join giorni on ore.id_giorno=giorni.id where studenti.id=?";
			$result=runstmt($link,$template,"i",$params);
			echo "<br>Presenze<br><br>";
			if(!($result->num_rows>0))echo "Nessuna presenza";
			while($row=$result->fetch_assoc())echo "Presente il ".$row["id"]." durante la ".$row["ora"]."° ora<br>";
		?>
	</div>
</body>
</html>

