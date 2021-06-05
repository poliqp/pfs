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

			if(isset($_POST["classe"])&&isset($_POST["data"])&&isset($_POST["ora"])&&isset($_POST["txt"])){
				
				$input[0]=validateInput($_POST["classe"]);
				$input[1]=validateInput($_POST["data"]);
				$input[2]=validateInput($_POST["ora"]);
				$input[3]=validateInput($_POST["txt"]);
				$_SESSION["id_classe"]=$input[0];

				//Verifica che la classe passata dalla form esista
				if(!checkClasse($link,$input[0]))die("Classe non presente nel db");

				//Verifica esistenza record nella tabella giorni 
				if(!checkGiorno($link,$input[1]))insertGiorno($link,$input[1]);
					
				if(checkOraClasseGiorno($link,$input[0],$input[1],$input[2]))die("Ora esistente");

				//Inserimento ora
				$params[0]=$input[1];
				$params[1]=$input[2];
				$params[2]=$_SESSION["id_professore"];
				$params[3]=$input[3];
				$params[4]=$input[0];
				echo $params[0]." ".$params[1]." ".$params[2]." ".$params[3];
				$template="Insert into ore(id_giorno,ora,id_professore,txt,id_classe) values (?,?,?,?,?)";
				runstmt($link,$template,"ssisi",$params);
				$ora_id=getIdOra($link,$input[0],$input[1],$input[2]);
				echo "ID_ORA: ".$ora_id;

				$params=[];

				//Retrive dal db delle informazioni degli studenti appartenenti alla classe immessa
				$params[0]=$input[0];
				$template="Select utenti.nome,utenti.cognome,studenti.id from studenti inner join classi on studenti.id_classe=classi.id inner join utenti on studenti.id_utente=utenti.id where classi.id=?";
				$result=runstmt($link,$template,"i",$params);

				//Se la classe è vuota
				if($result->num_rows==0)die("Classe vuota");
				
				//Stampa degli studenti appartenenti alla classe
				echo "<br><a>Seleziona gli studenti presenti</a><br><br>";
				echo "<form action=professore_appello.php method=POST>";
				while($row = $result->fetch_assoc()){
					$nome_cognome=$row["nome"]." ".$row["cognome"];
					$id=$row["id"];
					echo '<input type="checkbox" name="studenti[]" value="'.$id.'">'.$nome_cognome."<br/>";
				}
				echo '<input type="hidden" name="ora" value="'.$ora_id.'">';
				echo '<input type="submit" value="Invia">';
				echo "</form>";
			}

			elseif(isset($_POST["studenti"])&&isset($_POST["ora"])){
				
				$params=[];
				$input=$_POST["studenti"];
				$params[0]=$_POST["ora"];
				$template="Insert into presenze(id_ora,id_studente) values (?,?)";
				foreach($input as $key => $value){					
					echo $value."<br>";
					$params[1]=$value;
					runstmt($link,$template,"ii",$params);
				}
				echo "Appello completato";
			}

			else{
				$query="Select classi.id,classi.grado,classi.sezione,plessi.nome from classi inner join plessi on classi.id_plesso=plessi.id";
				$result = runquery($link,$query);
				echo "<br><a>Seleziona la classe</a><br><br>";
				echo "<form action=professore_appello.php method=POST>";
				while($row = $result->fetch_assoc()){
					$nome=$row["grado"].$row["sezione"]."-".$row["nome"];
					echo '<input type="radio" id="'.$nome.'"name="classe" value="'.$row["id"].'" required>';
					echo '<label for="'.$nome.'">'.$nome.'</label><br>';
				}
				echo '<br><label for="data">Selezion la data:</label><br>';
				echo '<input type=date name="data" required><br>';
				echo '<br><label for="ora">Inserisci ora (esempio 1 = prima ora)</label><br>';
				echo '<input type=text name="ora" required><br><br>';
				echo '<br><label for="txt">Inserisci testo (esempio materia,argomenti)</label><br>';
				echo '<input type=text name="txt" required><br><br>';
				echo '<input type=submit value="invia">';
				echo "</form>";
			}
		?>
	</div>
</body>
</html>