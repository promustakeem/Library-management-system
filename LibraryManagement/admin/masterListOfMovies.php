<?php
include 'dbconnect.php';

$sql = "SELECT * FROM master_list_of_movies"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $movies = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $movies = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master List of Movies</title>
    <style>
        .main {
            margin-left: 220px;
            padding: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2563eb;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    require 'nav.php';
    ?>
    <div class="main">
        <h2>Master List of Movies</h2>
        <table border="1px solid black">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name of Movie</th>
                    <th>Director Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Cost</th>
                    <th>Procurement Date</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($movies)) {
                    foreach ($movies as $movie) {
                        $status = $movie['quantity'] == 0 ? "Not Available" : $movie['status'];
                        echo "<tr>
                                <td>{$movie['serial_no']}</td>
                                <td>{$movie['movie_name']}</td>
                                <td>{$movie['author_name']}</td>
                                <td>{$movie['category']}</td>
                                <td>{$status}</td>
                                <td>{$movie['cost']}</td>
                                <td>{$movie['procurement_date']}</td>
                                <td>{$movie['quantity']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No movies available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="back-button">
            <button onclick="history.back()">Back</button>
        </div>
    </div>
</body>
</html>
