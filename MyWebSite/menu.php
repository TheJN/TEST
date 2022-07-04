<?php 

require 'elements/nav.php';
$id_user = $_SESSION['id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(!empty($_POST['menu_id'])){
        // Prepare an insert statement
        $sql = "DELETE FROM creation_menu WHERE id = ? AND id_user = ?";
            
        if($stmt = $DB->getDb()->prepare($sql)){
            
            $menu_id = $_POST['menu_id'];
            
            // Attempt to execute the prepared statement
            if($stmt->execute(array($menu_id,$id_user))){
                // Redirect to login page
            unset($_POST['menu_id']);
            

            } else{
                echo "Il y a eu un problème.Veuillez essayer plus tard.";
            }
        }
    }
    

}
$menu_bdd = $DB->query('SELECT * FROM creation_menu WHERE id_user = ?',array($id_user));
$stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));


 // Define variables and initialize with empty values
$aliment1 = $aliment2 = $quantity1 = $quantity2 = "";



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // MAJ du stock
    foreach ($stock_bdd as $id){
        
        if(strtolower($_POST['aliment1'])==strtolower($id->aliment_name)){
            $new_quantity = $id->quantity - $_POST['quantity1']  ;
            $aliment_name = $id->aliment_name;
            

        }elseif(strtolower($_POST['aliment2'])==strtolower($id->aliment_name)){
            $new_quantity = $id->quantity - $_POST['quantity2']  ;
            $aliment_name = $id->aliment_name;
        
        }elseif(strtolower($_POST['aliment3'])==strtolower($id->aliment_name)){
            $new_quantity = $id->quantity - $_POST['quantity3']  ;
            $aliment_name = $id->aliment_name;
            
        }

        if(!empty($new_quantity) && !empty($aliment_name)){

            // Prepare an insert statement
            $sql = "UPDATE food_stock SET quantity=? WHERE aliment_name=? AND id_user = ?";
            
            if($stmt = $DB->getDb()->prepare($sql)){
                
                // Set parameters
                $param_quantity = $new_quantity;
                $param_aliment_name = $aliment_name;
                
                
                // Attempt to execute the prepared statement
                if($stmt->execute(array($param_quantity,$param_aliment_name,$id_user))){
                    // Redirect to login page
                
                } else{
                    echo "Il y a eu un problème.Veuillez essayer plus tard.";
                }
            }
        }
        $new_quantity = $aliment_name ="";

    }   

    // ADD BDD historic menu 
        // Prepare an insert statement


        $sql = "INSERT INTO historic_menu (id_user,menu_type,menu_name,aliment1,quantity1,aliment2,quantity2,aliment3,quantity3) VALUES (?,?,?,?,?,?,?,?,?)";
         
        if($stmt = $DB->getDb()->prepare($sql)){
            
            // Set parameters
            $aliment1 = $_POST['aliment1'];
            $aliment2 = $_POST['aliment2'];
            $quantity1 = $_POST['quantity1'];
            $quantity2 = $_POST['quantity2'];
            $quantity3 = $_POST['quantity3'];
            $aliment3 = $_POST['aliment3'];
            $menu_name = $_POST['menu_name'];
            $menu_type =$_POST['menu_type'];
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute(array($id_user,$menu_type,$menu_name,$aliment1,$quantity1,$aliment2,$quantity2,$aliment3,$quantity3))){
                // Redirect to login page
               unset($_POST);
            } else{
                echo "Il y a eu un problème.Veuillez essayer plus tard.";
            }
        }
    
}


$tab_menutype = ['Petit déjeuner','Déjeuner','Diner','Collation'];


?>

<section id="Main" class="py-5 col">
    <div class="container-fluid">
        <div class="container-fluid bg-light text-center py-5">
            <h2>Choisis ton menu</h2>
        </div>

        <?php foreach ($tab_menutype as $type): ?>
            <div class="container bg-primary rounded shadow text-center my-3 py-3">
                    <h3><a class="btn btn-light " data-toggle="collapse" href="#<?=str_replace(" ","",$type)?>" role="button" aria-expanded="true" aria-controls="<?=str_replace(" ","",$type)?>"><?=$type?></a></h3>
                </div>
        <div class="container-fluid  my-3 collapse" id="<?=str_replace(" ","",$type)?>">
            <div class="row py-5 " >
            

        <?php foreach($menu_bdd as $id): 

                if($id->menu_type==$type){ ?>


                <div class="col-auto mx-auto py-lg-0 py-3 ">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="img/bootsrap.svg" alt="Card image cap">
                        <div class="card-body ">
                            <form action="menu.php" method="post">
                            <input type="hidden" type="text" name="menu_type" class="" value="<?= $id->menu_type?>">
                            <input type="hidden" type="text" name="menu_name" class="" value="<?= $id->name?>">
                                <h5 class="card-title text-center"><?= $id->name?></h5>
                                <p class="card-text">Ingredients :
                                <ul>
                                    <input type="hidden" type="text" name="aliment1" class=""   value="<?= $id->aliment1?>">
                                    <input type="hidden" type="number" name="quantity1" class=""   value="<?= $id->quantity1?>">
                                    <li><?php echo($id->quantity1); if ($id->quantity1>10){echo('g');}?> <?= $id->aliment1?></li>

                                    <input type="hidden" type="text" name="aliment2" class=""   value="<?= $id->aliment2?>">
                                    <input type="hidden" type="number" name="quantity2" class=""   value="<?= $id->quantity2?>">
                                    <li><?php echo($id->quantity2); if ($id->quantity2>10){echo('g');}?> <?= $id->aliment2?></li>
                                    
                                    <input type="hidden" type="text" name="aliment3" class=""   value="<?= $id->aliment3?>">
                                    <input type="hidden" type="number" name="quantity3" class=""   value="<?= $id->quantity3?>">
                                    <li><?php echo($id->quantity3); if ($id->quantity3>10){echo('g');}?> <?= $id->aliment3?></li>
                                </ul>
                                </p>
                                <div class="text-center">
                                 <button type="submit" class="btn btn-primary ">Miam</button>
                                </div>
                            </form>
                            <form action="menu.php" class="mt-3" method="post">
                                    <input type="hidden" type="text" name="menu_id" class=""   value="<?=$id->id?>">
                                    <button type="submit" class="btn btn-link text-danger float-right btn-sm ">Supprimer</button>
                                </form>
                            
                        </div>
                    </div>
                </div>
                <?php } 
                endforeach ;?>
            </div>
        </div>

       <?php  endforeach ?>
    </div>
</section>





<?php require 'elements/footer.php';?>
