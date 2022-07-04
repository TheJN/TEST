<?php
// Include config file
require 'elements/config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez entrez votre identifiant.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $DB->getDb()->prepare($sql)){
            $param_username = trim($_POST["username"]); 
            // Attempt to execute the prepared statement
            if($stmt->execute(array($param_username))){
                if (!empty($data = $stmt->fetchAll())) {
                    $username_err = "Cet identifiant est déjà pris.";
                }else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
            }
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrez votre mot de passe.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Le mot de passe doit contenir 6 caractères minimum";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Veuillez confirmer votre mot de passe.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Le mot de passe n'est pas correct.";
        }
    }

    // Validate email 

    if(empty(trim($_POST["email"]))){
        $email_err = "Veuillez entrez votre adresse email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = $DB->getDb()->prepare($sql)){
            $param_email = trim($_POST["email"]); 
            // Attempt to execute the prepared statement
            if($stmt->execute(array($param_email))){
                if (!empty($data = $stmt->fetchAll())) {
                    $email_err = "Cet email est déjà utlisé.";
                }else{
                    if(filter_var($param_email, FILTER_VALIDATE_EMAIL)){
                        $email = $_POST["email"];
                    }else{
                        $email_err = "L'adresse e-mail n'est pas valide.";
                    }
                }
            } else{
                echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
            }
        }
    }

        
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email,password) VALUES (?, ?, ?)";
         
        if($stmt = $DB->getDb()->prepare($sql)){
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute(array($param_username,$param_email,$param_password))){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Il y a eu un problème.Veuillez essayer plus tard.";
            }
        }
    }
}











?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/cd3f6ecfc8.js" crossorigin="anonymous"></script>
    <!--  -->

</head>
<body>
    <style>
        body{
  font-family: Montserrat, sans-serif ;
}

h1,h2,h3,h4,h5,h6{
  font-family: Garamond, Baskerville, Caslon, serif ;
}
        .form-control{
            border: none;
            border-bottom: 1px solid  rgba(13, 110, 253, 1);
            background-color:transparent ;
            color: rgba(13, 110, 253, 1);
        }
        .form-control:focus{
            outline: none;
            color: rgba(13, 110, 253, 1);
            background-color:transparent ;
            border: none;
            border-bottom: 1px solid  rgba(13, 110, 253, 1);
        }
        .form-control::placeholder{
            
        color: rgba(13, 110, 253, 1);
        }

    </style>


<section class=" bg-light" id="login" >
    <div class="container-fluid  px-md-5 py-3" >
        <div class="container   px-md-5 py-5">
            <div class="container rounded shadow p-5 bg-white" >
                <div class="row">
                    <div class="col-md-auto mx-auto">
                    <h1 class="text-center">Mon compte</h1>
                    <p class="text-primary text-center">Veuillez remplir le formulaire pour créer votre compte.</p>
                    </div>
                    
                    
                </div>
                <hr class=" mb-4">
                        
            </div>
            <div class="col-12 mx-auto  p-3">
                <div class="row">
                    <div class="col-12 col-md-8 py-5  mx-auto rounded shadow bg-white" >
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="px-md-3">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
                        <div class="form-group px-md-3 py-3 ">
                            <!-- <label><strong>Identifiant</strong></label><br> -->
                            <input type="text" name="username" class=" w-100 form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Identifiant *">
                            <span class="help-block text-danger "><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group px-md-3 py-3">
                            <!-- <label><strong>Email</strong></label> -->
                            <input type="text" name="email" class=" form-control w-100  <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Email *">
                            <span class="help-block text-danger"><?php echo $email_err; ?></span>
                        </div>  
                        <div class="form-group px-md-3 py-3">
                            <!-- <label><strong>Mot de passe</strong></label> -->
                            <input type="password" name="password" class=" form-control w-100 <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Mot de passe *">
                            <span class="help-block text-danger"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group px-md-3 py-3">
                            <!-- <label><strong>Confirmez votre mot de passe</strong></label> -->
                            <input type="password" name="confirm_password" class=" form-control w-100 <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirmez votre mot de passe *">
                            <span class="help-block text-danger"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group mt-4 px-md-3 py-3">
                            <input type="submit" class="btn btn-block btn-primary p-2 mb-3"  value="Créer mon compte">
                            <input type="reset" class="btn btn-block btn-light p-2" value="Annuler">
                        </div>
                        </div>
                    </div>
                    </form>
                    <p class="px-3">Vous avez déjà un compte?</p>
                    <a href="login.php" class="text-primary px-3">Connectez vous<i class=" px-3 fas fa-sign-in-alt text-primary"></i></a>
                    <p class="text-right"><a href="index.php" class="text-primary px-3">Retourner au site<i class=" px-3 far fa-hand-point-left text-primary"></i></a></p>
                    </div>
                </div>            
            </div>        
        </div>
    </div>

</section>


    
</body>
</html>