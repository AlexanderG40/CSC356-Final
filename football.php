<?php 
// start of our players and how much they cost the user using json
$jsonPlayer = '{
    "players": [
        {"id": 1, "name": "Tom Brady", "salary": 28100000},
        {"id": 2, "name": "Patrick Mahomes", "salary": 22000000},
        {"id": 3, "name": "Aaron Donald", "salary": 10000000},
        {"id": 4, "name": "Chris Boswell", "salary": 1800000},
        {"id": 5, "name": "Justin Tucker", "salary": 800000},
        {"id": 6, "name": "Puka Nakua", "salary": 2700000},
        {"id": 7, "name": "Justin Herbert", "salary": 2900000},
        {"id": 8, "name": "Alvin Kamara", "salary": 22000000},
        {"id": 9, "name": "Jared Goff", "salary": 12000000},
        {"id": 10, "name": "Josh Jacobs", "salary": 10000000},
        {"id": 11, "name": "D.K. Metcalf", "salary": 17000000},
        {"id": 12, "name": "Najee Harris", "salary": 1300000},
        {"id": 13, "name": "Kyler Murray", "salary": 2300000},
        {"id": 14, "name": "Julian Edelman", "salary": 2150000},
        {"id": 15, "name": "Derrick Henry", "salary": 7130000},
        {"id": 16, "name": "Lamar Jackson", "salary": 3590000},
        {"id": 17, "name": "Daniel Jones", "salary": 850000},
        {"id": 18, "name": "Travis Kelce", "salary": 7850000},
        {"id": 19, "name": "Trav Piker", "salary": 5850000}
    ],
    "budget": 50000000
}';

// used the json decode to make it into a php array for the user
// sources used that helped me with this : https://stackoverflow.com/questions/29308898/how-to-extract-and-access-data-from-json-with-php
// and https://www.w3schools.com/Php/func_json_decode.asp
$jsonData = json_decode($jsonPlayer, true);

// now we fianlly extract the data from the decoded data
$players = $jsonData['players'];
$budget = $jsonData['budget'];

// set the starting salary to 0
$totalSalary = 0;
// added a variable that stores the chance of winning
$chanceOfWin = 0;
// added to show the welcome screen when the user joins our game
$WelcomeScreen =  true;

// check if the form is submitted using the server
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // get the players id from the form 
    $selectedPlayerIds = $_POST['players'] ?? [];
    // here we calculate the total salary by adding the salary of the selected players
    $totalSalary = array_reduce($players, function ($carry, $player) use ($selectedPlayerIds) {
        return in_array($player['id'], $selectedPlayerIds) ? $carry + $player['salary'] : $carry;
    }, 0);

    // Here we calculate the overall chance of winning we use the total salary divided by the budget
    $chanceOfWin = $totalSalary > 0 ? min(($totalSalary / $budget) * 100, 100) : 0;

    // here we set the total salary back to zero if the user exceeds the budget
    if ($totalSalary > $budget) $totalSalary = 0;

    // we hide the welcome screen after our user submits their form so that they do not have a crowded screen
    $WelcomeScreen = false;
}

// here we show the welcome screen to our user
if ($WelcomeScreen) {
    echo '
        <h1>Welcome to Football Philanthropy!</h1>
        <div class="welcome_message">
            <p>Nice to have you here! In this football selection game, you have a budget of no more than 50 Million dollars to build your dream team. So get to choosing and we will calculate your team chances of winning based on their salary.</p>
            <p>Just click below to start choosing your players!</p>
        </div>

        <form method="POST">
            <button type="submit">Start Player Selection</button>
        </form>
    ';
    exit;
}

?>

<!-- start of our html form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final for CSC356 - Football Philanthropy</title>
    <!-- added the link to the jquery library so it shows up in our code -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- link to our external JS -->
    <script src="script.js"></script>
    <!-- Added the link to the css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Start for the main Website where the user will be able to see their budget. -->
    <h1>Football Player Selection</h1>
    <h3>Here you will select the players for your team as the General Manager, your job is to spend money without going over the budget. Your Budget is 50 Million.</h3>
    <!-- Display of the current budget using a div -->
    <div class="budget_info">
        Selected Players Total Salary: $<span id="totalSalary"><?= number_format($totalSalary) ?></span> / $50,000,000
    </div>

    <!-- start another div class but for our users chance of winning to two decimals -->
    <div class="chancewin_info">
        Chance of winning: <span id="ChanceOfWin"><?= number_format($chanceOfWin, 2) ?>%</span>
    </div>

    <!-- Now start the player selection for the user to choose their desired players -->
    <form method="POST">
        <div class="player_list">
            <!-- here we created a for each loop for each player. This helps make it easier as it keeps each indivisual player sepeareta from others. -->
            <?php foreach ($players as $player): ?>
                <div class="player">
                    <!-- we make each player into a checkbox that the user can select -->
                    <input type="checkbox" name="players[]" value="<?= $player['id'] ?>" id="player-<?= $player['id'] ?>"
                    
                    <?= in_array($player['id'], $_POST['players'] ?? []) ? 'checked' : '' ?>>

                    <!-- we have label for each player showing off their salary and name -->
                    <label for="player-<?= $player['id'] ?>"><?= $player['name'] ?> = $<?= number_format($player['salary']) ?></label>

                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" id="submitBtn">Submit Team Selection</button>
    </form>
</body>
</html>
