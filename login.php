<?php 

// L'output buffer permet de faire un tampon : il permet d'éxecuter les lignes de code
// ci-dessous seulement une fois que le buffer est "flushed" (vidé) à partir de la commande ob_flush()
ob_start();

include "partials/header.php";
// J'importe db.php afin d'avoir accès à ma variable de connexion $pdo
include "config/db.php";

// Logique du Login / Traitement des infos et envoie à la BDD

// On vient récupérer les infos rentrées dans le form 
// Je m'occupe de les vérifier et de les nettoyer si besoin

// Si il ya eu soumission du form via la méthode POST ...
if (($_SERVER["REQUEST_METHOD"] === "POST") && (isset($_POST["submit"]))) {
  // .. Alors on récupère les infos transmises par le user 

  if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    // Methode 1 pour vérifier l'email : Une REGEX (ou expressiobn régulière)
    // Je vérifie que le mail soit bien un mail et je hash le mdp afin de le comparer ultérieurement 
    // au mdp ptrésent dans la BDD (qui doit etre hashé également)
    $emailRegex = "/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/";
    $email = $_POST["email"];
    
    if (!preg_match($emailRegex, $email)) {
      $error = "l'email n'est pas eu bon format";
    } else {
      $password = $_POST["password"];

    // Methode 2 : la fonction PHP filter_var avec 
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //   $error = "l'email n'est pas eu bon format";
    // } else {
    //   $password = $_POST["password"];
  
      // On vient ici hash le mdp grace à la fonction php password_hash
      // $hash = password_hash($password, PASSWORD_DEFAULT);
      
      // On va utiliser une requete SQL arfin de vérifier que le user existe bien et qe ses infos sont les bonnes
      // Avec les ? à la place des valeurs dynamiques on effectue une requete préparée qui permet d'éviter les injections SQL
      $sql = "SELECT * FROM users WHERE email = ?";
  
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);
      $user = $stmt->fetch();
      
      // Si on recup bien un user avecx la bonne adresse mail
      // Dans ce cas on vérifie que les mdp correspondent bien
      if ($user) {
        // On recup le mdp hashé de la BDD 
        $user_hash = $user["password_hash"];
  
        // On vérifie le mdp avec celui de la BDD
        $checkPassword = password_verify($password, $user_hash);
  
        // Si le mdp correspond on affiche un message de confirmation 
        if ($checkPassword) {
          echo "Le user correspond bien à celui de la BDD";
  
          // Une fois login je démarre une session (un cookie de session va automatiquement etre crée suite à cette ligne)
          session_start();

          // J'ajoute au tableau $_SESSION les infos user que je récupère de la BDD
          $_SESSION = $user;

          // Je redirige vers la home page 
          header("Location: index.php");
          
          // On éxecute l'ensemble du code d'un coup, code écrit après ob_start()
          ob_flush();
  
        } else {
          $error = "Le mdp ne correspond pas";
        }
      }
    }

    } else {
      $error = "Aucun utilisateur trouvé avec cette email";
    }
  } else {
    $error = "Veuillez remplir tous les champs ..";
}


?>


<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-32 w-auto" src="assets/whale.webp" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Page de login</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <form class="space-y-6" action="#" method="POST">

      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
        <div class="mt-2">
          <input type="text" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <input value="Soumettre" name="submit" type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      </div>
    </form>

    <!-- On affiche l'erreur si elle existe  -->
    <?php if (isset($error)) : ?>

      <h3><?= $error ?></h3>

    <?php endif ?> 

  </div>
</div>


<?php 
include "partials/footer.php"
?>
