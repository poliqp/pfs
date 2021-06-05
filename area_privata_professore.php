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
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title>Home</title>
</head>
<body>
	<div class="container-content">
		<nav>
			<ul>
				<li><a href="professore_appello.php">APPELLO</a></li>
				<li><a href="professore_voti.php">VOTI</a></li>
				<li><a href="professore_nota_studente.php">NOTA STUDENTE</a></li>
				<li><a href="professore_nota_classe.php">NOTA CLASSE</a></li>
				<li><a href="professore_compiti.php">COMPITI</a></li>
				<li><a href="professore_messaggi.php">MESSAGGI</a></li>
				<li><a href="professore_incontri.php">INCONTRI</a></li>
				<li><a href="log.php">LOG</a></li>
				<li><a href="professore_logout.php">LOGOUT</a></li>
			</ul>
		</nav>

		<?php
			include "var.php";
			$template1="Select nome,cognome,email,username,data_nascita,telefono_cellulare from utenti where id=?";
			$params[0]=$_SESSION["id_utente"];
			$row=mysqli_fetch_array(runstmt($link,$template1,"s",$params));

			echo "<br>Nome: ".$row["nome"]."<br>";
			echo "Cognome: ".$row["cognome"]."<br>";
			echo "Email: ".$row["email"]."<br>";
			echo "Data di nascita: ".$row["data_nascita"]."<br>";
			echo "Username: ".$row["username"]."<br>";
			echo "Telefono cellulare: ".$row["telefono_cellulare"]."<br>";
		?>

	</div>
</body>
</html>