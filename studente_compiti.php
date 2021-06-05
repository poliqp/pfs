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
			$template="Select compiti.txt,compiti.giorno_scadenza from studenti inner join classi on studenti.id_classe=classi.id inner join compiti on classi.id=compiti.id_classe where studenti.id=?";
			$result=runstmt($link,$template,"i",$params);
			echo "<br>Compiti<br><br>";
			if(!($result->num_rows>0))echo "Nessun Compito";
			while($row=$result->fetch_assoc())echo "Scadenza: ".$row["giorno_scadenza"]." txt: ".$row["txt"];
		?>
	</div>
</body>
</html>

