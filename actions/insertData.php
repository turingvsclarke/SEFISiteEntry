<!--
FILE NAME:insertdata.php
PURPOSE:Reads file of csv type. Makes sure the file is right and shows data if it is.
MODIFICATION HISTORY:
11/04/20 Added file header
-->


<?php
 
require_once "readfile.php";
 
    // check for admin
	require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";
    
    // this will store the students part of our table
    $students = "";

    // this will store the projects part of our table
    $projects = "";    
	
    print_r($data);
	// while you still have text to read, read the file
	for($i=0;$i<count($data);$i++){
        try{
			$cont=$data[$i];		
			$fname=$cont[0];
			$mname=$cont[1];
			$lname=$cont[2];
            echo "Last name:$lname";
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
			$year=date("Y");	
   	
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
				// If the query returns a county, that's our county.
				if($count>0){
					$countyid=$count;
				} // end if
                // if the county doesn't exist, create a new one for that value
				else{
                    $sql = "call NEW_COUNTY_BY_NAME('$county')";
           			$con->query($sql);
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
				// check if we already have a grade of that value, find it's id
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
				// check if we already have a grade level of that name, find it's id
				$sql = "call GRADEL_ID_BY_NAME('$gradelevel')";
				$count=$con->query($sql)->fetchColumn();
				// if the grade level doesn't exist, create a new one for that value
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
				$sql = "call SCHOOLID_BY_NAME_CITY_COUNTY('$school',".($city ? "'".$city."'" : "null").",".($countyid ? $countyid : "null").")";
				$count=$con->query($sql)->fetchColumn();
                
				// if the school of that name, county, city exists that's our id
				if($count>0){
					$schoolid=$count;
				}
                // Create a new school otherwise
				else{
					$sql = "call NEW_SCHOOL_BY_NAME_CITY_COUNTY('$school',".($city ? "'".$city."'" : "null").",".($countyid ? $countyid : "null").")";
					$con->query($sql);
			     }
		
                } // end while
	        } //end else
		// make sure only one project of the number we want exists
		if($projectnumber==="" or $projectnumber==null or $title === "" or $title == null){
            if(!($title==="" or $title==null)){
                echo "<script>alert('Project number not provided for project \"$title\". View existing projects and upload the file again using an available project number');</script>";
            } // end if
			$projectid=null;
        } // end if
		else{

			$projectid=null;
			while(!($projectid)){
				// check if we already have a project of that number, find its id
				$sql = "call PROJECT_BY_NUMBER($projectnumber)";
				$count=$con->query($sql)->fetchColumn();
                
				// if we have a project with that number, that's the id for this project.
				if($count>0){
					$projectid=$count;	
                    $projectTitle = $con->query("select Title from PROJECT where PROJECT.ProjectID=$projectid")->fetchColumn();
                    echo "<script>alert('A project numbered $projectnumber already exists, called \"$projectTitle\". If \"$title\" is a different project, retry with an available number.')</script>";
				}
				else{
					$sql = "call NEW_PROJECT_NORANK($projectnumber,'$title','$abstract',".($gradelevelid ? $gradelevelid : "null").",".($categoryid ? $categoryid : "null").",".($boothid ? $boothid : "null").",".($gradeid ? $gradeid : "null").",".($CNid ? "'".$CNid."'" : "null").",$year)";
					$con->query($sql);
			}
		}
		}	
       
	// Store the student if first and last are given        
        if(!($fname==="" or $fname==null or $lname==="" or $lname==null)){    
            // look for a student with that first, middle, and last name 
            
            // Let them know there are two students with the same first and last name and flag if 
            
            $tableM = $con->query("select MiddleName from STUDENT where STUDENT.FirstName='$fname' and STUDENT.LastName='$lname'")->fetchColumn(); 
            $count = $con->query("select StudentID from STUDENT where STUDENT.FirstName='$fname' and STUDENT.LastName='$lname'")->fetchColumn();
            // Insert into student only if there is no first name, middle name, last name match
            if(!($count>0 and $tableM===$mname)){
               // send an alert if you got a first name, last name match but no middle name was provided 
               if(($mname==="" or $mname==null)&& $count>0){
                       echo "<script>alert('\"$lname, $fname\" already exists in the database. Consider adding a middle name as an identifier')</script>";
               
               }
               
                
		      $sql= "insert into `STUDENT`(`FirstName`, `MiddleName`, `LastName`, `GradeID`, `Gender`, `SchoolID`, `ProjectID`, `Year`) values ('$fname',".($mname ? "'".$mname."'" : "null").",'$lname',".($gradeid ? $gradeid : "null").",'$gender',".($schoolid ? $schoolid : "null").",".($projectid ? $projectid : "null").",$year)";
                if($con->query($sql)){
                    echo "Succeeded in insertion";
                }
            }
        }
        } // end try
		catch(Exception $e){
            $message = "Data entry failed";
            Header("Location: /n342-final/admin/uploadFile.php");
        } 

	} // end for

    Header("Location: /n342-final/admin/list.php");

?>
