<?php 

    //Funzione per l'esecuzione di statment
	function runstmt($mysqli,$template,$types,$params){
		$stmt=mysqli_prepare($mysqli,$template) or die("Failed to prepare statment");
		mysqli_stmt_bind_param($stmt,$types,...$params);
		mysqli_stmt_execute($stmt);
		return mysqli_stmt_get_result($stmt);
	}

	/*
	function runstmt($mysqli,$template,$type,$params){
		$stmt = $mysqli->prepare($template);
		$stmt->bind_param($type,...$params);
		$stmt->execute();
		result = $stmt->get_result();
	}
	*/

	//Funzione per l'esecuzione di una query
	function runquery($mysqli,$sql){
		return mysqli_query($mysqli,$sql);
	}

	/*
	function runquery($mysqli,$sql")é
		return $mysqli->query($sql);
	}
	*/

	//Funzione generazione stringa "casuale"
	function randString($length){
		$chars="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		for($i=0;$i<$length;$i++)$string.=$chars[rand(0,61)];
		return (string)$string;
	}
	
	//Funzione per la verifica se la lunghezza di una string è minore o uguale a un valore
	function checkLength($string,$length){
		if(strlen($string)<=$length)return true;
		else return false;

	}

	//Funzione per validare gli input
	function validateInput($data){
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}

	//Funzione per la verifica dell'esistenza di uno specifico record nella tabella giorni
	function checkGiorno($mysqli,$date){
		$params[0]=$date;
		$result=runstmt($mysqli,"Select giorni.id from giorni where giorni.id=?","s",$params);
		if($result->num_rows>0)return true;
		else return false;
	}

	//Funzione per l'inserimento di un record nella tabella giorni
	function insertGiorno($mysqli,$date){
		$params[0]=$date;
		if(runstmt($mysqli,"Insert into giorni(id) values (?)","s",$params))return true;
		return false;
	}

	//Funzione per la verifica dell'esistenza di uno specifico record nella tabella ore
	function checkOra($mysqli,$hour){
		$params[0]=$hour;
		$result=runstmt($mysqli,"Select ore.id from ore where ore.ora=?","s",$params);
		if($result->num_rows>0)return true;
		else return false; 
	}

	function checkOraClasseGiorno($mysqli,$id_classe,$id_giorno,$ora){
		$params[0]=$id_classe;
		$params[1]=$id_giorno;
		$params[2]=$ora;
		$result=runstmt($mysqli,"Select ore.id from ore where ore.id_classe=? and ore.id_giorno=? and ore.ora=?","iss",$params);
		if($result->num_rows>0)return true;
		else return false;
	}


	//Funzione per ottenere l'id di un'ora
	function getIdOra($mysqli,$id_classe,$id_giorno,$ora){
		$params[0]=$id_classe;
		$params[1]=$id_giorno;
		$params[2]=$ora;
		$result=runstmt($mysqli,"Select ore.id from ore where ore.id_classe=? and ore.id_giorno=? and ore.ora=?","iss",$params);
		if($result->num_rows>0){
			$row=mysqli_fetch_assoc($result);
			return $row["id"];
		}
		else return -1;
	}

	//Funzione la verifica dell'esistenza di uno specifico record nella tabella classe
	function checkClasse($mysqli,$id_classe){
		$params[0]=$id_classe;
		$result=runstmt($mysqli,"Select classi.id from classi where classi.id=?","s",$params);
		if($result->num_rows>0)return true;
		else return false;
	}

	function querry($mysqli,$sql){
		$result=runquery($mysqli,$sql);
		while($row = $result->fetch_assoc()){
			foreach ($row as $key => $value) {
				echo $key." ".$value."<br>";
			}
		}
	}


	//parametri database
	$db_host="127.0.0.1:3306";
	$db_user="root";
	$db_pwd="test12";
	$db_name="registro_elettronico";

	//definizione del link al database
	$link=mysqli_connect($db_host,$db_user,$db_pwd,$db_name);

?>