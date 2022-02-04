<?php
    /*
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!    this script is removed temporarly     !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    // echo "enter : \n 1.item name \n 2.item amount ";
    if ( isset($_SESSION['id']) ) {
            header('Location: ./Dashboard.php');
            exit;

        $pg = 0;

        if( isset( $_GET["page"] ) ){

            $pg = $_GET["page"];

        }

        if( isset( $_GET["storage_id"] ) ) {

            $Items = get_archive_items ( $db, $_GET["storage_id"], 100, $pg * 100, true );
            $users = array();

            foreach ( $Items as $item ) {

                if( $item["Enter_User_Id"] == 0 ){
                    $users[$item["Exit_User_Id"]] = "Admin"; 

                }else{

                    $users[$item["Enter_User_Id"]] = get_user_by_id( $db, $item["Enter_User_Id"] )[0]["Name"]; 

                }
            }

            foreach ( $Items as $item ) {

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
                    
                    // handle user deletion
                    echo exit_item( $db, $data->exit_item );
                    exit;
                }
    
                if( isset( $data->add_item ) ){
                    
                    echo input_items ( $db, $_GET["storage_id"], $data->add_item, $data->amount, 0 );
                    exit;
    
                }

                if( isset( $data->update_item ) ){
                    
                    echo update_item ( $db, $data->update_item, $data->name, $data->amount );
                    exit;
    
                }
    
            }

            $privs = get_user_privileges_of_storage( $db, $_SESSION['id'], $_GET["storage_id"] );

            // Render view
            render_view("Items Archive");
            exit;

       } else {

            header('Location: ./Dashboard.php');
            exit;

       }

       

    }else{

        header('Location: ../Users/Login.php');
    	exit;

    } */
?>