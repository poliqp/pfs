<?php 
	session_start();
	if(!isset($_SESSION["id_utente"])&&!isset($_SESSION["id_studente"])){
		header("Location: login.php");
		exit;
	}
	elseif(isset($_SESSION["id_utente"])&&isset($_SESSION["id_studente"])){
		unset($_SESSION["id_utente"]);
		unset($_SESSION["id_studente"]);
		session_destroy();
		header("Location: login.php");
		exit;
	}
?>
