<?php

if (isset($_POST['submit'])) {

	include_once 'dbh-inc.php';
	

	$fornavn = mysqli_real_escape_string($conn, $_POST['fornavn']);
	$etternavn = mysqli_real_escape_string($conn, $_POST['etternavn']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$brukernavn = mysqli_real_escape_string($conn, $_POST['brukernavn']);
	$passord = mysqli_real_escape_string($conn, $_POST['passord']);
	// Error handlers
	// Check for empty fields
	if (empty($fornavn) || empty($etternavn) || empty($email) || empty($brukernavn) || 
		empty($passord)) {
		header("Location: ../signup.php?signup=tom");
		exit();
	} else {
		//CHECK if input characters are valid
		if (!preg_match("/^[a-zA-Z]*$/", $fornavn) || !preg_match("/^[a-zA-Z]*$/", $etternavn)) {
			header("Location: ../signup.php?signup=Invalid");
			exit();
		} else {
			//check if email is valid
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../signup.php?signup=Email");
			exit();
		
		} else {
			$sql = "SELECT * FROM brukere WHERE user_brukernavn = '$brukernavn'";
			$result = mysqli_query($conn, $sql);
			$resultCheck = mysqli_num_rows($result);
		
		if ($resultCheck > 0) {
			header("Location: ../signup.php?signup=Usertaken");
			exit();
		
		}else {
			//Hasing the password
			
			// Insert the user into the database
			$sql = "INSERT INTO brukere (user_fornavn, user_etternavn, user_email, user_brukernavn, user_passord) VALUES ('$fornavn', '$etternavn', '$email', '$brukernavn', '$passord');";
			mysqli_query($conn, $sql);
			header("Location: ../signup.php?signup=Success!");
			exit();
}}}}}
 else{
	header("Location: ../signup.php");
	exit();
}



?>