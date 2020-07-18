<?php
require "adminOperationsDB.php";
session_start();

// check if there users in session
if( count($_SESSION) == 0 ){
	header("Location: ../login.php");
	exit();
}


$user_id = $_GET['u'];

$connection = connect_DB();
if($connection){

	$branches = getBranchesOfUser( $connection , $user_id );


	$user = getInfoUser($connection , $user_id);
	
}

?>


<html>
<head>
	<title>CM - Branches</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">

	<style type="text/css">
		body{
			background-color: #eeeeeebd;
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
				<h4>User : <?php echo $user['name']; ?></h4>
			</div>

		</div><hr>

		<div class="row justify-content-center mt-3">
			<div class="col-8 col-lg-4 m-1">

				<table class="table-branches">
					<thead>
						<tr>
							<th>id</th>
							<th>name</th>
							<th>phone</th>
							<th>location</th>
						</tr>
					</thead>

					<tbody>
						<?php
						if($branches->num_rows > 0){
							while ($branch = $branches->fetch_assoc()) {
							?>
								<tr>
									<td><?php echo $branch['id']; ?></td>
									<td><?php echo $branch['name']; ?></td>
									<td><?php echo $branch['phone']; ?></td>
									<td><?php echo $branch['location']; ?></td>
							  	</tr>
							<?php
							}
						}
						else
							echo "no branches ...";
						?>

					</tbody>
				</table>

			</div>
		</div>
	</div>

	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>