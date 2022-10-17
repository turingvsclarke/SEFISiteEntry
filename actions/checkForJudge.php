<?php
// this file checks for the judge and logouts the session out if they aren't there
session_start();
if(!(isset($_SESSION['type']) && $_SESSION['type']=='judge'))
	header("Location: /n342-final/actions/logout.php");


?>
