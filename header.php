<?php session_start();
      ob_start(); 
  /*determine which javascript source to load and if it is about destination.php load the cords stored*/
  $temp = explode('/',$_SERVER['PHP_SELF']);
  $src = null;
  foreach($temp as $str){ 
	if($str == "destination.php"){
			$src = '<script src="https://maps.googleapis.com/maps/api/js"></script>
			        <script src="js/geoPckg.js"></script>';
	}elseif($str == "cart.php"){
			$src = '<script src="js/cart.js"></script>';
	}elseif($str == "compare.php"){
			$src = '<script src="js/date.js"></script>
					<script src="https://maps.googleapis.com/maps/api/js?libraries=geometry"></script>
					<script src="js/compare.js"></script>';
	}
  }
  if($src == null) $src = '<script src="js/listHandler.js"></script>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="ongroup.css" rel="stylesheet" type="text/css"/>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<?php echo $src;?>
<title>Ongroup.gr - User Profile</title>
</head>
<body>
<!--Main header holding menu and logo-->
<div class="MainHeader">
	<div class="LogoPlaceholder"><a href="packages.php"><img src="pictures/logoOnGroup292x100.png"></a></div>
	<div class="menuWrapper">
	<ul>
		<li><a class="compare" title="compare" href="./compare.php">Compare</a></li>
		<li><a class="yourList" title="your list" href="./cart.php">MyDestinations</a></li>
		<li><a class="packages" title="travelpackages" href="./packages.php">Packages</a></li>
		<li><a class="account" title="account" href="./userHandler.php">Account</a></li>
		<li><a class="logout" title="logout" href="./logout.php">Logout</a></li>
	</ul>	
	</div>
</div>
