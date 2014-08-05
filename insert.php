<?php
	include 'dbc.php';


if ($_SERVER["REQUEST_METHOD"]=="POST"){

	$email = $_POST["emailadd"];
	$passw = $_POST["passw"];
	if($email!=Null && $passw!=Null){
	
		$dbpassw = crypt($passw);	
		 $qUser = "INSERT INTO User(email, password) VALUES ('{$email}', '{$dbpassw}')";
                 	 if(mysqli_query($con,$qUser)){
				
				
				echo 'success with '.$passw.'->'.$dbpassw;
				

			}else{
				echo 'Something happened:/';
			}
		
	

	}

}


?>
