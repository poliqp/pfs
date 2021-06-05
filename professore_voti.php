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
	<title>Appello</title>
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

				//Retrive dal db delle informazioni degli studenti appartenenti alla classe immessa
				$id_classe=validateInput($_POST["classe"]);
				$params[0]=$id_classe;
				$template="Select utenti.nome,utenti.cognome,studenti.id from studenti inner join classi on studenti.id_classe=classi.id inner join utenti on studenti.id_utente=utenti.id where classi.id=?";
				$result=runstmt($link,$template,"i",$params);

				//Se la classe è vuota
				if($result->num_rows==0)die("Classe vuota");
		
				//Stampa degli studenti appartenenti alla classe
				echo "<form action=professore_voti.php method=POST>";
				echo "<br><a>Seleziona lo studente</a><br><br>";
				while($row = $result->fetch_assoc()){
					$nome_cognome=$row["nome"]." ".$row["cognome"];
					$id=$row["id"];
					echo '<input type="radio" name="studente" value="'.$id.'"';
					echo '<label for="studente">'.$nome_cognome.'</label><br>';
				}

				//Retrive dal db delle materie insegnate dal professore
				$params[1]=$_SESSION["id_professore"];
				$template="Select materie.nome,materie.id from professori_classi_materie inner join professori on professori_classi_materie.id_professore=professori.id inner join materie on professori_classi_materie.id_materia=materie.id where professori_classi_materie.id_classe=? and professori.id=?";
				$result=runstmt($link,$template,"ii",$params);
				
				//Stampa delle materie
				echo "<br><br><a>Seleziona la materia</a><br><br>";
				while($row = $result->fetch_assoc()){
					echo '<input type="radio" name="materia" value="'.$row["id"].'">';
					echo '<label for="materia">'.$row["nome"].'</label><br>';
				}

				//voto
				echo '<br><br><label for="voto">Voto:</label>';
				echo '<input type="number" name="voto" min="0" max="10">';

				//data
				echo '<br><br><label for="data">Selezion la data:</label><br>';
				echo '<input type="date" name="data" required><br>';


				echo '<input type="submit" value="Invia">';
				echo "</form>";

			}

			elseif(isset($_POST["materia"])&&is_numeric($_POST["materia"])&&isset($_POST["studente"])&&is_numeric($_POST["studente"])&&isset($_POST["voto"])&&is_numeric($_POST["voto"])&&isset($_POST["data"])){

				/*$params[0]=$_SESSION["id_utente"];
				$params[1]=$input[0]=validateInput($_POST["class"]);
				$params[2]=$input[1]=validateInput($_POST["materia"]);
				$params[3]=$input[2]=validateInput($_POST["studente"]);
				$input[3]=$_POST["voto"];
				$input[4]=$_POST["data"];
				$template="Select studenti.id from professori inner join professori_classi_materie on professori.id=professori_classi_materie.id_professore inner join studenti on professori_classi_materie.id_classe=studenti.id_classe where professori.id_utente=? and professori_classi_materie.id_classe=? and professori_classi_materie.id_materia=? and studenti.id=?";
				//$result=runstmt($link,$template,"iiii",$params);
				if($result->num_rows>0){
					$template="Insert into voti(id_studente,id_professore_classe_materia,id_studente,valore,data) values(?,?,?,?)";
					if(runstmt($link,$template,"iiiis"))

				}*/


				$input[0]=validateInput($_POST["materia"]);
				$input[1]=validateInput($_POST["studente"]);
				$input[2]=validateInput($_POST["voto"]);
				$input[3]=validateInput($_POST["data"]);

				if(!checkGiorno($link,$input[3]))insertGiorno($link,$input[3]);

				$params[0]=$_SESSION["id_professore"];
				$params[1]=$input[1];
				$params[2]=$input[0];
				$params[3]=$input[2];
				$params[4]=$input[3];

				$template="Insert into voti(id_professore,id_studente,id_materia,valore,id_giorno) values(?,?,?,?,?)";
				runstmt($link,$template,"iiiis",$params);
				echo "Voto inserito";
			}

			else{

				//Retrive delle classi dal db
				$query="Select classi.id,classi.grado,classi.sezione,plessi.nome from classi inner join plessi on classi.id_plesso=plessi.id";
				$result = runquery($link,$query);
				echo "<br><a>Seleziona la classe</a><br><br>";
				echo "<form action=professore_voti.php method=POST>";

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

