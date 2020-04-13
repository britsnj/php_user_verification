<?php

session_start();

//connect to database

    $link = mysqli_connect("shareddb-u.hosting.stackcp.net", "secret-diary-313333a05a", "n7vafey1d8", "secret-diary-313333a05a");

    if (mysqli_connect_error()) {    
      die ("Database Connection NOT Successful");
    } 

//Get token from clicked link in mail

    if (isset($_GET['token'])){
        
        $token = $_GET['token'];
        $query = "SELECT * FROM `users` WHERE token='$token' LIMIT 1";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0 ){
            
            $user = mysqli_fetch_array($result);
            
            $query = "UPDATE `users` SET verified=1 WHERE token='$token' LIMIT 1";
            
            if (mysqli_query($link, $query)){
                
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = true;
                $_SESSION['message'] = "Your email has been verified";
                header('location: diary.php');
                
            }
        } else {
            
            echo "User not found";
                
        }
    } else {
        
        echo "No token provided";
        
    }


?>