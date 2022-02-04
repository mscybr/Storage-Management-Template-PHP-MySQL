<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';

    if( isset($_SESSION['id']) ){
		// logged in as a user

    	header('Location: ./Users/Dashboard.php');
    	exit;
        
    } else if( isset($_SESSION['admin']) ){
		// logged in as an admin

    	header('Location: ./Admin/Dashboard.php');
    	exit;
        
    }else{
		// not logged in

    	header('Location: ./Users/Login.php');
    	exit;

    }

?>