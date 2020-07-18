<?php

// connect with database
function connect_DB(){
	$serverName = "localhost";
	$username = "root";
	$password = "";
	$DbName = "CMDB";	// CMDB => Companies Management DataBase

	$connection = new mysqli($serverName , $username , $password , $DbName);

	if($connection->connect_error){
		return false;
	}
	else{
		return $connection;
	}
}


// get all users are not admin
function getAllUsers($c){
	$sql = "SELECT * FROM users WHERE isAdmin='0'";
	$result = $c->query($sql);
	return $result;
}

function getInfoUser($c , $id){
	$sql = "SELECT * FROM users WHERE id='$id'";
	$result = $c->query($sql);
	return $result->fetch_assoc();
}

function getCountBranchesOfUser($c , $user_id){
	$sql = "SELECT * FROM branches WHERE user_id='$user_id'";
	$result = $c->query($sql);
	return $result->num_rows;
}


function getCountEmployeesOfUser($c , $user_id){
	$sql = "SELECT * FROM employees WHERE user_id='$user_id'";
	$result = $c->query($sql);
	return $result->num_rows;
}


function getBranchesOfUser($c , $user_id){
	$sql = "SELECT * FROM branches WHERE user_id='$user_id'";
	$result = $c->query($sql);
	return $result;
}

function getEmployeesOfUser($c , $user_id){
	$sql = "SELECT * FROM employees WHERE user_id='$user_id'";
	$result = $c->query($sql);
	return $result;
}

function getBranchInfo($c , $id){
	$sql = "SELECT * FROM branches WHERE id='$id'";
	$result = $c->query($sql);
	return $result->fetch_assoc();
}


function changeStateUser($c , $user_id , $current_state){
	$new_state = !$current_state;

	$sql = "UPDATE users SET isActive='$new_state' WHERE id='$user_id'";
	if($c->query($sql)){
		return true;
	}
}


?>