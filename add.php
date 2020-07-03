<?php
session_start();

if($_POST){
    if(isset($_POST['produits']) && !empty($_POST['produits'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){

        require_once('connect.php');

        //nettoyage des données
        $produit = strip_tags($_POST['produits']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'INSERT INTO articles (produits, prix, nombre ) VALUES (:produit, :prix, :nombre);';
        $query = $db->prepare($sql);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message'] = "Le produit a été ajouté";
        require_once('close.php');

        header('Location: index.php');
        
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}



?>

<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Produits</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="#">Ajouter</a>
    </div>
  </div>
</nav>
  </head>
  <body>
    <main class="container">
        <div class="row">
            <section class="col-12"><br><br>
            <?php 
                    if(!empty($_SESSION['erreur']))
                    {
                       echo '<div class="alert alert-danger" role="alert"> '. $_SESSION['erreur'] .'</div>';
                       $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Ajouter un produit : </h1>
                <br>
                <form method="post">
                    <div class="form-group">
                        <label for="produits">Produit</label>
                        <input type="text" id="produits" name="produits" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="produit">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Stock</label>
                        <input type="number" id="nombre" name="nombre" class="form-control">
                    </div>
                    <button class="btn btn-outline-success">Valider</button>
                </form>
            </section>
        </div>  
    </main>
  </body>
</html>