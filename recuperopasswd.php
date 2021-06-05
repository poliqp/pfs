<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
	<title>Recupero password</title>
</head>
<body>
	<?php  

		include("var.php");
		if(isset($_POST["user"])){
			//retrive dei parametri dalla form
			$params[0]=$_POST["user"];
			//template
			$template1="Select username,email from utenti where username=?";
			$template2="Update utenti set codice_recupero_passwd=? where username=?";
			$result=runstmt($link,$template1,"s",$params);
			if($result->num_rows>0){
				$row=mysqli_fetch_array($result);
				$params[0]=randString(10); 		//codice
				$params[1]=$row["username"];	//username
				$email=$row["email"];			//email
				runstmt($link,$template2,"ss",$params);
				//mail($email,"Recupero Password","Link: 127.0.0.1:8080/recuperopasswd.php?crp=".$params[0]);
				$link = "127.0.0.1:8080/recuperopasswd.php?crp=".$params[0];
				echo "email:".$email." Link: ".$link;
			}
			else echo "Username errato";

		}

		elseif(isset($_GET["crp"])){
			$template3="Select codice_recupero_passwd from utenti where codice_recupero_passwd=?";
			$params[0]=$_GET["crp"];
			$result=runstmt($link,$template3,"s",$params);
			if($result->num_rows>0){
				echo '
					<div class="container-form-center">
					<form class="form-generic" action="recuperopasswd.php" method=POST>
						<label for="pwd">Password</label>
						<input type="text" name="pwd" required>
						<input type="hidden" name="crp" value='.$_GET["crp"].'>
						<input type="submit" value="Invia">
					</form>
					</div>
				';
			}
			else echo "Codice recupero password errato o scaduto";
		}
		
		elseif(isset($_POST["pwd"])&&isset($_POST["crp"])){
			$template4="Update utenti set passwd=? where codice_recupero_passwd=?";
			$params[0]=(string)hash("sha256",$_POST["pwd"]);
			$params[1]=$_POST["crp"];
			if(runstmt($link,$template4,"ss",$params)){
				echo "Password modificata";
				runquery($link,'Update utenti set codice_recupero_passwd=null where codice_recupero_passwd="'.$params[1].'"');
			}
			else echo "Passwod non modificata";
		}

		else{
			echo '
				<div class="container-form-center">
				<form class="form-generic" action="recuperopasswd.php" method=POST>
					<label for="user">Username</label>
					<input type="text" name="user" required>
					<input type="submit" value="Invia">
				</form>
				</div>
				';
		}
	?>

</body>
</html>