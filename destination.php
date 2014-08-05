<?php
include 'header.php';
include 'dbc.php';
include 'user.php';

function transformDate($data){
			$eDate= date_create_from_format('Y-m-d', $data);
			$eDate= date_format($eDate, 'd-m-Y');
			return $eDate;
	}

	/*query the package that the user chose*/
  $qPckg = "SELECT * FROM TravelPackages WHERE PackageID = {$_GET['id']}";
  $qPckgRe = mysqli_query($con,$qPckg);
  $pckgData = mysqli_fetch_array($qPckgRe);

    /*find the agency details*/
    $qTravAg = "SELECT * FROM Agencies WHERE AgencyID ={$_GET['ag']}";
    $qTravAgRe = mysqli_query($con,$qTravAg);
    $TravAgData = mysqli_fetch_array($qTravAgRe);
    
  /*for every package, retrieve the destination list*/          
	$qDestInd = "SELECT * FROM destinationsIndex WHERE PackageID = '{$_GET['id']}'";
	$qDestIndRe = mysqli_query($con,$qDestInd);
	
?>
<!--Main Body Wrapper holding side menu and content-->
<div class="MainBodyWrapper destination">

<!--side menu formation -->
<div class="SideContent">
<div class="packageDisplay">
	<h3>Basic Details</h1>
	<div class="price">From:<?php echo ' '.$pckgData["StartingPrice"].'&euro;'; ?></div>
	<div class="date"><div class="title">Departure:</div><?php echo ' '.transformDate($pckgData["StartDate"]); ?></div>
	<div class="date"><div class="title">Returning:</div><?php echo ' '.transformDate($pckgData["EndDate"]); ?></div>
	<div class="button"><a href="./cart.php?id=<?php echo $_GET['id'].'&ag='.$_GET['ag']; ?>">Buy Now</a></div>
</div>
<div class="destGoogleMaps">
	<div id="googleMaps"></div>

</div>
<div class="SideMenu">
	<ul>
	<li><a href="userHandler.php"><div class="MenuTitle">account</div><div class="TitleDetails">basic information</div></a></li>
	<li><a href="#"><div class="MenuTitle">my destinations</div><div class="TitleDetails">check and modify your destinations list</div></a></li>
	</ul>
</div>
</div>
<!--RightSide Package Selection-->

<!--main body -->
<div class="MainContent">
<div class="top">
		<div class="Title">
		<?php
		/*print out the destinations*/
		$rows = mysqli_num_rows($qDestIndRe);
		echo '<div class="destTitleFrame">';
			while($destData = mysqli_fetch_array($qDestIndRe)){
				$qDestCity = "SELECT Name,latitude,longitude FROM Cities WHERE c_id = {$destData['CityID']}";
				$qDestCityRe = mysqli_query($con,$qDestCity);
				$DestCityData = mysqli_fetch_array($qDestCityRe);
				        $rows--;
				echo '<div class="destTitle">'.$DestCityData["Name"];
				if($rows > 0){echo ' -';}
				echo '</div>';
				/*print out hidden long lat values to retreive them with js*/
				echo '<div class = "domTarget" style="display:none"><div class="domTargetLat">'.$DestCityData["latitude"].'</div><div class="domTargetLong">'.$DestCityData["longitude"].'</div></div>';
			}
		echo '</div>';
		?>
		<a class="addToCart" href="./cart.php?id=<?php echo $_GET['id'].'&ag='.$_GET['ag']; ?>">Add To Cart</a>
		</div>
</div>
<!--all the content goes here-->
<div class="packageFrame">
<?php
echo '<img src="'.$pckgData["Photos"].'" >';
     echo '<div class="infoFrame">
			
			<h3>Description</h3>
			<div class="details">
			<div class="infoDets"><div class="title">Leaving:</div>'.transformDate($pckgData["StartDate"]).'</div>
			<div class="infoDets"><div class="title">Returning:</div>'.transformDate($pckgData["EndDate"]).'</div>
			<div class="infoDets"><div class="title">From:</div>'.$pckgData["StartingPrice"].'&euro;</div>
			</div>
			<div class="info">'.$pckgData["RouteDescription"].'</div>
			<h4>Extras</h4>
			<div class="info">'.$pckgData["Extras"].'</div>
			<h5>Details</h5>
			<div class="details">
			<div class="infoDets"><div class="title">Hotel:</div>'.$pckgData["Hotel"].'</div>
			<div class="infoDets"><div class="title">Airline:</div>'.$pckgData["AirlineCompany"].'</div>
			<div class="infoDets"><div class="title">Agency:</div>'.$TravAgData["AgencyName"].'</div>
			</div>
          </div>';
?>

<!--packageFrame ends here-->
</div>
<!--Main content ends here-->
</div>
		



<?php
	include 'footer.php';
?>

