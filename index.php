<?php 

session_start();

include "partials/header.php"

?>



    
<h1 class="text-center">Bienvenue sur le eShop en PHP <?= $_SESSION["username"] ?> !!</h1>
<h2>Votre email est : <?= $_SESSION["email"] ?></h2>


<?php 
include "partials/footer.php"
?>

