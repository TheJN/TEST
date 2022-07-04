<?php 

require 'elements/nav.php';

$id_user = $_SESSION['id'];
$message_succes ="";
// Define variables and initialize with empty values
$aliment_name = $quantity = $quantity_ref= "";
$aliment_name_err = $quantity_err = $quantity_ref_err ="";

if (isset($_SESSION['id'])){
  
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Validate aliment_name
        if(empty(trim($_POST["aliment_name"]))){
            $aliment_name_err = "Veuillez entrez un aliment.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM food_stock WHERE aliment_name = ? AND id_user = ?";

            if($stmt = $DB->getDb()->prepare($sql)){
                $param_aliment_name = trim($_POST["aliment_name"]);
                $id_user = $_SESSION['id'];
                // Attempt to execute the prepared statement
                if($stmt->execute(array($param_aliment_name,$id_user))){
                    if (!empty($data = $stmt->fetchAll())) {
                        
                        $aliment_name_err = "Cet aliment a déja été ajouté.";
                    }else{
                        $aliment_name = trim($_POST["aliment_name"]);
                    }
                } else{
                    echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
                }
            }
        }
        

        // Validate quantity 

        if(empty(trim($_POST["quantity"]))){
            $quantity_err = "Veuillez entrez une quantité.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM food_stock WHERE quantity = ?";

            if($stmt = $DB->getDb()->prepare($sql)){
                $param_quantity = trim($_POST["quantity"]); 
                // Attempt to execute the prepared statement
                if($stmt->execute(array($param_quantity))){
                            $quantity = $_POST["quantity"];
                } else{
                    echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
                }
            }
        }

        // Validate quantity ref

        if(empty(trim($_POST["quantity_ref"]))){
            $quantity_ref_err = "Veuillez entrez une quantité.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM food_stock WHERE quantity_reference = ?";

            if($stmt = $DB->getDb()->prepare($sql)){
                $param_quantity_ref = trim($_POST["quantity_ref"]); 
                // Attempt to execute the prepared statement
                if($stmt->execute(array($param_quantity_ref))){
                            $quantity_ref = $_POST["quantity_ref"];
                } else{
                    echo "Oops! Il y a eu problème. Veuillez réessayer plus tard s'il-vous-plait.";
                }
            }
        }
            
        // Check input errors before inserting in database
        if(empty($aliment_name_err) && empty($quantity_err) && empty($quantity_ref_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO food_stock (id_user,aliment_name,quantity,quantity_reference) VALUES (?,?, ?,?)";
            
            if($stmt = $DB->getDb()->prepare($sql)){
                
                // Set parameters
                $id_user = $_SESSION['id'];
                $param_quantity = $quantity;
                $param_aliment_name = $aliment_name;
                $param_quantity_ref=$quantity_ref;
                
                // Attempt to execute the prepared statement
                if($stmt->execute(array($id_user,$param_aliment_name,$param_quantity,$param_quantity_ref))){
                    // Redirect to login page
                unset($_POST);
                $message_succes ="L'aliment a bien été ajouté !";
                } else{
                    echo "Il y a eu un problème.Veuillez essayer plus tard.";
                }
            }
        }
    }
}
$stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));
?>



<div class="col-md-8 mx-auto mt-5">
    <div class="card  shadow rounded">
        <h5 class="card-header text-primary h2 text-center py-3">Ajout au stock <button type="button" class="btn btn-link border-0 float-right" data-toggle="modal" data-target="#Information"><i class="fa-solid fa-circle-info fa-2x"></i>
</button></h5>
            <div class="card-body">
                <div class="container ">
                    <div class="p-5">
                        <?php if ($message_succes){?>
                                <div class="alert alert-success" role="alert">
                                <?= $message_succes;?>
                                </div>
                        <?php }?>

                        <form action="add_stock.php" method="post">
                            <div class="row ">
                                <div class="col-md my-md-0 my-3">
                                    <label for="">Nom de l'aliment</label>
                                <input type="text" name="aliment_name" class="form-control <?php echo (!empty($aliment_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $aliment_name; ?>" placeholder="Brocolis">
                                    <span class="help-block text-danger "><?php echo $aliment_name_err; ?></span>
                                </div>
                                <div class="col-md my-md-0 my-3">
                                <label for="">Quantité à ajouter (en gramme)</label>
                                <input type="number" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  placeholder="200">
                                    <span class="help-block text-danger "><?php echo $quantity_err; ?></span>
                                </div>
                                <div class="col-md my-md-0 my-3">
                                    <label for="">Quantité réference (en gramme) </label>
                                <input type="number" name="quantity_ref" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>"  placeholder="1000">
                                    <span class="help-block text-danger "><?php echo $quantity_err; ?></span>
                                </div>
                                
                            </div>
                            <div class="row pt-5">
                                <div class="col-auto mx-auto ">
                                    <button type="submit" class="btn btn-primary  ">Ajoutez</button>
                                </div>
                            </div>
                            
                            
                        </form>
                        <div class="dropdown py-5">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aliments déja ajouté
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach ($stock_bdd as $id):?>
                            <a class="dropdown-item" href="#"><?= $id->aliment_name;?></a>
                            <?php endforeach ?>
                        </div>
                    </div>
                    </div> 
                </div>
            </div>
    </div>
</div>


    
<!-- Modal -->
<div class="modal fade" id="Information" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-primary " id="Information_title">Informations</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Le but de cette page est de ....</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ca marche !</button>
      </div>
    </div>
  </div>
</div>








<?php require 'elements/footer.php';?>
