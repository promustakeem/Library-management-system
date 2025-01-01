<?php
include 'dbconnect.php';

// Fetch book names and authors where quantity > 0
$sql = "SELECT book_name, author_name, serial_no, quantity FROM master_list_of_books WHERE quantity > 0";
$result = $conn->query($sql);

$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_name = $_POST['book_name'];

    // Query to fetch books based on selected book name
    $sql = "SELECT book_name, author_name, serial_no, quantity 
            FROM master_list_of_books 
            WHERE book_name = ? AND quantity > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $book_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $available_books = [];
    while ($row = $result->fetch_assoc()) {
        $available_books[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
            width: 70%;
            margin: 20px auto;
            border: 1px solid #000;
            padding: 20px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        button:hover {
            background-color: #3498db;
        }
    </style>
</head>
<body>
    <?php require 'nav.php'; ?>

    <div class="container">
        <form action="" method="post" id="bookForm">
            <table>
            <tr>
                    <th colspan="2">Book Availability</th>
                </tr>
                <tr>
                    <th>Book Name</th>
                    <td>
                        <select name="book_name" id="bookName" required>
                            <option value="">Select a Book</option>
                            <?php foreach ($books as $book): ?>
                                <option value="<?= $book['book_name']; ?>" 
                                        data-author="<?= $book['author_name']; ?>"
                                        data-quantity="<?= $book['quantity']; ?>">
                                    <?= $book['book_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Author Name</th>
                    <td><input type="text" id="authorName" readonly></td>
                </tr>
            </table>

            <div class="button-container">
                <button type="button" onclick="history.back()">Back</button>
                <button type="submit">Search</button>
            </div>
        </form>

        <?php if (!empty($available_books)): ?>
            <table>
                
                <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Author Name</th>
                        <th>Serial Number</th>
                        <th>Quantity</th>
                        <!-- <th>radio button to select</th> -->

                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($available_books as $book): ?>
                        <tr>
                            <td><?= $book['book_name']; ?></td>
                            <td><?= $book['author_name']; ?></td>
                            <td><?= $book['serial_no']; ?></td>
                            <td><?= $book['quantity']; ?></td>
                            <!-- <td><input type="radio"> select</td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('bookName').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const author = selectedOption.getAttribute('data-author');
            document.getElementById('authorName').value = author || '';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
