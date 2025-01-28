<?php 

ob_start();

include "partials/header.php";
include "config/db.php";

// AJOUT D'UN USER VIA LE SIGNUP

// 1) On vérifie que le form ait été soumis avec la méthode POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {

  // 2) On vérifie que les champs soient tous remplis
  if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm-password"])) {

    // 3) On vérirife que les mdp soient les memes (sinon on affiche une erreur)
    if ($_POST["password"] === $_POST["confirm-password"]) {

      $email = $_POST["email"];
      $username = $_POST["username"];
      $password = $_POST["password"];

      // 4) Vérification de la forme de l'email 
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

          // 5) On annule les potentiels caractères spéciaux liés au HTML
          $username = htmlspecialchars($username);        

          // 6) On vient vérifier que le user n'existe pas déjà, via son email
          $sql = "SELECT * FROM users WHERE email = ?";
          
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$email]);
          $user = $stmt->fetch();

          // Si il existe déjà un user avec cet email on affiche un message d'erreur 
          // Sinon on enregistre le nouveau user en BDD 
          if ($user) {
            $error = "Il semble que l'email existe déjà en BDD";
          } else {
            // On crée le hash avant d'enregistrer les infos en BDD
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(email, username, password_hash) VALUES(?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $username, $hash]);

            header("Location: login.php");

            ob_flush();
            die();
          }
      } else {
        $error = "Email au mauvais format";
      }
    } else {
      $error = "Attention les mdp sont différents";
    }
  } else {
    $error = "Veuillez remplir tous les champs";
  }
}?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-10 w-auto" src="assets/whale.webp" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Inscrivez-vous sur le site</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <form class="space-y-6" action="#" method="POST">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
        <div class="mt-2">
          <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <label for="username" class="block text-sm/6 font-medium text-gray-900">Username</label>
        <div class="mt-2">
          <input type="username" name="username" id="username" autocomplete="username" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
        </div>
        <div class="mt-2">
          <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
        <div class="flex items-center justify-between">
          <label for="confirm-password" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
        </div>
        <div class="mt-2">
          <input type="password" name="confirm-password" id="confirm-password" autocomplete="confirm-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <input type="submit" name="submit" value="Signup" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
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
