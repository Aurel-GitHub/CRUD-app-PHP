<?php
session_start();



//VERIFICATION DE L'EXISTENCE DE L'ID
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    //on nettoie l'id envoyé contre mauvaise manip des users
    $id = strip_tags($_GET['id']);//suppression des balises de l id

    $sql = 'SELECT * FROM articles WHERE id = :id;'; //insertion de l' id

    //prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres (id)

    $query->bindValue(':id', $id, PDO::PARAM_INT);//bind.. associe une valeur à un paramètre PDO::PARAM_INT pour forcer l'id à etre un entier

    //On execute la requte
    $query->execute();

    //On affiche le produit
    $produit = $query->fetch();//on recup qu un pdt

    //on vérifie si le pdt existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet ID n'existe pas";
    header('Location: index.php');
    }

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php'); //redirection vers index en cas d'erreur id dans l'url
}

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['produits']) && !empty($_POST['produits'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){

        require_once('connect.php');

        //nettoyage des données
        $produit = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produits']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'UPDATE articles SET produits =:produits, prix =:prix, nombre =:nombre WHERE id=:id;';

        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produits', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['message'] = "Le produit a été modifié";
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
      <a class="nav-item nav-link" href="add.php">Ajouter</a>
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
                <h1>Modifier un produit : </h1>
                <br>
                <form method="post">
                    <div class="form-group">
                        <label for="produits">Produit</label>
                        <input type="text" id="produits" name="produits" class="form-control" value="<?= $produit['produits'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control" value="<?= $produit['prix'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Stock</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre'] ?>">
                    </div>
                    <input type="hidden" value="<?= $produit['id'] ?>" name="id">
                    <button class="btn btn-outline-success">Valider</button>
                </form>
            </section>
        </div>  
    </main>
  </body>
</html>