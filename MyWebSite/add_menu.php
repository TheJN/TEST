<?php 

require 'elements/nav.php';

$message_succes="";

// Define variables and initialize with empty values
$aliment_name1 = $aliment_name2 = $aliment_name3 = $quantity1 = $quantity2 = $quantity3 = $menu_name = $menu_type = "";
$aliment_name_err = $quantity_err = $menu_type_err = "";
if (isset($_SESSION['id'])){
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){


            // Validate menu name
            if(empty(trim($_POST["menu_name"]))){
                $menu_name_err = "Veuillez entrez un nom de menu.";
            } else{
                // Prepare a select statement
                $sql = "SELECT id FROM creation_menu WHERE name = ? AND id_user =?";
        
                if($stmt = $DB->getDb()->prepare($sql)){
                    $param_menu_name = trim($_POST["menu_name"]);
                    $id_user = $_SESSION['id'];
                    // Attempt to execute the prepared statement
                    if($stmt->execute(array($param_menu_name,$id_user))){
                        if (!empty($data = $stmt->fetchAll())) {
                            
                            $menu_name_err = "Ce menu a déja été ajouté.";
                        }else{
                            $menu_name = trim($_POST["menu_name"]);
                        }
                    } else{
                        echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
                    }
                }
            }




            
        // Check input errors before inserting in database
        if(empty($menu_name_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO creation_menu (id_user,menu_type,name,aliment1,quantity1,aliment2,quantity2,aliment3,quantity3) VALUES (?,?,?,?,?,?,?,?,?)";
            
            if($stmt = $DB->getDb()->prepare($sql)){
                
                // Set parameters
                $aliment_name1 = trim($_POST["aliment1"]);
                $aliment_name2 = trim($_POST["aliment2"]);
                $aliment_name3 = trim($_POST["aliment3"]);

                $quantity1 = trim($_POST["quantity1"]);
                $quantity2 = trim($_POST["quantity2"]);
                $quantity3 = trim($_POST["quantity3"]);

                $menu_type = trim($_POST["menu_type"]);

                if(empty($aliment_name1)){
                    $aliment_name1 = "none";
                }
                if(empty($quantity1)){
                    $quantity1 = "0";
                }
                if(empty($aliment_name2)){
                    $aliment_name2 = "none";
                }
                if(empty($quantity2)){
                    $quantity2 = "0";
                }
                if(empty($aliment_name3)){
                    $aliment_name3 = "none";
                }
                if(empty($quantity3)){
                    $quantity3 = "0";
                }

                
                
                // Attempt to execute the prepared statement
                if($stmt->execute(array($id_user,$menu_type,$menu_name,$aliment_name1,$quantity1,$aliment_name2,$quantity2,$aliment_name3,$quantity3))){
                    // Redirect to login page
                unset($_POST);
                $message_succes ="Le menu a bien été ajouté !";
                

                } else{
                    echo "Il y a eu un problème.Veuillez essayer plus tard.";
                }
            }
        }
    }
}
$menu_bdd = $DB->query('SELECT * FROM creation_menu WHERE id_user = ?',array($id_user));
$stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));
?>

<section id="addbdd" class="py-5 col">
    <div class="container-fluid">
            <div class="container ">
                <div class="rounded shadow p-5">
                    <h2 class="text-center pb-3">Ajoute ton repas !</h2>
                    <div class="row">
                        <div class="dropdown  col-auto ml-auto py-2">
                            <a class="  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Menu déja ajouté
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php foreach ($menu_bdd as $id):?>
                                <a class="dropdown-item" href="#"><?= $id->name;?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($message_succes){?>
                        <div class="alert alert-success" role="alert">
                        <?= $message_succes;?>
                        </div>
                        <?php }?>
                    
                        <form action="add_menu.php" method="post">
                        <div class=" py-3 ">
                            <label >Type de repas :</label>
                            <select name="menu_type" class="form-control">
                                <option  value="Petit déjeuner">Petit déjeuner</option>
                                <option value="Collation">Collation </option>
                                <option value="Déjeuner">Déjeuner </option>
                                <option value="Diner">Diner </option>
                            </select>
                        </div>
                        <div class=" py-3 pb-5">
                            <label >Nom de mon menu :</label>
                            <input type="text" name="menu_name" class="form-control <?php echo (!empty($menu_name_err)) ? 'is-invalid' : ''; ?>"  placeholder="Poulet Broccolis + Riz">
                                <span class="help-block text-danger "><?php echo $menu_name_err; ?></span>
                        </div>
                        <div class="row ">
                            <div class="col ">
                            <label >Aliment :</label>
                            <select type="text" name="aliment1" class="form-control <?php echo (!empty($aliment_name_err)) ? 'is-invalid' : ''; ?>"  placeholder="Poulet">
                                <?php foreach ($stock_bdd as $id):?>
                                    <option value="<?=$id->aliment_name;?>"><?=$id->aliment_name;?></option>
                                <?php endforeach ?>
                            
                            </select>
                                <span class="help-block text-danger "><?php echo $aliment_name_err; ?></span>
                            </div>
                            <div class="col">
                            <label >Quantité en gramme :</label>
                            <input type="number" name="quantity1" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  placeholder="250 g">
                               
                            </div>
                            
                        </div>
                        <div class="row pt-5">
                            <div class="col ">
                            <select type="text" name="aliment2" class="form-control <?php echo (!empty($aliment_name_err)) ? 'is-invalid' : ''; ?>"  placeholder="Aliment">
                                <?php foreach ($stock_bdd as $id):?>
                                    <option value="<?=$id->aliment_name;?>"><?=$id->aliment_name;?></option>
                                <?php endforeach ?>                           
                            </select>
                                <span class="help-block text-danger "><?php echo $aliment_name_err; ?></span>
                            </div>
                            <div class="col">
                            <input type="number" name="quantity2" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  placeholder="Quantité">
                                <span class="help-block text-danger "><?php echo $quantity_err; ?></span>
                            </div>
                            
                        </div>
                        <div class="row pt-5">
                            <div class="col ">
                            <select type="text" name="aliment3" class="form-control <?php echo (!empty($aliment_name_err)) ? 'is-invalid' : ''; ?>"  placeholder="Aliment">
                                <?php foreach ($stock_bdd as $id):?>
                                    <option value="<?=$id->aliment_name;?>"><?=$id->aliment_name;?></option>
                                <?php endforeach ?>                           
                            </select>
                                <span class="help-block text-danger "><?php echo $aliment_name_err; ?></span>
                            </div>
                            <div class="col">
                            <input type="number" name="quantity3" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  placeholder="Quantité">
                                <span class="help-block text-danger "><?php echo $quantity_err; ?></span>
                            </div>
                            
                        </div>
                        <?php if($quantity_err){ ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $quantity_err; ?>
                        </div>
                        <?php }; ?>
                        <div class="row py-3">
                            <div class="col-auto mx-auto">
                                <button type="submit" class="btn btn-primary ">Ajoutez le menu</button>
                            </div>
                        </div>
                        
                    </form>
                    
                </div> 
        </div>
    </div>
</section>






<?php require 'elements/footer.php';?>
