<?php
include 'dbconnect.php';

// Query to fetch overdue returns (where return_date is past the current date)
$query = "SELECT SerialNoBook, NameOfBook, MembershipId, NameOfAuthor, DateOfIssue, DateOfReturn, TotalFine from overduereturns where TotalFine > 0.0";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Returns</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            text-align: center;
        }
        table {
            width: auto;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    require 'nav.php';
    ?>
    <div class="container">
        <h2>Overdue Returns</h2>
        <table>
            <thead>
                <tr>
                    <th>Serial No Book/Movie</th>
                    <th>Name of Book/Movie</th>
                    <th>Membership ID</th>
                    <th>Author Name</th>
                    <th>Date of Issue</th>
                    <th>Date of Return</th>
                    <th>Total Fine (Days)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any overdue returns
                if (mysqli_num_rows($result) > 0) {
                    // Loop through the results and display each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['SerialNoBook'] . "</td>
                                <td>" . $row['NameOfBook'] . "</td>
                                <td>" . $row['MembershipId'] . "</td>
                                <td>" . $row['NameOfAuthor'] . "</td>
                                <td>" . $row['DateOfIssue'] . "</td>
                                <td>" . $row['DateOfReturn'] . "</td>
                                <td>" . $row['TotalFine'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No Overdue returns found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="../admin/reports.php" class="btn-back">Back</a>
    </div>
</body>
</html>
