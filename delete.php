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
    die();
    }

    $sql = 'DELETE FROM articles WHERE id = :id;'; //insertion de l' id

    //prepare la requete
    $query = $db->prepare($sql);

    //on accroche les parametres (id)

    $query->bindValue(':id', $id, PDO::PARAM_INT);//bind.. associe une valeur à un paramètre PDO::PARAM_INT pour forcer l'id à etre un entier

    //On execute la requte
    $query->execute();
    $_SESSION['message'] = "Le produit a bien été supprimé";
    header('Location: index.php');


}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php'); //redirection vers index en cas d'erreur id dans l'url
}

?>
