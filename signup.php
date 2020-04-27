<?php

require_once 'sendMail.php'; /* Include sendMail.php to call sendVerificationMail function */

session_start();

    $username = "";
    $email = "";
    $errors = [];
    
    
    
    //connect to database

    $link = mysqli_connect("SQL_SERVER", "SQL_dbNAME", "db_PASSWORD", "SQL_USERNAME");

    if (mysqli_connect_error()) {    
      die ("Database Connection NOT Successful");
    } 

    /* first we verify input fields have all been completed */
    
    if (isset($_POST['register_btn'])){
        
        if (empty($_POST['name'])){
            
            $errors['name'] = "A Name is required"; /* $errors array is desplayed in alert on form */
            
        } 
        
        if (empty($_POST['email'])) {
            
            $errors['email'] = "An e-mail adress is required";
            
        }
        
        if (empty($_POST['password'])) {
            
            $errors['password'] = "A password is required!";
            
        } 
        
        if(isset($_POST['password']) && $_POST['password'] !== $_POST['confirm_password']) {
            
            $errors['noMatch'] ="Passwords do not match";
            
        } else {
                    
            /* save POST array to variables */
            
            $name = mysqli_real_escape_string($link, $_POST['name']);
            $email = mysqli_real_escape_string($link, $_POST['email']);
            $password = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT); /*encrypt password */
            $token = bin2hex (random_bytes(50)); /* generate token for e-mail verification */      
        
            /* check if email exists in database */

            $query = "SELECT * FROM `users` WHERE email = '$email' LIMIT 1";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0){

                $errors['exist'] = "That email is already registered. <a href='login.php'>LOG IN</a>?";
                
                /* if email does not exist update database with user information and log the user in */       
                } else {
                
                    if(count($errors) === 0) {

                    $query = "INSERT INTO `users` (`name`, `email`, `password`, `token`) VALUES ('$name', '$email', '$password', '$token')";

                    if (mysqli_query($link, $query)){
                        
                        /* if sucessfully saved in database then call function from sendMail.php */
                        
                        sendVerificationMail($email, $token);
                        
                        /* and set SESSION keys */

                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        $_SESSION['verified'] = true; //verified is used for email verification. We set it to true to allow for immediate login.
                        $_SESSION['token'] = $token;
                        header('location: index.php');
                        
                        } else {

                            $errors['database'] = "Registration failed. Please Try Again Later";
                            
                        }
                        
                        }
                    }
            }   
        }

?>

<!-- This form is provided as a signup form. If you change it make sure that the "name" values remains the same 
    or is changed in the php script as well -->

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- Bootstrap, Fonts and Stylesheet Links -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="main.css">
        
    </head>
    
    <body>
        
        <div class="container-fluid" id="background">
            
            <h1 id="title">SIGNUP FORM</h1>
            
            <div class="container" id="registerForm">
                <?php if (count($errors) > 0): ?>
                      <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?> <!-- Parses any errors into a bootstrap alert -->
                        <li>
                          <?php echo $error; ?>
                        </li>
                        <?php endforeach;?>
                      </div>
                    <?php endif;?>
                <form method="POST">
                    <div class="row">
                        <div class="col">
                        </div>
                        <div class="col-6">
                            <p id="prompt">Please ener your name, email and password to sign up</p>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="form-group mx-sm-3">
                        <label for="name">Your Name</label>
                        <input type="text" name="name" class="form-control" id="signupName" value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?/*This keeps the entered value in the form, otherwise it clears and has to be typed in again */>">
                    </div>
                    <div class="form-group mx-sm-3">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="signupEmail" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>">
                    </div>
                    <div class="form-group mx-sm-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="signupPassword">
                    </div>
                    <div class="form-group mx-sm-3">
                        <label for="check_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
                    </div>
                    <button type="submit" class="btn btn-primary mx-sm-3" name = "register_btn">Register</button>
                    </form>
                    
                <div class="row">

                    <div class="col">
                    </div>
                    <div class="col">
                        <a id=logLink href="login.php">Click here to Log In</a> <!-- Link to Login Page -->
                    </div>
                    <div class="col">
                    </div>
                </div>                      
            </div>

        </div>


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  

        
    
    </body>
</html>


