<?php 
$qPckg = "SELECT * FROM TravelPackages WHERE AgencyID={$agID} ORDER BY PackageID DESC"; 

function transformDate($data){
			$eDate= date_create_from_format('Y-m-d', $data);
			$eDate= date_format($eDate, 'd-m-Y');
			return $eDate;
	}
	
function shortDescr($data){
	if (strlen($data) > 300) {

    // truncate string
    $stringCut = substr($data, 0, 300);

    // make sure it ends in a word so assassinate doesn't become ass...
    $data = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="/this/story">Read More</a>'; 
	}
	return $data;
}

?>
<div class="top">
		<div class="Title">Travel Packages</div>
	</div>
<!--all the content goes here-->
	<div class="content">
		<?php
			/*check if there was a newly added package and notify accordingly*/
			if($_GET['new']=='y'){echo '<div class="newlyAdded">Your new travel package was successfully submitted!</div>';}
		$qPckgRe = mysqli_query($con,$qPckg);
		while($pckgData = mysqli_fetch_array($qPckgRe)){
			/*for every package, retrieve the destination list*/
			              $counter++;
			$qDestInd = "SELECT * FROM destinationsIndex WHERE PackageID = '{$pckgData['PackageID']}'";
			$qDestIndRe = mysqli_query($con,$qDestInd);
				echo '<div class="pckgWrapper">';
			    echo '<div class="pckgCounter">'.$counter.'</div>';echo '<div class="pointer"></div>';
				echo '<div class="pckgFrame">';
				$rows = mysqli_num_rows($qDestIndRe);
			while($destData = mysqli_fetch_array($qDestIndRe)){
				        $rows--;
				$qDestCity = "SELECT Name FROM Cities WHERE c_id = {$destData['CityID']}";
				$qDestCityRe = mysqli_query($con,$qDestCity);
				$DestCityData = mysqli_fetch_array($qDestCityRe);
				echo '<div class="destTitle">'.$DestCityData["Name"];
				if($rows > 0){echo ' -';}
				echo '</div>';
			}
			
			echo '<img src="'.$pckgData["Photos"].'" >
			
				  <div class="detsFrame">
					<div class="detsLeft">
					<div class="info"><div class="title">Leaving:</div>'.transformDate($pckgData["StartDate"]).'</div>
					<div class="info"><div class="title">Returning:</div>'.transformDate($pckgData["EndDate"]).'</div>
					<div class="info"><div class="title">From:</div>'.$pckgData["StartingPrice"].'&euro;</div>
					</div>
					<div class="detsRight">
					  <div class="info"><div class="title">Hotel:</div>'.$pckgData["Hotel"].'</div>
					  <div class="info"><div class="title">Airline:</div>'.$pckgData["AirlineCompany"].'</div>
					</div>
				  </div>
				  <div class="desc">'.shortDescr($pckgData["RouteDescription"]).'</div>
				</div>';
			/*package wrapper ends here*/
			echo '</div>';
		}
		?>	
	 <!--Content ends here--->	 
	</div>
