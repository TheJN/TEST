<?php


require 'elements/nav.php';
$id_user = $_SESSION['id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(!empty($_POST['menu_id'])){
        // Prepare an insert statement
        $sql = "DELETE FROM historic_menu WHERE id = ? AND id_user = ?";
            
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

$stock_bdd = $DB->query('SELECT * FROM food_stock WHERE id_user = ?',array($id_user));
$historic_menu = $DB->query('SELECT * FROM historic_menu WHERE id_user = ?',array($id_user));

// YOLO TEST 232332454

?>



<?php 


foreach ($historic_menu as $id => $value):
   
    $years = substr($value->created_at,0,4);
    $months =substr($value->created_at,5,2);
    $days = substr($value->created_at,8,2);


    $hours = substr($value->created_at,11,2);
    $tab_years[]=$years;
    $tab_months[]=$months;
    $tab_days[]=$days;
    $tab_hours[]=$hours;
  
   
     endforeach ;

    $tab_years= array_reverse($tab_years, true);
    $tab_months= array_reverse($tab_months, true);
    $tab_days= array_reverse($tab_days, true);

?>

<div class="col py-5">
    <h2 class="text-center py-2">Historique des repas mangé</h2>

    <div id="accordion">
        <?php 
        foreach ($tab_years as $key => $annee){
            if($tab_years[$key]!=$tab_years[$key-1]){
                
            
                ?>
                
            <div class="card">
                <div class="card-header" >
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$i?>" >
                <?=$annee?>
                </button>
            </h5>
            </div>
                
                <?php foreach($tab_months as $id => $mois) :?>
                    <?php 
                    if($tab_months[$id]!=$tab_months[$id-1]){

                    
                    ?>
                    <div id="collapse<?=$i?>" class="collapse" >
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header" >
                                <h5 class="mb-0">
                                <button class="btn btn-link " data-toggle="collapse" data-target="#collapse2<?=$t?>" >
                                <?=$mois?>
                                </button>
                                </h5>
                                </div>
                                <?php foreach($tab_days as $id => $day) :
                                
                                        if($tab_days[$id]!=$tab_days[$id-1]){?>

       

                                <div id="collapse2<?=$t?>" class="collapse" >
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-header" >
                                            <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3<?=$s?>" >
                                            <?=$day?>
                                            </button>
                                            </h5>
                                            </div>
                                            <div id="collapse3<?=$s?>" class="collapse" >
                                                <div class="row">
                                
                                                    <?php foreach ($historic_menu as $id_bdd => $value_bdd):
                                                    $days_bdd  = substr($value_bdd->created_at,8,2);
                                                    if($days_bdd==$tab_days[$id]){?>
                                                    
                                                    <div class="col-auto mx-auto">
                                                        <div class="card-body">
                                                            <div class="col-auto mx-auto py-lg-0 py-3 ">
                                                                <div class="card" style="width: 18rem;">
                                                                    <img class="card-img-top" src="img/bootsrap.svg" alt="Card image cap">
                                                                    <div class="card-body ">
                                                                        
                                                                            <h5 class="card-title text-center"><?=$historic_menu[$id_bdd]->menu_type?></h5>
                                                                            <h6 class="text-center"><?=$historic_menu[$id_bdd]->menu_name?></h6>
                                                                            <p class="card-text">Ingredients :
                                                                            <ul>
                                                                            <?php if ($historic_menu[$id_bdd]->quantity1!=0){?>
                                                                                <li><?=$historic_menu[$id_bdd]->quantity1?><?php if ($historic_menu[$id_bdd]->quantity1>10){echo(' g');}?> <?=$historic_menu[$id_bdd]->aliment1?></li>            
                                                                                <?php }?>

                                                                                <?php if ($historic_menu[$id_bdd]->quantity2!=0){?>
                                                                                <li><?=$historic_menu[$id_bdd]->quantity2?><?php if ($historic_menu[$id_bdd]->quantity2>10){echo(' g');}?> <?=$historic_menu[$id_bdd]->aliment2?></li>                                   
                                                                                <?php }?>
                                                                                
                                                                                <?php if ($historic_menu[$id_bdd]->quantity3!=0){?>
                                                                                <li><?=$historic_menu[$id_bdd]->quantity3?><?php if ($historic_menu[$id_bdd]->quantity3>10){echo(' g');}?> <?=$historic_menu[$id_bdd]->aliment3?></li>
                                                                                  <?php }?>
                                                                                    
                                                                            </ul>
                                                                            </p>

                                                                            <form action="historic.php" class="mt-3" method="post">
                                                                                <input type="hidden" type="text" name="menu_id" class=""   value="<?=$historic_menu[$id_bdd]->id?>">
                                                                                <button type="submit" class="btn btn-link text-danger float-right btn-sm ">Supprimer</button>
                                                                            </form>
                                                                            
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php  }
                                                    endforeach;?>
                                                    
                                                </div>
                                            </div>
                                        </div>           
                                    </div>
                                </div>
                            <?php } 
                            $s++;
                        endforeach;?>
                            </div>           
                        </div>
                    </div>
                <?php } 
                $t++;
            endforeach;?>
            </div>
            <?php
            }
            $i++;
        }
        
        ?>
    
    </div>

</div>



<?php require 'elements/footer.php';?>
