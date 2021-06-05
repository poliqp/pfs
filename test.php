<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test</title>
</head>
<body>


	<?php
		include "var.php";
		$ora_id=getIdOra($link,1,"2021-06-15","2");
		echo "ID_ORA: ".$ora_id;


		$params[0]=1;
		$params[1]="2021-06-15";
		$params[2]="2";
		$result=runstmt($link,"Select ore.id from ore where ore.id_classe=? and ore.id_giorno=? and ore.ora=?","iss",$params);
		if($result->num_rows>0){
			$row=mysqli_fetch_assoc($result);
			echo $row["id"];
		}



	?>

</body>
</html>