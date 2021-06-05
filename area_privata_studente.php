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
			$template1="Select utenti.nome,utenti.cognome,utenti.email,utenti.username,utenti.data_nascita,utenti.telefono_cellulare,classi.grado,classi.sezione from utenti inner join studenti on utenti.id=studenti.id_utente inner join classi on studenti.id_classe=classi.id where utenti.id=?";
			$params[0]=$_SESSION["id_utente"];
			$row=mysqli_fetch_array(runstmt($link,$template1,"s",$params));

			echo "<br>Nome: ".$row["nome"]."<br>";
			echo "Cognome: ".$row["cognome"]."<br>";
			echo "Email: ".$row["email"]."<br>";
			echo "Data di nascita: ".$row["data_nascita"]."<br>";
			echo "Username: ".$row["username"]."<br>";
			echo "Telefono cellulare: ".$row["telefono_cellulare"]."<br>";
			echo "Classe: ".$row["grado"].$row["sezione"];
		?>
	</div>
</body>
</html>