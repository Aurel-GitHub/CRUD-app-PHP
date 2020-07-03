<?php
session_start();

//co à la base
require_once('connect.php');

$sql ='SELECT * FROM articles';

//preparation de la requete
$query = $db->prepare($sql);

//on execute la requete
$query->execute();

//stockage des données dans un tableau
$result = $query->fetchAll(PDO::FETCH_ASSOC);//que des resultats avec les titres des différentes colonnes

require_once('close.php');

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
  <a class="navbar-brand" href="#">Produits</a>
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
            <section class="col-12"><br>
                <?php 
                    if(!empty($_SESSION['erreur']))
                    {
                       echo '<div class="alert alert-danger" role="alert"> '. $_SESSION['erreur'] .'</div>';
                       $_SESSION['erreur'] = "";
                    }
                ?>
                <?php 
                    if(!empty($_SESSION['message']))
                    {
                       echo '<div class="alert alert-success" role="alert"> '. $_SESSION['message'] .'</div>';
                       $_SESSION['message'] = "";
                    }
                ?>
            <br><h1>Liste un produit</h1><br>
            <table class="table">
                <thead> 
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Nombre</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php
                    //on boucle sur la variable result pour parcourir et afficher le tableau
                        foreach($result as $produit)
                        {
                        ?>
                            <tr>
                                <td><?= $produit['id']?></td>
                                <td><?= $produit['produits']?></td>
                                <td><?= $produit['prix']?></td>
                                <td><?= $produit['nombre']?></td>
                                <td>
                                  <a href="details.php?id=<?= $produit['id']?>">Voir</a>
                                  <a href="edit.php?id=<?= $produit['id']?>">Modifier</a>
                                </td>
                                
                            </tr>
                        <?php
                        }
                        ?>
                </tbody>
            </table>    
            </section>
        </div>
    </main>
  </body>
</html>