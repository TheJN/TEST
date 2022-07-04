<?php require  'config.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title_page?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="img/J_logo.png">
    <!-- Carousel -->

    <!--  -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--  -->

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!--  -->

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/cd3f6ecfc8.js" crossorigin="anonymous"></script>
    <!--  -->

</head>
<body>
    
<section>
<div class="container-fluid">
        <div class="row bg-light">
            <div class="col-auto mx-auto ">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item ">
                                <a class="nav-link" href="index.php">Accueil </a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="recap.php">Récapitulatif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_stock.php">Add Stock</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="maj_stock.php">Mise à jour du stock</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="historic.php">Historique</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="menu.php">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="add_menu.php">Add menu</a>
                            </li>
                            </ul>
                            
                        </div>
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>

</section>
