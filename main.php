<!-- Added a php associative array for our players -->
<?php 
// start of our players and how much they cost the user
$players = [
    ['id' => 1, 'name' => 'Tom Brady', 'salary' => 28000000],
    ['id' => 2, 'name' => 'Patrick Mahomes', 'salary' => 8000000],
    ['id' => 3, 'name' => 'Aaron Donald', 'salary' => 10000000],
    ['id' => 4, 'name' => 'Chris Boswell', 'salary' => 1800000],
    ['id' => 5, 'name' => 'Justin Tucker', 'salary' => 18000000],
    ['id' => 6, 'name' => 'Alvin Kamara', 'salary' => 22000000],
    ['id' => 7, 'name' => 'Josh Jacobs', 'salary' => 24000000],
    ['id' => 8, 'name' => 'Najee Harris', 'salary' => 14000000],
    ['id' => 9, 'name' => 'Kyler Murray', 'salary' => 2000000],
    ['id' => 10, 'name' => 'Jalen Hurts', 'salary' => 4000000],
    ['id' => 11, 'name' => 'Daniel Jones', 'salary' => 100000],
    ['id' => 12, 'name' => 'Lamar Jackson', 'salary' => 23000000],
    ['id' => 13, 'name' => 'Derrick Henry', 'salary' => 19000000]
];

// Set the budget to 50 million
$budget = 50000000;
// set the starting salary to 0
$totalSalary = 0;

// check if the form is submitted using the server
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // get the players id from the form 
    $selectedPlayerIds = $_POST['players'] ?? [];
    // here we reset the salary and start the calculation based on the set of players selected
    $totalSalary = array_reduce($players, fn($carry, $player) => in_array($player['id'], $selectedPlayerIds) ? $carry + $player['salary'] : $carry,0);

    // finally if the salary exceeds the budget, we reset the salary to $0
    if ($totalSalary > $budget){
        $totalSalary = 0;
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
            <?php foreach ($players as $player): ?>
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
    </form>
</body>
</html>