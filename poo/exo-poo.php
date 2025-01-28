<?php 

// EXERCICE POO

// 1) Vous allez créer la classe User 
// 2) Dans cette classe on souhaite les props suivantes : 

//    - id qui sera de portée protected - int
//    - email avec une portée privée - string
//    - username avec une portée publique - string
//    - password de portée privée - string
//    - loggedIn de portée publique - boolean - cette propriété par défaut = false

// Vous coderez la méthode construct sans la propriété loggedIn ayant une valeur par défaut déjà définie. 

// 3) Vous allez créer une méthode login() publique qui affichera "Username a été login avec succès" 
// et elle modifiera la propriété loogedIn qui passe de false à true. Sauf si loggedIn est déjà égale 
// à true auquel cas on retourne un message "username est déjà logged in". Cette méthode ne retourne rien 
//
// 4) Je veux accéder à l'email hors de ma classe et pouvoir le modifier malgré sa portée (sans changer celle-ci). 
// Trouver une solution :)

// BONUS : coder la méthode logout qui passe loggedIn de true à false. Elle vérifie que le user soit login 
// sinon elle arffiche un message de type "Vous etes déjà logout".

class User {
    // déclaration des props
    protected int $id;
    private string $email;
    public string $username;
    private string $password;
    public bool $loggedIn = false;

    // Fonction de type constructor
    public function __construct($id, $email, $username, $password) {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    // Méthode de login 
    public function login() : void {
        // Si il est connecté alors message d'erreur
        if ($this->loggedIn) { 
            echo "$this->username est déjà connecté";
        // Sinon on passe loggedIn à true et on affiche un message de confirmation
        } else {
            echo "$this->username a été login avec succès";
            $this->loggedIn = true;
        }
    }

    // Afin d'afficher et changer la valeur d'un eprop private on peut mettre en place des Getter et des Setter
    // Ci-dessous le Getter
    public function getMail() : string {
        return $this->email;
    }  

    // Ci-dessous le Setter 
    public function setMail(string $mail) : string {
        $this->email = $mail;
        return $this->email;
    }

    public function logout() : void {
        if ($this->loggedIn == false) {
            echo "$this->username est déjà logout";
        } else {
            echo "$this->username est désormais logout";
            $this->loggedIn = false;
        }
    }
}

$jojo = new User(1, "jojo@gmail.com", "Jojo la terreur", "1234");

echo $jojo->getMail(); // censé retourner le mail 
echo "<br>";
$jojo->setMail("jojo@wanadoo.fr"); 
echo "<br>";
echo $jojo->getMail();
