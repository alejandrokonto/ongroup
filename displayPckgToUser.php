<?php
/*make the appropriate query according to user's options in packages.php*/
	$qPckg = "SELECT * FROM TravelPackages";
if(empty($_SESSION["liveIn"]) and empty($_SESSION["dest"])) {
/*if there is no input on liveIn and destination fields*/ 
if(!isset($_GET['order'])){
		$qPckg .= " ORDER BY PackageID DESC";
}elseif($_GET['order']=='price'){
		$qPckg .= " ORDER BY StartingPrice ASC";
}elseif($_GET['order']=='sDate'){
		$qPckg .= " ORDER BY StartDate ASC";
}elseif($_GET['order']=='dur'){
		$qPckg .= " ORDER BY TIMEDIFF(StartDate,EndDate) DESC";
}else{
		$qPckg .= " ORDER BY PackageID DESC";
	}
 
}else{
	/*determine wether a liveIn or a destination field is chosen*/
	if(empty($_SESSION["dest"])){
		$city = strtolower($_SESSION['liveIn']);
		$qField = " WHERE AgencyID IN (
					SELECT AgencyID FROM Agencies
						WHERE CityID IN (
							SELECT c_id FROM Cities
							WHERE LCASE(Name) = '{$city}'
						)
		)";
    }elseif(empty($_SESSION["liveIn"])){
		$dest = strtolower($_SESSION['dest']);
		$qField = " WHERE PackageID IN(
					SELECT PackageID FROM destinationsIndex
					WHERE CityID IN (
							SELECT c_id FROM Cities
							WHERE LCASE(Name) = '{$dest}'
						)
		
		)";
		
	}else{
		$city = strtolower($_SESSION['liveIn']);
		$dest = strtolower($_SESSION['dest']);
			$qField = " WHERE AgencyID IN (
						SELECT AgencyID FROM Agencies
							WHERE CityID IN (
							SELECT c_id FROM Cities
							WHERE LCASE(Name) = '{$city}'
						))
							AND PackageID IN(
								SELECT PackageID FROM destinationsIndex
								WHERE CityID IN (
							SELECT c_id FROM Cities
							WHERE LCASE(Name) = '{$dest}'
						))
							
		";
		}
    
    /*add this to the rest of the query*/
	$qPckg .= $qField;
	
	if(!isset($_GET['order'])){
		$qPckg .= " ORDER BY PackageID DESC";
	}elseif($_GET['order']=='price'){
		$qPckg .= " ORDER BY StartingPrice ASC";
	}elseif($_GET['order']=='sDate'){
		$qPckg .= " ORDER BY StartDate ASC";
	}elseif($_GET['order']=='dur'){
		$qPckg .= " ORDER BY TIMEDIFF(StartDate,EndDate) DESC";
	}else{
		$qPckg .= " ORDER BY PackageID DESC";
	}
	
	
	}
	
function transformDate($data){
			$eDate= date_create_from_format('Y-m-d', $data);
			$eDate= date_format($eDate, 'd-m-Y');
			return $eDate;
	}
	
function shortDescr($data, $id, $ag){
	if (strlen($data) > 300) {

    // truncate string
    $stringCut = substr($data, 0, 300);

    // make sure it ends in a word so assassinate doesn't become ass...
    $data = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="./destination.php?id='.$id.'&ag='.$ag.'">Read More</a>'; 
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
			
		$qPckgRe = mysqli_query($con,$qPckg);

		while($pckgData = mysqli_fetch_array($qPckgRe)){
			
			/*for every package, retrieve the destination list*/
			             
			$qDestInd = "SELECT * FROM destinationsIndex WHERE PackageID = '{$pckgData['PackageID']}'";
			$qDestIndRe = mysqli_query($con,$qDestInd);
			
			/*for every package,retrieve the travelAgency avatar*/
			$qTravAg = "SELECT avatar, AgencyName, AgencyID FROM Agencies where AgencyID = {$pckgData['AgencyID']}";
			$qTravAgRe = mysqli_query($con,$qTravAg);
			$TravAgData = mysqli_fetch_array($qTravAgRe);
			
			/*for every package, put an id to make it accessible*/
                
				echo '<div class="pckgWrapper" id="no'.$pckgData['PackageID'].'">';
			    echo '<div class="pckgAgAvatar"><img src="'.$TravAgData["avatar"].'"></div>';echo '<div class="pointer"></div>';
				echo '<div class="pckgFrame">';
				echo '<div class="destTitleFrame">';
				$rows = mysqli_num_rows($qDestIndRe);
			while($destData = mysqli_fetch_array($qDestIndRe)){
				$qDestCity = "SELECT Name,latitude,longitude FROM Cities WHERE c_id = {$destData['CityID']}";
				$qDestCityRe = mysqli_query($con,$qDestCity);
				$DestCityData = mysqli_fetch_array($qDestCityRe);
				        $rows--;
				echo '<div class="destTitle">'.$DestCityData["Name"];
				if($rows > 0){echo ' -';}
				echo '</div>';
				/*print out hidden long lat values to retreive them with js*/
				echo '<div class = "domTarget" style="display:none"><div class="domTargetLat">'.$DestCityData["latitude"].'</div><div class="domTargetLong">'.$DestCityData["longitude"].'</div><div class="domTargetAgencyID">'.$TravAgData["AgencyID"].'</div></div>';
			}
				echo '</div>';
				
			/*add the add-to-list button at the end of the destinations list*/
			echo '<input type="button" id="addToListButtonImg" onclick="addToList('.$pckgData['PackageID'].')">';
			echo '<img src="'.$pckgData["Photos"].'" >
			
				  <div class="detsFrame">
					<div class="detsLeft">
					<div class="info" id="ldate'.$pckgData['PackageID'].'"><div class="title">Leaving:</div>'.transformDate($pckgData["StartDate"]).'</div>
					<div class="info" id="rdate'.$pckgData['PackageID'].'"><div class="title">Returning:</div>'.transformDate($pckgData["EndDate"]).'</div>
					<div class="info" id="price'.$pckgData['PackageID'].'"><div class="title">From:</div>'.$pckgData["StartingPrice"].'&euro;</div>
					</div>
					<div class="detsRight">
					  <div class="info"><div class="title">Hotel:</div>'.$pckgData["Hotel"].'</div>
					  <div class="info"><div class="title">Airline:</div>'.$pckgData["AirlineCompany"].'</div>
					  <div class="info" id="title'.$pckgData['PackageID'].'"><div class="title">Agency:</div>'.$TravAgData["AgencyName"].'</div>
					</div>
				  </div>
				  <div class="desc">'.shortDescr($pckgData["RouteDescription"],$pckgData['PackageID'],$TravAgData["AgencyID"]).'</div>
				  <div class="addPckgButtonWrapper"><input type="button" id="addToListButton" value="+ Add destination" onclick="addToList('.$pckgData['PackageID'].')">
				</div>';
			/*package wrapper ends here*/
			echo '</div>';
			echo '</div>';
			
		}
		?>	
	 <!--Content ends here--->	 
	</div>
