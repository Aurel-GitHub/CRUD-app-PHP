<?php
//démarrage de la session
session_start();

//si l'id existe et si il n est pas vide
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
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
  </div>
</nav>
  </head>
  <body>
  <br>
    <main class="container">
        <div class="row">
        <section class="col-12">
            <h1>Détails du produit : <?= $produit['produits']?></h1>
            <p>ID: <?= $produit['id']?><p>
            <p>Prix: <?= $produit['prix']?><p>
            <p>Nombre en stock : <?= $produit['nombre']?><p>
            <p><a href="edit.php?id=<?= $produit['id'] ?>">Modifier</p>



        </section>
        </div>
    </main>
  </body>
</html>