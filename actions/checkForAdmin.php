<?
// This file checks to see if the admin is logged in. If not, we log out.
session_start();
if(!(isset($_SESSION['type']) && $_SESSION['type']=='admin'))
	header("Location: /n342-final/actions/logout.php");
?>
