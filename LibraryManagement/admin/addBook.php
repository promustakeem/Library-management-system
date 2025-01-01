


<?php

require 'dbconnect.php';  
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $type = $_POST['type']; // 'book' or 'movie'
    $name = $_POST['name'];
    $author_name = $_POST['author_name'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $cost = $_POST['cost'];
    $date = $_POST['date'];
    $quantity = $_POST['quantity'];

    // Check if the type is "book"
    if ($type == 'book') {
        // SQL query to insert a new book into the 'master_list_of_books' table
        $sql = "INSERT INTO master_list_of_books (book_name, author_name, category, status, cost, procurement_date, quantity) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
     
            $stmt->bind_param("ssssssi", $name, $author_name, $category, $status, $cost, $date, $quantity);

          
            if ($stmt->execute()) {
                echo "<script>alert('Book added successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for books.');</script>";
        }
    }

    // Check if the type is "movie"
    if ($type == 'movie') {
        // SQL query to insert a new movie into the 'master_list_of_movies' table
        $sql = "INSERT INTO master_list_of_movies (movie_name, author_name, category, status, cost, procurement_date, quantity) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters (s = string, i = integer)
            $stmt->bind_param("ssssssi", $name, $author_name, $category, $status, $cost, $date, $quantity);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Movie added successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing the query for movies.');</script>";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book/Movie</title>
    <style>
        /* Your existing styles */
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
      .form-container input[type="number"] {
          width: 60%;
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
      #book{
          margin-left: 550px;
      }
      #movie{
          margin-left:250px;
      }
      </style>
</head>
<body>
<?php require 'nav.php'; ?>
    <form class="form-container" method="POST">
        <!-- Book Section -->
        <div>
            <input type="radio" id="book" name="type" value="book" checked>
            <label for="book">Book</label>
        </div>
        <!-- Movie Section -->
        <div>
            <input type="radio" id="movie" name="type" value="movie">
            <label for="movie">Movie</label>
        </div>
        
        <!-- Common Fields -->
        <label for="name">Book/Movie Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="author_name">Author/Director Name:</label>
        <input type="text" id="author_name" name="author_name" required>
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>
        
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required>
        
        <label for="cost">Cost:</label>
        <input type="number" id="cost" name="cost" required>
        
        <label for="date">Procurement Date:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1">
        
        <!-- Buttons -->
        <div class="buttons">
            <button type="button" class="cancel">Cancel</button>
            <button type="submit" class="confirm">Confirm</button>
        </div>
    </form>
</body>
</html>
