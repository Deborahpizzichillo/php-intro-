<?php
// Require page with Blackjack class once
require_once('home.php');
// If the session variable for the player is not yet created, the class will be instantiated for the player and dealer variables
if(!isset($_SESSION['player'])) {
    $player = new Blackjack;
    $dealer = new Blackjack;
    // The data of the objects will be serialized and stored into the session variables
    $_SESSION['player'] = serialize($player);
    $_SESSION['dealer'] = serialize($dealer);
}
// The data will be unserialized from the session variables with each script refresh, so the objects will be accessable again
$player = unserialize($_SESSION['player']);
$dealer = unserialize($_SESSION['dealer']);
// If the player is still in turn but has an empty hand, 2 cards will be given with the Hit method
if($player->turn == true && $player->hand == null){
    for($i = 0; $i < 2; $i++){
        $player->Hit();
    }
    // If the score of the two first cards equals 21, player has Blackjack and wins the game
    if($player->score == 21){
        $_SESSION['msg'] = "Blackjack! You win!";
        session_destroy();
    }
    // New object data will be serialized and stored in session variable
    $_SESSION['player'] = serialize($player);
}
// If player is still in turn and hits the hit button a card will be added to his hand. Data will be serialized and stored in session variable
if(isset($_POST['hit']) && $player->turn == true){
    $player->Hit();
    $_SESSION['player'] = serialize($player);
}
// If player hits stand button his turn will end and dealer will hit until his score is higher than 15
if(isset($_POST['stand'])){
    $player->Stand();
    $_SESSION['player'] = serialize($player);
    do{
        $dealer->Hit();
    } while($dealer->score < 15);
    // Dealer will eventually end his turn. New object data will be serialized and stored in session variable
    $dealer->Stand();
    $_SESSION['dealer'] = serialize($dealer);
}
// If player hits surrender button a message will tell him he lost and will show what would be the dealer's hand
if(isset($_POST['surrender'])){
    $player->Surrender();
    for($i = 0; $i < 2; $i++){
        $dealer->Hit();
    }
    session_destroy();
}
// Game scenarios / Game rules
if($player->score > 21) {
    // If player's score exceeds 21 player loses the game
    $_SESSION['msg'] = "You lost!";
    session_destroy();
} elseif($dealer->score > 21) {
    // If dealer's score exceeds 21 player wins the game
    $_SESSION['msg'] = "You won the game!";
    session_destroy();
} elseif($player->turn == false && $dealer->turn == false) { 
    // When both the player and dealer have ended their turn
    if($player->score <= $dealer->score){
    // If player's score is smaller of equal to dealer's score, player loses the game
    $_SESSION['msg'] = "You lost! The dealer wins this game.";
    session_destroy();
} else {
    // Otherwise player's score is greater than dealer's score and player wins the game
    $_SESSION['msg'] = "You won the game!";
    session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Blackjack GAME</title>
</head>

<body>
    <p>Your hand: <?php foreach($player->hand as $value){echo $value." ";} ?></p>
    <p>Your score: <?php echo $player->score; ?></p>
    <p>Dealer hand: <?php foreach($dealer->hand as $value){echo $value." ";} ?></p>
    <p>Dealer score: <?php echo $dealer->score; ?></p>
    <form action="" method="POST">
        <input type="submit" name="hit" value="Hit">
        <input type="submit" name="stand" value="Stand">
        <input type="submit" name="surrender" value="Surrender">
    </form>
    
    <?php echo $_SESSION['msg']; ?>
   
    <br>
    <br>
    <br>
    <br>
    <br>
    <p style="text-align:center"><a class="nav-item nav-link px-2" href="home.php">Home <span class="sr-only"></span></p>
</body>
</html>

