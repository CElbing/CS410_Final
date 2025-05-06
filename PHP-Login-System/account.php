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
    <title>Account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body class="justify-content-center text-center container-fluid">

    <div class="container-fluid bg-dark pt-3 pb-3">
    <div class="dropdown">
        <button type="button" class="btn btn-warning dropdown-toggle shadow-sm" data-bs-toggle="dropdown">
            Settings
        </button>
        <ul class="dropdown-menu bg-warning">
            <li><a class="dropdown-item" href="#">Delete Account</a></li>
            <li><a class="dropdown-item" href="#">Delete All Data</a></li>
            <li><a class="dropdown-item" href="register.html">Reset Password</a></li>
            <li><a class="dropdown-item" href="index.html">Logout</a></li>
        </ul>
    </div>
    </div>

    <div class="container mt-3">
        <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#myModal">
            Upload Data
        </button>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content bg-success text-light border border-5 border-dark">

                <h2 class="mt-3 fw-bold">Enter Your Budget</h2>
                <label for="wants" class="mt-3 text-warning mb-1">Spending on Wants:</label>
                <input type="number" id="wants" placeholder="e.g. 100" class="ms-5 me-5 p-2"><br><br>

                <label for="wantsPercentage" class="text-warning mb-1">Goal Percentage for Wants (%):</label>
                <input type="number" id="wantsPercentage" placeholder="e.g. 20" class="ms-5 me-5 p-2"><br><br>

                <label for="needs" class="text-warning mb-1">Spending on Needs:</label>
                <input type="number" id="needs" placeholder="e.g. 200" class="ms-5 me-5 p-2"><br><br>

                <label for="needsPercentage" class="text-warning mb-1">Goal Percentage for Needs (%):</label>
                <input type="number" id="needsPercentage" placeholder="e.g. 30" class="ms-5 me-5 p-2"><br><br>

                <label for="savings" class="text-warning mb-1">Amount Saved:</label>
                <input type="number" id="savings" placeholder="e.g. 150" class="ms-5 me-5 p-2"><br><br>

                <label for="savingsPercentage" class="text-warning mb-1">Goal Percentage for Savings (%):</label>
                <input type="number" id="savingsPercentage" placeholder="e.g. 50" class="ms-5 me-5 p-2"><br><br>

                <div class="modal-footer">
                    <button onclick="storeBudget()" type="button" class="btn border border-4 border-warning text-warning"
                        data-bs-dismiss="modal">Submit</button>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-5 col-md-4">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-5 col-md-4 bg-light rounded-3 ms-3 shadow">
                <p1 id="advice"></p1>
            </div>
        </div>
    </div>

    <footer class="position-absolute bottom-0 end-0 me-3 mb-3">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-4 col-md-2">
                <img src="../assets/icons/DoughDaddy.png" class="img-fluid" alt="Dough Daddy Logo">
                </div>
            </div>
        </div>
    </footer>


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