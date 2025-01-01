<?php
include 'dbconnect.php'; 
 
$sql = "select * from master_list_of_books";
$result = $conn->query($sql); // Execute the query

// Check if the query was successful
if ($result->num_rows > 0) {
    $books = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
} else {
    $books = []; // If no rows are returned, set an empty array
}



$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master List of Books</title>
    <style>
        /* Main Content */
        .main {
            margin-left: 220px;
            padding: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        /* Table Styling */
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

        /* Back Button */
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
    require 'nav.php'; // Include the navigation bar
    ?>
    <div class="main">
        <h2>Master List of Books</h2>
        <table border="1px solid black">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name of Book</th>
                    <th>Author Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Cost</th>
                    <th>Procurement Date</th>
                    <th>quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display each book dynamically from the fetched data
                if (!empty($books)) {
                    foreach ($books as $book) {
                        $status = $book['quantity'] == 0 ? "Not Available" : $book['status'];
                        echo "<tr>
                                <td>{$book['serial_no']}</td>
                                <td>{$book['book_name']}</td>
                                <td>{$book['author_name']}</td>
                                <td>{$book['category']}</td>
                                <td>{$status}</td>
                                <td>{$book['cost']}</td>
                                <td>{$book['procurement_date']}</td>;
                                <td>{$book['quantity']}</td>";
                                


                              echo" </tr>";

                            
                    }
                } else {
                    echo "<tr><td colspan='7'>No books available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="back-button">
            <button onclick="history.back()">Back</button>
        </div>
    </div>

    
</body>
</html>
