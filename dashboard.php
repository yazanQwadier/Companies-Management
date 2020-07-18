<?php
session_start();

if( count($_SESSION) == 0 ){
	header("Location:login.php");
	exit();
}


if( isset($_POST['btnlogout']) ){
	session_unset();
	header("Location:login.php");
}

?>

<html>
<head>
	<title>CM - Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}

		.layout-employee{
			background-color: #b55656ed;
			box-shadow: 1px 1px 12px #9f9f9f;
		}

		.layout-branch{
			background-color: #2a2962e3;
			box-shadow: 1px 1px 12px #9f9f9f;
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
				<h2>Dashboard</h2>
			</div>
			<hr>
			<div class="col-12 text-right">
				<form action="dashboard.php" method="post">
					<input type="submit" name="btnlogout" value="logout" class="btn btn-danger">
				</form><hr>
			</div>
		</div>

		<div class="row justify-content-center mt-5">

				<div class="col-3 text-center p-5 m-1 layout-employee">
					<a href="employees.php">Employee</a>
				</div>

				<div class="col-3 text-center p-5 m-1 layout-branch">
					<a href="branches.php">Branch</a>
				</div>
		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>