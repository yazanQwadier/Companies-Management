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

function check_exists_user($c , $em_ph , $p){
	$sql = "SELECT * FROM users WHERE email='$em_ph' OR phone='$em_ph'";

	$result = $c->query($sql);

	if( $result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			if( password_verify($p , $row['password']) ){
				if($row['isActive'] == true)
					return $row;
				else
					return "unactive";
			}
		}
	}
	else
		return false;
}

function create_new_user($c , $name , $phone , $email , $pass , $img , $loc){
	$sql = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
	$result = $c->query($sql);

	if( $result->num_rows > 0)
		return $result->fetch_assoc();
	else{
		$pathImg = "";

 		if( $img['size'] != 0 ){
 			$targetFile = "files/img".rand(1000 , 9999).".".pathinfo($img['name'] , PATHINFO_EXTENSION);

 			if( move_uploaded_file( $img['tmp_name'] , $targetFile) )
 				$pathImg = "../".$targetFile;
 			else
 				$pathImg = "http://localhost/companies-management/files/imgs/avatar.png";
 		}
	 	else
			$pathImg = "http://localhost/companies-management/files/imgs/avatar.png";
	 		
		$newPass = password_hash($pass, PASSWORD_DEFAULT);
 		$newSql = "INSERT INTO users (name,phone,email,password,img,location) 
			       VALUES ('$name','$phone','$email','$newPass','$pathImg','$loc')";
	 		
		if( $c->query($newSql) )
			return $c->query("SELECT * FROM users WHERE id='$c->insert_id'")->fetch_assoc();
		else
			return "error";
	}
}

function getAllBranches($c , $id){
	$sql = "SELECT * FROM branches WHERE user_id='$id'";
	$result = $c->query($sql);
	return $result;
}

function saveNewBranch($c , $id , $nameB , $phoneB){
	$sql = "SELECT * FROM branches WHERE name='$nameB' AND user_id='$id'";
	$result = $c->query($sql);
	
	if( $result->num_rows > 0){
		return false;
	}
	else{
		$newSql = "INSERT INTO branches(user_id , name , phone)
				   VALUES('$id' , '$nameB' , '$phoneB')";
		if($c->query($newSql)){
			return true;
		}
	}
}

function getAllEmployees($c , $id){
	$sql = "SELECT * FROM employees WHERE user_id='$id'";
	$result = $c->query($sql);
	return $result;
}

function saveNewEmployee($c , $id , $nameE , $phoneE , $branchE){
	$sql = "SELECT * FROM employees WHERE name='$nameE' AND user_id='$id'";
	$result = $c->query($sql);
	
	if( $result->num_rows > 0){
		return false;
	}
	else{
		$newSql = "INSERT INTO employees(branch_id , user_id , name , phone)
				   VALUES('$branchE' , '$id' ,'$nameE' ,'$phoneE')";
		if($c->query($newSql)){
			return true;
		}
	}
}

function getSpecificBranch($c , $id){
	$sql = "SELECT * FROM branches WHERE id='$id'";
	$result = $c->query($sql);
	return $result->fetch_assoc();
}


function getCountOfBranch($c , $id){
	$sql = "SELECT * FROM employees WHERE branch_id='$id'";
	$result = $c->query($sql);
	return $result->num_rows;
}

?>