<?php 

session_start();

//Opdracht1 Create an array, an associative array and an object in home.php. 

//Array
$cars = array("Mazda mx5","Nissan350Z","Toyota Celica","Bmw E30","Audi R8");

//Associative array
$ageArray = array("Rebecca"=>22, "Patricia"=>50, "Rocco"=>54);

//OBject
class Person{
    public function __construct($firstname, $lastname, $age, $city){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->city = $city;

}
}

$me = new person("Deborah","Pizzichillo",26,"Genk");

//For-loop to add different data
for($i = 0; $i < 1; $i++){

//Push new item to cars variable and print result
array_push($cars,'Ford Mustang');
//echo print_r($cars)."<br>";

//Declare new key and value to ageArray variable and print result
$ageArray["Carravagio"] = 39;
//echo print_r($ageArray)."<br>";


//Instantiante new person objes and print result
$Frida = new person("Frida","Kahlo",47,"Mexico");
//echo print_r($MercedesBenz)."<br>";

}

//If statement wich has 20% chance to be executed
if(mt_rand(0,100) <= 20){
    //Variables to hold one random index/key of arrays
    $cars_random = array_rand($cars, 1);
    $ageArray_random = array_rand($ageArray, 1);

//Converts object to array
$arr_Frida = (array)$Frida;
$person_random = array_rand($arr_Frida, 1);

//Changes random index/key value to "edited"
$cars[$cars_random] = "edited";
$ageArray[$ageArray_random] = "edited";
$Frida->$person_random = "edited";

//Call functin to store changes in session
storeChanges($cars, $ageArray, $Frida);

//When executes print message
//echo "<p> DATA UPDATED </p>";

}

function storeChanges($x,$y,$z){
//Store changes to session superglobal 

$_SESSION['array'] = $x;
$_SESSION['assoc'] = $y;
$_SESSION['object'] = $z;

}

// echo print_r($_SESSION['array'])."<br>";
// echo print_r($_SESSION['assoc'])."<br>";
// echo print_r($_SESSION['object'])."<br>";


// 7 Create a class called Blackjack

class blackjack{
  //Let does not work here let is javascript
  //var used instead of let or const

  var $hand = [];
  var $score;
  var $turn = true;

//Hit
  function hit() {
      array_push($this->hand,mt_rand(1,11));
      $this->score = array_sum($this->hand);
  }
//Stand
  function Stand() {
      $this->turn = false;
  }
//Surrender
  function Surrender(){
      $_SESSION['msg'] = "Dealer wins!!";
  }
}
echo "<form action='game.php' methode='POST'><input type='submit' name='play' value='Play Blackjack'/></form>";

?>
