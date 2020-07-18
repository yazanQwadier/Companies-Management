<?php
require "OperationsDB.php";
session_start();

if( count($_SESSION) == 0 ){
	header("Location:login.php");
	exit();
}

$connection = connect_DB();

if(! $connection)
	echo "error in connection";
else{
	// if connection with database is good 

	// get all branches of user.
	$branches = getAllBranches($connection , $_SESSION['id']);

	if( isset($_POST['btnAddBranch']) ){
		$nameB = strip_tags( $_POST['nameB'] );
		$phoneB = strip_tags( $_POST['phoneB'] );

		$isSaved=saveNewBranch($connection , $_SESSION['id'] , $nameB , $phoneB);
		if($isSaved){
			echo "<div class='alert alert-success'>Added successfully</div>";
		}
		else{
			echo "<div class='alert alert-danger'>The Branch is found !</div>";
		}
	}
}

?>


<html>
<head>
	<title>CM - Branches</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}

		.layout-add-branch{
			border:1px dotted #ccc;
			padding: 10px;
		}

		.table-branches{
			border:1px solid #ccc;			
		}

		.table-branches td ,
		.table-branches th {
			padding:8px;
			text-align: center;
			border-top: 1px solid #ccc;	
		}

		.table-branches th {
			border-right: 1px solid #ccc;	
		}

		.table-branches > tbody tr:hover {
			background-color: #cec;	
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h2>Branches</h2>
			</div>
		</div>

		<div class="row layout-add-branch">
			<div class="col-12">

				<form action="branches.php" method="post">
					<div class="row justify-content-center">
						<div class="col-3">
							<input type="text" name="nameB" class="form-control" placeholder="name" required>
						</div>

						<div class="col-3">
							<input type="text" name="phoneB" class="form-control" placeholder="phone" required>
						</div>

						<div class="col-1">
							<input type="submit" name="btnAddBranch" class="btn btn-success" value="add">
						</div>
					</div>
				</form>

			</div>
		</div>

		<div class="row justify-content-center mt-3">
			<div class="col-8 col-lg-5 m-1">

				<table class="table-branches">
					<thead>
						<tr>
							<th>id</th>
							<th>name</th>
							<th>phone</th>
							<th>location</th>
							<th>employees</th>
						</tr>
					</thead>

					<tbody>
						<?php
						while ($row = $branches->fetch_assoc()) {
							?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['phone']; ?></td>
								<td><?php echo $row['location']; ?></td>
								<td><?php echo getCountOfBranch($connection ,$row['id']); ?></td>
						  	</tr>
							<?php
						}
						?>
					</tbody>
				</table>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
