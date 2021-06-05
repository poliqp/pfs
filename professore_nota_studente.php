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
	<title>Nota Studente</title>
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
			if(isset($_POST["classe"])&&is_numeric($_POST["classe"])){
				$id_classe=validateInput($_POST["classe"]);
				$params[0]=$id_classe;
				$template="Select utenti.nome,utenti.cognome,studenti.id from studenti inner join classi on studenti.id_classe=classi.id inner join utenti on studenti.id_utente=utenti.id where classi.id=?";
				$result=runstmt($link,$template,"i",$params);

				//Se la classe è vuota
				if($result->num_rows==0)die("Classe vuota");
			
				//Stampa degli studenti appartenenti alla classe
				echo "<form action=professore_nota_studente.php method=POST>";
				echo '<br><label for="txt">Testo:</label>';
				echo '<input type="text" name="txt">';
				echo "<br><br><a>Seleziona lo studente</a><br><br>";
				while($row = $result->fetch_assoc()){
					$nome_cognome=$row["nome"]." ".$row["cognome"];
					$id=$row["id"];
					echo '<input type="radio" name="studente" value="'.$id.'"';
					echo '<label for="studente">'.$nome_cognome.'</label><br>';
				}
				echo '<input type="submit" value="invia">';
				echo '</form>';
			}

			elseif(isset($_POST["studente"])&&isset($_POST["txt"])){
				//Inserimento nel db
				$params[0]=$_SESSION["id_professore"];
				$params[1]=validateInput($_POST["studente"]);
				$params[2]=validateInput($_POST["txt"]);
				echo "id_professore: ".$params[0]." id_studente: ".$params[1]." txt: ".$params[2];
				$template="Insert into note(id_professore,id_studente,txt) values (?,?,?)";
				runstmt($link,$template,"iis",$params);
				echo "Nota aggiunta";
			}

			else{
				//Retrive delle classi dal db
				$query="Select classi.id,classi.grado,classi.sezione,plessi.nome from classi inner join plessi on classi.id_plesso=plessi.id";
				$result = runquery($link,$query);
				echo "<br><a>Seleziona la classe</a><br><br>";
				echo "<form action=professore_nota_studente.php method=POST>";
				
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