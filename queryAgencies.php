<?php
/*retreive agency data*/
$qAgency = "SELECT * FROM Agencies WHERE email='{$_SESSION['liEmail']}'";
$qResult = mysqli_query($con,$qAgency);
$agData = mysqli_fetch_array($qResult);

/*retreive placement of agency*/
$qFindCity = "SELECT Name FROM Cities WHERE c_id = {$agData['CityID']}";
$qFindCityRe = mysqli_query($con,$qFindCity);
$CityData = mysqli_fetch_array($qFindCityRe);

/*check for default values*/
$agID = $agData['AgencyID'];
$nameData = $agData['AgencyName'];
$urlData = $agData['Url'];
$phoneData = $agData['phoneNo'];
$scoreData = $agData['score'];
$cityData = $CityData['Name'];
$imageDir = $agData['avatar'];
if(!isset($nameData)){$nameData='No name registered';}
if(!isset($urlData)){$urlData='No url given';}
if(!isset($phoneData)){$phoneData='Uknown phone contact';}
if(!isset($scoreData)){$scoreData='No score given so far';}
if(!isset($cityData)){$cityData='No city specified';}
if(!isset($imageDir)){$imageDir='uploads/defaults/service-icons.png';}
?>
