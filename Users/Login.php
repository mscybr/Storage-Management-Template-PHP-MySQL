<?php


    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';
    $errors = [];

    if ( isset($_SESSION['id']) ) {
   
      header('Location: ./Dashboard.php');
      exit;

    } else if( isset($_SESSION['admin']) ){

    	header('Location: ../Admin/Dashboard.php');
    	exit;
        
    } else if( isset($_POST['name']) and isset($_POST['password']) ) {

      if( $_POST['name'] == Admin_name && $_POST['password'] == Admin_Password ){
        // check is admin

        $_SESSION['admin'] = "true";
        header('Location: ../Admin/Dashboard.php');
        exit;

    }

      try {

        $qr = $db->query("SELECT * FROM `user`  WHERE Name = ".$db->quote( clenze_String( $_POST['name']) ) );

        if( $qr->rowCount() != 0  ){
          // check to see if the user exsits
         
          $qr_Array = $qr->fetchAll()[0];
          $passwrd = $qr_Array["Password"];
          $id = $qr_Array["User_Id"];
          
          if( $_POST['password'] == $passwrd ){
            //password verfication

            $_SESSION['id'] = $id;
            header('Location: ./Dashboard.php');
            exit;

          }else{

            $errors[ sizeof($errors) - 1 ]  = "Please enter the correct password";

          }

        }else{
            
          $errors[ sizeof($errors) - 1  ]  = "Please enter the correct name";

        }



      } catch (PDOException $e) {
        
        handle_error( "error : $e", "u20005");
      
      }

        // Render view
        render_view("Login");
        exit;

    }else{

      // Render view
      render_view("Login");
      exit;

    }

?>

