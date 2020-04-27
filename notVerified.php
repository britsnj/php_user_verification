<?php

require_once 'sendMail.php'; //INCLUDE SENDMAIL.PHP AS WE CALL A FUNCTION THERE

session_start();

if ($_GET) {
      
    sendVerificationMail($_SESSION['email'], $_SESSION['token']); //CALLS THE FUNCTION LOCATED IN SENDMAIL.PHP
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- BOOTSTRAP FONTS AND STYLESHEETS -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="main.css">
        
        <title>NOT VERIFIED</title>
        
    </head>
    <body>
        
        <!-- BOOTSTRAP ALERT IS USED TO PASS VERIFICATION ERROR -->
        
        <div class="container-fluid" id="background">
                            
            <h1 id="title">USER MAIL NOT VERIFIED</h1>
            
            <div class="alert alert-danger text-center" role="alert">
                <p><strong>Your account has not yet been verified</strong></p>
                <br>
                <p>Please click on the link that we sent to you at <strong><?php echo $_SESSION['email']; ?></strong> </p>
                <br>
                <p>If you did not receive the e-mail, please <a id="reMail" href='?submitted=yes'>click here</a> and we will re-send it to you. </p> <!-- THIS LINE INVOKES A $_GET RESPONSE -->
            
            </div>
        
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
       
              
    </body>
</html>
