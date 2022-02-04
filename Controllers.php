<?php


function Unautherized_Request(){

    header( "HTTP/1.0 403 Forbidden" );
    exit;

}


function current_time(){
    // returns current time according the timezone specified in the config file

    return date("Y-m-d H:i:s");

}


function get_data_with_query( $query, $pdo_obj, $error_msg, $error_code, $user = false ){
    // returns data retrieved from the database using an sql query

    if ( isset($_SESSION['admin']) || ( isset($_SESSION['id']) && $user == true )) {
        // only if the user is logged in can he retrive data from the database
        // also there are some data that will not be accessed by the user( the data with the "$user" variable = false are only accessible to the admin  )
        
        try {

            $qr = $pdo_obj->query($query);
            
            return $qr->fetchAll();

        } catch (\Throwable $th) {

            handle_error( $error_msg, $error_code );

        }
    
    }else{

        return Unautherized_Request();

    }

}


function check_authority( $pdo_obj, $storage_id, $privilege ){
    // checks to see if the user has a specific privilege

    $user_privileges = get_user_privileges( $pdo_obj, $_SESSION['id']);
    $authrize = false;

    for ( $i=0; $i < sizeof( $user_privileges ); $i++ ) { 

        if( $user_privileges[$i]["Storage_Id"] == $storage_id ){

            if( $user_privileges[$i][$privilege] == 1  ){

                $authrize = true;
                break;

            }

        }

    }

    return $authrize;
}


function get_user_dashboard( $pdo_obj ){

    // Get User Info
    $qr = $pdo_obj->query("SELECT * FROM user WHERE User_Id = ".$_SESSION['id'] );
    $User_Data = $qr->fetchAll()[0];
    $user_privileges = get_user_privileges($pdo_obj, $_SESSION['id']);
    $companies = array();


    foreach ( $user_privileges as $priv ) {
        // adding companies data

        $storage = get_storage_by_id( $pdo_obj, $priv['Storage_Id'] )[0];
        $company_id = $storage["Company_Id"];

        $priv["Company_Id"] = $company_id;

        $companies[ $company_id ] = get_company_by_id( $pdo_obj, $company_id )[0];

    }

    

    foreach ($user_privileges as $priv ) {
        // adding privileges of each storage avaliable for the user to the companies array

        $company_id = get_storage_by_id( $pdo_obj, $priv['Storage_Id'] )[0]["Company_Id"] ;

        $company = $companies[ $company_id ];

        // echo $companies[ $company_id ];
        if( !isset( $companies[ $company_id ]["Storages"] ) ){
        
            $companies[ $company_id ]["Storages"] = array();

        }

        $companies[ $company_id ]["Storages"][ sizeof(  $companies[ $company_id ]["Storages"] ) ] = $priv;

    }

    return $companies;
}

function get_user_privileges_of_storage( $pdo_obj, $user_id, $storage_id){
    // returns user privileges of a specific storage

    $new_array = array();
    $user_privileges = get_user_privileges( $pdo_obj, $user_id );
         
    foreach ( $user_privileges as $priv ) {

        $new_array[ $priv['Storage_Id'] ] = $priv;

    }

    return $new_array ;
    
}


//////////////////////////////////////////////// GET //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function get_users( $pdo_obj, $amount, $starting_from, $descending_order ){

    $order_string = $descending_order == false ? "ASC" : "DESC";
    return get_data_with_query( "SELECT * FROM `user` ORDER BY User_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get users", "e3000" );

}

function get_user_by_id ( $pdo_obj, $user_id ){
    
    $clean_id = $pdo_obj->quote(clenze_String($user_id));
    $usr = get_data_with_query( "SELECT * FROM `user` WHERE User_Id = $clean_id", $pdo_obj, "Error couldn't get users", "b2500", true);
                        
        if ( array_key_exists ( 0, $usr ) ) {

            return $usr; 

        }else {
            
            return $arrayName = array( 0 => array('Name' => "DELETED USER" ) );

        }    

}

function get_companies ( $pdo_obj, $amount, $starting_from, $descending_order ){

    $order_string = $descending_order == false ? "ASC" : "DESC";
    return get_data_with_query( "SELECT * FROM `company` ORDER BY Company_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get companies", "t9732", true );

}


