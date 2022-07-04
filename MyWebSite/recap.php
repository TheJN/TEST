<?php 

require 'elements/nav.php';

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Prepare an insert statement
        $sql = "DELETE FROM food_stock WHERE id = ?";
         
        if($stmt = $DB->getDb()->prepare($sql)){
            
            $aliment_id = $_POST['aliment_id'];
            // Attempt to execute the prepared statement
            if($stmt->execute(array($aliment_id))){
                // Redirect to login page
               unset($_POST);
               

            } else{
                echo "Il y a eu un problème.Veuillez essayer plus tard.";
            }
        }
    
}

$id_user= $_SESSION['id'];

$stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));

?>




<section id="Main" class="py-5 col ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto mx-auto">
                <div class="container-fluid text-center">
                    <h1 class="text-primary">Récapitulatif de l'inventaire</h1>
                </div>
                
            </div>
        </div>
        <div class="container-fluid py-5" >
            <div class="shadow rounded ">
                <table class="table bg-white text-center">
                    <thead>
                        <tr>
                        <th scope="" ></th>
                            <th scope="col">Aliments</th>
                            <th scope="col">Quantité en gramme</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stock_bdd as $id):?>
                        
    
                        <tr>
                            <th scope="row" class="col-1">
                                <form action="recap.php" method="post">
                                    <input type="hidden" type="text" name="aliment_id" class=""   value="<?=$id->id?>">
                                    <button type="submit" class="btn btn-link text-danger float-left"><i class="bi bi-trash "></i></button>
                                </form>
                            </th>
                            <td  >
                                <?= $id->aliment_name;?>
                            </td>
                            <td ><?php echo($id->quantity); if ($id->quantity>10){echo('g');}?></td>
                            <td> 
                                <div class="progress ">
                                    <div class="progress-bar progress-bar-striped <?php progress($id->quantity,$id->quantity_reference);?>" role="progressbar" style="width: <?php echo(($id->quantity)/($id->quantity_reference)*100);?>%" ></div>
                                </div>
                            </td>
                        </tr>
                            <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>







<?php require 'elements/footer.php';?>
