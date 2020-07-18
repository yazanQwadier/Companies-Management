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

	if(isset( $_POST['btnLogin'] )){
		$Em_Ph = strip_tags( $_POST['Em_Ph_U'] );
		$passU = strip_tags( $_POST['passU'] );

		// check if entered data is email or phone
		if( filter_var($Em_Ph , FILTER_VALIDATE_EMAIL) || filter_var($Em_Ph , FILTER_VALIDATE_INT) ){

			$user = check_exists_user($connection , $Em_Ph , $passU);
			if($user == "unactive")
				echo "this account unactive !";
			elseif( $user ){
				$_SESSION["id"] = $user['id'];
				$_SESSION["username"] = $user['name'];
				$_SESSION["admin"] = $user['isAdmin'];

				// check if user is admin or not.
				($user['isAdmin']) ?  header("Location: admin/") :
									  header("Location: dashboard.php");
			}
			else
				echo "invalid (email or phone) or password data !";
		}
		else
			echo "invalid email or phone data !";

	}

}

?>

<html>
<head>
	<title>CM - Login</title>
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
				<h2>Login</h2>
			</div>
		</div>

		<div class="row justify-content-center mt-5">
			<div class="col-6 p-5 m-1">

				<form action="login.php" method="post">
					<div class="form-group">
						<label for="Em_Ph_U">Email / Phone :</label>
						<input type="text" id="Em_Ph_U" name="Em_Ph_U" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="passU">Password :</label>
						<input type="password" id="passU" name="passU" class="form-control" required>
					</div>

					<div  class="form-group text-center">
						<input type="submit" name="btnLogin" value="login" class="btn btn-success">
					</div>
				</form>
				<a href="signup.php">create new account</a>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>