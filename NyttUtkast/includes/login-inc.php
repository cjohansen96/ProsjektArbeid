<?php

session_start();

if (isset($_POST['submit'])) {
	
	include 'dbh-inc.php';
	
	$brukernavn = mysqli_real_escape_string($conn, $_POST['brukernavn']);
	$passord = mysqli_real_escape_string($conn, $_POST['passord']);
	
	//Error handlers
	//Check if inputs are empty
	if (empty($brukernavn) || empty($passord)) {
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM brukere WHERE user_brukernavn='$brukernavn'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error1");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//De-hashing the password
				
				if ($passord == false) {
					header("Location: ../index.php?login=feilpassord");
					exit();
				} elseif ($passord == true) {
					//Log in the user here
					$_SESSION['u_fornavn'] = $row['user_fornavn'];
					$_SESSION['u_etternavn'] = $row['user_etternavn'];
					$_SESSION['u_email'] = $row['user_email'];
					$_SESSION['u_brukernavn'] = $row['user_brukernavn'];
					header("Location: ../index.php?login=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?login=error3");
	exit();
}