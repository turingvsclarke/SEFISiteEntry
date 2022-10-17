<!--
FILE NAME:readcsv.php
PURPOSE:Reads file of csv type. Makes sure the file is right and shows data if it is.
MODIFICATION HISTORY:
11/04/20 Added file header
-->

<!---  Needs styling to display message and display table  -->
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

	$year = date("Y");	
	// create a file reading stream
	$handle = fopen($file,"r",1);

	try{
	$i=1;
	// while you still have text to read, read the file
	while(($cont=fgetcsv($handle,1000,","))!=false){
		if($i>1){
			
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
	
            $students = $students."<tr><td>$fname</td>
                        <td>$mname</td>
                        <td>$lname</td>
                        <td>$school</td>
                        <td>$city</td>
                        <td>$county</td>
                        <td>$grade</td>
                        <td>$gender</td></tr>";
                
            $projects=$projects."<tr><td>$title</td>
					<td>$abstract</td>
                    <td>$grade</td>
                    <td>$gradelevel</td>
                    <td>$category</td>
                    <td>$CNid</td>
					<td>$booth</td></tr>";
	
		// add the county if need be, just get the county id
		if($county=="" or $county==null ){
			$countyid=null;
		}
		else{
			$countyid=null;
			while(!($countyid)){
				// check if we already have a county of that name, find it's id
				$sql = "call COUNTYID_BY_NAME('$county')";
				$count=$con->query($sql)->fetchColumn();
				// if the county doesn't exist, create a new one for that value
				if($count>0){
					$countyid=$count;	
				} // end if
				else{
					$con->query("call NEW_COUNTY_BY_NAME('$county')");
				} // end else
			} // end while
		} // end else

		// make sure only one booth exists with the number we want
		if($booth=="" or $booth==null){
			$boothid=null;
		}
		else{
			$boothid=null;
			while(!($boothid)){
				// check if we already have a booth of that number and find it's id
				$sql = "call BOOTHID_BY_NUMBER('$booth')";
				$count=$con->query($sql)->fetchColumn();
				// if the booth doesn't exist, create a new one for that value
				if($count>0){
					$boothid=$count;	
				}
				else{
					$con->query("call NEW_BOOTH_BY_NUMBER('$booth')");
				}
			}
		}
		
		/// determine the grade id
		if($grade=="" or $grade==null){
			$gradeid=null;
		}
		else{
			$gradeid=null;
			while(!($gradeid)){
				// check if we already have a county of that name, find it's id
				$sql = "call GRADEID_BY_GRADE('$grade')";
				$count=$con->query($sql)->fetchColumn();
				// if the grade doesn't exist, create a new one for that value
				if($count>0){
					$gradeid=$count;	
				}
				else{
					$con->query("call NEW_GRADE_BY_GRADE('$grade')");
				}
			}
		}

// only add a new grade level by name if there are no grade levels containing that grade 
		// make sure only one grade level exists of that name
		if($gradelevel=="" or $gradelevel==null){
			$gradelevelid=null;
		}
		else{
			$gradelevelid=null;
			while(!($gradelevelid)){
				// check if we already have a county of that name, find it's id
				$sql = "call GRADEL_ID_BY_NAME('$gradelevel')";
				$count=$con->query($sql)->fetchColumn();
				// if the grade doesn't exist, create a new one for that value
				if($count>0){
					$gradelevelid=$count;	
				}
				else{
					$con->query("call NEW_GRADELEVEL_BY_NAME('$gradelevel')");
				}
			}
		}


		// find out if there is a category of that name yet and add if there is
			if($category=="" or $category==null){
			$categoryid=null;
		}
		else{
			$categoryid=null;
			while(!($categoryid)){
				// check if we already have a county of that name, find it's id
				$sql = "call CATEGORYID_BY_NAME('$category')";
				$count=$con->query($sql)->fetchColumn();
				// if the grade doesn't exist, create a new one for that value
				if($count>0){
					$categoryid=$count;	
				}
				else{
					$con->query("call NEW_CATEGORY_BY_NAME('$category')");
				}
			}
		}

		// add the school if one of the same name city and county doesn't alredy exist
		if($school=="" or $school==null ){
			$schoolid=null;
		}
		else{
			$schoolid=null;
			while(!($schoolid)){
				// check if we already have a school with that name, city, county
				
				$sql = "call SCHOOLID_BY_NAME_CITY_COUNTY('$school','$city','".($countyid ? $countyid : "null")."')";
				$count=$con->query($sql)->fetchColumn();
				// if the school doesn't exist, create a new one for that value
				if($count>0){
					$schoolid=$count;	
				}
				else{
					$sql = "call NEW_SCHOOL_BY_NAME_CITY_COUNTY('$school','$city','".($countyid ? $countyid : "null")."')";
					$con->query($sql);
			     }
		
	            }
	        }
	
		// make sure only one project of the number we want exists
		if($projectnumber=="" or $projectnumber==null){
			$projectid=null;
		}
		else{
			$projectid=null;
			while(!($projectid)){
				// check if we already have a project of that number, find its id
				$sql = "call PROJECT_BY_NUMBER('$projectnumber')";
				$count=$con->query($sql)->fetchColumn();
				echo $sql;
				// if the county doesn't exist, create a new one for that value
				if($count>0){
					$projectid=$count;	
				}
				else{
					$sql = "call NEW_PROJECT_NORANK('$projectnumber','$title','$abstract',".($gradelevelid ? $gradelevelid : "null").",".($categoryid ? $categoryid : "null").",".($boothid ? $boothid : "null").",".($gradeid ? $gradeid : "null").",'$CNid','$year')";
					$con->query($sql);
					echo $sql;
			}
			}
		}	

		$sql= "insert into STUDENT values (null,'$fname','$mname','$lname',".($gradeid ? $gradeid : "null").",'$gender',".($schoolid ? $schoolid : "null")."',".($projectid ? $projectid : "null").",$year)";
		echo $sql;                while(!($countyid)){
                                // check if we already have a county of that name, find it's id
                                $sql = "call COUNTYID_BY_NAME('$county')";
                                $count=$con->query($sql)->fetchColumn();
                                // if the county doesn't exist, create a new one for that value
                                if($count>0){
          
		if($con->query($sql)){
			echo "succeeded in insertion";
		}
		else
			echo "did not succeed";
	}// end if
		$i++;
	} // end while 
        
	$message="Data successfully added. See entries below:";
	$displayData = true;

	} // end try
	
	catch(Exception $e){
		$message="Failed to read from file. Incorrect format";
		$displayData = false;
	}
    // unlink($_SESSION['file']);

?>