function get_company_by_id ( $pdo_obj, $company_id ){

    $clean_id = clenze_String($company_id);
    return get_data_with_query( "SELECT * FROM `company` Where Company_Id = $clean_id", $pdo_obj,"Error couldn't get company", "k5222", true );

}

function get_storage_by_id ( $pdo_obj, $storage_id ){

    $clean_id = clenze_String($storage_id);
    return get_data_with_query( "SELECT * FROM `storage` WHERE Storage_Id =  $clean_id", $pdo_obj, "Error couldn't get storages", "l2233", true );

}


function get_storages ( $pdo_obj, $company_id, $amount, $starting_from, $descending_order ){

    $order_string = $descending_order == false ? "ASC" : "DESC";
    $clean_id = clenze_String($company_id);
    
    return get_data_with_query( "SELECT * FROM `storage` WHERE Company_Id =  $clean_id ORDER BY Storage_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get storages", "s5501" );

}

function get_items ( $pdo_obj, $storage_id, $amount, $starting_from, $descending_order ){

    $order_string = $descending_order == false ? "ASC" : "DESC";
    $clean_id = clenze_String($storage_id);

    if ( isset($_SESSION['admin']) ) {

        return get_data_with_query( "SELECT * FROM `item` WHERE Storage_Id =  $clean_id AND Exit_User_Id is NULL ORDER BY Item_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get items", "j005" );

    }else if ( isset($_SESSION['id']) ) {

        // checks to see if the user can view items
        $user_privileges = get_user_privileges( $pdo_obj, $_SESSION['id']);
        $authrize = false;

        if( check_authority( $pdo_obj, $clean_id, "Item_Exit" ) || check_authority( $pdo_obj, $clean_id, "Item_Edit" )  || check_authority( $pdo_obj, $clean_id, "Item_Enter" ) ){

            return get_data_with_query( "SELECT * FROM `item` WHERE Storage_Id =  $clean_id AND Exit_User_Id is NULL ORDER BY Item_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get items", "h521", true );
        
        }else{

            return Unautherized_Request();

        }


    }else{

        // send 403
        return Unautherized_Request();

    }
}

