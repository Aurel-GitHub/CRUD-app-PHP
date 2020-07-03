<?php
session_start();

if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    $id = strip_tags($_GET['id']);//suppression des balises de l id

    $sql = 'SELECT * FROM articles WHERE id = :id;'; //insertion de l' id

    $query = $db->prepare($sql);


    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $produit = $query->fetch();

    if(!$produit){
        $_SESSION['erreur'] = "Cet ID n'existe pas";
    header('Location: index.php');
    die();
    }

    $sql = 'DELETE FROM articles WHERE id = :id;'; 

    $query = $db->prepare($sql);


    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();
    $_SESSION['message'] = "Le produit a bien été supprimé";
    header('Location: index.php');


}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php'); 
}

?>
