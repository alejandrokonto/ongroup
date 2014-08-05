<?php
		include 'dbc.php';
		
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if(!empty($_FILES["file"]["name"])){
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 50000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    $avatarMsg = "Return Code: " . $_FILES["file"]["error"];
  } else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>".
     "Type: " . $_FILES["file"]["type"] . "<br>".
     "Size: " . ($_FILES["file"]["size"] / 1024) . " kB";
     
    /*Handle the UPLOAD DIRECTORIES PROPERLY*/
    $dir = 'uploads/{$_SESSION["agencyName"]}';
    if(!is_dir($dir)){
				@mkdir("uploads/{$_SESSION['agencyName']}",0755);
	}
		 		
	if (file_exists("uploads/{$_SESSION['agencyName']}/" . $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "uploads/{$_SESSION['agencyName']}/". $_FILES["file"]["name"]);
      
      $qUpdateAvatar = "UPDATE Agencies SET avatar = 'uploads/{$_SESSION['agencyName']}/{$_FILES["file"]["name"]}' 
						WHERE email = '{$_SESSION['liEmail']}'";
	   mysqli_query($con,$qUpdateAvatar);
       echo $_FILES["file"]["name"].' successfully stored!';
	}	
    
  }
  
} else {
  echo "Invalid file";
}
}
?> 
