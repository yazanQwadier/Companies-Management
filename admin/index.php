<?php
require "adminOperationsDB.php";
session_start();

// check if there users in session
if( count($_SESSION) == 0 ){
	header("Location: ../login.php");
	exit();
}


$connection = connect_DB();
if($connection){

	$users = getAllUsers( $connection );

	$user = getInfoUser( $connection , $_SESSION['id'] );

	
	if( isset($_POST['btnActiveUser']) ){
		$user_id = $_POST['userId'];
		$isActive = $_POST['isActiveUser'];

		changeStateUser($connection , $user_id , $isActive);
	}
}

// when click on (logout) button
if( isset($_POST['btnlogout']) ){
	session_unset();
	header("Location: ../login.php");
}

?>


<html>
<head>
	<title>CM - Admin</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}

		.table-users{
			border:1px solid #ccc;			
		}

		.table-users td ,
		.table-users th {
			padding:7px;
			text-align: center;
			border-top: 1px solid #ccc;	
		}

		.table-users th {
			border-right: 1px solid #ccc;	
		}

		.table-users > tbody tr:hover {
			background-color: #cec;	
		}

		.active{
			color: green;
		}
		.unActive{
			color: red;
		}

		.act-btn{
			background-color: green;
		}
		.unAct-btn{
			background-color: red;
		}

		.imgUser{
			border:1px solid #ccc;
			border-radius: 50px;
			width: 100px;
			height: 100px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h2>Admin - <?php echo $user['name']; ?> </h2>
				<img src="<?php echo $user['img']; ?>" width="90">
			</div>
		</div>

		<div class="row">
			<div class="col text-right">
				<form action="" method="post">
					<input type="submit" name="btnlogout" value="logout" class="btn btn-danger">
				</form>
				<hr>
			</div>
		</div>

		<div class="row justify-content-center mt-3">
			<div class="col-12 col-lg-8">

				<table class="table-users">
				<thead>
					<tr>
						<th>image</th>
						<th>name</th>
						<th>phone</th>
						<th>email</th>
						<th>branches</th>
						<th>employees</th>
						<th>state</th>
					</tr>
				</thead>

				<tbody>
					<?php
					while ($user = $users->fetch_assoc()) {
						$state = ($user['isActive'])? "active":"unActive";
						$notState = (!$user['isActive'])? 'active':'unActive';
						$classState = (!$user['isActive'])? 'btn-success':'btn-danger';
					?>
						<tr>
							<td>
								<img src="<?php echo $user['img']; ?>" class="imgUser" >
							</td>
							<td><?php echo $user['name']; ?></td>
							<td><?php echo $user['phone']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td>
								<a href="userBranches.php?u=<?php echo $user['id']; ?>">
									<?php echo getCountBranchesOfUser($connection,$user['id']); ?>
								</a>
							</td>
							<td>
								<a href="userEmployees.php?u=<?php echo $user['id']; ?>">
									<?php echo getCountEmployeesOfUser($connection,$user['id']); ?>
								</a>
							</td>

							<td>
								<font class="<?php echo $state; ?>">
									<?php echo $state; ?>
								</font>

								<form action="" method="post">
									<input type="submit" name="btnActiveUser" value="<?php echo $notState; ?>" class="<?php echo $classState; ?>" >
									
									<input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
									<input type="hidden" name="isActiveUser" value="<?php echo $user['isActive']; ?>">
								</form>
							</td>
					  	</tr>
						<?php
					}
					?>
				</tbody>
				</table>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>