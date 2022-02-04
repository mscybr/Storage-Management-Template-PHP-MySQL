<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';

    // get json data for handling request
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    
    // intial page number
    $pg = 0;

    if ( isset($_SESSION['admin']) ) {

        if( isset( $_GET["page"] ) ){

            $pg = $_GET["page"];

        }

       if( isset( $_GET["company_id"] ) ){

            // sending storages data to the view
            $Storages = get_storages( $db, $_GET["company_id"], Number_Of_Storages_Per_Page, $pg * Number_Of_Storages_Per_Page, true );


            if( $data != null  ){

                if( isset( $data->delete_storage ) ){
                    // handle storage deletion
                    
                    echo delete_storage( $db, $data->delete_storage );
                    exit;
                }
    
                if( isset( $data->add_storage ) ){
                    // handle storage addition
                    
                    echo input_storage ( $db, $_GET["company_id"] );
                    exit;
    
                }
    
            }


            // Render view
            render_view("Manage Storages");
            exit;

       } else {

            header('Location: ./Manage Companies.php');
            exit;

       }

    }else{

        header('Location: ../Users/Login.php');
    	exit;

    }
?>