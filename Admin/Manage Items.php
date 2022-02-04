<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';

    // retriving json data from front-end
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // intial page number
    $pg = 0;

    
    if ( isset($_SESSION['admin']) ) {

        if( isset( $_GET["page"] ) ){

            $pg = $_GET["page"];

        }

        if( isset( $_GET["storage_id"] ) ) {

            $Items = get_items ( $db, $_GET["storage_id"], Number_Of_Items_Per_Page, $pg * Number_Of_Items_Per_Page, true );
            $users = array();

            foreach ( $Items as $item ) {
                // filling names of data enter-er

                if( $item["Enter_User_Id"] == 0 ){

                    $users[$item["Enter_User_Id"]] = "Admin"; 

                }else{

                    $users[$item["Enter_User_Id"]] = get_user_by_id( $db, $item["Enter_User_Id"] )[0]["Name"]; 

                }
            }


            if( $data != null  ){

                if( isset( $data->delete_item ) ){
                    // handle item deletion
                    
                    echo delete_item( $db, $data->delete_item );
                    exit;

                }

                if( isset( $data->exit_item ) ){
                    // handle item exit
                    
                    echo exit_item( $db, $data->exit_item );
                    exit;

                }
    
                if( isset( $data->add_item ) ){
                    // handle item add
                    
                    echo input_items ( $db, $_GET["storage_id"], $data->add_item, $data->amount, 0 );
                    exit;
    
                }

                if( isset( $data->update_item ) ){
                    // handle item update
                    
                    echo update_item ( $db, $data->update_item, $data->name, $data->amount );
                    exit;
    
                }
    
            }


            // Render view
            render_view("Manage Items");
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