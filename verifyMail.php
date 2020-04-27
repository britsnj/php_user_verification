<?php

session_start();

//connect to database

    $link = mysqli_connect("SQL_SERVER", "SQL_dbNAME", "db_PASSWORD", "SQL_USERNAME");

    if (mysqli_connect_error()) {    
      die ("Database Connection NOT Successful");
    } 

/* Get token from clicked link in mail */

    if (isset($_GET['token'])){
        
        $token = $_GET['token'];
        /* Select user from database for token value */
        $query = "SELECT * FROM `users` WHERE token='$token' LIMIT 1";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0 ){
            
            $user = mysqli_fetch_array($result);
            /* If user exists in database, update verified field to TRUE */            
            $query = "UPDATE `users` SET verified=1 WHERE token='$token' LIMIT 1";
            
            if (mysqli_query($link, $query)){
                /* if successfull, log user into session and transfer to index page */
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = true;
                $_SESSION['message'] = "Your email has been verified";
                header('location: index.php');
                
            }
        } else {
            /* if user is not found in database */
            echo "User not found";
                
        }
    } else {
        /* if token is not valid */
        echo "No token provided";
        
    }


?>