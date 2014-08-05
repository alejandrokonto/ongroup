<?php 
	include 'headerAG.php';

        if(isset($_SESSION['agencyName'])){

	$_SESSION = array();
	session_destroy();
	setcookie(session_name(), '', time()-300, '/', '',0);
	$msg = "You are now loged out.";
	}elseif(isset($_GET['restricted'])){
		$msg = 'Oops! You cant have access to this area, please login.';
		}else {$msg = 'It seems that you already are <br/> logged out:/';}
?>

	<!--Main Body Wrapper holding side menu and content -->
<div class="MainBodyWrapper loginPage">

<form name="input" action="agencyLogin.php" method="post">
			
			<div class="loginTitle">Sign In</div>
			<div class="sepLine"></div> 
			<div class="loginLowerBG">
			<input type="text" name="emailadd" placeholder="Email Address"> 
			 
			<input type="password" name="passw" placeholder="Password">
			
			<input type="submit" value="Sign In">
			<div class="logoutMSG"><?php echo $msg ?></div>
			</div>



<?php	
	include 'footerAG.php';

?>

