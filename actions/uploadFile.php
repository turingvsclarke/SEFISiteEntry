<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
// We check the file for right type and if it exists already.
$directory = $_SERVER['DOCUMENT_ROOT'].'/n342-final/uploads/';

if(is_uploaded_file($_FILES["userFile"]["tmp_name"])){
	$file = $_FILES["userFile"];
	$filename = $file["name"];
	$targetFile = $directory.basename($filename);
	$upload = true;
	$fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
	
	// check to see if the file is a csv file
	if($fileType!= "csv"){
		$message="Any file to upload  must be a csv file";
		$upload=false;
        //unlink($file["tmp_name"]);
	}


	if($upload){
		if(move_uploaded_file($file["tmp_name"],$targetFile)){
			$message="Uploaded ".htmlspecialchars($filename);
			$_SESSION['file']=$targetFile;
            print_r($_SESSION['file']."\n");
			// unlink($file["tmp_name"]);
			echo "I uploaded the file!!!\n";

			header("Location: /n342-final/admin/fileUploaded.php");	
	}	
	}

// unlink($_FILE["userFile"]["name"]);
}
else{
	$message="Upload a valid file(less than a megabyte)"; 
}

?>
