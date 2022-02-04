<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';


    if ( isset($_SESSION['id']) ) {

        $companies = get_user_dashboard( $db );

        // Render view
        render_view("Dashboard");
        exit;
        

    } else if( isset($_SESSION['admin']) ){

    	header('Location: ../Admin/Dashboard.php');
    	exit;
        
    }else{

    	header('Location: ./Login.php');
    	exit;

    }

?>