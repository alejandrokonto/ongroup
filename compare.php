<?php
include 'header.php';
include 'dbc.php';
include 'user.php';

	
?>
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper compare">

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
		<div class="Title">Compare and Book!</div>
	</div>
<!--all the content goes here-->
	<div class="content">
		<div class="packagesWrapper">
				
		</div>
		<!--content ends here-->
	</div>
<!--Main content ends here-->		
</div>

<?php
	include 'footer.php';
?>

