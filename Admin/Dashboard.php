<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';

    if ( isset($_SESSION['admin']) ) {
        // only view to an admin

        // Render view
        render_view("Dashboard");
        exit;

    }else{

        // redirect to login if not logged in as an admin
        header('Location: ../Users/Login.php');
    	exit;

    }
    
?>