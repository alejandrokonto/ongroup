<?php 
	include 'header.php';
	include 'user.php';
	
?>	
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper">

<!--side menu formation -->
<div class="SideContent">
<div class="SideMenu">
	<ul>
	<li><a href="userHandler.php"><div class="MenuTitle">account</div><div class="TitleDetails">basic information</div></a></li>
	<li><a href="#"><div class="MenuTitle">my destinations</div><div class="TitleDetails">check and modify your destinations list</div></a></li>
	</ul>
</div>
<div class="SideDataDisplay">
    <ul>
	<li><div class="title">name</div><div class="details"><?php echo $nameData;?></div></li>
	<li><div class="title">last name</div><div class="details"><?php echo $surnameData;?></div></li>
	<li><div class="title">age</div><div class="details"><?php echo $ageData;?></div></li>
	<li><div class="title">gender</div><div class="details"><?php echo $genderData;?></div></li>
    </ul>
</div>
</div>
<!--main body -->
<div class="MainContent">
	<div class="top">
		<div class="Title">account</div>
	</div>
<!--all the content goes here-->
	<div class="content">
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
			<div class="Label">Name:</div> <input type="text" name="name" >
			<input type="submit" value="Save"> 
		</form> 
	</div>
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
		<div class="Label">surname:</div> <input type="text" name="surname" >
		<input type="submit" value="Save"> 
		</form> 
	</div>
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
			<div class="Label">E-mail:</div> <input type="text" name="emailadd">
			<input type="submit" value="Save"> 
		</form>
	 </div>
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
			<div class="Label">Password:</div> <input type="password" name="passw">
			<input type="submit" value="Save">
		</form>
	 </div>
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
			<div class="Label">Age:</div> <input type="number" name="age">
			<input type="submit" value="Save">
		</form>
	 </div>
	 <div class="inputField">
	 	<form name="input" action="userHandler.php" method="post">
			<div class="Label">Gender:</div> 
			<div class="radioButtons">
			 male<input type="radio" name="sex" <?php if($gender!=null && $gender == 'male') echo 'checked';?> value="male">
			 female<input type="radio" name="sex" <?php if($gender!=null && $gender == 'female') echo 'checked';?> value="female">
			</div>
			<input id="radioButtonsSubmit" type="submit" value="Save">
		</form>
	 </div>
	</div>
		
</div>

<?php 
	include 'footer.php';
?>







