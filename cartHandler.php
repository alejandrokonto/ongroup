<?php
/*declaring functions needed*/
function transformDate($data){
			$eDate= date_create_from_format('Y-m-d', $data);
			$eDate= date_format($eDate, 'd-m-Y');
			return $eDate;
	}

function refreshURLcart(){

	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/cart.php';
	ob_end_clean();
	header("Location:$url");
} 

/*if a purchase is occuring through DESTINATION.php, add this to the database*/

if($_SERVER["REQUEST_METHOD"]=="GET"){
	/*ignore duplicates and store if needed*/
	$qPckgCart = "SELECT * FROM Cart WHERE user_id = '{$_SESSION["liEmail"]}' AND package_id = {$_GET['id']}";
	$qPckgCartRe = mysqli_query($con,$qPckgCart);
	if(@mysqli_fetch_array($qPckgCartRe)){
			$qPckgCart = "SELECT * FROM Cart WHERE user_id = '{$_SESSION["liEmail"]}'";
			$qPckgCartRe = mysqli_query($con,$qPckgCart);
			
	}else{
			$qPckgCart = "INSERT INTO Cart (package_id, agency_id, user_id) VALUES ({$_GET['id']},{$_GET['ag']},'{$_SESSION["liEmail"]}')";
			mysqli_query($con,$qPckgCart);
			
			$qPckgCart = "SELECT * FROM Cart WHERE user_id = '{$_SESSION["liEmail"]}'";
			$qPckgCartRe = mysqli_query($con,$qPckgCart);
	}
	
	/*if removal is chosen proceed accordingly*/
	if(!empty($_GET["rem"])){
		$qCartDel = "DELETE FROM Cart WHERE package_id = {$_GET["rem"]}";
		mysqli_query($con,$qCartDel);
		refreshURLcart();
	}elseif(!empty($_GET["clear"])){
		$qCartDel = "DELETE FROM Cart WHERE user_id = '{$_SESSION["liEmail"]}'";
		mysqli_query($con,$qCartDel);
		refreshURLcart();
	}
	
}
	


?>
