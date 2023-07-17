<!Name: Nur Aishah Hanim binti Abdul Rahman
  UniSZA 12th July 2023
  Electricity Calculator>

<html>
<head>
    <title>Electricity Bill</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Electricity Bill</h1>
        <form method="POST">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step=any"" class="form-control" id="voltage" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="any" class="form-control" id="current" name="current" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" step="0.01" class="form-control" id="rate" name="rate" required>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'] / 100; //Converting sen to RM

            function calculateCharge($voltage, $current, $rate, $hour)
            {
                $power = $voltage * $current;
                $energy = ($power * $hour) / 1000;
                $total = $energy * $rate;
                return [$power, $energy, $total];
            }

            $detailsTable = [];
            for ($hour = 1; $hour <= 24; $hour++) {
                $detailsTable[$hour] = calculateCharge($voltage, $current, $rate, $hour);
            }
        ?>
            <div class="mt-4">
                <h4>Electricity Details:</h4>
                <ul>
                    <li>Voltage (V): <?php echo $voltage; ?></li>
                    <li>Current (A): <?php echo $current; ?></li>
                    <li>Power (W): <?php echo $detailsTable[1][0]; ?></li>
                    <li>Current Rate (RM/kWh): <?php echo $rate; ?></li>
                </ul>
            </div>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Hour</th>
                        <th>Energy (kWh)</th>
                        <th>Total Charge (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($detailsTable as $hour => $details) {
                        $energy = $details[1];
                        $totalCharge = $details[2];
                    ?>
                        <tr>
                            <td><?php echo $hour; ?></td>
                            <td><?php echo number_format($energy, 4); ?></td>
                            <td><?php echo number_format($totalCharge, 2); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</body>
</html>
