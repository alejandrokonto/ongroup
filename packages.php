<?php
include 'header.php';
include 'dbc.php';
include 'user.php';

/*check if any input field is entered and put it in a session variable*/
	if(isset($_POST["myLoc"])){$_SESSION["liveIn"] = $_POST["myLoc"];}
		elseif(isset($_POST["myDest"])){$_SESSION["dest"] = $_POST["myDest"];}
		
/*check if any of the destination point or live in input are set and pass em to the link*/
	         $url = "packages.php?";
	
?>
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper packageFunctionsUsr">

<!--side menu formation -->
<div class="SideContent">
<div class="SideMenu">
	<ul>
	<li id="LiveInSearch">
		<div class="MenuTitle">I Live in</div>
		<form id="LiveInS" action="<?php echo $url;?>" method="post">
			<input type="text" name="myLoc" placeholder="Your Location..." value="<?php if(isset($_SESSION["liveIn"])){echo $_SESSION["liveIn"];} ?>">
		</form>
	</li>
	<li id="DestinationPoint">
		<div class="MenuTitle">Destination Point</div>
		<form id="DestS" action="<?php echo $url;?>" method="post">
			<input type="text" name="myDest" placeholder="Destination..." value="<?php if(isset($_SESSION["dest"])){echo $_SESSION["dest"];} ?>">
		</form>
	</li>
	</ul>
</div>
<div class="SideMenu OrderByMenu">
	<ul>
	<li><div class="MenuTitle">Arrange By</div></li>
	<?php 
	/*add essential elements to url string*/
	
	?>
	<li class="orderBy"><a href="<?php echo $url."order=price";?>">Price</a></li>
	<li class="orderBy"><a href="<?php echo $url."order=sDate";?>">Starting Date</a></li>
	<li class="orderBy"><a href="<?php echo $url."order=dur";?>">Duration</a></li>
	<li class="orderBy"><a href="<?php echo $url."order=issueDate";?>">Issue Date</a></li>
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
<!--RightSide Package Selection-->
<div class="MyPackages">
<div class="title">Let's See..</div>
<div class="subtitle">DESTINATIONS</div>
	<div class="destEg">
	<img src="pictures/DestinationListPin.png">
	<div class="clearWidth"></div>
	Add any destination to the list
	</div>
	<div id="sideBarList">
		
	</div>
	<div class="sideBarListButtons">
	<input type="button" id="clearButton" value="clear">
	<a href="./compare.php" id=checkItButton>checkIt</a>
	</div>
</div>
<!--main body -->
<div class="MainContent">
<?php
	

	include 'displayPckgToUser.php';
?>
<!--Main content ends here-->
</div>
		



<?php
	include 'footer.php';
?>
