<?php 
	session_start();
	if(!isset($_SESSION["id_utente"])&&!isset($_SESSION["id_professore"])){
		header("Location: login.php");
		exit;
	}
	elseif(isset($_SESSION["id_utente"])&&isset($_SESSION["id_professore"])){
		unset($_SESSION["id_utente"]);
		unset($_SESSION["id_professore"]);
		session_destroy();
		header("Location: login.php");
		exit;
	}
?>