function get_archive_items ( $pdo_obj, $storage_id, $amount, $starting_from, $descending_order ){

    $order_string = $descending_order == false ? "ASC" : "DESC";
    $clean_id = clenze_String($storage_id);

    if ( isset($_SESSION['admin']) ) {

        return get_data_with_query( "SELECT * FROM `item` WHERE Storage_Id =  $clean_id AND Exit_User_Id is NOT NULL ORDER BY Item_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get items", "f001" );

    }else if ( isset($_SESSION['id']) ) {

        if( check_authority( $pdo_obj, $clean_id, "Item_Edit" ) ){

            return get_data_with_query( "SELECT * FROM `item` WHERE Storage_Id =  $clean_id AND Exit_User_Id is NOT NULL ORDER BY Item_Id $order_string Limit $starting_from, $amount", $pdo_obj, "Error couldn't get items", "l005", true );
       
        }else{
       
            return Unautherized_Request();
       
        }

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function get_user_privileges ( $pdo_obj, $user_id  ){

    $clean_id = clenze_String($user_id);

    if ( isset($_SESSION['admin']) ) {

        $dt = get_data_with_query( "SELECT * FROM `user_privilege` WHERE User_Id =  $clean_id", $pdo_obj, "Error couldn't get privileges", "v526" );

        if( sizeof( $dt ) > 0 ){

            return $dt;

        }else {

            return array();

        }

        

    }elseif ( isset($_SESSION['id']) ) {

        $clean_id = clenze_String($_SESSION['id']);

        $dt = get_data_with_query( "SELECT * FROM `user_privilege` WHERE User_Id =  $clean_id", $pdo_obj, "Error couldn't get privileges", "c5269", true );

        if( sizeof( $dt ) > 0 ){

            return $dt;

        }else {

            return array();

        }

        

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function input_user( $pdo_obj, $name, $password ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );
    $clean_password =  $pdo_obj->quote( clenze_String( $password ) );

    if ( isset($_SESSION['admin']) ) {

        try {

            $qr = $pdo_obj->query("SELECT * FROM `user`  WHERE Name = ".$clean_name  );

            if( $qr->rowCount() == 0  ){

                $pdo_obj->query("INSERT INTO `user` (`Name`, `Password`) VALUES ( $clean_name, $clean_password )");
                return "Added user successfully";

            }else{

                handle_error( "Error couldn't add user", "u2532c");

            }
            


        } catch (\Throwable $th) {

           return "Error couldn't add user";

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function input_company ( $pdo_obj, $name, $thumbnail ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );
    $clean_thumbnail =  $pdo_obj->quote( clenze_String( $thumbnail ) );

    if ( isset($_SESSION['admin']) ) {

        try {

            $qr = $pdo_obj->query("SELECT * FROM `company`  WHERE Company_Name = ".$clean_name  );

            if( $qr->rowCount() == 0  ){

                $pdo_obj->query("INSERT INTO `company` (`Company_Name`, `Company_Thumbnail` ) VALUES ( $clean_name, $clean_thumbnail )");

                $st = $pdo_obj->query("SELECT Company_Id FROM `company` WHERE `Company_Name` = $clean_name");
                
                input_storage( $pdo_obj, $st->fetchAll()[0][0] );

                return "Added company successfully";

            }else{

                return "company already exists";

            }
            


        } catch (\Throwable $th) {

           handle_error( "Error couldn't add company", "u22532c");

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function input_storage ( $pdo_obj, $company_id ){

    $clean_company_id =  $pdo_obj->quote( clenze_String( $company_id ) );

    if ( isset($_SESSION['admin']) ) {

        try {

            $pdo_obj->query("INSERT INTO `storage` ( `Company_Id` ) VALUES ( $clean_company_id )");
            return "1";


        } catch (\Throwable $th) {

           handle_error( "Error couldn't add storage", "u3252");

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}



function input_items ( $pdo_obj, $storage_id, $item_name, $amount, $enter_id ){

    $clean_storage_id =  $pdo_obj->quote( clenze_String( $storage_id ) );
    $clean_item_name =  $pdo_obj->quote( clenze_String( $item_name ) );
    $clean_amount =  $pdo_obj->quote( clenze_String( $amount ) );
    $clean_enter_id =  $pdo_obj->quote( clenze_String( $enter_id ) );
    $currnt_time =  $pdo_obj->quote(current_time());

    if ( isset($_SESSION['admin']) ) {

        try {

            $pdo_obj->query("INSERT INTO `item` ( `Storage_Id`, `Item_Name`, `Amount`, `Enter_User_Id`, `Enter_Date` ) VALUES ( $clean_storage_id, $clean_item_name, $clean_amount, $clean_enter_id, $currnt_time )");
            return "1";


        } catch (\Throwable $th) {

           handle_error( "Error couldn't add item", "y2233");

        }
        

    }else if ( isset($_SESSION['id']) ) {

        // checks to see if the user can view items
        $user_privileges = get_user_privileges( $pdo_obj, $_SESSION['id']);
        $authrize = false;

        // make a function that does this looop
        for ( $i=0; $i < sizeof( $user_privileges ); $i++ ) { 

            if( $user_privileges[$i]["Storage_Id"] == $storage_id ){

                if( $user_privileges[$i]["Item_Enter"] == 1  ){

                    $authrize = true;
                    break;
                }

            }
        }

        if( $authrize ){

            $pdo_obj->query("INSERT INTO `item` ( `Storage_Id`, `Item_Name`, `Amount`, `Enter_User_Id`, `Enter_Date` ) VALUES ( $clean_storage_id, $clean_item_name, $clean_amount, $clean_enter_id, $currnt_time )");
            return "1";

        }else{

            return Unautherized_Request();

        }

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function input_privilege ( $pdo_obj, $user_id, $storage_id, $enter, $exit, $edit, $delete ){

    $clean_storage_id =  $pdo_obj->quote( clenze_String( $storage_id ) );
    $clean_user_id =  $pdo_obj->quote( clenze_String( $user_id ) );
    $clean_enter =  $pdo_obj->quote( clenze_String( $enter ) );
    $clean_exit =  $pdo_obj->quote( clenze_String( $exit ) );
    $clean_edit =  $pdo_obj->quote( clenze_String( $edit ) );
    $clean_delete =  $pdo_obj->quote( clenze_String( $delete ) );


    if ( isset($_SESSION['admin']) ) {

        try {

            $qr = $pdo_obj->query("SELECT * FROM `user_privilege`  WHERE Storage_Id = ".$clean_storage_id." AND User_id = ".$clean_user_id  );

            if( $qr->rowCount() == 0  ){

                $pdo_obj->query("INSERT INTO `user_privilege` ( `User_Id` , `Storage_Id`, `Item_Enter`, `Item_Exit`, `Item_Edit`, `Item_Delete` ) VALUES ( $clean_user_id, $clean_storage_id, $clean_enter, $clean_exit, $clean_edit, $clean_delete )");
                return "1";

            }else{

                // UPDATE `user_privilege` SET `Item_Exit` = '1'

                $pdo_obj->query("UPDATE `user_privilege` SET `Item_Enter` = $clean_enter, `Item_Exit` = $clean_exit, `Item_Edit` = $clean_edit, `Item_Delete` = $clean_delete  WHERE `Storage_Id` = $clean_storage_id AND `User_id` = $clean_user_id");
                return "2";

            }


        } catch (\Throwable $th) {

            return handle_error( "Error couldn't add privilege", "y2233");

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function update_and_delete( $pdo_obj, $matching_query, $query, $error_msg, $error_code, $user = false ){


    if ( isset($_SESSION['admin']) || (isset( $_SESSION["id"]) && $user == true) ) {

        try {

            $qr = $pdo_obj->query( $matching_query );

            if( $qr->rowCount() == 1  ){

                $pdo_obj->query($query);
                return "1";

            }else{

                return handle_error( $error_msg, $error_code);

            }
            


        } catch (\Throwable $th) {

           handle_error( $error_msg, $error_code);

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
    
}


function update_user( $pdo_obj, $old_name, $name, $password ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );
    $clean_password =  $pdo_obj->quote( clenze_String( $password ) );
    $clean_old_name = $pdo_obj->quote( clenze_String( $old_name ) );
    
    return update_and_delete(
        $pdo_obj, "SELECT * FROM `user`  WHERE Name = ".$clean_old_name,
        "UPDATE `user` SET `Name` = $clean_name, `Password` = $clean_password WHERE `user`.`Name` = $clean_old_name", 
        "Couldn't update, user doesn't exist",
        "t555"
    );

    
}



function update_company ( $pdo_obj, $old_name, $name, $thumbnail ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );
    $clean_thumbnail =  $pdo_obj->quote( clenze_String( $thumbnail ) );
    $clean_old_name = $pdo_obj->quote( clenze_String( $old_name ) );

    return update_and_delete(
        $pdo_obj, "SELECT * FROM `company`  WHERE Company_Name = ".$clean_old_name,
        "UPDATE `company` SET `Company_Name` = $clean_name, `Company_Thumbnail` = $clean_thumbnail WHERE `company`.`Company_Name` = $clean_old_name", 
        "Error couldn't update company",
        "z425"
    );

}




function update_item ( $pdo_obj, $item_id, $name, $amount ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );
    $clean_amount =  $pdo_obj->quote( clenze_String( $amount ) );
    $clean_item_id = $pdo_obj->quote( clenze_String( $item_id ) );

    return update_and_delete(
        $pdo_obj, "SELECT * FROM `item`  WHERE Item_Id = ".$clean_item_id,
        "UPDATE `item` SET `Item_Name` = $clean_name, `Amount` = $clean_amount WHERE `item`.`Item_Id` = $clean_item_id", 
        "Error couldn't update item",
        "g55",
        true
    );

}

//////////////////////////////////////////////////// DELETE \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

function delete_user( $pdo_obj, $user_id ){

    $clean_id =  $pdo_obj->quote( clenze_String( $user_id ) );

    return update_and_delete(
        $pdo_obj,
        "SELECT Name FROM `user`  WHERE User_Id = ".$clean_id,
        "DELETE FROM `user` WHERE `user`.`User_Id` = $clean_id",
        "Couldn't delete, user doesn't exist",
        "l200"
    );
}


function delete_company ( $pdo_obj, $name ){

    $clean_name =  $pdo_obj->quote( clenze_String( $name ) );


    return update_and_delete(
        $pdo_obj,
        "SELECT Company_Name FROM `company`  WHERE Company_Name = ".$clean_name,
        "DELETE FROM `company` WHERE `company`.`Company_Name` = $clean_name",
        "Couldn't delete, company doesn't exist",
        "k32230"
    );

}


function delete_storage ( $pdo_obj, $id ){

    $clean_id =  $pdo_obj->quote( clenze_String( $id ) );

    return update_and_delete(
        $pdo_obj,
        "SELECT * FROM `storage`  WHERE Storage_Id = ".$clean_id,
        "DELETE FROM `storage` WHERE `storage`.`Storage_Id` = $clean_id",
        "Couldn't delete, storage doesn't exist",
        "op2000"
    );

    
}



function delete_item ( $pdo_obj, $id ){

    $clean_id =  $pdo_obj->quote( clenze_String( $id ) );

    if ( isset($_SESSION['admin']) ) {

        return update_and_delete(
            $pdo_obj,
            "SELECT * FROM `item`  WHERE Item_Id = ".$clean_id,
            "DELETE FROM `item` WHERE `item`.`Item_Id` = $clean_id",
            "Couldn't delete, item ",
            "1337"
        );
        
    }else if ( isset($_SESSION['id']) ) {

        try {

            $qr = $pdo_obj->query("SELECT * FROM `item`  WHERE Item_Id = ".$clean_id  );

            if( $qr->rowCount() == 1  ){    

                $item_obj = $qr->fetchAll();
                $storage_id = $item_obj[0]["Storage_Id"];

                if( check_authority( $pdo_obj, $storage_id, "Item_Delete" ) ){
                    
                    $pdo_obj->query("DELETE FROM `item` WHERE `item`.`Item_Id` = $clean_id");
                    return "1";

                }else{

                    return Unautherized_Request();

                }

            }else{

                return "Couldn't delete, item doesn't exist";

            }
            


        } catch (\Throwable $th) {

           return "Error couldn't delete item : $th";

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}


function exit_item ( $pdo_obj, $item_id ){

    $clean_id =  $pdo_obj->quote( clenze_String( $item_id ) );
    $currnt_time = $pdo_obj->quote( current_time() );

    if ( isset($_SESSION['admin']) ) {

        return update_and_delete(
            $pdo_obj,
            "SELECT * FROM `item`  WHERE Item_Id = ".$clean_id,
            " UPDATE `item` SET `Exit_User_Id` = 0, `Exit_Date` = $currnt_time WHERE `item`.`Item_Id` = $clean_id",
            "Couldn't exit, item",
            "er2351"
        );
        
    }else if ( isset($_SESSION['id']) ) {

        try {

            $qr = $pdo_obj->query("SELECT * FROM `item`  WHERE Item_Id = ".$clean_id  );

            if( $qr->rowCount() == 1  ){

                // checks to see if the user can view items
                $user_privileges = get_user_privileges( $pdo_obj, $_SESSION['id']);
                $item_obj = $pdo_obj->query("SELECT * FROM `item`  WHERE Item_Id = ".$clean_id  )->fetchAll();
                $storage_id = $item_obj[0]["Storage_Id"];

                if( check_authority( $pdo_obj, $storage_id, "Item_Exit" ) ){

                    $id = $_SESSION['id'];

                    $pdo_obj->query(" UPDATE `item` SET `Exit_User_Id` = $id, `Exit_Date` = $currnt_time WHERE `item`.`Item_Id` = $clean_id");
                    return "1"; 
                }

            }else{

                return "Couldn't exit, item doesn't exist";

            }
            
        } catch (\Throwable $th) {

           return "Error exit item $th";

        }
        

    }else{

        // send 403
        return Unautherized_Request();

    }
}

?>