<?php
require 'dbconnect.php';

$books = []; // Initialize an empty array for books
$movies = []; // Initialize an empty array for movies

// Query for available books
$sql_books = "SELECT book_name, serial_no FROM master_list_of_books";
$result_books = $conn->query($sql_books);

if ($result_books->num_rows > 0) {
    while ($row = $result_books->fetch_assoc()) {
        $books[] = ['name' => $row['book_name'], 'serial' => $row['serial_no']]; // Add each available book and serial number to the array
    }
}

// Query for available movies
$sql_movies = "SELECT movie_name, serial_no FROM master_list_of_movies WHERE status = 'available'";
$result_movies = $conn->query($sql_movies);

if ($result_movies->num_rows > 0) {
    while ($row = $result_movies->fetch_assoc()) {
        $movies[] = ['name' => $row['movie_name'], 'serial' => $row['serial_no']]; // Add each available movie and serial number to the array
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $serial_no = $_POST['serial'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    if ($type == 'book') {
        $sql = "UPDATE master_list_of_books SET status = ?, procurement_date = ? WHERE serial_no = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $status, $date, $serial_no);

            if ($stmt->execute()) {
                echo "<script>alert('Book updated successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for books.');</script>";
        }
    }

    if ($type == 'movie') {
        $sql = "UPDATE master_list_of_movies SET status = ?, procurement_date = ? WHERE serial_no = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $status, $date, $serial_no);

            if ($stmt->execute()) {
                echo "<script>alert('Movie updated successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for movies.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book/Movie</title>
    <style>
        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container label {
            font-weight: bold;
        }
        .form-container input[type="text"], 
        .form-container input[type="date"], 
        .form-container select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container .buttons {
            grid-column: span 2;
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .form-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button.cancel {
            background-color: #ff4d4d;
            color: white;
        }
        .form-container button.confirm {
            background-color: #4caf50;
            color: white;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
<?php require 'nav.php'; ?>
    <form class="form-container" method="POST">
        <div>
            <input type="radio" id="book" name="type" value="book" checked>
            <label for="book">Book</label>
        </div>
        <div>
            <input type="radio" id="movie" name="type" value="movie">
            <label for="movie">Movie</label>
        </div>
        
        <label for="name">Book/Movie Name:</label>
        <select id="name" name="name">
            <option value="">Select</option>
        </select>
        
        <label for="serial">Serial No:</label>
        <input type="text" id="serial" name="serial" required readonly>
        
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="available">Available</option>
            <option value="issued">Issued</option>
            <option value="lost">Lost</option>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        
        <div class="buttons">
            <button type="button" class="cancel">Cancel</button>
            <button type="submit" class="confirm">Confirm</button>
        </div>
    </form>
    <script>
        function updateDropdown() {
            var type = document.querySelector('input[name="type"]:checked').value;
            var nameDropdown = document.getElementById('name');
            nameDropdown.innerHTML = "<option value=''>Select</option>"; // Reset options

            var serialField = document.getElementById('serial');
            serialField.value = ""; // Clear the serial number field

            if (type == "book") {
                var books = <?php echo json_encode($books); ?>;
                books.forEach(function(book) {
                    var option = document.createElement("option");
                    option.value = book.name;
                    option.text = book.name;
                    option.dataset.serial = book.serial; // Store the serial number as a data attribute
                    nameDropdown.appendChild(option);
                });
            } else if (type == "movie") {
                var movies = <?php echo json_encode($movies); ?>;
                movies.forEach(function(movie) {
                    var option = document.createElement("option");
                    option.value = movie.name;
                    option.text = movie.name;
                    option.dataset.serial = movie.serial; // Store the serial number as a data attribute
                    nameDropdown.appendChild(option);
                });
            }
        }

        function fillSerialNumber() {
            var nameDropdown = document.getElementById('name');
            var serialField = document.getElementById('serial');
            var selectedOption = nameDropdown.options[nameDropdown.selectedIndex];

            // If an option is selected, fill the serial number field
            if (selectedOption && selectedOption.dataset.serial) {
                serialField.value = selectedOption.dataset.serial;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateDropdown(); // Call when the page loads
            // Listen for changes in the radio button selection
            var radioButtons = document.querySelectorAll('input[name="type"]');
            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', updateDropdown);
            });

            // Listen for changes in the dropdown selection
            var nameDropdown = document.getElementById('name');
            nameDropdown.addEventListener('change', fillSerialNumber);
        });
    </script>
</body>
</html>
