<?php
session_start();

// We check the file for right type and if it exists already.
$directory = $_SERVER['DOCUMENT_ROOT'].'/n342-final/uploads/';
if(isset($_FILES["userFile"])){
	$file = $_FILES["userFile"];
	$filename = $file["name"];
	$targetFile = $directory.basename($filename);
	$upload = true;
	$fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
	
	// check to see if the file is a csv file
	if($fileType!= "csv"){
		$message="Any file to upload  must be a csv file";
		$upload=false;
	}


	if($upload){
		if(move_uploaded_file($file["tmp_name"],$targetFile)){
			$message="Uploaded ".htmlspecialchars($filename);
			$_SESSION['file']=$targetFile;
			unlink($file["tmp_name"]);
			echo "I uploaded the file!!!";

			header("Location: /n342-final/admin/fileUploaded.php");	
	}	
	}
}
else{
	$message="File not found"; 
}

echo $message;




?>
