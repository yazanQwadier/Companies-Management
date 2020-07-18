<?php
session_start();

if( count($_SESSION) > 0 ){
	header("Location:dashboard.php");
	exit();
}


?>

<html>
<head>
	<title>CM - Main</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}
		.layout-login{
			background-color: #b93434;
		}

		.layout-sign{
			background-color: #64993ff2;
		}

		a{
			color: white;
			text-decoration: none;
			font-size: 18px;
		}
		a:hover{
			color: white;
			text-decoration: none;
			font-size: 20px;
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h2>Companies Management</h2>
			</div>
		</div>

		<div class="row justify-content-center mt-5">
			<div class="col-3 text-center p-5 m-1 layout-login">
				<a href="login.php">Login</a>
			</div>

			<div class="col-3 text-center p-5 m-1 layout-sign">
				<a href="signup.php">Sign up</a>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>