<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}
if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="justify-content-center text-center">

    <div class="dropdown m-5">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
            Settings
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Delete Account</a></li>
            <li><a class="dropdown-item" href="#">Delete All Data</a></li>
            <li><a class="dropdown-item" href="register.html">Reset Password</a></li>
            <li><a class="dropdown-item" href="index.html">Logout</a></li>
        </ul>
    </div>

    <div class="container mt-3">
        <h3>Modal Example</h3>
        <p>Click on the button to open the modal.</p>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Upload Data
        </button>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <h2>Enter Your Budget</h2>
                <label for="wants">Spending on Wants:</label>
                <input type="number" id="wants" placeholder="e.g. 100"><br><br>

                <label for="wantsPercentage">Goal Percentage for Wants (%):</label>
                <input type="number" id="wantsPercentage" placeholder="e.g. 20"><br><br>

                <label for="needs">Spending on Needs:</label>
                <input type="number" id="needs" placeholder="e.g. 200"><br><br>

                <label for="needsPercentage">Goal Percentage for Needs (%):</label>
                <input type="number" id="needsPercentage" placeholder="e.g. 30"><br><br>

                <label for="savings">Amount Saved:</label>
                <input type="number" id="savings" placeholder="e.g. 150"><br><br>

                <label for="savingsPercentage">Goal Percentage for Savings (%):</label>
                <input type="number" id="savingsPercentage" placeholder="e.g. 50"><br><br>

                <div class="modal-footer">
                    <button onclick="storeBudget()" type="button" class="btn btn-success"
                        data-bs-dismiss="modal">Submit</button>
                </div>

            </div>
        </div>
    </div>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <div>
        <p1 id="advice"></p1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function storeBudget() {
            // Retrieve input values
            const wants = parseFloat(document.getElementById("wants").value) || 0;
            const needs = parseFloat(document.getElementById("needs").value) || 0;
            const savings = parseFloat(document.getElementById("savings").value) || 0;

            // Retrieve goal percentage values
            const wantsPercentage = parseFloat(document.getElementById("wantsPercentage").value) || 0;
            const needsPercentage = parseFloat(document.getElementById("needsPercentage").value) || 0;
            const savingsPercentage = parseFloat(document.getElementById("savingsPercentage").value) || 0;

            // Calculate total spending and compare with goal percentages
            const totalSpending = wants + needs;
            const totalSaving = savings;
            // Calculate total budget
            const totalBudget = totalSpending + savings;


            const actualWantsPercentage = (wants / totalBudget) * 100;
            const actualNeedsPercentage = (needs / totalBudget) * 100;
            const actualSavingsPercentage = (savings / totalBudget) * 100;

            const ctx = document.getElementById('myChart');

            // Check if the sum of goal percentages equals 100
            const totalGoalPercentage = wantsPercentage + needsPercentage + savingsPercentage;

            if (totalGoalPercentage !== 100) {
                console.log("Warning: The sum of goal percentages does not equal 100%");
            } else {
                console.log("Total Goal Percentage is 100%");
            }

            // Prepare advice string
            let adviceText = "";

            // Advice for Wants
            if (actualWantsPercentage < wantsPercentage) {
                adviceText += "You're spending less on Wants than your goal. Consider adjusting your budget if needed.<br>";
            } else if (actualWantsPercentage > wantsPercentage) {
                adviceText += "You're spending more on Wants than your goal. You might want to reduce spending here.<br>";
            } else {
                adviceText += "You're on target for your Wants budget.<br>";
            }

            // Advice for Needs
            if (actualNeedsPercentage < needsPercentage) {
                adviceText += "You're spending less on Needs than your goal. Consider adjusting your budget if needed.<br>";
            } else if (actualNeedsPercentage > needsPercentage) {
                adviceText += "You're spending more on Needs than your goal. You might want to reduce spending here.<br>";
            } else {
                adviceText += "You're on target for your Needs budget.<br>";
            }
            // Advice for Savings
            if (actualSavingsPercentage < savingsPercentage) {
                adviceText += "You're saving less than your goal. Try to allocate more towards savings.<br>";
            } else if (actualSavingsPercentage > savingsPercentage) {
                adviceText += "You're saving more than your goal. Great job!<br>";
            } else {
                adviceText += "You're on target for your Savings goal.<br>";
            }

            // Show the advice in the <p1> tag
            document.getElementById("advice").innerHTML = adviceText;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Wants', 'Needs', 'Savings'],
                    datasets: [{
                        label: 'Spending',
                        data: [wants, needs, savings],
                        borderWidth: 1,
                        //backgroundColor: '#800000',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>


</body>

</html>