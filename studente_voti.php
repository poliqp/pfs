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
			$template="Select voti.valore,utenti.nome,utenti.cognome,giorni.id,materie.nome as matnome from voti inner join professori on voti.id_professore=professori.id inner join utenti on professori.id_utente=utenti.id inner join materie on voti.id_materia=materie.id inner join giorni on voti.id_giorno=giorni.id inner join studenti on voti.id_studente=studenti.id where studenti.id=?";
			$result=runstmt($link,$template,"i",$params);
			echo "<br>Voti<br><br>";
			if(!($result->num_rows>0))echo "Nessun voto";
			while($row=$result->fetch_assoc())echo "Voto: ".$row["valore"]." Giorno: ".$row["id"]." Professore: ".$row["nome"]." ".$row["cognome"]." Materia: ".$row["matnome"]."<br>";
		?>
	</div>
</body>
</html>
