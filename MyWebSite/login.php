<?php
// Include config file
require 'elements/config.php';
// Initialize the session
//session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:index.php");
    exit;
}

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez entrez votre identifiant.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrez votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }

    
    
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password,email FROM users WHERE username = ?";
        
        if($stmt = $DB->getDb()->prepare($sql)){
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute(array($param_username))){
                $data = $stmt->fetchAll();
                // Check if username exists, if yes then verify password
                if(!empty($data)){  
                    
                    $hashed_password = $data[0]['password'];

                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $data[0]['id'];
                            $_SESSION["username"] = $username;
                                                
                            
                            // Redirect user to welcome page
                           header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Le mot de passe entré n'est pas valide.";
                        }
                    
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "Aucun compte trouvé avec cet identifiant.";
                }
            } else{
                echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
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
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/cd3f6ecfc8.js" crossorigin="anonymous"></script>
    <!--  -->
</head>
<body class="bg-light">
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

    

<section class="vh-100 bg-light" id="login">
    <div class="container-fluid  px-md-5 py-2" >
        <div class="container   px-md-5 py-5">
            <div class="container rounded shadow p-5 bg-white " >
                <div class="row">
                    <div class="col-md-auto mx-auto">
                    <h1 class="text-center">Connexion</h1>
                        <p class="text-primary text-center"> Entrez votre identifiant ainsi que votre mot de passe pour vous connectez.</p>
                      
                    </div>
                    
                    
                </div>
                <hr class=" mb-4">
                        
            </div>
            <div class="col-12 mx-auto  p-3">
                <div class="row">
                    <div class="col-12 col-md py-5 rounded shadow bg-white" >
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                            <div class="form-group p-3">
                                <label><strong>Identifiant</strong></label>
                                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Identifiant *">
                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>    
                            <div class="form-group p-3">
                                <label><strong>Mot de passe</strong></label>
                                <input type="password" name="password" class="form-control  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Mot de passe *">
                                <span class="help-block"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group p-3">
                                <input type="submit" class="btn btn-primary btn-block" value="Se connecter">
                            </div>
                        </form>
                        <p><a href="index.php" class="text-primary px-3">Retourner au site<i class=" px-3 far fa-hand-point-left text-primary"></i></a></p>
                    </div>
                    <div class="col-12 col-md py-5 ">
                        <div class=" rounded shadow p-5 mb-3 bg-white" >
                        <div class="row">
                            <div class="col-md-8 col-9">
                            <p>Vous n'avez pas de compte ? </p>
                            <a href="register.php" class="text-primary">S'inscrire</a>
                            </div>
                            <div class="col-md-4 col-3">
                            <a href="register.php" class="text-primary"><i class="far fa-user-circle text-primary fa-3x px-lg-5 py-md-0 py-4"></i></a>
                            </div>
                        </div>
                            
                        </div>
                        <div class="col rounded shadow p-5 bg-white" >
                        <div class="row">
                            <div class="col-md-8 col-9">
                            <p>Mot de passe oublié ?</p>
                            <a href="reset-password.php" class="text-primary">Réinitialiser mon mot de passe</a>
                            </div>
                            <div class="col-md-4 col-3">
                            <a href="reset-password.php" class="text-primary"><i class="fas fa-unlock-alt text-primary fa-3x px-lg-5 py-md-0 py-4"></i></a>
                            </div>
                        </div>
                           
                        </div>
                    </div>

                </div>
                
                
            </div>
            
            
        </div>
    </div>

</section>

    
</body>
</html>


