<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';
    
    // retriving json data
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    if ( isset($_SESSION['admin']) ) {
        // only accessible to an admin

        $pg = 0;

        if( isset( $_GET["page"] ) ){
            // page number ( 0 is the intial )

            $pg = $_GET["page"];

        }

        if( isset( $_GET["storage_id"] ) ) {
            // storage_id of he archive

            // retriving items of archive at the specified page number
            $Items = get_archive_items ( $db, $_GET["storage_id"], Number_Of_Archive_Items_Per_Page, $pg * Number_Of_Archive_Items_Per_Page, true );
            $users = array();

            foreach ( $Items as $item ) {
                // filling the enter user name data

                if( $item["Enter_User_Id"] == 0 ){

                    $users[$item["Exit_User_Id"]] = "Admin"; 

                }else{

                    $users[$item["Enter_User_Id"]] = get_user_by_id( $db, $item["Enter_User_Id"] )[0]["Name"]; 

                }
            }

            foreach ( $Items as $item ) {
                // filling the exit user name data

                if( $item["Exit_User_Id"] == 0 ){

                    $users[$item["Exit_User_Id"]] = "Admin"; 

                }else{

                    $users[$item["Exit_User_Id"]] = get_user_by_id( $db, $item["Exit_User_Id"] )[0]["Name"]; 

                }
            }


            if( $data != null  ){

                if( isset( $data->delete_item ) ){
                    // handle user deletion

                    echo delete_item( $db, $data->delete_item );
                    exit;

                }

                if( isset( $data->exit_item ) ){
                    // handle exit item

                    echo exit_item( $db, $data->exit_item );
                    exit;
                    
                }
    
                if( isset( $data->add_item ) ){
                    // handle adding item
                    
                    echo input_items ( $db, $_GET["storage_id"], $data->add_item, $data->amount, 0 );
                    exit;
    
                }

                if( isset( $data->update_item ) ){
                    // handle updating item
                    
                    echo update_item ( $db, $data->update_item, $data->name, $data->amount );
                    exit;
    
                }
    
            }

            // Render view
            render_view("Items Archive");
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