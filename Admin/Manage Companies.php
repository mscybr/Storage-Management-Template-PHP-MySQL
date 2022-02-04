<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';

    // get json data for handling request
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // intial page number
    $pg_number = 0;

    if ( isset($_SESSION['admin']) ) {

        // handling admin requests
    
        if( $data != null  ){

            if( isset( $data->delete_company ) ){
                // handle company deletion
                
                echo delete_company( $db, $data->delete_company );
                exit;

            }
            
            if( isset( $data->update_old_name ) ){
                // update company data

                echo update_company ( $db, $data->update_old_name, $data->update_name, $data->update_thumbnail );
                exit;

            }

            if( isset( $data->add_company ) ){
                // handle company creation

                echo input_company ( $db, $data->add_company, $data->company_thumbnail );
                exit;

            }

        }


        if( isset( $_GET["page"] ) ){

            $pg_number = $_GET["page"];

        }

        // sending "$companies" to the view
        $companies = get_companies ( $db, 100, $pg_number * 100, false );
        

        // Render view
        render_view("Manage Companies");
        exit;


    }else{

        header('Location: ../Users/Login.php');
    	exit;

    }
?>