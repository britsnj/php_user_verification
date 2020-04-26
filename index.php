<?php

session_start();

// redirect user to login page if they're not logged in
if (empty($_SESSION['name'])) {
    header('location: login.php');
//if they are logged in but email not verified, send them to 
//the email verification page
} elseif($_SESSION['verified'] == false){
    header('location: notVerified.php');
}

//Other php scripts required for your site goes here

?>

<!--Your site HTML Goes here -->

<!DOCTYPE html>
<html lang="en">
    <head>
        
            
    </head>

    <body>
 
    </body>
</html>

    