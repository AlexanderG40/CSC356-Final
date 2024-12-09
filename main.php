<!-- Added a php associative array for our players -->
<?php 
// start of our players and how much they cost the user using json
$jsonPlayer = '{
    "players": [
        {"id": 1, "name": "Tom Brady", "salary": 28100000},
        {"id": 2, "name": "Patrick Mahomes", "salary": 8000000},
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
        {"id": 18, "name": "Travis Kelce", "salary": 7850000}
    ],
    "budget": 50000000
}';

// used the json decode to make it into a php array for the user
// sources used that helped me with this : https://stackoverflow.com/questions/29308898/how-to-extract-and-access-data-from-json-with-php
// and https://www.w3schools.com/Php/func_json_decode.asp
$jsonData = json_decode($jsonPlayer, true);

// now we fianlly extract the data from the decoded data
$player = $jsonData['players'];
$budget = $jsonData['budget'];



// set the starting salary to 0
$totalSalary = 0;
// add a budget exceeded just in case the user exceedes the budget
$budgetExceeded = false;

// check if the form is submitted using the server
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // get the players id from the form 
    $selectedPlayerIds = $_POST['players'] ?? [];
    // here we reset the salary and start the calculation based on the set of players selected
    $totalSalary = array_reduce($player, fn($carry, $player) => in_array($player['id'], $selectedPlayerIds) ? $carry + $player['salary'] : $carry, 0);

    // finally if the salary exceeds the budget, we reset the salary to $0
    if ($totalSalary > $budget){
        $budgetExceeded = true;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final for CSC356</title>
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

    <!-- Now start the player selection for the user to choose their desired players -->
    <form method="POST">
        <!-- A div class for our player -->
        <div class="player_list">
            <!-- added a little php to display each players info, instead of doing it manually this saves us time/effort -->
            <?php foreach ($player as $player): ?>
                <!-- started a div class as 'player' -->
                <div class="player">
                    <!-- made a simple checkbox for the user -->
                    <input type="checkbox" name="players[]" value="<?= $player['id'] ?>"
                        id="player-<?= $player['id'] ?>"
                        <?= in_array($player['id'], $selectedPlayerIds ?? []) ? 'checked' : '' ?>>
                    <label for="player-<?= $player['id'] ?>"><?= $player['name'] ?><br>$<?= number_format($player['salary'])     ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Added a submit button if for some reason the user goes over budget we wont let that happen -->
        <button type="submit" <?= $totalSalary > $budget ? 'disabled' : '' ?>>Submit Players</button>

        <!-- start the java script for our salary update -->
        <!-- the javascript will be added next week as needed... -->
        
    </form>
</body>
</html>