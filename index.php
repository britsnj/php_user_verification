<?php

    session_start();

    $username = "";
    $email = "";
    
    
    //connect to database

    $link = mysqli_connect("shareddb-u.hosting.stackcp.net", "secret-diary-313333a05a", "n7vafey1d8", "secret-diary-313333a05a");

    if (mysqli_connect_error()) {    
      die ("Database Connection NOT Successful");
    } 

    // this is the registration section
    // first we check that all inputs has been completed
    
    if (isset($_POST['register_btn'])){
        
        if (empty($_POST['name'])){
            
            echo "A Name is required";
        } elseif (empty($_POST['email'])) {
            
            echo "An e-mail adress is required";
        } elseif (empty($_POST['password'])) {
            
            echo "A password is required!";
        } else {
                    
        
            $name = mysqli_real_escape_string($link, $_POST['name']);
            $email = mysqli_real_escape_string($link, $_POST['email']);
            $password = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT);
            $token = bin2hex (random_bytes(50));       
        
            //check if email exists

            $query = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0){

                echo "<p>That email is already registered. Would you rather like to LOG IN?</p>";
                //if email does not exist update database with user information and log the user in        
                } else {

                    $query = "INSERT INTO `users` (`name`, `email`, `password`, `token`) VALUES ('$name', '$email', '$password', '$token')";

                    if (mysqli_query($link, $query)){
                        
                        //then send verification mail
                        $emailTo = $email;
                        $subject = "Please verify your e-mail address";
                        $body = "<p>You have recently registerd on our website. If this was not you, please ignore this mail.</p><p>To confirm your e-mail address, please click on the link below or copy and paste it into your browser</p><p>https://playpen.nicojbrits.co.za/diary/verifyMail.php?token=".$token."</p>"; 
                        $headers = "From: verification@nicojbrits.co.za";
                        
                        mail($emailTo, $subject, $body, $headers);

                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        $_SESSION['verified'] = false; //verified is used for email verification
                        $_SESSION['message'] = "You have been logged in";
                        header('location: diary.php');
                        
                        } else {

                            echo "<p>Registration failed. Please Try Again Later</p>";
                        }

                    }
            }   
        }

        //THIS IS THE LOGIN SECTION
        //ONCE AGAIN CHECK THAT ALL INPUTS ARE COMPLETE

        if (isset($_POST['login_btn'])){

                if (empty($_POST['email'])){

                    echo "Please enter your e-mail";
                } elseif (empty($_POST['password'])) {

                    echo "Please enter your password to continue";
    
                    } else {
                    
                    //CHECK THAT THE USER EXISTS
                    
                    $email = mysqli_real_escape_string($link, $_POST['email']);
                    $password = mysqli_real_escape_string($link, $_POST['password']);
                    
                                     
                    $query = "SELECT * from `users` WHERE email = '$email'";
                    
                    if ($result = mysqli_query($link, $query)){
                        
                        $user = mysqli_fetch_array($result);
                    
                        if (mysqli_num_rows($result) > 0){
                    
                    
                                if (password_verify($password, $user['password'])){
                                    
                                    $_SESSION['name'] = $user['name'];
                                    $_SESSION['email'] = $user['email'];
                                    $_SESSION['verified'] = $user['verified']; //verified is used for email verification
                                    $_SESSION['message'] = "You have been logged in";
                                    header('location: diary.php');
                                    
                                } else {
                                    
                                    echo "Invalid Password. Try again.";
                                } 
                        } else {
                            
                            echo "We do not have that user in our database. Please Register";
                        }
                        
                        }
                    
                    }
        }


/*    

    if (array_key_exists('my_email', $_POST) OR array_key_exists('password', $_POST)) {
    
        if ($_POST['my_email'] == '') {
            
            echo "<p>Please enter your e-mail to log in</p>";
        } elseif ($_POST['password'] == '') {
                
                echo "<p>A password is required to log in</p>";
            } else {
            
            
                //this is the login section

               
                $query = "SELECT `password` FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['my_email'])."'";

                if($result = mysqli_query($link, $query)){
                    
                    $row = mysqli_fetch_array($result);
                 
                    if (mysqli_num_rows($result) > 0){
                        
                        if (password_verify($_POST['password'], $row['password'])) {
                                echo 'Password is valid!';
                                } else {
                                    echo 'Invalid password.';
                                }
                    
                            } else {

                                echo "We do not have that user in our database. Would you like to SIGN UP?";
                                    }
                    
                            } else {
                    
                    echo "Error logging in. Please try again later.";
                }

                
        
        
        }
    }
    
*/
   
?>



<p>Please enter E-Mail and Password to register.</p>
<form method="post">
    <input type = "text" name = "name" placeholder = "Your Name">
    <input type="email" name="email" placeholder="Enter Your Email">
    <input type="password" name="password" placeholder="Enter Password">
    <button type="submit" name = "register_btn">REGISTER</button>
</form>

<p>Alternatively enter your Username or e-mail and Password to log in</p>
<form method="post">
    <input type="email" name="email" placeholder="Enter Your e-mail">
    <input type="password" name="password" placeholder="Enter Password">
    <button type="submit" name = "login_btn">LOG IN</button>
</form>
