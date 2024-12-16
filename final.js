 // start of our javascript and some jquery
 let totalSalary = <?= $totalSalary ?>;
 let chanceOfWin = <?= $chanceOfWin ?>;
 const budget = 50000000;

 // update the total salary and the chance of winning 
 function updateTotalSalary() {
 $('#totalSalary').text(totalSalary.toLocaleString());
 // here we pretty much divide to two decimal places for the user win predictability
 $('#ChanceOfWin').text(((totalSalary / budget) * 100).toFixed(2) + "%");
 // we disable the submit button if the total salary exceeds the users budget
 $('#submitBtn').prop('disabled', totalSalary > budget);
}

// added a event listener that triggers depending on if a checkbox is checked or even unchecked
$('input[type="checkbox"]').on('change', function(){
 // here we get the players salary text to do some math.
 const selectedCheckbox = $(this);
 const playerSalaryText = selectedCheckbox.next('label').text();

 // we remove the commas from our text here as sometimes it can not correctly calcualte with commas and other factors
 const playerSalary = Number(playerSalaryText.replace(/[^\d.-]/g, ''));

 // at the last we check our checkboxes to see if they are unchecked or checked
 if (selectedCheckbox.is(':checked')) {
     // if the checkbox is checked, we add the players and the total
     totalSalary += playerSalary;
 } else {
     // here if unchecked we subtract the players salary from the total
     totalSalary -= playerSalary;
 }
 // here we update the salary
 updateTotalSalary();
});

updateTotalSalary(); // Initial update on page load