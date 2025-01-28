<?php 

include "partials/header.php"

?>


<section class="contact">
    <h1 class="text-center mt-8 mb-8">Page de contact</h1>

    <form class="flex flex-col w-80 mx-auto" action="contact-process.php" method="POST">

        <input class="w-80 border rounded mb-4 p-2" placeholder="Votre username" name="username"  type="text">
        <input class="w-80 border rounded mb-4 p-2" placeholder="Votre email" name="email"  type="email">
        <input class="w-80 border rounded mb-4 p-2" placeholder="Le sujet du message" name="subject"  type="text">
        <textarea class="w-80 h-40 border rounded mb-4 p-2" placeholder="Votre message ici ..." name="message"  type="text"></textarea>
        <input class="w-80 border rounded mb-4 p-2 bg-slate-300" value="Envoyer le message" name="submit" type="submit">

    </form>

</section>


<?php 
    include "partials/footer.php"
?>
