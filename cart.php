<?php
include 'header.php';
include 'dbc.php';
include 'user.php';
include 'cartHandler.php';

	
?>
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper cart">

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
		<div class="Title">My Cart</div>
	</div>
<!--all the content goes here-->
	<div class="content">
		<?php 
		while($cartData = mysqli_fetch_array($qPckgCartRe)){
			
		/*retreive package details*/
		$qPckg = "SELECT * FROM TravelPackages WHERE PackageID = {$cartData['package_id']}";
		$qPckgRe = mysqli_query($con,$qPckg);
		$Pckg = mysqli_fetch_array($qPckgRe);
		
		echo '<div class="packageFrame" id="No'.$Pckg["PackageID"].'">';
 
		
		
		$datetime1 = date_create($Pckg["StartDate"]);
		$datetime2 = date_create($Pckg["EndDate"]);
		$diff = date_diff($datetime1,$datetime2);
		$diffF = $diff->format('%a days');
		
		$qDestInd = "SELECT CityID FROM destinationsIndex WHERE PackageID = {$cartData['package_id']}";
		$qDestIndRe = mysqli_query($con,$qDestInd);
		$rows = mysqli_num_rows($qDestIndRe);
		
		echo '<div class="title"><div class="days">'.$diffF.' Tour to </div>';
		while($DestInd = mysqli_fetch_array($qDestIndRe)){	
			    
				$qCityName = "SELECT Name FROM Cities WHERE c_id = {$DestInd['CityID']}";
				$qCityNameRe = mysqli_query($con,$qCityName);
				$CityName = mysqli_fetch_array($qCityNameRe);
				$rows--;
				echo '<div class="dest">'.$CityName["Name"];
				if($rows > 0){echo ' -';}
				echo '</div>';
			}
		echo  '</div>
			  <img src="'.$Pckg["Photos"].'">
			  <div class="detsFrame" >
			  <div class="details"><div class="label">Leaving:</div>'	.transformDate($Pckg["StartDate"]).'</div>
			  <div class="details"><div class="label">Returning:</div>'.transformDate($Pckg["EndDate"]).'</div>
			  <div class="details"><div class="label">Price:</div>'.$Pckg["StartingPrice"].' &euro; / person</div>
			  <div class="details"><div class="label">Hotel:</div>'.$Pckg["Hotel"].'</div>
			  </div>
			  <div class="orderDets">Quantity: 
				<select onchange="reCalc('.$Pckg["PackageID"].')">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
				</select>
			  </div>
			  <div class="removeSubTotal">
				<a href="./cart.php?rem='.$Pckg["PackageID"].'"><i class="fa fa-times"></i></a>
				<div class="subTotal"><div class="label">Subtotal:</div>'.$Pckg["StartingPrice"].' &euro;</div>
			  </div>
		<!--packageFrame ends here-->
			  </div>';
		} ?>
		
		<div class="totalPrice">
		   <div class="frame">
			<div class="label">Total:</div>
			<div class="value"></div>
		   </div>
		</div>
		<div class="actions">
			<a href="./cart.php?clear=true" class="clearCart"><i class="fa fa-trash-o"></i>Clear Cart</a>
			<a href="./book.php" class="checkout">Checkout</a>
		</div>
		<!--content ends here-->
	</div>
<!--Main content ends here-->		
</div>

<?php
	include 'footer.php';
?>
