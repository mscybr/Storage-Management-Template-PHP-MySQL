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

            if( isset( $data->delete_user ) ){
                // handle user deletion
                
                echo delete_user( $db, $data->delete_user );
                exit;
            }
            
            if( isset( $data->update_old_name ) ){
                // handle user update
                
                echo update_user( $db, $data->update_old_name, $data->update_name, $data->update_password );
                exit;

            }


            if( isset( $data->add_user ) ){
                // handle user addition

                echo input_user( $db, $data->add_user, $data->password  );
                exit;

            }


            if( isset( $data->add_privilege ) ){
                // handle privilege addition / update

                echo input_privilege( $db, $data->add_privilege, $data->storage_id, $data->enter, $data->exit, $data->edit, $data->delete  );
                exit;

            }

        }

        if( isset( $_GET["page"] ) ){

            $pg_number = $_GET["page"];

        }


        $users = get_users( $db, Number_Of_Users_Per_Page, $pg_number * Number_Of_Users_Per_Page, false );

        $privilages = array();

        // filling privileges of each user in "$privilages" array indexed with the user_id
        foreach ($users as $user ) {

            // adding intial array
            $privilages[ $user['User_Id'] ] = array();

        }
        foreach ($users as $user ) {

            $priv = get_user_privileges( $db, $user["User_Id"] );
            
            if( sizeof( $priv ) > 0 ){
    
                $privilages[ $user['User_Id'] ][ sizeof( $privilages[ $user['User_Id'] ] ) ] = $priv;
    
            }   

        }



        // companies data 
        $companies = get_companies ( $db, 100, $pg_number * 100, false );

        $storages = array();

        foreach ($companies as $company ) {

            $stor = get_storages( $db, $company["Company_Id"], 100, $pg_number * 100, false );
            
            if( sizeof( $stor ) > 0 ){

                $storages[ $company['Company_Name'] ] = $stor;

            }

        }

        $storages = json_encode($storages);

        // Render view
        render_view("Manage Users");
        exit;

    }else{

        header('Location: ../Users/Login.php');
    	exit;

    }

?>