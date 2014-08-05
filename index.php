<?php
 include 'header.php';
 include 'userCon.php';
?>
<!--Main Body Wrapper holding side menu and content -->

<div class="MainBodyWrapper loginPage">

<form name="input" action="index.php" method="post">
			
			<div class="loginTitle">Sign In</div>
			<div class="sepLine"></div> 
			<div class="loginLowerBG">
			<input type="text" name="emailadd" placeholder="Email Address"> 
			 
			<input type="password" name="passw" placeholder="Password">
			
			<input type="submit" value="Sign In">
			</div>
</form>
<div class="agenciesLink"><a href="http://www.ongroup.gr/php/agencyLogin.php">Travel Agencies</a></div>
<?php
 include 'footer.php';
?>
