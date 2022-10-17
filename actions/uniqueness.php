<!--
FILE NAME:existence.php
PURPOSE:Create a function that takes in a sql row and table and then returns true or false if a too similar row exists in the table
MODIFICATION HISTORY:
11/05/20 Original build
-->
require_once "$_SERVER['DOCUMENT_ROOT']".'/n342-final/actions/dbconnect.php';
function exists($row,$tableName){

	// check the 
	switch ($tableName){
	case "ADMIN":
		if(  find an admin with that username
	case "BOOTH_NUMBER":
		if(// find a booth with that number
	break;
	case "CATEGORY":
	
	break;
	case "COUNTY":

	break;
	case "GRADE":

	break;
	case "JUDGE":
	
	break;
	case "JUDGE_CATEGORY_PREF":

	break;
	case "PROJECT":
	
	break;
	case "PROJECT_GRADE_LEVEL":
	
	break;
	case "SCHEDULE":

	break;
	case "SCHOOL":

	break;
	case "SESSION":
 
	break;
	
	case "STUDENT":
		
		$exists= 
	break;
	
	default:
		$exists=false;
	}

	return $exists;

} // end exists
