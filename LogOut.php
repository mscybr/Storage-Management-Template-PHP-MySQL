<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/Config.php';
    
    // destroy the session to log the user out
    session_destroy ();
    header('Location: ./Users/Login.php');
    exit;
?>