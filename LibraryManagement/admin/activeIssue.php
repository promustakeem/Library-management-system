<?php
include 'dbconnect.php';

// Fetch active issues from the books table where issue_date is set and return_date is NULL (book not returned yet)
$query = "SELECT * FROM list_of_issuebooks";
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
    <title>Active Issues</title>
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
            width: 100%;
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
        <h2>Active Issues</h2>
        <table>
            <thead>
                <tr>
                    <th>Serial No Book/Movie</th>
                    <th>Name of Book/Movie</th>
                    <th>Author Name</th>
                    <th>Membership ID</th>
                    <th>Date of Issue</th>
                    <th>Date of Return</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['serial_no'] . "</td>
                                <td>" . $row['book_name'] . "</td>
                                <td>" . $row['author_name'] . "</td>
                                <td>" . $row['membership_id'] . "</td>
                                <td>" . $row['issue_date'] . "</td>
                                <td>" . $row['return_date'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No active issues found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="../admin/reports.php" class="btn-back">Back</a>
    </div>
</body>
</html>
