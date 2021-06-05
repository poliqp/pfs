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
	<title>NOTE</title>
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
			$template="Select note.txt,utenti.nome,utenti.cognome from note inner join studenti on note.id_studente=studenti.id inner join professori on note.id_professore=professori.id inner join utenti on professori.id_utente=utenti.id where studenti.id=?";
			$result=runstmt($link,$template,"i",$params);
			echo "<br>Note Studente<br><br>";
			if(!($result->num_rows>0))echo "Nessuna nota personale";
			while($row=$result->fetch_assoc())echo "Nota: ".$row["txt"]." da: ".$row["nome"]." ".$row["cognome"]."<br>";

			$result=[];
			$row=[];
			$template="Select note.txt,utenti.nome,utenti.cognome from note inner join classi on note.id_classe=classi.id inner join studenti on studenti.id_classe=classi.id inner join professori on note.id_professore=professori.id inner join utenti on professori.id_utente=utenti.id where studenti.id=?";
			$result=runstmt($link,$template,"i",$params);
			echo "<br>Note Classe<br><br>";
			if(!($result->num_rows>0))echo "Nessun nota alla classe";
			while($row=$result->fetch_assoc())echo "Nota: ".$row["txt"]." da: ".$row["nome"]." ".$row["cognome"]."<br>";
		?>
	</div>
</body>
</html>

