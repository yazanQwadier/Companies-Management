<?php
require "OperationsDB.php";
session_start();

if( count($_SESSION) > 0 ){
	header("Location:dashboard.php");
	exit();
}

$connection = connect_DB();

if(! $connection)
	echo "error in connection";
else{
	// if connection with database is good 

	if(isset( $_POST['btnSign'] )){
		$isValid = check_validate_data($_POST , $_FILES);

		if($isValid){
			$nameU = strip_tags( $_POST['nameU'] );
			$phoneU = strip_tags( $_POST['phoneU'] );
			$emailU = strip_tags( $_POST['emailU'] );
			$passU = strip_tags( $_POST['passU'] );
			$locationU = strip_tags( $_POST['locationUser'] );
			$imgU = $_FILES['imgU'];

			$user = create_new_user($connection , $nameU , $phoneU , $emailU , $passU , $imgU , $locationU);

			switch($user){
				case "error":
					echo "<div class='alert alert-danger'>There is problem.</div>"; break;

				default:
					$_SESSION["id"] = $user['id'];
					$_SESSION["username"] = $user['name'];
					$_SESSION["admin"] = $user['isAdmin'];
					header("Location: dashboard.php");
			}

		}

	}
}

// function to check validation of register data
function check_validate_data($data , $file){
	$errors = [];

	if( strlen($data['nameU']) <= 2 ){
		$errors[] = "name must be greater than 2 letters.";
	}
	if( strlen($data['phoneU']) != 10 ){
		$errors[] = "phone must be equal 10 digits.";
	}
	if( !filter_var($data['emailU'] , FILTER_VALIDATE_EMAIL) ){
		$errors[] = "invalid email entered.";
	}
	if( strlen($data['passU']) < 8 ){
		$errors[] = "password must be greater than or equal 8 digits.";
	}

	if($file['imgU']['size'] != 0 ){
		if( $file['imgU']['size'] > 500000){
			$errors[] = "file size must be less than 500000 byets.";
		}

		$typeFile = pathinfo($file['imgU']['name'] , PATHINFO_EXTENSION);
		if( !in_array($typeFile , ['jpg' , 'png' , 'jpeg']) ){
			$errors[] = "file type must be image (png , jpeg , jpg).";
		}
	}


	if( count($errors) > 0 ){
		?> <div class="col-6"> <?php
		foreach ($errors as $e) {
			echo  "<div class='alert alert-danger'>".$e."</div>";
		}
		?></div> <?php 
		return false;
	}
	else
		return true;
}

?>

<html>
<head>
	<title>CM - SignUp</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h2>SignUp</h2>
			</div>
		</div>

		<div class="row justify-content-center mt-2">
			<div class="col-6 p-5 m-1">

				<form action="signup.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nameU">Name :</label>
						<input type="text" id="nameU" name="nameU" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="phoneU">Phone :</label>
						<input type="number" id="phoneU" name="phoneU" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="emailU">Email :</label>
						<input type="email" id="emailU" name="emailU" class="form-control" required>
					</div>
					
					<div class="form-group">
						<label for="passU">Password :</label>
						<input type="password" id="passU" name="passU" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="imgU">Image :</label>
						<input type="file" id="imgU" class="form-control" name="imgU">
					</div>

					<input type="hidden" name="locationUser" id="locationUser">

					<div class="form-group text-center">
						<input type="submit" name="btnSign" value="sign up" class="btn btn-success">
					</div>
				</form>

			</div>
		</div>
	</div>

	<!-- this script to get location of user -->
	<script>
		var x = document.getElementById("locationUser");

		function getLocation() {
		  if (navigator.geolocation) 
		    navigator.geolocation.getCurrentPosition(showPosition);
		  else
		    x.innerHTML = "Geolocation is not supported by this browser.";
		}

		function showPosition(position) {
			var data = {};
			data["lat"] = position.coords.latitude;
			data["long"] = position.coords.longitude;
		  	x.value = JSON.stringify(data);
		}

		getLocation();	// calls method automate
	</script>


	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>


