<?php

require_once '../config/database.php';
require_once '../config/function.php';

$action = $_GET['action'];	
	
switch ($action) {
    
	case 'login' :
		login();
		break;

	case 'register' :
		register();
		break;
		
	case 'upload':
		upload();
		break;
	
	case 'changepassword' :
		changepassword();
		break;
		
	case 'logout' :
		logout();
		break;
	
	default :
}


function login()
{
	// if we found an error save the error message in this variable
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$query = mysql_query("select * from user where username = '".$username."' and password = '".$password."'");
	
	if (mysql_num_rows($query) != 0)
	{

		$_SESSION['user_session'] = $username;

			header('Location: ../home/');
	
	}
	else
	{
		header('Location: index.php?error=User not found in the Database');
	}
	
}

function register()
{
	$username = $_POST['username'];
	$full_name = $_POST['full_name'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	
		if (user_exist($username)!=true){
			if ($password == $password2){
				mysql_query("insert into user set username='$username',
												full_name='$full_name',
												password='$password'");

				header('Location: ../home/');
			}else{
				header('Location: index.php?view=register&error=Password not matched');
			}

		}else{
			header('Location: index.php?view=register&error=Username already exists.');
		}
}

function logout()

{
	if (isset($_SESSION['user_session'])) {
		unset($_SESSION['user_session']);
	}
	header('Location: index.php');
	exit;
}


?>