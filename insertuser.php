<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title>Insert user</title>
</head>
<body>
	<div class="container-form-center">
	<form class="form-generic" action="insertuser.php" method="POST">
		<label for="nome">Nome</label>
		<input type="text" name="nome">
		<label for="cognome">Cognome</label>
		<input type="text" name="cognome">
		<label for="user">Username</label>
		<input type="text" name="user">
		<label for="codice_fiscale">Codice fiscale</label>
		<input type="text" name="codice_fiscale">
		<label for="data_nascita">Data di nascita</label>
		<input type="date" name="data_nascita">
		<label for="telefono_cellulare">Telefono cellulare</label>
		<input type="text" name="telefono_cellulare">
		<label type="email">Email</label>
		<input type="text" name="email">
		<label for="password">Password</label>
		<input type="text" name="password">
		<input type="submit" value="Invia">
	</form>
	</div>
	<?php

		if(isset($_POST["nome"])&&
		  isset($_POST["cognome"])&&
		  isset($_POST["codice_fiscale"])&&
		  isset($_POST["data_nascita"])&&
		  isset($_POST["telefono_cellulare"])&&
		  isset($_POST["email"])&&
		  isset($_POST["password"])&&
		  isset($_POST["username"])&&
		  checkLength($_POST["nome",50])&&
		  checkLength($_POST["cognome",50])&&
		  checkLength($_POST["codice_fiscale",16])&&
		  checkLength($_POST["telefono_cellulare",10])&&
		  filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
		{
			
			$params[0]=$_POST["nome"];
			$params[1]=$_POST["cognome"];
			$params[2]=$_POST["user"];
			$params[3]=$_POST["codice_fiscale"];
			$params[4]=(string)$_POST["data_nascita"];
			$params[5]=$_POST["telefono_cellulare"];
			$params[6]=$_POST["email"];
			$params[7]=(string)hash("sha256",$_POST["password"]);

			$template1="Insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values(?,?,?,?,?,?,?,?)";
			if(runstmt($link,$template1,"sssssiss",$params))echo "Utente Aggiunto";
			else echo "Problemi con i valori inseriti";
		}

	?>
</body>
</html>