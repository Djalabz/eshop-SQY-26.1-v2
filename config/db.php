<?php 

// CONNEXION AVEC PDO
// Fichier permettant de se connecter à la BDD avec PDO via un try et catch

try {
    // TRY : On va essayer de se connecter à la BDD dans ce bloc

    // Data Source Name cad certaines infos concernant ma BDD (le SGBD, nom de la base et nom de l'hote)
    $dsn = "mysql:dbname=eshop;host=localhost";

    // Mes infos de connexion à la BDD
    $user = "root";
    $password = "";

    // On précise des options pour PDO au sein d'un tableau associatif si nécessaire 
    // Ici il s'agit de récupérer les réponses de la BDD sous forme de tableau associatif
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

    // Enfin on vient se connecter avec les infos précédemment déclarées
    $pdo = new PDO($dsn, $user, $password, $options);

    // On affiche un message de confirmation si on est bien connecté
    // echo "Je suis bien connecté à ma BDD !!";

} catch (PDOException $error) {
    // CATCH : Ici on décrit ce qu'il se passe si la connexion échoue pour x ou y raison
    die("Attention erreur lors de la connexion à la BDD :" . $error->getMessage());
}