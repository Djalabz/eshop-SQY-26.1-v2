<?php 

class Animal {
    // Les props avec leur portées, ici public
    public $type;
    public $color;
    public $name;
    public $age;
    private $adress;

    // Ici notre fonction dite de constructor qui s'éxecute automatiquement lors de l'instanciation de la classe
    // Elle vient lier les paramètres que l'on fournit lors de l'instanciation aux props définies au début de ma classe
    public function __construct($type, $color, $name, $age) {
        $this->type = $type;
        $this->color = $color;
        $this->name = $name;
        $this->age = $age;
    }

    // Je définis une méthode statique attack(). 
    // Je pourrais l'utiliser sur la classe directement sans instancier celle-ci 
    static function attack() {
        echo "Animal attacks !";
    }

    public function eat($food) {
        echo "Le $this->type de couleur $this->color mange $food";
    }

    abstract function run();
}

$lion = new Animal("Félin", "jaune", "Simba", "12");

// J'appel une méthode statique cad directement sur la classe
Animal::attack();

echo $lion->type; // Va afficher "félin"
echo "<br>";
$lion->eat("le zèbre"); // Va afficher le félin jaune mange le zèbre

// Cette classe est un enfant de Animal (elle hérite des propriétés et méthodes de portée public, protected)
class Mammal extends Animal {

}




?>
