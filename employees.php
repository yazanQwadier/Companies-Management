<?php
require "OperationsDB.php";
session_start();

if( count($_SESSION) == 0 ){
	header("Location:login.php");
	exit();
}

$connection = connect_DB();

if(! $connection)
	echo "error at connection";
else{
	// if connection with database is good 

	// get all branches of user.
	$employees = getAllEmployees($connection , $_SESSION['id']);

	// when click on btn for add new employee
	if( isset($_POST['btnAddEmployee']) ){
		$nameE = strip_tags( $_POST['nameE'] );
		$phoneE = strip_tags( $_POST['phoneE'] );
		$branchE = $_POST['branchE'];
		
		$isSaved=saveNewEmployee($connection ,$_SESSION['id'] ,$nameE ,$phoneE , $branchE);
		if($isSaved){
			echo "<div class='alert alert-success'>Added successfully</div>";
		}
		else{
			echo "<div class='alert alert-danger'>The Employee is found!</div>";
		}
	}

	// get all branches to put them in select tag.
	$branches = getAllBranches($connection , $_SESSION['id']);
}

?>


<html>
<head>
	<title>CM - Employees</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
		}

		.layout-add-employee{
			border:1px dotted #ccc;
			padding: 10px;
		}

		.table-employees{
			border:1px solid #ccc;			
		}

		.table-employees td ,
		.table-employees th {
			padding:8px;
			text-align: center;
			border-top: 1px solid #ccc;	
		}

		.table-employees th {
			border-right: 1px solid #ccc;	
		}

		.table-employees > tbody tr:hover {
			background-color: #cec;	
		}
	</style>
</head>
<body>

	<div class="container">
		<div class="row mt-3">
			<div class="col-12 text-center">
				<h2>Employees</h2>
			</div>
		</div>

		<div class="row layout-add-employee">
			<div class="col-12">
				<form action="employees.php" method="post">
					<div class="row justify-content-center">
					<div class="col-3">
						<input type="text" name="nameE" class="form-control" placeholder="name" required>
					</div>
					
					<div class="col-3">
						<input type="text" name="phoneE" class="form-control"  placeholder="phone" required>
					</div>

					<div class="col-2">
						<select name="branchE">
							<?php
							while ($row = $branches->fetch_assoc()) {
								?> <option value="<?php echo $row['id']; ?>">
									<?php echo $row['name']; ?>
								</option> <?php
							}
							?>
						</select>
					</div>

					<div class="col-1">
						<input type="submit" name="btnAddEmployee" value="add" class="btn btn-success">
					</div>
				</div>
				</form>
			</div>
		</div>


		<div class="row justify-content-center mt-3">
			<div class="col-7 col-lg-4 p-2 m-1">

				<table class="table-employees">
					<thead>
						<tr>
							<th>id</th>
							<th>name</th>
							<th>phone</th>
							<th>branch</th>
						</tr>
					</thead>

					<tbody>
						<?php
						while ($row = $employees->fetch_assoc()) {
							?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['phone']; ?></td>
								<td><?php echo getSpecificBranch($connection , $row['branch_id'])['name']; ?></td>
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