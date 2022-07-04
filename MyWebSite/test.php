<?php

require 'elements/header.php';

if(isset($_FILES['file'])){
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    $tabExtension = explode('.', $name);
    $extension = strtolower(end($tabExtension));

    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $maxSize = 40000000;

    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){

        $uniqueName = uniqid('', true);
        //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
        $file = $uniqueName.".".$extension;
        //$file = 5f586bf96dcd38.73540086.jpg

        move_uploaded_file($tmpName, './upload/'.$file);

        //$req = $db->prepare('INSERT INTO file (name) VALUES (?)');
        //$req->execute([$file]);

        echo "Image enregistrée";
    }
    else{
        echo "Une erreur est survenue";
    }
}

debug($_POST);
debug($_FILES);

?>

<h2>Ajouter une image</h2>
    <form action="test.php" method="POST" enctype="multipart/form-data">
    
        <label for="file">Fichier</label>
        <input type="file" name="file">

        <button type="submit">Enregistrer</button>
    </form>




<?php require 'elements/footer.php';?>
