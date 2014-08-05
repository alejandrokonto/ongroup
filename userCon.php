<?php
	include 'dbc.php';


if ($_SERVER["REQUEST_METHOD"]=="POST"){

	$email = $_POST["emailadd"];
	$passw = $_POST["passw"];
	if($email!=Null && $passw!=Null){
	
			
		 $qUser = "SELECT * FROM User WHERE email = '{$email}'";
                 $result = mysqli_query($con, $qUser);
			if(($userData=mysqli_fetch_array($result))){
				
				$hashed_password = $userData['password'];
				if (crypt($passw, $hashed_password) == $hashed_password) {
  					
					/*log the user in and redirect to the account page*/
					 $_SESSION['liEmail'] = $email;
					$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/userHandler.php';
					ob_end_clean();
					header("Location:$url");
				}else{echo "Wrong password:/ Plz try again.";}
				

			}else{
				echo 'The account is not in our databases.';
			}
		
	

	}

}


?>
