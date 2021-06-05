<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title>Login Page</title>
</head>
<body>
	<div class="container-form-center">
	<form class="form-generic" action="login.php" method="POST">
		<h2>Accedi</h2>

		<label for="user">Username</label>
		<input type="text" name="user" required>

		<label for="pwd">Password</label>
		<input type="text" name="pwd"required>

		<input type="submit" value="invia">
		<a href="recuperopasswd.php">Recupera password</a>
	</form>
	<?php

	if(isset($_POST["user"])&&isset($_POST["pwd"])){
		
		//inclusione file var.php
		include("var.php");

		//retrive dei parametri passati dalla form
		$params[0]=$_POST["user"];
		$params[1]=(string)hash("sha256",$_POST["pwd"]);

		//definizione dei template 
		$template1="Select utenti.id as id_utente, professori.id as id_professore from utenti inner join professori on utenti.id=professori.id_utente where username=? and passwd=?";
		$template2="Select utenti.id as id_utente, studenti.id as id_studente from utenti inner join studenti on utenti.id = studenti.id_utente where username=? and passwd=?";
		$template3="Select utenti.id as id_utente, genitori.id as id_genitore from utenti inner join genitori on utenti.id = genitori.id_utente where username=? and passwd=?";

		$result=runstmt($link,$template1,"ss",$params);
		if($result->num_rows>0){
			$row=mysqli_fetch_array($result);
			session_start();
			$_SESSION["id_utente"]=$row["id_utente"];
			$_SESSION["id_professore"]=$row["id_professore"];
			header("Location: area_privata_professore.php");
			exit();
		}
		
		echo "ciao";
		$result=runstmt($link,$template2,"ss",$params);
		if($result->num_rows>0){
			$row=mysqli_fetch_array($result);
			session_start();
			$_SESSION["id_utente"]=$row["id_utente"];
			$_SESSION["id_studente"]=$row["id_studente"];
			header("Location: area_privata_studente.php");
			exit();		
		}

		$result=runstmt($link,$template3,"ss",$params);
		if($result->num_rows>0){
			$row=mysqli_fetch_array($result);
			session_start();
			$_SESSION["id_utente"]=$row["id_utente"];
			$_SESSION["id_genitore"]=$row["id_genitore"];
			header("Location: area_privata_genitore.php");
			exit();
		}

		else echo "Username o Password errate";
	}

	?>
	</div>
</body>
</html>