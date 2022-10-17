<!--
FILE NAME:readfile.php
PURPOSE:Reads file of csv type. Makes sure the file is right and shows data if it is.
MODIFICATION HISTORY:
11/04/20 Added file header
-->

<!---  Needs styling to display message and display table  -->
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
      
    // check for admin
	require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";

	// CSV file read
     if(!(isset($_SESSION['file']))){
            header("Location: /n342-final/admin/uploadFile.php");
    }

     $file = $_SESSION['file'];
    
    
    // this will store the students part of our table
    $students = "";

    // this will store the projects part of our table
    $projects = "";    
	$data = [];
	$year = date("Y");	
	// create a file reading stream
	$handle = fopen($file,"r",1);

	try{
	$i=0;
    $displayData = true;
	// while you still have text to read, read the file
	while(($cont=fgetcsv($handle,1000,","))!=false && $displayData){
		if($i>0){	
              if(count($cont)===16){
                $data[$i-1]=$cont;
                $displayData=true;  
                  
                $fname=$cont[0];
                $mname=$cont[1];
                $lname=$cont[2];
                $school=$cont[3];
                $city=$cont[4];
                $county=$cont[5];
                $grade=$cont[6];
                $gender=$cont[7];
                $projectnumber=$cont[8];
                $title=$cont[9];
                $abstract=$cont[10];
                $gradelevel=$cont[12];
                $category=$cont[13];
                $CNid=$cont[14];
                $booth=$cont[15];
                $message="File successfully processed. Data array is ".count($data)." long. Click 'Verify' to add the data below or 'Don't Add' to go back";
        }
        else {
            $message = "File has incorrect format";
            $displayData = false;
            break;
        }
            $students = $students."<tr><td>$fname</td>
                        <td>$mname</td>
                        <td>$lname</td>
                        <td>$school</td>
                        <td>$city</td>
                        <td>$county</td>
                        <td>$grade</td>
                        <td>$gender</td></tr>";
                
            $projects=$projects."<tr><td>$projectnumber</td><td>$title</td>
					<td>$abstract</td>
                    <td>$grade</td>
                    <td>$gradelevel</td>
                    <td>$category</td>
                    <td>$CNid</td>
					<td>$booth</td></tr>";
	
		}// end if
		$i++;
	} // end while 

	} // end try
	catch(Exception $e){
		$message="Failed to read from file. Incorrect format";
		$displayData = false;
	}
    // unlink($_SESSION['file']);

?>
