<?php

    // constants
    define('Host_Name', 'localhost');
    define("Default_Language", "en" );
    define("Supported_Languages", ["en"]);
    define("Number_Of_Items_Per_Page", 100 );
    define("Number_Of_Archive_Items_Per_Page", 100 );
    define("Number_Of_Users_Per_Page", 100 );
    define("Number_Of_Storages_Per_Page", 100 );
    Define('DB_dsn', 'mysql:dbname=storage_website;host='.Host_Name);
    Define('DB_user', 'root');
    Define('DB_password', '');
    Define('Admin_name', 'Admin');
    Define('Admin_Password', 'Password');

    // "Development_Mode" when off supresses errors for security 
    Define("Development_Mode", false );

    // default timezone set it up according to your location so the server can input the "entry date" according to that timezone
    date_default_timezone_set("Europe/Berlin");

    //starting session( session will be destroyed once the browser is closed  )
    session_set_cookie_params( 0, '/', Host_Name, true, true);
    session_start();
    $db;

    
    function clenze_String ( $string ){
        // clean strings from html characters and extra whitespaces

        return  htmlspecialchars( trim($string) );

    }

    function handle_error( $error, $error_code ){
        // handle errors according to the development_mode ( development mode is on sends error otherwise supresses them and sends an error code that can be identified by the developer )
        if ( Development_Mode ) {

            die( "Error : $error" );

        }else{

            die( "An error has occurred please contact the developer with error code : $error_code" );

        }

    }



    function render_view ( $view ){
        // renders the proper view according to the language passed into the lang get argument( if the language is supported otherwise renders the default language view )
        
        $lng = Default_Language;

        if ( isset( $_GET["lang"] ) ) {

            foreach ( Supported_Languages as $key => $lang ) {
                
                if( $_GET["lang"] == $lang ){

                    $in = $lang;

                }

            }
            
        } 

        return require_once("./Views/$lng/$view.php");

    }
    
    //Establish Connection
    try {

        $db = new PDO(DB_dsn, DB_user, DB_password);

    } catch (PDOException $err) { 

        handle_error( "Could not connect to database", "01110" );
      
    }

    // loading controllers
    require_once $_SERVER['DOCUMENT_ROOT']."/Controllers.php";


?>




