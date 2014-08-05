<?php
 /*Check if the user is logged in*/
 if(isset($_SESSION['liEmail'])){
 include 'dbc.php';

 /*Query the database to SELECT User's data in order to display them, */
 $qUser = "SELECT * FROM User WHERE email='{$_SESSION['liEmail']}'";

 
 $qUserR = mysqli_query($con,$qUser);
 $userData = mysqli_fetch_array($qUserR);
 $nameData = $userData['FirstName'];
 $surnameData = $userData['LastName'];
 $ageData = $userData['Age'];
 $genderData = $userData['Gender'];
 if(!isset($nameData)){$nameData='Still didnt catch your name';}
 if(!isset($surnameData)){$surnameData='Nope...not a surname here';}
 if(!isset($ageData)){$ageData='Empty so far';}
 if(!isset($genderData)){$genderData='Be proud of your gender';}

 
 /*initialize error and msg variables*/ 
 $nameE = $surnameE = $emailE = $passwE = $ageE = $genderE = Null;

function refreshURL(){

	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/userHandler.php';
	ob_end_clean();
	header("Location:$url");
} 
function inputFilter($data) {

	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

/*If the user makes an update request, proceed accordingly*/
if ($_SERVER["REQUEST_METHOD"]=="POST"){
      
	if(!empty($_POST["name"])) {
		
		$name = inputFilter($_POST["name"]);
		if(!preg_match("/^[a-zA-Z]*$/",$name)){
			$nameE = "Only letters and white spaces allowed";
		}else{  
			$updateQ = "UPDATE User SET FirstName='{$name}' WHERE email='{$userData['email']}'";
			mysqli_query($con, $updateQ);
                        $msg = 'New First Name successfully updated!';
			refreshURL();
		     }
	}else{$blankName = true;}


	if(!empty($_POST["surname"])){
	
	$surname = inputFilter($_POST["surname"]);
	if(!preg_match("/^[a-zA-Z]*/",$surname)){
		$surnameE = "only letters and white spaces allowed";
	}else{
		$updateQ ="UPDATE User SET LastName='{$surname}' WHERE email='{$userData['email']}'";
		mysqli_query($con, $updateQ);
		$msg = 'New Last Name successfully registered!';
			refreshURL();
        }

	}else{$blankSurname = true;}

	if(!empty($_POST["emailadd"])){
	$email = inputFilter($_POST["emailadd"]);
	if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)){
		$emailE = "Invalid email format";
	}else{
		$updateQ ="UPDATE User SET email='{$email}' WHERE email='{$userData['email']}'";
		mysqli_query($con, $updateQ);
		$msg = 'New email address successfully registered!';
		$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/logout.php?relogin = yes';
		ob_end_clean();
		header("Location:$url");
	}
	
	}else{$blankEmail = true;}

	if(!empty($_POST["age"])){
	$age = inputFilter($_POST["age"]);
	if(!(is_numeric($age) && is_int(0+$age))){
		$ageE = "Invalid age input. Only integers"; echo $ageE;
	}else{
		$updateQ ="UPDATE User SET Age={$age} WHERE email='{$userData['email']}'";
		mysqli_query($con, $updateQ);
		$msg = 'New age input successfully registered!';
			refreshURL();
	}

	}else{$blankAge = true;}

	if(!empty($_POST["sex"])){
		$gender = $_POST["sex"];
		$updateQ ="UPDATE User SET Gender='{$gender}' WHERE email='{$userData['email']}'";
		mysqli_query($con, $updateQ);
		$msg = 'New gender input successfully registered';
			refreshURL();
	
	}else{$blankGender = true;}	
	
	/*if server request method = post ENDS*/
	}	

	}else{
                /*if they are logged out, take them to the login page*/  
		$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/logout.php?restricted=yes';
		ob_end_clean();
		header("Location:$url");
	 }




?>
