<?php
include 'headerAG.php';
include 'dbc.php';
include 'queryAgencies.php';
?>
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper packageFunctionsAG">

<!--side menu formation -->
<div class="SideContent">
<div class="SideMenu">
	<ul>
	<li><a href="packageFunctions.php?ftype=insert"><div class="MenuTitle">insert</div><div class="TitleDetails">Insert a new travel package</div></a></li>
	<li><a href="packageFunctions.php?ftype=update"><div class="MenuTitle">update</div><div class="TitleDetails">Update a package's details</div></a></li>
	<li><a href="packageFunctions.php?ftype=delete"><div class="MenuTitle">delete</div><div class="TitleDetails">Remove a travel package from your offers</div></a></li>
	</ul>
</div>
<div class="SideDataDisplay">
    <ul>	
    <li><div class="avatar"><img src="<?php echo $imageDir; ?>" ></div></li>
	<li><div class="title">Agency Name</div><div class="details"><?php echo $nameData;?></div></li>
	<li><div class="title">Url</div><div class="details"><?php echo $urlData;?></div></li>
	<li><div class="title">Phone Number</div><div class="details"><?php echo $phoneData;?></div></li>
	<li><div class="title">City</div><div class="details"><?php echo $cityData;?></div></li>
    </ul>
</div>
</div>
<!--main body -->
<div class="MainContent">
<?php
	/*decide wether a travel agency is logged in or not*/
	/*decide wether it is for starting page, insert function, update function, delete function*/
	if(!isset($_GET['ftype'])){
		include 'displayPckg.php';
	}elseif($_GET['ftype'] == 'insert'){
		include 'insertPckg.php';
	}elseif($_GET['ftype'] == 'update'){
		include 'updatePckg.php';
	}else{ 
		include 'deletePckg.php';
	}
?>
<!--Main content ends here-->
</div>		



<?php
	include 'footerAG.php';
?>
