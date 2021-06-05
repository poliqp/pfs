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
	<title>Compiti</title>
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
			include("var.php");
			
			if(isset($_POST["classe"])&&is_numeric($_POST["classe"])&&isset($_POST["data"])&&isset($_POST["txt"])){
				$params[0]=$_SESSION["id_professore"];
				$params[1]=validateInput($_POST["classe"]);
				$params[2]=validateInput($_POST["txt"]);
				$params[3]=validateInput($_POST["data"]);

				echo json_encode($params);
				$template="Insert into compiti(id_professore,id_classe,txt,giorno_scadenza) values (?,?,?,?)";
				runstmt($link,$template,"iiss",$params);
				echo "Compito aggiunto";
			}

			else{
				//Retrive delle classi dal db
				$query="Select classi.id,classi.grado,classi.sezione,plessi.nome from classi inner join plessi on classi.id_plesso=plessi.id";
				$result = runquery($link,$query);
				echo "<br><a>Seleziona la classe</a><br><br>";
				echo "<form action=professore_compiti.php method=POST>";
				echo '<br><label for="txt">Testo:</label><br>';
				echo '<input type="text" name="txt"><br>';
				echo '<br><label for="data">Data:</label>';
				echo '<input type="date" name="data">';
				echo "<br><br><a>Seleziona la classe</a><br><br>";
				//Stampa delle classi
				while($row = $result->fetch_assoc()){
				$name=$row["grado"].$row["sezione"]."-".$row["nome"];
					echo '<input type="radio" id="'.$name.'"name="classe" value="'.$row["id"].'" required>';
					echo '<label for="'.$name.'">'.$name.'</label><br>';
				}
				echo '<input type=submit value="invia">';
				echo "</form>";
				}
		?>
	</div>
</body>
</html>