<?php 

require 'elements/nav.php';
if (isset($_SESSION['id'])){
    $id_user = $_SESSION['id'];

    $stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));




    // Define variables and initialize with empty values
    $aliment_name = $quantity = "";
    $aliment_name_err = $quantity_err = "";


    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        
        
        foreach ($stock_bdd as $id){
            if($_POST['aliment_name']==$id->aliment_name){
                $new_quantity = $_POST['quantity'] + $id->quantity;
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

            
        // Check input errors before inserting in database
        if(empty($quantity_err)){
            
            // Prepare an insert statement
            $sql = "UPDATE food_stock SET quantity=? WHERE aliment_name=? AND id_user = ?";
            
            if($stmt = $DB->getDb()->prepare($sql)){
                
                // Set parameters
                $param_quantity = $new_quantity;
                $param_aliment_name = $_POST['aliment_name'];
                
                
                // Attempt to execute the prepared statement
                if($stmt->execute(array($param_quantity,$param_aliment_name,$id_user))){
                    // Redirect to login page
                unset($_POST);
                } else{
                    echo "Il y a eu un problème.Veuillez essayer plus tard.";
                }
            }
        }
    }
}

?>

<div class="col-md-8 mx-auto mt-5">
    <div class="card  shadow rounded">
        <h5 class="card-header text-primary h2 text-center py-3">Mise à jour du stock <button type="button" class="btn btn-link border-0 float-right" data-toggle="modal" data-target="#Information"><i class="fa-solid fa-circle-info fa-2x"></i>
</button></h5>
            <div class="card-body">
                <div class="container py-5">
                    <form action="maj_stock.php" method="post">
                        <div class="row ">
                            <div class="col-md-auto mx-auto my-md-0 my-3">
                                <label for="">Nom de l'aliment</label>
                            <select name="aliment_name" class="form-control" id="">
                                <?php foreach ($stock_bdd as $id):?>
                                    <option value="<?=$id->aliment_name;?>"><?=$id->aliment_name;?></option>
                                <?php endforeach ?>
                            
                            </select>
                            </div>
                            <div class="col-md-auto mx-auto my-md-0 my-3">
                            <label for="">Quantité à rajouter (en gramme) :</label>
                            <input type="number" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="" placeholder="200">
                                <span class="help-block text-danger "><?php echo $quantity_err; ?></span>
                            </div>
                            
                            <div class="col-auto align-self-end mx-auto   py-md-0 py-3">
                                <button type="submit" class="btn btn-primary ">Ajoutez</button>
                            </div>
                        </div>
                    </form>
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
      <p>Le but de cette page est de faire comme si on venait de faire les courses. Donc on rajoute ce qu'on a acheté. Cela va s'additioner avec le stock qu'on avait déja rempli auparavant.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ca marche !</button>
      </div>
    </div>
  </div>
</div>


<?php require 'elements/footer.php';?>
