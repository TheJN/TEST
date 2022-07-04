<?php require  'config.php';

if (!isset($_SESSION["loggedin"])){
    // Redirect user to welcome page
    header("location: login.php");
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title_page?></title>

    <!-- Carousel -->

    <!--  -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--  -->

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!--  -->

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/cd3f6ecfc8.js" crossorigin="anonymous"></script>
    <!--  -->

</head>
<body class="bg-light">
    
<div class="col-12 m-2">
    

<div class="row g-0">

    <div class="col-md-2 bg-primary collapse show shadow rounded mx-3 mt-3 text-white navigation" id="navbar" >

        <div class=" col-12 pt-2 text-center">
        <i class="bi bi-incognito" style="font-size:35px"></i>
        </div>

        <div class="container-fluid  text-center">
            <hr class="bg-white">
            <div class=" mx-md-auto">
                <div class="col-md-auto mx-auto">
                <a href="index.php" class="text-white text-decoration-none"><i class="fas fa-tachometer-alt text-center"></i></a>
                    
                </div>
            <div class="col-md-auto mx-auto">
            <a href="index.php" class="text-white text-decoration-none">Dashboard</a>
            </div>
        
            </div>
            
            <hr class="bg-white">
        </div>

        <div class="container-fluid  my-3 ">
            <div class=" mx-md-auto">
                <div class="col-md-auto mx-auto text-center">
                <a class=" text-white text-decoration-none" data-toggle="collapse" href="#navbar_page" role="button" aria-expanded="true" aria-controls="navbar_page"><i class="fas fa-folder my-md-auto"></i></a>
                </div>
                <div class="col-md-auto mx-auto text-center">
                <a class=" text-white text-decoration-none" data-toggle="collapse" href="#navbar_page" role="button" aria-expanded="true" aria-controls="navbar_page">Pages</a>
                </div>
                <div class=" container-fluid bg-light rounded shadow navigation_page collapse py-3 my-3 " id="navbar_page">
                    <ul class="list-unstyled">
                        <li><a class=" nav-link text-muted">Nutrition</a></li>
                        <hr class="w-25 my-0 mx-3">
                        <li><a class="btn btn-light border-0 text-dark" href="recap.php">Récapitulatif</a> </li>
                        <li><a class="btn btn-light border-0 text-dark" href="add_stock.php">Add Stock</a>  </li>
                        <li><a class="btn btn-light border-0 text-dark" href="maj_stock.php">Mise à jour du stock</a></li>
                        <li><a class="btn btn-light border-0 text-dark" href="historic.php">Historique</a></li>
                        <li><a class="btn btn-light border-0 text-dark" href="menu.php">Menu</a></li>
                        <li> <a class="btn btn-light border-0 text-dark" href="add_menu.php">Add menu</a></li>
                        <li><a class=" nav-link text-muted">Autre pages</a> </li>
                        <hr class="w-25 my-1 mx-3">
                        <li><a class="btn btn-light border-0 text-dark" href="">Comming soon..</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col mt-3 d-flex align-items-end flex-column min-vh-100">
        <div class=" bg-white container-fluid shadow rounded py-3">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-md py-md-0  col-auto mx-auto">
                        <a class="btn btn-primary" data-toggle="collapse" href="#navbar" role="button" aria-expanded="false" aria-controls="navbar"><i class=" bi bi-list"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row justify-content-end ">
                        <div class="col-auto ">
                        <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    
                        <div class="col-auto  ">
                        <p class=" "><?=$_SESSION['username']?></p>
                        </div>
                        <div class="col-auto  ">
                            <div class="dropleft ">
                                <button class=" border-0 btn-link bg-white " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="img/undraw_profile.svg" alt="" height="30px" width="30px">
                                </button>
                                <div class=" dropdown-menu">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <a class="dropdown-item" href="#">Parametres</a>
                                    
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout.php">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        
            
            
        </div>
        
    
