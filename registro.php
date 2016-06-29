<?php 

	
	require "site/config.php";
	if(isset($_GET['by'])){
		$referidoPor=$_GET['by'];
		if(trim($referidoPor)!=""){
			$conn=new PDO('mysql:host=localhost;dbname=accounts;charset=utf8',$usuario,$contra);
			$sql=$conn->prepare("SELECT id FROM cuentas WHERE id = ".$referidoPor);
			$sql->execute();
			$resultado=$sql->fetchAll();
			$id=0;
			foreach($resultado as $row){
				$id=$row['id'];
				}
			if($id!=0){
				echo "<script>var by = 'exists'</script>";
			}else{
				echo "<script>var by = 'unknow'</script>";
			}
		}
		else{echo "<script>var by = 'dont'</script>";
		}echo "<script>var referidoPor = '".$id."'</script>";
	}
	

	require_once("site/singin.php");
 ?>